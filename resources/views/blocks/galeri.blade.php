@if ($galeri->isEmpty())
    <p class="empty">Dokumentasi belum tersedia.</p>
@else
    <div class="gallery">
        @foreach ($galeri as $g)
            @php $teks = $g->judul . ($g->judul !== $g->album ? ', ' . $g->album : '') . ' (' . $g->tahun . ')'; @endphp
            @if ($g->gambar_url || $g->video_url)
                <a class="shot reveal" href="{{ $g->video_url ?: $g->gambar_url }}"
                   @if ($g->video_url) target="_blank" rel="noopener" @else data-lightbox data-caption="{{ $teks }}" @endif>
                    @if ($g->gambar_url)
                        <img src="{{ $g->gambar_url }}" alt="{{ $g->judul }}" width="480" height="360" loading="lazy">
                    @else
                        <span class="placeholder"><svg class="ic"><use href="#i-play"/></svg></span>
                    @endif
                    @if ($g->video_url)<span class="play"><svg class="ic"><use href="#i-play"/></svg></span>@endif
                    <span class="shot-cap"><strong>{{ $g->judul }}</strong><small>{{ $g->album }}</small></span>
                </a>
            @else
                <figure class="shot reveal">
                    <span class="placeholder"><svg class="ic"><use href="#i-image"/></svg></span>
                    <span class="shot-cap"><strong>{{ $g->judul }}</strong><small>{{ $g->album }}</small></span>
                </figure>
            @endif
        @endforeach
    </div>

    @once
        <dialog class="lightbox" id="lightbox" aria-label="Pratinjau foto">
            <button type="button" class="lb-btn lb-close" data-lb="close" aria-label="Tutup"><svg class="ic"><use href="#i-x"/></svg></button>
            <button type="button" class="lb-btn lb-prev" data-lb="prev" aria-label="Foto sebelumnya"><svg class="ic"><use href="#i-arrow"/></svg></button>
            <figure><img alt=""><figcaption></figcaption></figure>
            <button type="button" class="lb-btn lb-next" data-lb="next" aria-label="Foto berikutnya"><svg class="ic"><use href="#i-arrow"/></svg></button>
        </dialog>
    @endonce
@endif
