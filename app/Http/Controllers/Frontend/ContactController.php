<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use App\Mail\ContactMessage;

class ContactController extends Controller
{
    public function index ()
    {
        return view('frontend.kontak.index',[
            'title' => 'Kontak'
        ]);
    }
    public function send(Request $request)
{
    // Validasi input
    $request->validate([
        'name' => 'required|string|max:100',
        'email' => 'required|email',
        'message' => 'required|string|max:1000',
    ]);

    // Kirim email (optional, jika ingin)
    Mail::to('affantmami@gmail.com')->send(new ContactMessage($request->all()));

    // Atau simpan ke database (opsional jika punya model)

    // Flash message sukses
    return back()->with('success', 'Pesan Anda berhasil dikirim!');
}
}
