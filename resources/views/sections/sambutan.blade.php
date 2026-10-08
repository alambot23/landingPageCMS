@php $mentor = config('himdes.pembimbing'); @endphp
@if ($ketua || $mentor['nama'])
<section class="section" id="sambutan">
    <div class="container">
        @if ($ketua)
            <div class="greet">
                <figure class="greet-photo reveal">
                    @if ($ketua->foto_url)
                        <img src="{{ $ketua->foto_url }}" alt="Foto {{ $ketua->nama }}" width="420" height="525" loading="lazy">
                    @else
                        <div class="portrait-ph" aria-hidden="true">{{ $ketua->inisial }}</div>
                    @endif
                </figure>

                <div class="greet-text reveal">
                    <p class="eyebrow">Sambutan Ketua Umum</p>
                    <blockquote>
                        <p>{{ $ketua->kata ?: 'Selamat datang di rumah kedua kita di tanah rantau. Mari tumbuh dan berkarya bersama.' }}</p>
                    </blockquote>
                    <p class="greet-who">
                        <strong>{{ $ketua->nama }}</strong>
                        <span>Ketua Umum, periode {{ $ketua->periode }}</span>
                    </p>
                    <a href="{{ route('tentang') }}#linimasa" class="link-arrow">Lihat linimasa kepemimpinan <svg class="ic"><use href="#i-arrow"/></svg></a>
                </div>
            </div>
        @endif

        @if ($mentor['nama'] || $ketuaLalu->isNotEmpty())
            <div class="greet-more">
                @if ($mentor['nama'])
                    <article class="card mentor reveal">
                        @if ($mentor['foto'])
                            <img class="avatar" src="{{ $mentor['foto'] }}" alt="Foto {{ $mentor['nama'] }}" width="88" height="88" loading="lazy">
                        @else
                            <div class="avatar avatar-initial" aria-hidden="true">{{ mb_strtoupper(mb_substr($mentor['nama'], 0, 1)) }}</div>
                        @endif
                        <div>
                            <p class="muted small">Pembimbing</p>
                            <h3>{{ $mentor['nama'] }}</h3>
                            @if ($mentor['jabatan'])<p class="role">{{ $mentor['jabatan'] }}</p>@endif
                            @if ($mentor['kata'])<p class="mentor-quote">{{ $mentor['kata'] }}</p>@endif
                        </div>
                    </article>
                @endif

                @if ($ketuaLalu->isNotEmpty())
                    <article class="card past reveal">
                        <h3>Ketua sebelumnya</h3>
                        <ul>
                            @foreach ($ketuaLalu as $k)
                                <li>
                                    @if ($k->foto_url)
                                        <img class="avatar avatar-sm" src="{{ $k->foto_url }}" alt="" width="64" height="64" loading="lazy">
                                    @else
                                        <span class="avatar avatar-initial avatar-sm" aria-hidden="true">{{ $k->inisial }}</span>
                                    @endif
                                    <span><strong>{{ $k->nama }}</strong><small>{{ $k->periode }}</small></span>
                                </li>
                            @endforeach
                        </ul>
                        <a href="{{ route('tentang') }}#linimasa" class="link-arrow">Semua ketua <svg class="ic"><use href="#i-arrow"/></svg></a>
                    </article>
                @endif
            </div>
        @endif
    </div>
</section>
@endif
