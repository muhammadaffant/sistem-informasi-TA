<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Carbon\Carbon; // Tambahkan ini untuk menggunakan Carbon

class GoogleController extends Controller
{
    /**
     * Mengarahkan pengguna ke halaman autentikasi Google.
     */
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Mendapatkan informasi pengguna dari Google dan melakukan login/register.
     */
    public function callback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            // Cari pengguna berdasarkan google_id atau email
            $user = User::where('google_id', $googleUser->id)
                        ->orWhere('email', $googleUser->email)
                        ->first();

            if ($user) {
                // Jika pengguna sudah ada, update google_id jika belum ada dan login
                if (is_null($user->google_id)) {
                    $user->google_id = $googleUser->id;
                    // Tandai email sebagai terverifikasi karena login via Google
                    $user->email_verified_at = Carbon::now();
                    $user->save();
                } elseif (is_null($user->email_verified_at)) {
                    // Jika email_verified_at masih null untuk user yang sudah ada, set juga
                    $user->email_verified_at = Carbon::now();
                    $user->save();
                }
                Auth::login($user);
            } else {
                // Jika pengguna belum ada, buat pengguna baru
                // Username & numberphone tidak disediakan Google, jadi kita bisa isi default atau null
                $newUser = User::create([
                    'name' => $googleUser->name,
                    'email' => $googleUser->email,
                    'username' => strstr($googleUser->email, '@', true) . Str::random(3), // Contoh username
                    'google_id' => $googleUser->id,
                    'password' => Hash::make(Str::random(24)), // Buat password acak
                    'email_verified_at' => Carbon::now(), // <<< Tambahkan baris ini
                    // 'numberphone' bisa dibiarkan null jika schema mengizinkan
                ]);

                // Assign role 'user' seperti pada action Fortify Anda
                // Pastikan Anda sudah menginstal dan mengkonfigurasi spatie/laravel-permission jika menggunakan ini
                if (method_exists($newUser, 'assignRole')) {
                    $newUser->assignRole('user');
                }

                Auth::login($newUser);
            }

            return redirect('/dashboard'); // Arahkan ke dashboard setelah berhasil login

        } catch (\Exception $e) {
            // Tangani error, misalnya kembali ke halaman login dengan pesan error
            // Untuk debugging, Anda bisa mencetak errornya:
            // dd($e->getMessage());
            return redirect('/login')->with('error', 'Gagal login dengan Google: ' . $e->getMessage());
        }
    }
}