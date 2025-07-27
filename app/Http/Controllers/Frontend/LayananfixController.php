<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Layanan;

class LayananfixController extends Controller
{
    public function index()
    {
        $layanans = Layanan::latest()->get();
        return view('frontend.layanan.index', compact('layanans'));
    }
}
