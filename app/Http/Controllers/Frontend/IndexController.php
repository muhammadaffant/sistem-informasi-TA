<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\MultiImg;
use App\Models\Product;
use App\Models\Slider;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\Review;
use App\Models\OrderItem;

class IndexController extends Controller
{
    public function index()
    {
        // Ambil sliders dan brands
        $title = 'Home';
        $sliders = Slider::where('status', 1)->limit(3)->get() ?? collect();
        $brands = Brand::all() ?? collect();

        // Eager Load categories dengan relasi subCategory dan subSubCategory
        $categories = Category::with(['subCategory.subSubCategory'])
            ->orderBy('category_name', 'ASC')
            ->get() ?? collect();

        // Ambil produk dengan kondisi spesifik, dengan eager load relasi yang mungkin dipakai
        $products = Product::with(['category', 'brand'])
            ->where('status', 1)
            ->orderBy('id', 'DESC')
            ->limit(6)->get() ?? collect();

        // $featured = Product::with(['category', 'brand'])
        //     ->where('featured', 1)
        //     ->orderBy('id', 'DESC')
        //     ->limit(6)->get() ?? collect();

        // $hotDeals = Product::with(['category', 'brand'])
        //     ->where('hot_deals', 1)
        //     ->orderBy('id', 'DESC')
        //     ->limit(3)->get() ?? collect();

        // $specialOffer = Product::with(['category', 'brand'])
        //     ->where('special_offer', 1)
        //     ->orderBy('id', 'DESC')
        //     ->limit(3)->get() ?? collect();

        $specialDeals = Product::with(['category', 'brand'])
            ->where('special_deals', 1)
            ->orderBy('id', 'DESC')
            ->limit(3)->get() ?? collect();

        // Optimalkan skip category dan produk
        $skippedCategories = Category::with('product')
            ->skip(0)->take(2)->get() ?? collect();

        $skip_category_0 = $skippedCategories->get(0) ?? null;
        $skip_product_0 = $skip_category_0->products ?? collect();

        $skip_category_1 = $skippedCategories->get(1) ?? null;
        $skip_product_1 = $skip_category_1->products ?? collect();

        // Optimalkan skip brand dan produk
        $skip_brand_5 = Brand::skip(0)->first() ?? null;
        $skip_product_5 = $skip_brand_5->products ?? collect();

        // Return view dengan variabel
        return view('frontend.index', compact([
            'title',
            'sliders',
            'categories',
            'products',
            // 'featured',
            // 'specialOffer',
            // 'hotDeals',
            'specialDeals',
            'skip_product_0',
            'skip_category_0',
            'skip_category_1',
            'skip_product_1',
            'skip_brand_5',
            'skip_product_5',
            'brands',
        ]));
    }

    public function userLogout()
    {
        Auth::logout();
        return redirect()->route('login');
    }

    public function userProfileEdit()
    {
        $id = Auth::user()->id;
        $user = User::find($id);

        return view('frontend.profile.user_profile', compact('user'));
    }

    public function userProfileUpdate(Request $request)
    {
        $data = User::find(Auth::user()->id);
        $data->name = $request->name;
        $data->email = $request->email;
        $data->numberphone = $request->numberphone;

        $data->save();

        return back()->with('success', 'Profil berhasil diperbarui!');
    }

    public function changePassword()
    {
        $id = Auth::user()->id;
        $user = User::find($id);

        return view('frontend.profile.change_password', compact('user'));
    }

public function userUpdatePassword(Request $request)
{
    $request->validate([
        'oldpassword' => 'required',
        'password' => 'required|confirmed'
    ]);

    $user = Auth::user();

    // Ambil password lama dari database
    $currentPassword = User::find($user->id)->password;

    // Cek apakah password lama sesuai
    if (!Hash::check($request->oldpassword, $currentPassword)) {
        // Jika tidak sesuai, redirect dengan pesan error
        return back()->with('error', 'Password lama tidak sesuai.');
    }

    // Update password jika cocok
    $user->password = Hash::make($request->password);
    $user->save();

    return back()->with('success', 'Password berhasil diubah.');
}


public function detail($id, $slug)
{
    $title = 'Detail';
    // Gunakan with('variants') untuk eager load relasi varian
    $product = Product::with('variants')->findOrFail($id);

    $multiImg = MultiImg::where('product_id', $id)->orderBy('id', 'DESC')->get();
    $relatedProduct = Product::where('category_id', $product->category_id)->where('id', '!=', $product->id)->orderBy('id', 'DESC')->get();
    $specialDeals = Product::where('special_deals', 1)->orderBy('id', 'DESC')->limit(3)->get();

    // =======================================================
    // == LOGIKA UNTUK FITUR REVIEW (BAGIAN YANG DITAMBAHKAN) ==
    // =======================================================

    // 1. Ambil semua ulasan yang statusnya 'approved' untuk produk ini.
    //    Kita juga mengambil data 'user' yang terkait agar bisa menampilkan nama pemberi ulasan.
    $reviews = Review::with('user')
                ->where('product_id', $id)
                ->where('status', 'approved') // Hanya tampilkan yang sudah disetujui
                ->latest()
                ->get();

    // 2. Cek apakah pengguna yang sedang login sudah pernah membeli produk ini.
    //    Ini untuk memastikan hanya pembeli yang bisa menulis ulasan.
    $hasPurchased = false; // Defaultnya false
    if (Auth::check()) { // Cek dulu apakah ada pengguna yang login
        $hasPurchased = OrderItem::whereHas('order', function ($query) {
            $query->where('user_id', Auth::id()); // Cek pesanan milik user yg login
        })->where('product_id', $id)->exists(); // Cek apakah produk ini ada di item pesanannya
    }

    // ===================================
    // == AKHIR BAGIAN YANG DITAMBAHKAN ==
    // ===================================

    // Kirim semua variabel ke view, termasuk variabel baru 'reviews' dan 'hasPurchased'
    return view('frontend.product.detail_product', compact([
        'title',
        'product',
        'multiImg',
        'relatedProduct',
        'specialDeals',
        'reviews',       // <-- Variabel baru untuk data ulasan
        'hasPurchased',  // <-- Variabel baru untuk status pembelian
    ]));
}

    public function subcatProduct($subcat_id, $slug)
    {
        $title = 'Kategori';
        $products = Product::status()->subcategory($subcat_id)->orderBy('id', 'DESC')->get();
        $categories = Category::orderBy('category_name', 'ASC')->get();

        return view('frontend.category.product_category', compact('categories', 'products', 'title'));
    }

    public function tagProduct($tag)
    {
        $title = 'tagProduct';
        $products = Product::status()->tag($tag)->orderBy('id', 'DESC')->get();
        $categories = Category::orderBy('category_name', 'ASC')->get();

        return view('frontend.tags.tags_view', compact('products', 'categories', 'title'));
    }

    public function subsubcatProduct($subsubcat_id, $slug)
    {
        $title = 'SubSubCategory';
        $products = Product::status()->subsubcategory($subsubcat_id)->orderBy('id', 'DESC')->get();
        $categories = Category::orderBy('category_name', 'ASC')->get();

        return view('frontend.category.subsubcategory_product', compact('categories', 'title','products'));
    }

    // get data product with ajax
// app/Http/Controllers/Frontend/IndexController.php

public function getProductModal($id)
{
    // Eager load relasi brand, category, dan variants
    $product = Product::with(['brand', 'category', 'variants'])->findOrFail($id);
    
    // Anda masih perlu URL thumbnail
    $product['product_thumbnail'] = Storage::url($product['product_thumbnail']);

    // Logika lama untuk warna dan ukuran tidak lagi diperlukan di sini
    // $color = $product->product_color;
    // $product_color = explode(',', $color);
    // $size = $product->product_size;
    // $product_size = explode(',', $size);

    // Kirim seluruh objek produk yang sudah berisi varian
    return response()->json([
        'product' => $product,
    ]);
}
}
