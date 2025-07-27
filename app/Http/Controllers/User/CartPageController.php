<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;

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
        Cart::update($rowId, $row->qty + 1);
        return response()->json(['success' => 'Data Qty Berhasil Ditambahkan']);
    }

    public function decrementMyCart($rowId)
    {
        $row = Cart::get($rowId);
        Cart::update($rowId, $row->qty - 1);
        return response()->json(['success' => 'Data Qty Berhasil Ditambahkan']);
    }
}
