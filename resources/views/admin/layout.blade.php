<!DOCTYPE html>
<html lang="id" class="no-js">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <title>@yield('title', 'Admin') | Panel {{ config('himdes.singkatan') }}</title>
    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}?v={{ @filemtime(public_path('css/app.css')) }}">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}?v={{ @filemtime(public_path('css/admin.css')) }}">
    <script>document.documentElement.className = 'js';</script>
</head>
<body class="adm-body">
    @include('partials.icons')
    <div class="adm">
        <aside class="adm-side" id="admSide" aria-label="Menu admin">
            <a class="adm-brand" href="{{ route('admin.dashboard') }}">
                <img src="{{ asset('images/logo.png') }}" alt="" width="36" height="39">
                <span><strong>{{ config('himdes.singkatan') }}</strong><small>Panel admin</small></span>
            </a>
            <nav class="adm-nav">
                @foreach (config('admin.menu') as $grup => $items)
                    <p class="adm-group">{{ $grup }}</p>
                    @foreach ($items as [$target, $label, $ikon])
                        @php
                            $rute = str_starts_with($target, 'admin.');
                            $res = request()->route('resource');
                            $aktif = $rute
                                ? (request()->routeIs($target) || ($target === 'admin.profil' && $res === 'slide'))
                                : ($res === $target);
                        @endphp
                        <a href="{{ $rute ? route($target) : route('admin.res.index', $target) }}" class="{{ $aktif ? 'is-active' : '' }}" @if ($aktif) aria-current="page" @endif>
                            <svg class="ic"><use href="#i-{{ $ikon }}"/></svg>{{ $label }}
                        </a>
                    @endforeach
                @endforeach
            </nav>
            <div class="adm-foot">
                <a href="{{ route('home') }}" target="_blank" rel="noopener"><svg class="ic"><use href="#i-external"/></svg>Lihat situs</a>
                <a href="{{ route('admin.akun') }}" class="{{ request()->routeIs('admin.akun') ? 'is-active' : '' }}"><svg class="ic"><use href="#i-lock"/></svg>Ganti kata sandi</a>
                <form method="post" action="{{ route('logout') }}">@csrf
                    <button type="submit"><svg class="ic"><use href="#i-logout"/></svg>Keluar</button>
                </form>
            </div>
        </aside>
        <div class="adm-scrim" data-adm="close"></div>

        <div class="adm-main">
            <header class="adm-top">
                <button type="button" class="adm-burger" data-adm="open" aria-label="Buka menu" aria-controls="admSide"><svg class="ic"><use href="#i-menu"/></svg></button>
                <h1>@yield('heading')</h1>
                <span class="adm-user">{{ auth()->user()->name }}</span>
            </header>
            <main class="adm-content">
                @if (session('ok'))<div class="alert alert-ok" role="status">{{ session('ok') }}</div>@endif
                @if ($errors->any())<div class="alert alert-err" role="alert">Ada isian yang perlu diperbaiki. Periksa kolom bertanda merah.</div>@endif
                @yield('content')
            </main>
        </div>
    </div>
    <script src="{{ asset('js/admin.js') }}?v={{ @filemtime(public_path('js/admin.js')) }}" defer></script>
</body>
</html>
