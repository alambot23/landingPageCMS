@extends('layouts.app')

@section('title', 'Budaya Daerah | ' . config('himdes.singkatan'))

@section('content')
    @include('partials.page-hero', ['eyebrow' => 'Budaya Daerah', 'title' => 'Mengobati rindu kampung halaman', 'text' => 'Bahasa, kuliner, tari, dan cerita dari Deli Serdang yang kami jaga bersama.'])

    <section class="section">
        <div class="container">
            @if ($budaya->isEmpty())
                <p class="empty">Konten budaya belum tersedia.</p>
            @else
                <div class="grid grid-4">
                    @foreach ($budaya as $b)
                        <article class="card culture reveal">
                            <div class="culture-top">
                                @if ($b->gambar_url)
                                    <img src="{{ $b->gambar_url }}" alt="" width="320" height="160" loading="lazy">
                                @else
                                    <span class="culture-pattern" aria-hidden="true"></span>
                                @endif
                                <span class="tag tag-light">{{ $b->kategori }}</span>
                            </div>
                            <div class="culture-body">
                                <h3>{{ $b->judul }}</h3>
                                <p>{{ $b->deskripsi }}</p>
                            </div>
                        </article>
                    @endforeach
                </div>
            @endif
        </div>
    </section>
@endsection
