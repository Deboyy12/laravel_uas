<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QRCodeController;
use App\Http\Controllers\XSSController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Mews\Captcha\Facades\Captcha;

// Halaman Landing Page
Route::get('/', function () {
    return view('landingpage.landingpage');
});

// Dashboard Admin (Hanya bisa diakses setelah login & verifikasi email)
Route::get('/admin', function () {
    return view('admin.dashboard', ['showSidebar' => true]);
})->middleware(['auth', 'verified'])->name('dashboard');

// Middleware untuk user yang sudah login
Route::middleware('auth')->group(function () {
    // Halaman profil pengguna
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Routing untuk QR Code
    Route::get('/qrcode', [QRCodeController::class, 'showForm'])->name('qrcode.form'); // Form QR Code
    Route::post('/generate-qrcode', [QRCodeController::class, 'generate'])->name('qrcode.generate'); // Generate QR Code
    Route::get('/qrcode/download/{fileName}', [QRCodeController::class, 'download'])->name('qrcode.download'); // Download QR Code

    // Routing XSS Protection
    Route::get('/xss-form', [XSSController::class, 'showForm'])->name('xss.form');
    Route::post('/submit-comment', [XSSController::class, 'sanitizeInput'])->name('submit.comment');
});

// Route untuk menampilkan CAPTCHA
Route::get('/captcha', function () {
    return Captcha::create('default');
})->name('captcha');

// Route untuk Refresh Captcha tanpa Reload
Route::get('/refresh-captcha', function (Request $request) {
    return response()->json(['captcha' => captcha_src('default') . '?' . time()]);
});

// Include routing autentikasi (login, register, dll.)
require __DIR__.'/auth.php';
