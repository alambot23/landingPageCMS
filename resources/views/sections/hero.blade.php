@php
    $slides = $slides->isEmpty()
        ? collect([(object) ['judul' => config('himdes.tagline'), 'subjudul' => config('himdes.deskripsi'), 'gambar_url' => null, 'tombol_label' => 'Gabung Sekarang', 'tombol_url' => '#daftar']])
        : $slides;
    $jumlah = $slides->count();
@endphp
<section class="hero" id="beranda" aria-roledescription="carousel" aria-label="Sorotan {{ config('himdes.singkatan') }}" data-carousel>
    <div class="slides">
        @foreach ($slides as $i => $s)
            <div class="slide {{ $s->gambar_url ? 'slide--photo' : 'slide--plain' }} {{ $i === 0 ? 'is-active' : '' }}" role="group" aria-roledescription="slide" aria-label="{{ $i + 1 }} dari {{ $jumlah }}">
                @if ($s->gambar_url)
                    <img class="slide-img" src="{{ $s->gambar_url }}" alt="" @if ($i === 0) fetchpriority="high" @else loading="lazy" @endif>
                    <span class="slide-shade" aria-hidden="true"></span>
                @else
                    <div class="hero-bg" aria-hidden="true"></div>
                @endif

                <div class="container hero-inner">
                    <div class="hero-copy">
                        <p class="eyebrow eyebrow-light">{{ config('himdes.nama') }}, {{ config('himdes.kota') }}</p>
                        @if ($i === 0)
                            <h1 class="hero-title">{{ $s->judul }}</h1>
                        @else
                            <h2 class="hero-title">{{ $s->judul }}</h2>
                        @endif
                        @if ($s->subjudul)<p class="lead">{{ $s->subjudul }}</p>@endif
                        @if ($s->tombol_label && $s->tombol_url)
                            <div class="hero-actions">
                                <a href="{{ str_starts_with($s->tombol_url, '#') ? route('home') . $s->tombol_url : $s->tombol_url }}" class="btn btn-light">{{ $s->tombol_label }} <svg class="ic"><use href="#i-arrow"/></svg></a>
                            </div>
                        @endif
                    </div>

                    @unless ($s->gambar_url)
                        <div class="hero-logo" aria-hidden="true">
                            <div class="hero-logo-glow"></div>
                            <img src="{{ asset('images/logo.png') }}" alt="" width="360" height="387">
                        </div>
                    @endunless
                </div>
            </div>
        @endforeach
    </div>

    @if ($jumlah > 1)
        <div class="hero-nav">
            <div class="container hero-nav-inner">
                <div class="dots" role="group" aria-label="Pilih slide">
                    @foreach ($slides as $i => $s)
                        <button type="button" class="dot {{ $i === 0 ? 'is-active' : '' }}" data-go="{{ $i }}" aria-label="Slide {{ $i + 1 }}"></button>
                    @endforeach
                </div>
                <div class="arrows">
                    <button type="button" class="arrow-btn" data-pause aria-label="Jeda geser otomatis" aria-pressed="false"><svg class="ic"><use href="#i-pause"/></svg></button>
                    <button type="button" class="arrow-btn arrow-prev" data-dir="-1" aria-label="Slide sebelumnya"><svg class="ic"><use href="#i-arrow"/></svg></button>
                    <button type="button" class="arrow-btn" data-dir="1" aria-label="Slide berikutnya"><svg class="ic"><use href="#i-arrow"/></svg></button>
                </div>
            </div>
        </div>
    @endif
</section>

<div class="container statbar reveal">
    <dl>
        @foreach ($stat as $label => $angka)
            <div><dt>{{ $label }}</dt><dd>{{ $angka }}</dd></div>
        @endforeach
    </dl>
</div>
