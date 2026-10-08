@extends('layouts.app')

@section('title', 'Tentang Kami | ' . config('himdes.singkatan'))

@section('content')
    @include('partials.page-hero', ['eyebrow' => 'Tentang Kami', 'title' => 'Satu daerah, satu keluarga', 'text' => 'Sejarah, visi, misi, dan para pemimpin yang telah menjaga HIMDES dari masa ke masa.'])

    <section class="section">
        <div class="container">
            <div class="about-grid">
                <div class="about-story reveal">
                    <h2 class="subhead-lg">Sejarah singkat</h2>
                    @foreach (config('himdes.sejarah') as $paragraf)
                        <p>{{ $paragraf }}</p>
                    @endforeach

                    <ul class="origin" aria-label="Asal dan tujuan">
                        <li><svg class="ic"><use href="#i-home"/></svg><span><small>Asal daerah</small><strong>Deli Serdang</strong></span></li>
                        <li class="origin-arrow" aria-hidden="true"><svg class="ic"><use href="#i-arrow"/></svg></li>
                        <li><svg class="ic"><use href="#i-graduation"/></svg><span><small>Tanah rantau</small><strong>{{ config('himdes.kota') }}</strong></span></li>
                    </ul>
                </div>

                <div class="about-cards">
                    <article class="card card-accent reveal">
                        <h3>Visi</h3>
                        <p>{{ config('himdes.visi') }}</p>
                    </article>
                    <article class="card reveal">
                        <h3>Misi</h3>
                        <ol class="mission">
                            @foreach (config('himdes.misi') as $misi)
                                <li>{{ $misi }}</li>
                            @endforeach
                        </ol>
                    </article>
                </div>
            </div>
        </div>
    </section>

    @php $m = config('himdes.pembimbing'); @endphp
    @if ($m['nama'])
        <section class="section section-tint" id="pembimbing">
            <div class="container">
                <div class="greet">
                    <figure class="greet-photo reveal">
                        @if ($m['foto'])
                            <img src="{{ $m['foto'] }}" alt="Foto {{ $m['nama'] }}" width="420" height="525" loading="lazy">
                        @else
                            <div class="portrait-ph" aria-hidden="true">{{ mb_strtoupper(mb_substr($m['nama'], 0, 1)) }}</div>
                        @endif
                    </figure>
                    <div class="greet-text reveal">
                        <p class="eyebrow">Pembimbing</p>
                        @if ($m['kata'])<blockquote><p>{{ $m['kata'] }}</p></blockquote>@endif
                        <p class="greet-who"><strong>{{ $m['nama'] }}</strong>@if ($m['jabatan'])<span>{{ $m['jabatan'] }}</span>@endif</p>
                    </div>
                </div>
            </div>
        </section>
    @endif

    <section class="section" id="linimasa">
        <div class="container">
            @include('partials.head', ['eyebrow' => 'Linimasa Kepemimpinan', 'title' => 'Ketua umum dari masa ke masa', 'text' => 'Setiap periode punya cerita dan jejaknya sendiri.'])

            @if ($ketua->isEmpty())
                <p class="empty">Data ketua belum tersedia.</p>
            @else
                <ol class="timeline">
                    @foreach ($ketua as $k)
                        <li class="timeline-item reveal">
                            <span class="year">{{ $k->tahun_mulai }}</span>
                            <article class="card leader">
                                @if ($k->foto_url)
                                    <img class="leader-photo" src="{{ $k->foto_url }}" alt="Foto {{ $k->nama }}" width="112" height="140" loading="lazy">
                                @else
                                    <div class="leader-photo leader-ph" aria-hidden="true">{{ $k->inisial }}</div>
                                @endif
                                <div>
                                    <div class="timeline-meta">
                                        <strong>Periode {{ $k->periode }}</strong>
                                        @if ($k->aktif)<span class="tag tag-gold">Sedang menjabat</span>@endif
                                    </div>
                                    <h3>{{ $k->nama }}</h3>
                                    @if ($k->kampus)<p class="muted small">{{ $k->kampus }}</p>@endif
                                    @if ($k->kata)<p class="leader-quote">{{ $k->kata }}</p>@endif
                                    @if ($k->capaian)<p class="small"><strong>Capaian:</strong> {{ $k->capaian }}</p>@endif
                                </div>
                            </article>
                        </li>
                    @endforeach
                </ol>
            @endif
        </div>
    </section>
@endsection
