<!DOCTYPE html>
<html lang="id" class="no-js">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', config('himdes.singkatan') . ' ' . config('himdes.kota') . ' | ' . config('himdes.nama'))</title>
    <meta name="description" content="@yield('description', config('himdes.deskripsi'))">
    <meta name="theme-color" content="#0a1f44">
    <link rel="canonical" href="{{ url()->current() }}">

    <meta property="og:type" content="website">
    <meta property="og:site_name" content="{{ config('himdes.nama') }}">
    <meta property="og:title" content="@yield('title', config('himdes.singkatan') . ' ' . config('himdes.kota'))">
    <meta property="og:description" content="@yield('description', config('himdes.deskripsi'))">
    <meta property="og:image" content="@yield('og_image', asset('images/logo.png'))">

    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}?v={{ @filemtime(public_path('css/app.css')) }}">
    <script>document.documentElement.className = 'js';</script>
</head>
<body>
    @include('partials.icons')

    <a class="skip-link" href="#konten">Lompat ke konten</a>

    @include('partials.header')

    <main id="konten">
        @yield('content')
    </main>

    @include('partials.footer')

    <script src="{{ asset('js/app.js') }}?v={{ @filemtime(public_path('js/app.js')) }}" defer></script>
</body>
</html>
