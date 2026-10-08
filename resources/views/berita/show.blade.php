@extends('layouts.app')

@section('title', $berita->judul . ' | ' . config('himdes.singkatan'))
@section('description', $berita->ringkasan)

@section('content')
    @include('partials.page-hero', ['narrow' => true, 'eyebrow' => $berita->kategori, 'title' => $berita->judul])
    <div class="page-meta-bar"><div class="container narrow"><time datetime="{{ $berita->dipublikasi_pada->toDateString() }}">{{ $berita->dipublikasi_pada->translatedFormat('l, d F Y') }}</time></div></div>

    <article class="section">
        <div class="container narrow prose">
            @if ($berita->gambar_url)
                <img src="{{ $berita->gambar_url }}" alt="" class="prose-cover" loading="lazy">
            @endif
            {!! \App\Support\Md::html($berita->isi) !!}

            <p class="back"><a href="{{ route('berita.index') }}" class="link-arrow">&larr; Kembali ke semua berita</a></p>
        </div>
    </article>

    @if ($lainnya->isNotEmpty())
        <section class="section section-tint">
            <div class="container">
                <header class="section-head">
                    <p class="eyebrow">Baca juga</p>
                    <h2>Berita lainnya</h2>
                </header>
                <div class="grid grid-3">
                    @foreach ($lainnya as $b)
                        @include('berita._kartu', ['b' => $b])
                    @endforeach
                </div>
            </div>
        </section>
    @endif
@endsection
