@if ($program->isEmpty())
    <p class="empty">Program kerja belum tersedia.</p>
@else
    <div class="grid grid-3">
        @foreach ($program as $item)
            <article class="card news program reveal">
                <div class="news-media">
                    @if ($item->gambar_url)
                        <img src="{{ $item->gambar_url }}" alt="Dokumentasi {{ $item->judul }}" width="480" height="300" loading="lazy">
                    @else
                        <span class="placeholder"><svg class="ic"><use href="#i-{{ $item->ikon }}"/></svg></span>
                    @endif
                </div>
                <div class="news-body">
                    @if ($item->kategori)<div class="news-meta"><span class="tag">{{ $item->kategori }}</span></div>@endif
                    <h3>{{ $item->judul }}</h3>
                    <p>{{ $item->deskripsi }}</p>
                </div>
            </article>
        @endforeach
    </div>
@endif
