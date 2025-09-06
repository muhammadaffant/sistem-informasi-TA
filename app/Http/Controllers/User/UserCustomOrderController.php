<?php

namespace App\Http\Controllers\User;

use App\Models\Size;
use App\Models\Bahan;
use App\Models\Ongkir;
use App\Models\CustomOrder;
use App\Models\CustomOrderItem;
use App\Models\JenisSablon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Mail\CustomOrderInvoiceMail;
use Illuminate\Support\Facades\Mail;
use App\Models\Province;
use App\Models\Regency;


class UserCustomOrderController extends Controller
{
    public function index()
    {
        return view('frontend.user.customorder.index',[
            'title' => 'Custom Kaos'
        ]);
    }

public function store(Request $request)
{
    $validator = Validator::make($request->all(), [
        'name' => 'required|string|max:255',
        'file_design' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        'variations' => 'required|array|min:1',
        'variations.*.bahan_id' => 'required|exists:bahans,id',
        'variations.*.size_id' => 'required|exists:sizes,id',
        'variations.*.jenis_sablon_id' => 'required|exists:jenis_sablons,id',
        'variations.*.quantity' => 'required|integer|min:1',
        'address' => 'required',
        'province_id' => 'required|integer',
        'city_id' => 'required|integer',
        'district_id' => 'required|integer',
        'village_id' => 'nullable|integer',
        'position' => 'required|string',
    ]);

    if ($validator->fails()) {
        return response()->json(['error' => $validator->errors()->first()], 422);
    }

    // Validasi total kuantitas minimum
    $totalQty = 0;
    foreach ($request->variations as $variation) {
        $totalQty += $variation['quantity'];
    }

    if ($totalQty < 12) {
        return response()->json(['error' => 'Minimum total kuantitas pemesanan adalah 12 pcs.'], 422);
    }

    // Process variations dan hitung total
    $variationItems = [];
    $totalPrice = 0;
    $bahans = [];
    $sablons = [];

    foreach ($request->variations as $variation) {
        $size = Size::findOrFail($variation['size_id']);
        $jenisSablon = JenisSablon::findOrFail($variation['jenis_sablon_id']);
        $quantity = $variation['quantity'];
        
        $bahanPrice = $size->price;
        $sablonPrice = $jenisSablon->harga;
        $subtotal = ($bahanPrice + $sablonPrice) * $quantity;
        
        $variationItems[] = [
            'bahan_id' => $variation['bahan_id'],
            'size_id' => $variation['size_id'],
            'jenis_sablon_id' => $variation['jenis_sablon_id'],
            'quantity' => $quantity,
            'bahan_price' => $bahanPrice,
            'sablon_price' => $sablonPrice,
            'subtotal' => $subtotal,
        ];

        $totalPrice += $subtotal;
        
        // Collect bahan dan sablon names untuk summary
        $bahans[] = $size->bahan->nama_bahan;
        $sablons[] = $jenisSablon->sablonCategory->name . ' - ' . $jenisSablon->nama_sablon;
    }

    // Upload design files
    $designFileName = 'design.jpg';
    $frontDesignFileName = null;
    $backDesignFileName = null;
    
    // Upload main design file (untuk backward compatibility)
    if ($request->hasFile('file_design')) {
        $designFileName = upload('customorder', $request->file('file_design'), 'file_design');
    }
    
    // Upload front design file
    if ($request->hasFile('front_design_file')) {
        $frontDesignFileName = upload('customorder', $request->file('front_design_file'), 'front_design_file');
    }
    
    // Upload back design file
    if ($request->hasFile('back_design_file')) {
        $backDesignFileName = upload('customorder', $request->file('back_design_file'), 'back_design_file');
    }

    // Create summary untuk backward compatibility
    $orderedItemsDetails = [];
    foreach ($variationItems as $item) {
        $size = Size::find($item['size_id']);
        $orderedItemsDetails[] = [
            'size' => $size->nama_size,
            'quantity' => $item['quantity'],
            'price' => $item['bahan_price'],
            'sablon_price' => $item['sablon_price'],
            'subtotal' => $item['subtotal'],
        ];
    }

    // Handle province/regency mapping
    $apiProvinceId = $request->province_id;
    $apiRegencyId = $request->city_id;

    $localProvince = Province::where('rajaongkir_id', $apiProvinceId)->first();
    $localRegency = Regency::where('rajaongkir_id', $apiRegencyId)->first();

    // Hitung estimasi hari pengerjaan
    $estimatedDays = CustomOrder::calculateEstimatedDays($totalQty);

    // Hitung total berat pesanan
    $totalWeight = 0;
    foreach ($variationItems as $item) {
        $size = Size::find($item['size_id']);
        if ($size && $size->bahan && isset($size->bahan->weight)) {
            $totalWeight += $size->bahan->weight * $item['quantity'];
        }
    }
    // Minimal weight 100 gram
    $totalWeight = max($totalWeight, 100);

    // Create custom order
    $customOrder = CustomOrder::create([
        'user_id' => auth()->id(),
        'name' => $request->name,
        'file_design' => $designFileName,
        'file_design_front' => $frontDesignFileName,
        'file_design_back' => $backDesignFileName,
        'design_description' => $request->design_description,
        'position' => $request->position,
        'front_position' => $request->front_position,
        'back_position' => $request->back_position,
        'fabric_type' => implode(', ', array_unique($bahans)), // Summary of materials
        'jenis_sablon' => implode(', ', array_unique($sablons)), // Summary of sablon types
        'sablon_price' => collect($variationItems)->sum('sablon_price'), // Total sablon price
        'size' => json_encode($orderedItemsDetails), // Keep for backward compatibility
        'total_price' => $totalPrice,
        'qty' => $totalQty,
        'estimated_days' => $estimatedDays, // Estimasi hari pengerjaan
        'total_weight' => $totalWeight, // Total berat pesanan
        'dp_paid' => 0,
        'remaining_payment' => $totalPrice + ($request->ongkir ?? 0),
        'status' => 'Pending',
        'order_date' => now(),
        'completion_date' => now()->addDays($estimatedDays), // Gunakan estimasi hari untuk completion_date
        'address' => $request->address,
        'province_id' => $localProvince ? $localProvince->id : null,
        'regency_id' => $localRegency ? $localRegency->id : null,
        'district_id' => $request->district_id ?? null,
        'village_id' => $request->village_id ?? null,
        'ongkir' => $request->ongkir ?? 0,
        // 'courier' => $request->courier ?? null,
        'courir' => $request->courier_service ?? null,
    ]);

    // Create custom order items
    foreach ($variationItems as $item) {
        $customOrder->customOrderItems()->create($item);
    }

    return response()->json(['success' => 'Pesanan Custom Anda berhasil disubmit.']);
}

    public function history()
    {
        
        $userId = Auth::user()->id;
        $title = 'History Custom Order';
        $customOrders = CustomOrder::where('user_id', $userId)->orderBy('id', 'DESC')->get();

        return view('frontend.user.customorder.history', compact('customOrders', 'title'));
    }

    public function detail($id)
    {

        $title = 'Detail Custom Order';
        $customOrder = CustomOrder::findOrfail($id);

        \Midtrans\Config::$serverKey = config('midtrans.server_key');
        \Midtrans\Config::$isProduction = false;
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;

        $params = array(
            'transaction_details' => array(
                'order_id' => rand(),
                'gross_amount' => $customOrder->remaining_payment
            ),

            'customer_details' => array(
                'first_name' => $customOrder->name,
            ),
        );

        $snapToken = \Midtrans\Snap::getSnapToken($params);

        return view('frontend.user.customorder.detail', compact('customOrder', 'snapToken', 'title'));
    }

       public function getSizes($bahan_id)
    {
        // Cari bahan berdasarkan ID, jika tidak ketemu akan error 404 (ini bagus)
        // Lalu ambil semua data 'sizes' yang berelasi dengannya
        $sizes = Bahan::findOrFail($bahan_id)->sizes()->orderBy('price', 'asc')->get();
        
        // Kirim data sizes sebagai response JSON
        return response()->json($sizes);
    }

    public function getSablonDetails($categoryId)
{
    $details = \App\Models\JenisSablon::where('sablon_category_id', $categoryId)->get();
    return response()->json($details);
}
    public function customeOrderStore(Request $request)
    {
        $customId = $request->custom_order_id;
        $data = json_decode($request->get('json'));

        CustomOrder::findOrfail($customId)->update([
            'status' => 'Success',
            'payment_type' => $data->payment_type,
            'transaction_id' => $data->transaction_id
        ]);

        // ==========================================================
        // ==========================================================
        try {
            // Kita perlu eager load relasi 'user' karena digunakan di template PDF
            $customOrderDataForEmail = CustomOrder::with('user')->findOrFail($customId);

            // Kirim email ke alamat email user
            Mail::to($customOrderDataForEmail->user->email)->send(new CustomOrderInvoiceMail($customOrderDataForEmail));

        } catch (\Exception $e) {
            // (Opsional) Catat error jika email gagal terkirim
            // \Log::error('Gagal mengirim email invoice custom order #' . $customId . ': ' . $e->getMessage());
        }
        //

        $notification = [
            'message' => 'Pembayaran Success',
            'alert-type' => 'success',
        ];

        return redirect()->route('user.customorder.history')->with($notification);
    }

    /**
     * Calculate total weight for custom order based on materials and quantities
     */
    public function calculateWeight(Request $request)
    {
        $request->validate([
            'variations' => 'required|array',
            'variations.*.bahan_id' => 'required|integer|exists:bahans,id',
            'variations.*.quantity' => 'required|integer|min:1',
        ]);

        $totalWeight = 0;
        
        foreach ($request->variations as $variation) {
            $bahan = Bahan::find($variation['bahan_id']);
            if ($bahan && isset($bahan->weight)) {
                $totalWeight += $bahan->weight * $variation['quantity'];
            }
        }

        // Minimal weight 100 gram untuk shipping calculation
        $totalWeight = max($totalWeight, 100);

        return response()->json([
            'success' => true,
            'total_weight' => $totalWeight
        ]);
    }

    /**
     * Calculate estimated days for custom order
     */
    public function calculateEstimation(Request $request)
    {
        $totalQuantity = $request->input('total_quantity', 0);
        $estimatedDays = CustomOrder::calculateEstimatedDays($totalQuantity);
        
        $orderDate = now();
        $completionDate = $orderDate->copy()->addDays($estimatedDays);
        
        return response()->json([
            'success' => true,
            'estimated_days' => $estimatedDays,
            'order_date' => $orderDate->format('d M Y'),
            'completion_date' => $completionDate->format('d M Y'),
            'working_days_info' => $this->getWorkingDaysInfo($estimatedDays)
        ]);
    }

    /**
     * Get working days information
     */
    private function getWorkingDaysInfo($estimatedDays)
    {
        if ($estimatedDays <= 3) {
            return "Pesanan cepat - siap dalam 3 hari kerja";
        } elseif ($estimatedDays <= 5) {
            return "Pesanan standar - siap dalam 5 hari kerja";
        } elseif ($estimatedDays <= 7) {
            return "Pesanan sedang - membutuhkan 1 minggu";
        } elseif ($estimatedDays <= 10) {
            return "Pesanan besar - membutuhkan 10 hari kerja";
        } else {
            return "Pesanan jumbo - membutuhkan 2 minggu";
        }
    }
}
