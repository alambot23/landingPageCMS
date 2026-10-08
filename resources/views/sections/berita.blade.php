<section class="section section-tint" id="berita">
    <div class="container">
        @include('partials.head', ['eyebrow' => 'Berita & Pengumuman', 'title' => 'Kabar terbaru', 'href' => route('berita.index'), 'label' => 'Semua berita'])

        @if ($berita->isEmpty())
            <p class="empty">Belum ada berita yang terbit.</p>
        @else
            <div class="grid grid-3">
                @foreach ($berita as $b)
                    @include('berita._kartu', ['b' => $b])
                @endforeach
            </div>
        @endif
    </div>
</section>
