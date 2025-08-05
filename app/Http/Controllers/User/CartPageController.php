<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use App\Models\ProductVariant;

class CartPageController extends Controller
{
    public function index()
    {
        return view('frontend.mycart.index');
    }

    public function getMyCart()
    {
        $carts = Cart::content();
        $cartQty = Cart::count();
        $cartTotal = Cart::total();

        return response()->json(array(
            'carts' => $carts,
            'cartQty' => $cartQty,
            'cartTotal' => $cartTotal
        ));
    }

    public function removeMyCart($rowId)
    {
        Cart::remove($rowId);
        return response()->json(['success' => 'Data Cart Berhasil Dihapus']);
    }

    public function incrementMyCart($rowId)
        {
            $row = Cart::get($rowId);

            if (!isset($row->options['variant_id'])) {
                // Fallback: jika tidak ada variant_id, lakukan increment biasa
                Cart::update($rowId, $row->qty + 1);
                return response()->json(['success' => 'Data Qty Berhasil Ditambahkan']);
            }

            // Cari varian berdasarkan variant_id yang disimpan
            $variant = ProductVariant::find($row->options['variant_id']);

            // Validasi: Cek jika varian ada dan stok mencukupi
            if (!$variant || ($row->qty + 1) > $variant->quantity) {
                return response()->json(['error' => 'Stok maksimum untuk item ini telah tercapai!']);
            }

            // Jika lolos validasi, update kuantitas
            Cart::update($rowId, $row->qty + 1);

            return response()->json(['success' => 'Data Qty Berhasil Ditambahkan']);
        }

        public function decrementMyCart($rowId)
        {
            $row = Cart::get($rowId);
            // Pastikan kuantitas tidak kurang dari 1
            if ($row->qty > 1) {
                Cart::update($rowId, $row->qty - 1);
            }
            return response()->json(['success' => 'Data Qty Berhasil Dikurangi']);
        }
}
