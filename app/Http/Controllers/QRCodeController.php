<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Storage;

class QRCodeController extends Controller
{
    // Menampilkan halaman form QR Code
    public function showForm()
    {
        return view('codeqr');
    }

    // Fungsi untuk generate QR Code dan menyimpannya
    public function generate(Request $request)
    {
        // Validasi input
        $request->validate([
            'url' => 'required|url',
            'size' => 'required|integer|min:100|max:1000',
            'format' => 'required|in:svg,png',
        ]);

        // Ambil data input
        $url = $request->input('url');
        $size = $request->input('size');
        $format = $request->input('format');

        // Nama file unik berdasarkan timestamp
        $fileName = 'qrcode_' . time() . '.' . $format;
        $path = "qrcodes/$fileName";

        // Generate QR Code
        $qrCode = QrCode::format($format)->size($size)->generate($url);

        // Simpan QR Code ke storage
        Storage::disk('public')->put($path, $qrCode);

        // URL file untuk tampilan dan unduhan
        $fileUrl = asset("storage/$path");

        return back()->with([
            'qr_code' => $format === 'svg' ? $qrCode : null, // Tampilkan langsung jika SVG
            'file_url' => $fileUrl,
            'file_path' => $path,
        ]);
    }

    // Fungsi untuk mengunduh QR Code
    public function download($fileName)
    {
        $path = storage_path("app/public/qrcodes/$fileName");

        if (file_exists($path)) {
            return response()->download($path);
        } else {
            return abort(404);
        }
    }
}
