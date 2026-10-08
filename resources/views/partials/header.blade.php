@php
    $utama = [
        ['Tentang', 'tentang', 'tentang'],
        ['Pengurus', 'pengurus', 'pengurus'],
        ['Program', 'program', 'program'],
        ['Berita', 'berita.index', 'berita.*'],
        ['Dokumentasi', 'galeri', 'galeri'],
        ['Panduan Maba', 'panduan', 'panduan'],
    ];
    $lainnya = [
        ['Agenda', 'agenda', 'agenda', 'calendar'],
        ['Beasiswa & Magang', 'peluang.index', 'peluang.*', 'briefcase'],
        ['Prestasi', 'prestasi', 'prestasi', 'trophy'],
        ['Budaya Daerah', 'budaya', 'budaya', 'globe'],
        ['Direktori Anggota', 'direktori', 'direktori', 'graduation'],
    ];
    $lainAktif = collect($lainnya)->contains(fn ($m) => request()->routeIs($m[2]));
@endphp
<header class="site-header" id="header">
    <div class="container header-inner">
        <a href="{{ route('home') }}" class="brand" aria-label="{{ config('himdes.singkatan') }} beranda">
            <img src="{{ asset('images/logo.png') }}" alt="" width="40" height="43">
            <span class="brand-text">
                <strong>{{ config('himdes.singkatan') }}</strong>
                <small>{{ config('himdes.kota') }}</small>
            </span>
        </a>

        <nav class="nav" id="nav" aria-label="Menu utama">
            @foreach ($utama as [$label, $rute, $pola])
                <a href="{{ route($rute) }}" @if (request()->routeIs($pola)) aria-current="page" @endif>{{ $label }}</a>
            @endforeach

            <div class="dropdown" data-dropdown>
                <button type="button" class="dropdown-btn {{ $lainAktif ? 'is-current' : '' }}" aria-expanded="false" aria-haspopup="true">
                    Lainnya <svg class="ic"><use href="#i-chevron"/></svg>
                </button>
                <div class="dropdown-menu">
                    @foreach ($lainnya as [$label, $rute, $pola, $ikon])
                        <a href="{{ route($rute) }}" @if (request()->routeIs($pola)) aria-current="page" @endif>
                            <svg class="ic"><use href="#i-{{ $ikon }}"/></svg>{{ $label }}
                        </a>
                    @endforeach
                    <a href="{{ route('home') }}#kontak"><svg class="ic"><use href="#i-pin"/></svg>Kontak</a>
                </div>
            </div>

            <a href="{{ route('home') }}#daftar" class="btn btn-primary btn-sm nav-cta">Gabung Sekarang</a>
        </nav>

        <button class="nav-toggle" id="navToggle" type="button" aria-expanded="false" aria-controls="nav" aria-label="Buka menu">
            <svg class="ic ic-open"><use href="#i-menu"/></svg>
            <svg class="ic ic-close"><use href="#i-x"/></svg>
        </button>
    </div>
</header>
