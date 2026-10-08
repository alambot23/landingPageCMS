@extends('layouts.app')

@section('title', 'Pengurus | ' . config('himdes.singkatan'))

@section('content')
    @include('partials.page-hero', ['eyebrow' => 'Struktur Pengurus', 'title' => 'Pengurus periode ' . config('himdes.periode'), 'text' => 'Badan pengurus harian dan seluruh divisi beserta anggotanya.'])

    <section class="section">
        <div class="container">
            @if ($inti->isEmpty() && $divisi->isEmpty())
                <p class="empty">Data pengurus belum tersedia.</p>
            @endif

            @if ($divisi->isNotEmpty())
                <nav class="chips org-nav" aria-label="Lompat ke bagian">
                    @if ($inti->isNotEmpty())<a class="chip" href="#bph">Badan Pengurus Harian</a>@endif
                    @foreach ($divisi as $d)
                        <a class="chip" href="#divisi-{{ $d->id }}">{{ $d->nama }}</a>
                    @endforeach
                </nav>
            @endif

            @if ($inti->isNotEmpty())
                <div class="org-block" id="bph">
                    <header class="org-head reveal">
                        <span class="icon-badge"><svg class="ic"><use href="#i-shield"/></svg></span>
                        <div><h2>Badan Pengurus Harian</h2><p class="muted">Pimpinan yang mengarahkan seluruh kegiatan organisasi.</p></div>
                    </header>
                    <div class="people people-lg">
                        @foreach ($inti as $p)
                            @include('sections._orang', ['p' => $p])
                        @endforeach
                    </div>
                </div>
            @endif

            @foreach ($divisi as $d)
                <div class="org-block" id="divisi-{{ $d->id }}">
                    <header class="org-head reveal">
                        <span class="icon-badge"><svg class="ic"><use href="#i-{{ $d->ikon }}"/></svg></span>
                        <div><h2>{{ $d->nama }}</h2>@if ($d->deskripsi)<p class="muted">{{ $d->deskripsi }}</p>@endif</div>
                    </header>
                    @if ($d->pengurus->isEmpty())
                        <p class="empty">Anggota divisi belum diisi.</p>
                    @else
                        <div class="people">
                            @foreach ($d->pengurus as $p)
                                @include('sections._orang', ['p' => $p, 'kecil' => ! $p->is_kepala])
                            @endforeach
                        </div>
                    @endif
                </div>
            @endforeach

            @if ($lainnya->isNotEmpty())
                <div class="org-block">
                    <header class="org-head reveal">
                        <span class="icon-badge"><svg class="ic"><use href="#i-users"/></svg></span>
                        <div><h2>Pengurus lainnya</h2></div>
                    </header>
                    <div class="people">
                        @foreach ($lainnya as $p)
                            @include('sections._orang', ['p' => $p, 'kecil' => true])
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </section>
@endsection
