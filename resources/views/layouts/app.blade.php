<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles & Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Menambahkan CSS watermark dari public/css -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100 dark:bg-gray-900">

        <!-- Watermark Logo -->
        <div class="watermark">
            <img src="{{ asset('images/logo.png') }}" alt="Logo">
        </div>

        <!-- Hapus dashboard di halaman QR Code -->
        @if (!request()->is('qrcode'))
            @include('layouts.navigation')
        @endif

        <!-- Sidebar hanya muncul jika $showSidebar bernilai true -->
        @if(isset($showSidebar) && $showSidebar)
            @include('layouts.sidebar')
        @endif

        <!-- Page Heading -->
        @yield('header')

        <!-- Page Content -->
        <main>
            @yield('content')
        </main>
    </div>
</body>
</html>
