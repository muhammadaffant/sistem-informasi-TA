<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\ProductVariant;
use Carbon\Carbon;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

// Tambahkan 2 baris ini
use App\Mail\OrderInvoiceMail;
use Illuminate\Support\Facades\Mail;

class UserCheckoutController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            if (Cart::total() > 0) {
                return view('frontend.checkout.index', [
                    'title' => 'Checkout',
                    'carts' => Cart::content(),
                    'cartQty' => Cart::count(),
                    'total' => Cart::total()
                ]);
            }
            return redirect()->to('/');
        }
        return redirect()->route('login')->with(['message' => 'Silakan Login Terlebih Dahulu', 'alert-type' => 'error']);
    }

    // Mengambil Provinsi dari API Komerce
    public function getProvinces(Request $request)
    {
        $response = Http::withHeaders([
            'key' => env('RAJAONGKIR_API_KEY'),
        ])->get('https://rajaongkir.komerce.id/api/v1/destination/province', [
            'province_name' => $request->q
        ]);

        if ($response->successful() && isset($response->json()['meta']['status']) && $response->json()['meta']['status'] === 'success') {
            return response()->json($response->json()['data'] ?? []);
        }
        return response()->json([], 500);
    }

    // Mengambil Kota dari API Komerce
    public function getCities(Request $request, $province_id)
    {
        $searchTerm = $request->q;
        $response = Http::withHeaders([
        'key' => env('RAJAONGKIR_API_KEY'),
        ])->get('https://rajaongkir.komerce.id/api/v1/destination/city/' . $province_id, [
            'city_name' => $searchTerm
        ]);

        
        if ($response->successful() && isset($response->json()['meta']['status']) && $response->json()['meta']['status'] === 'success') {
            return response()->json($response->json()['data'] ?? []);
        }
        return response()->json([], 500);
    }

    public function getDistricts(Request $request, $city_id)
    {
        $response = Http::withHeaders(['key' => env('RAJAONGKIR_API_KEY')])
            ->get('https://rajaongkir.komerce.id/api/v1/destination/district/' . $city_id, ['district_name' => $request->q]);

        if ($response->successful() && isset($response->json()['meta']['status']) && $response->json()['meta']['status'] === 'success') {
            return response()->json($response->json()['data'] ?? []);
        }
        return response()->json([], 500);
    }
    public function getOngkir(Request $request)
    {
    $validated = $request->validate([
            'origin_id'      => 'required|integer',
            'destination_id' => 'required|integer',
            'weight'         => 'required|integer',
            'courier'        => 'required|string',
        ]);

        try {
            // ==========================================================
            $response = Http::asForm()->withHeaders([
                'key' => env('RAJAONGKIR_API_KEY'),
            ])->post('https://rajaongkir.komerce.id/api/v1/calculate/district/domestic-cost', [
                'origin'        => $validated['origin_id'],
                'destination'   => $validated['destination_id'],
                'weight'        => $validated['weight'],
                'courier'       => $validated['courier'],
            ]);

            if ($response->successful() && isset($response->json()['meta']['status']) && $response->json()['meta']['status'] === 'success') {
                return response()->json([
                    'status' => 'success',
                    'data' => $response->json()['data'],
                ]);
            }

            $errorMessage = $response->json()['meta']['message'] ?? 'Gagal mengambil data ongkir.';
            return response()->json(['status' => 'error', 'message' => $errorMessage], 400);

        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Tidak dapat terhubung ke server Komerce.'], 500);
        }
    }


    public function detail(Request $request)
    {
        // Validasi data yang masuk
        $validated = $request->validate([
            'name' => 'required|string|max:255', 'email' => 'required|email',
            'phone' => 'required|string', 'post_code' => 'required|string',
            'province_id' => 'required|integer', 'city_id' => 'required|integer',
            'district_id' => 'required|integer',
            'address' => 'required|string', 'notes' => 'nullable|string',
            'shipping_cost' => 'required|numeric', 'courier_hidden' => 'required|string',
            'courier_service_hidden' => 'required|string',
        ]);

        $carts = Cart::content();
        $total = Cart::total();
        $totalAmount = (int) str_replace(',', '', Cart::subtotal()) + $validated['shipping_cost'];
        
        $orderId = Order::insertGetId([
            'user_id' => Auth::id(), 'province_id' => $validated['province_id'],
            'regency_id' => $validated['city_id'], 'name' => $validated['name'],
            'district_id' => $validated['district_id'],
            'email' => $validated['email'], 'phone' => $validated['phone'],
            'address' => $validated['address'], 'post_code' => $validated['post_code'],
            'notes' => $validated['notes'], 'amount' => $totalAmount,
            'ongkir' => $validated['shipping_cost'],
            'courir' => $validated['courier_hidden'] . ' - ' . $validated['courier_service_hidden'],
            'invoice_no' => 'INV' . mt_rand(10000000, 99999999),
            // 'order_date' => Carbon::now()->format('d F Y'),
            // 'order_month' => Carbon::now()->format('F'), 'order_year' => Carbon::now()->format('Y'),
            'status' => 'Pending', 'created_at' => Carbon::now(),
        ]);
        
        foreach ($carts as $cart) {
            OrderItem::insert([
                'order_id' => $orderId, 'product_id' => $cart->id,
                'color' => $cart->options->color, 'size' => $cart->options->size,
                'qty' => $cart->qty, 'price' => $cart->price, 'created_at' => Carbon::now(),
            ]);
        }

        // Midtrans Logic
        \Midtrans\Config::$serverKey = config('midtrans.server_key');
        \Midtrans\Config::$isProduction = config('midtrans.is_production', false);
        \Midtrans\Config::$isSanitized = true; \Midtrans\Config::$is3ds = true;

        $params = [
            'transaction_details' => ['order_id' => $orderId . '-' . time(), 'gross_amount' => $totalAmount],
            'customer_details' => ['first_name' => $validated['name'], 'email' => $validated['email'], 'phone' => $validated['phone']],
        ];

        $snapToken = \Midtrans\Snap::getSnapToken($params);
        Cart::destroy();

    return view('frontend.checkout.detail', [
        'title' => 'Checkout Detail',
        'snapToken' => $snapToken,
        'orderId' => $orderId,
        'carts' => $carts, // Kirim data cart
        'total' => $total,
        'ongkir' => $validated['shipping_cost'],
        'name' => $validated['name'],
        'phone' => $validated['phone'],
        'address' => $validated['address'],
        'notes' => $validated['notes'],
    ]);
    }


public function checkoutStore(Request $request)
{
    $id_order = $request->id_order;
    $data = json_decode($request->get('json'));

    // Ambil data order utama di luar transaksi agar bisa digunakan nanti
    $order = Order::findOrFail($id_order);

    DB::transaction(function () use ($order, $data) {
        // 1. Update status order menjadi Success
        $order->update([
            'status' => 'Success',
            'payment_type' => $data->payment_type,
            'transaction_id' => $data->transaction_id
        ]);

        // Ambil semua item dari order tersebut
        $orderItems = OrderItem::where('order_id', $order->id)->get();

        // Loop setiap item untuk mengurangi stok varian produk
        foreach ($orderItems as $item) {
            $variant = ProductVariant::where('product_id', $item->product_id)
                                        ->where('size', $item->size)
                                        ->first();
            if ($variant) {
                $variant->decrement('quantity', $item->qty);
            }
        }
    }); // Transaksi database selesai.

    // ==========================================================
    
    // ==========================================================
    try {
        // Ambil data item order lagi untuk dilampirkan ke email
        $orderItems = OrderItem::with('product')->where('order_id', $order->id)->get();

        // Kirim email ke alamat email user yang ada di data order
        Mail::to($order->email)->send(new OrderInvoiceMail($order, $orderItems));

    } catch (\Exception $e) {
        // (Opsional) Catat error jika email gagal terkirim
        // Log::error('Gagal mengirim email invoice untuk order #' . $order->id . ': ' . $e->getMessage());
    }
    // ==========================================================
    // SELESAI KODE PENGIRIMAN EMAIL
    // ==========================================================

    $notification = [
        'message' => 'Pembayaran Berhasil dan Invoice Telah Dikirim!', // Ubah pesan notifikasi
        'alert-type' => 'success',
    ];

    return redirect()->route('user.order')->with($notification);
}


    public function destroy($id)
{
    $order = Order::findOrFail($id);
    if ($order->status == 'Pending') {
        $order->delete();

        return redirect()->back()->with('success', 'Order has been deleted successfully.');
    } else {
        return redirect()->back()->with('error', 'You can only delete orders with status Pending.');
    }
}

}
