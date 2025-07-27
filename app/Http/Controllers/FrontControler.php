<?php

namespace App\Http\Controllers;

use App\Models\Layanan;
use App\Models\Produk;
use Illuminate\Http\Request;

class FrontControler extends Controller
{
    public function home()
    {
        $layanans = Layanan::all();
        $listProduk = Produk::with(['produkDetails'])->get();

        return view('frontend.home', compact('layanans', 'listProduk'));
    }
}
