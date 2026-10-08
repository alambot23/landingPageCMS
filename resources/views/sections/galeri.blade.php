<section class="section" id="galeri">
    <div class="container">
        @include('partials.head', ['eyebrow' => 'Dokumentasi', 'title' => 'Potret kebersamaan', 'text' => 'Cuplikan kegiatan terbaru kami.', 'href' => route('galeri'), 'label' => 'Semua dokumentasi'])
        @include('blocks.galeri', ['galeri' => $galeri])
    </div>
</section>
