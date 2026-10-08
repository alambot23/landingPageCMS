@extends('layouts.app')

@section('title', $p->judul . ' | ' . config('himdes.singkatan'))
@section('description', $p->deskripsi ?: config('himdes.deskripsi'))

@section('content')
    @include('partials.page-hero', ['narrow' => true, 'eyebrow' => $p->jenis, 'title' => $p->judul])

    <article class="section">
        <div class="container narrow">
            <ul class="meta opp-meta">
                @if ($p->penyelenggara)<li><svg class="ic"><use href="#i-briefcase"/></svg>{{ $p->penyelenggara }}</li>@endif
                @if ($p->batas_waktu)<li class="deadline"><svg class="ic"><use href="#i-clock"/></svg>Batas pendaftaran: {{ $p->batas_waktu->translatedFormat('l, d F Y') }}</li>@endif
            </ul>

            <div class="prose">
                @if ($p->gambar_url)<img src="{{ $p->gambar_url }}" alt="" class="prose-cover" loading="lazy">@endif
                @if ($p->deskripsi)<p class="prose-lead">{{ $p->deskripsi }}</p>@endif
                {!! \App\Support\Md::html($p->isi) !!}

                @if ($p->tautan)
                    <p><a class="btn btn-primary" href="{{ $p->tautan }}" target="_blank" rel="noopener">Buka halaman pendaftaran <svg class="ic"><use href="#i-external"/></svg></a></p>
                @endif
                <p class="back"><a href="{{ route('peluang.index') }}" class="link-arrow">&larr; Kembali ke semua info</a></p>
            </div>
        </div>
    </article>

    @if ($lainnya->isNotEmpty())
        <section class="section section-tint">
            <div class="container">
                @include('partials.head', ['eyebrow' => 'Baca juga', 'title' => 'Info lainnya'])
                <div class="grid grid-3">
                    @foreach ($lainnya as $x)
                        @include('blocks.peluang-kartu', ['p' => $x])
                    @endforeach
                </div>
            </div>
        </section>
    @endif
@endsection
