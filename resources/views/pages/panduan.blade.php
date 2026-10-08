@extends('layouts.app')

@section('title', 'Panduan Mahasiswa Baru | ' . config('himdes.singkatan'))

@section('content')
    @include('partials.page-hero', ['eyebrow' => 'Panduan Mahasiswa Baru', 'title' => 'Baru tiba di ' . config('himdes.kota') . '? Mulai dari sini.', 'text' => 'Rangkuman dari senior agar kamu cepat betah: persiapan, tempat tinggal, transportasi, makan, kampus, dan adaptasi.'])

    <section class="section">
        <div class="container">
            @if ($panduan->isEmpty())
                <p class="empty">Panduan belum tersedia.</p>
            @else
                <div class="guide-layout">
                    <aside class="guide-toc" aria-label="Daftar topik">
                        <label class="field field-search js-only">
                            <span class="sr-only">Cari panduan</span>
                            <svg class="ic"><use href="#i-search"/></svg>
                            <input type="search" id="guideSearch" placeholder="Cari panduan" autocomplete="off">
                        </label>
                        <nav class="toc">
                            @foreach ($panduan as $kat => $items)
                                <a href="#{{ Str::slug($kat) }}"><svg class="ic"><use href="#i-{{ $items->first()->ikon }}"/></svg>{{ $kat }}<small>{{ $items->count() }}</small></a>
                            @endforeach
                        </nav>
                    </aside>

                    <div class="guide-body" id="guideBody">
                        @foreach ($panduan as $kat => $items)
                            <section class="guide-cat" id="{{ Str::slug($kat) }}">
                                <h2 class="reveal">{{ $kat }}</h2>
                                @foreach ($items as $item)
                                    <details class="qa" @if ($loop->first && $loop->parent->first) open @endif data-text="{{ mb_strtolower($item->judul . ' ' . strip_tags($item->isi)) }}">
                                        <summary>
                                            <span class="icon-badge icon-badge-sm"><svg class="ic"><use href="#i-{{ $item->ikon }}"/></svg></span>
                                            <span class="qa-title">{{ $item->judul }}</span>
                                            <svg class="ic qa-chev"><use href="#i-chevron"/></svg>
                                        </summary>
                                        <div class="qa-body prose">{!! \App\Support\Md::html($item->isi) !!}</div>
                                    </details>
                                @endforeach
                            </section>
                        @endforeach
                        <p class="empty" id="guideEmpty" hidden>Tidak ada panduan yang cocok dengan pencarianmu.</p>
                    </div>
                </div>

                <aside class="card card-accent guide-help reveal">
                    <div>
                        <h3>Masih bingung atau butuh bantuan?</h3>
                        <p>Pengurus dan senior siap membantu lewat WhatsApp kapan saja.</p>
                    </div>
                    <a class="btn btn-light" href="{{ route('home') }}#bantuan">Hubungi bantuan cepat <svg class="ic"><use href="#i-arrow"/></svg></a>
                </aside>
            @endif
        </div>
    </section>
@endsection
