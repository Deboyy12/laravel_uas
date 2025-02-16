<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException; 
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Menampilkan tampilan registrasi pengguna.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Menyimpan pengguna baru setelah melakukan registrasi.
     */
    public function store(Request $request): RedirectResponse
    {
        // Validasi input
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'g-recaptcha-response' => ['required'],  // Validasi CAPTCHA
        ]);

        // Verifikasi reCAPTCHA
        $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => env('RECAPTCHA_SECRET_KEY'),  // Pastikan secret key sudah diatur di .env
            'response' => $request->input('g-recaptcha-response')
        ]);

        if (!$response->json()['success']) {
            // Jika verifikasi CAPTCHA gagal, lemparkan error
            throw ValidationException::withMessages(['captcha' => 'Verifikasi Captcha gagal.']);
        }

        // Buat user baru setelah validasi dan CAPTCHA berhasil
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Event setelah registrasi berhasil
        event(new Registered($user));

        // Login otomatis pengguna yang baru saja terdaftar
        Auth::login($user);

        // Redirect ke dashboard setelah registrasi dan login sukses
        return redirect()->route('dashboard');
    }
}
