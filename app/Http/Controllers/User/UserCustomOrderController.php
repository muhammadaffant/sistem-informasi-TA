<?php

namespace App\Http\Controllers\User;

use App\Models\Size;
use App\Models\Bahan;
use App\Models\Ongkir;
use App\Models\CustomOrder;
use App\Models\JenisSablon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Mail\CustomOrderInvoiceMail;
use Illuminate\Support\Facades\Mail;

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
        // 'jenis_sablon' => 'required|string',
         'jenis_sablon_id' => 'required|exists:jenis_sablons,id', // Validasi ke ID
        'items' => 'required|array|min:1',
        'items.*.qty' => 'nullable|integer|min:0',
        'address' => 'required',
    ]);

    if ($validator->fails()) {
        return response()->json(['error' => $validator->errors()->first()], 422);
    }

    // $jenissablon = JenisSablon::where('nama_sablon', $request->jenis_sablon)->first();
    $jenissablon = JenisSablon::find($request->jenis_sablon_id);
    $hargaSablon = $jenissablon ? $jenissablon->harga : 0;

     // Menggabungkan nama kategori dan nama sablon untuk deskripsi
    $namaSablonLengkap = $jenissablon->sablonCategory->name . ' - ' . $jenissablon->nama_sablon;
    
    // Tahap 1: Hitung total kuantitas dari semua item
    $totalQty = 0;
    $validItems = [];
    foreach ($request->items as $sizeId => $item) {
        $qty = (int)($item['qty'] ?? 0);
        if ($qty > 0) {
            $size = Size::find($sizeId);
            if ($size) {
                $totalQty += $qty;
                $validItems[] = ['size' => $size, 'quantity' => $qty];
            }
        }
    }

    // Tahap 2: Validasi minimum pemesanan
    if ($totalQty > 0 && $totalQty < 12) {
        return response()->json(['error' => 'Minimum pemesanan adalah 12 pcs. Total pesanan Anda saat ini ' . $totalQty . ' pcs.'], 422);
    }
    if ($totalQty === 0) {
        return response()->json(['error' => 'Anda harus memasukkan jumlah (quantity) minimal pada satu ukuran.'], 422);
    }
    
    // Tahap 3: Tentukan persentase diskon berdasarkan total kuantitas
    $discountRate = 0; // dalam desimal, 0.05 = 5%
    if ($totalQty >= 100) {
        $discountRate = 0.15; // 15% untuk 100 pcs atau lebih
    } elseif ($totalQty >= 24) {
        $discountRate = 0.10; // 10% untuk 24-99 pcs
    } elseif ($totalQty >= 12) {
        $discountRate = 0.05; // 5% untuk 12-23 pcs
    }

    // Tahap 4: Hitung ulang harga total dengan diskon & siapkan detail JSON
    $totalPrice = 0;
    $orderedItemsDetails = [];

    foreach ($validItems as $item) {
        $size = $item['size'];
        $qty = $item['quantity'];

        // Harga bahan asli
        $originalBahanPrice = $size->price;
        // Hitung harga bahan setelah diskon
        $discountedBahanPrice = $originalBahanPrice * (1 - $discountRate);

        // Harga per item (bahan diskon + sablon)
        $pricePerItem = $discountedBahanPrice + $hargaSablon;
        $subtotal = $pricePerItem * $qty;
        
        $totalPrice += $subtotal;

        $orderedItemsDetails[] = [
            'size' => $size->nama_size,
            'quantity' => $qty,
            'price' => $originalBahanPrice, // Harga asli bahan
            'discount_percent' => $discountRate * 100, // Simpan info diskon
            'sablon_price' => $hargaSablon,
            'subtotal' => $subtotal,
        ];
    }
    
    // Tahap 5: Simpan ke database
    $data = $request->except(['file_design', 'items', '_token', 'fabric_type', 'bahan_id', 'jenis_sablon_id']);

    if ($request->hasFile('file_design')) {
        $data['file_design'] = upload('customorder', $request->file('file_design'), 'file_design');
    } else {
        $data['file_design'] = 'design.jpg';
    }

    $bahan = $validItems[0]['size']->bahan;
    
    $data['fabric_type'] = $bahan->nama_bahan;
    $data['jenis_sablon'] = $namaSablonLengkap;
    $data['user_id'] = auth()->id();
    $data['sablon_price'] = $hargaSablon;
    $data['price'] = 0;
    $data['total_price'] = $totalPrice;
    $data['qty'] = $totalQty;
    $data['size'] = json_encode($orderedItemsDetails);

    $data['dp_paid'] = 0;
    $data['remaining_payment'] = $totalPrice + (int)($request->ongkir ?? 0);
    $data['status'] = 'Pending';
    $data['order_date'] = now();
    $data['completion_date'] = now()->addWeeks(1);
    
    $data['province_id'] = $request->province_id;
    $data['regency_id'] = $request->city_id;
    $data['district_id'] = $request->district_id;
    $data['village_id'] = $request->village_id ?? 0;
    $data['ongkir'] = (int)($request->ongkir ?? 0);
    $data['courir'] = $request->courier_service;
    
    CustomOrder::create($data);

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
}
