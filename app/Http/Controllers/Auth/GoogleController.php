<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Carbon\Carbon;

class GoogleController extends Controller
{

    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }


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
                // Username & numberphone tidak disediakan Google, jadi bisa isi default atau null
                $newUser = User::create([
                    'name' => $googleUser->name,
                    'email' => $googleUser->email,
                    'username' => strstr($googleUser->email, '@', true) . Str::random(3),
                    'google_id' => $googleUser->id,
                    'password' => Hash::make(Str::random(24)),
                    'email_verified_at' => Carbon::now(),
                    // 'numberphone'
                ]);

                if (method_exists($newUser, 'assignRole')) {
                    $newUser->assignRole('user');
                }

                Auth::login($newUser);
            }

            return redirect('/dashboard');

        } catch (\Exception $e) {
            // Tangani error, misalnya kembali ke halaman login dengan pesan error
            // Untuk debugging, Anda bisa mencetak errornya:
            // dd($e->getMessage());
            return redirect('/login')->with('error', 'Gagal login dengan Google: ' . $e->getMessage());
        }
    }
}