@php $ikon = $p->jenis === 'Beasiswa' ? 'graduation' : ($p->jenis === 'Lomba' ? 'trophy' : 'briefcase'); @endphp
<article class="card news opp reveal {{ ($lewat ?? false) ? 'is-past' : '' }}" data-group="{{ $p->jenis }}">
    <a href="{{ route('peluang.show', $p) }}" class="news-media" aria-hidden="true" tabindex="-1">
        @if ($p->gambar_url)
            <img src="{{ $p->gambar_url }}" alt="" width="480" height="300" loading="lazy">
        @else
            <span class="placeholder"><svg class="ic"><use href="#i-{{ $ikon }}"/></svg></span>
        @endif
    </a>
    <div class="news-body">
        <div class="news-meta">
            <span class="tag">{{ $p->jenis }}</span>
            @if ($p->batas_waktu)
                <span class="deadline"><svg class="ic"><use href="#i-clock"/></svg>{{ $lewat ?? false ? 'Berakhir' : 'Batas' }} {{ $p->batas_waktu->translatedFormat('d M Y') }}</span>
            @endif
        </div>
        <h3><a href="{{ route('peluang.show', $p) }}">{{ $p->judul }}</a></h3>
        @if ($p->penyelenggara)<p class="muted small">{{ $p->penyelenggara }}</p>@endif
        @if ($p->deskripsi)<p>{{ $p->deskripsi }}</p>@endif
        <a href="{{ route('peluang.show', $p) }}" class="link-arrow">Detail &amp; cara daftar <svg class="ic"><use href="#i-arrow"/></svg></a>
    </div>
</article>
