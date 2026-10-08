<article class="card news reveal">
    <a href="{{ route('berita.show', $b) }}" class="news-media" aria-hidden="true" tabindex="-1">
        @if ($b->gambar_url)
            <img src="{{ $b->gambar_url }}" alt="" width="480" height="300" loading="lazy">
        @else
            <span class="placeholder"><svg class="ic"><use href="#i-file"/></svg></span>
        @endif
    </a>
    <div class="news-body">
        <div class="news-meta">
            <span class="tag">{{ $b->kategori }}</span>
            <time datetime="{{ $b->dipublikasi_pada->toDateString() }}">{{ $b->dipublikasi_pada->translatedFormat('d F Y') }}</time>
        </div>
        <h3><a href="{{ route('berita.show', $b) }}">{{ $b->judul }}</a></h3>
        <p>{{ $b->ringkasan }}</p>
        <a href="{{ route('berita.show', $b) }}" class="link-arrow">Baca selengkapnya <svg class="ic"><use href="#i-arrow"/></svg></a>
    </div>
</article>
