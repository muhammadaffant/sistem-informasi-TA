<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductVariant;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CartController extends Controller
{
    public function addToCar1t(Request $request, $id)
    {

        $product = Product::findOrFail($id);

        $price = $product->discount_price === 0
            ? $product->selling_price
            : $product->price_after_discount;

        Cart::add([
            'id' => $id,
            'name' => $request->product_name,
            'qty' => $request->qty,
            'price' => $price,
            'weight' => 1,
            'options' => [
                'size' => $request->size,
                'color' => $request->color,
                'image' => $product->product_thumbnail,
            ],
        ]);

        return response()->json(['success' => 'success', 'message' => 'Data berhasil ditambahkan ke Keranjang']);
    }

    public function addToCart(Request $request, $product_id)
    {
        $request->validate([
            'variant_id' => 'required|exists:product_variants,id',
            'color'      => 'required|string',
            'qty'        => 'required|integer|min:1'
        ]);

        $variant = ProductVariant::with('product')->find($request->variant_id);
        $product = $variant->product;
        $quantity_to_add = $request->qty;
        $available_stock = $variant->quantity;

        // Cari apakah varian ini sudah ada di keranjang
        $cartItem = Cart::search(function ($cartItem, $rowId) use ($variant) {
            return isset($cartItem->options['variant_id']) && $cartItem->options['variant_id'] == $variant->id;
        });

        $quantity_in_cart = 0;
        if ($cartItem->isNotEmpty()) {
            $quantity_in_cart = $cartItem->first()->qty;
        }

        //  Validasi utama. Cek total kuantitas vs stok
        if (($quantity_in_cart + $quantity_to_add) > $available_stock) {
            $sisa_bisa_ditambah = $available_stock - $quantity_in_cart;
            $pesan_error = 'Stok tidak mencukupi! Sisa stok: ' . $available_stock . '. ';
            
            if ($sisa_bisa_ditambah > 0) {
                 $pesan_error .= 'Anda hanya bisa menambahkan ' . $sisa_bisa_ditambah . ' lagi.';
            } else {
                 $pesan_error .= 'Anda tidak dapat menambahkan item ini lagi.';
            }

            return response()->json(['error' => $pesan_error], 422); // 422 Unprocessable Entity
        }

        // Jika validasi lolos, tambahkan ke keranjang
        $price = $variant->discount > 0 ? $variant->price_after_discount : $variant->price;

        Cart::add([
            'id'      => $product->id,
            'name'    => $product->product_name,
            'qty'     => $quantity_to_add,
            'price'   => $price,
            'weight'  => 1,
            'options' => [
                'image'      => Storage::url($product->product_thumbnail),
                'color'      => $request->color,
                'size'       => $variant->size,
                'variant_id' => $variant->id 
            ]
        ]);

        return response()->json(['success' => 'Produk berhasil ditambahkan ke keranjang']);
    }
    

    public function addMiniCart()
    {
        $carts = Cart::content();
        $cartQty = Cart::count();
        $cartTotal =  Cart::total();

        return response()->json(array(
            'carts' => $carts,
            'cartQty' => $cartQty,
            'cartTotal' => $cartTotal
        ));
    }

    public function removeMiniCart($rowId)
    {
        Cart::remove($rowId);

        return response()->json(['success' => 'Data Keranjang Berhasil Dihapus']);
    }
}
