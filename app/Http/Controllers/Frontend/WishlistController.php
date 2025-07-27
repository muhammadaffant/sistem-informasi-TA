<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function store(Request $request, $product_id)
    {
        if (Auth::check()) {
            $whislist = Wishlist::where('user_id', Auth::user()->id)->where('product_id', $product_id)->first();

            if ($whislist) {
                return response()->json(['error' => 'Product sudah ada di Wishlist anda']);
            }

            Wishlist::create([
                'user_id' => Auth::user()->id,
                'product_id' => $product_id
            ]);

            return response()->json(['success' => 'Product Berhasil Disimpan Wishlist']);
        } else {
            return response()->json(['error' => 'Silahkan Login Terlebih Dahulu']);
        }
    }

    public function viewWishlist()
    {
        $wishlist = Wishlist::with('product')->where('user_id', Auth::user()->id)->latest()->get();
        return view('frontend.wishlist.view_wishlist',[
            'title' => 'My Wishlist',
            'wishlist' => $wishlist
        ]);
    }

    public function getWishlist()
    {
        $wishlist = Wishlist::with('product')->where('user_id', Auth::user()->id)->latest()->get();
        return response()->json($wishlist);
    }

    public function removeWishlist($id)
    {
        Wishlist::where('user_id', Auth::user()->id)->where('id', $id)->delete();
        return response()->json(['success' => 'Data Wishlist berhasil dihapus']);
    }
}
