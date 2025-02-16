@extends('layouts.app')

@section('content')
<div class="text-center">
    <h2 class="text-4xl font-bold" style="font-size: 2rem !important;">🔗 QR Code Generator</h2><br>

    <form action="{{ route('qrcode.generate') }}" method="POST">
        @csrf
        <label>Masukkan URL:</label>
        <input type="text" name="url" required>

        <label>Ukuran QR Code:</label>
        <select name="size">
            <option value="200">Kecil (200x200)</option>
            <option value="300" selected>Sedang (300x300)</option>
            <option value="500">Besar (500x500)</option>
        </select>

        <label>Format QR Code:</label>
        <select name="format">
            <option value="svg" selected>SVG</option>
            <option value="png">PNG</option>
        </select>
        <br><br>

        <div class="flex justify-center mt-4">
            <button type="submit" class="bg-blue-500 text-black px-4 py-2 rounded-lg hover:bg-blue-600">
                🎯 Generate QR Code
            </button>
        </div>
        
    </form><br><br><br>

    @if (session('qr_code'))
        <div class="mt-4 flex justify-center">
            {!! session('qr_code') !!}
        </div>
    @endif<br><br>

    @if (session('file_url'))
        <div class="mt-4 flex justify-center">
            <br>
            <a href="{{ route('qrcode.download', basename(session('file_path'))) }}" class="btn btn-primary">
                ⬇️ Unduh QR Code
            </a>
        </div>
    @endif
</div>
@endsection
