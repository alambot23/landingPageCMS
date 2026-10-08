<section class="section section-tint" id="kegiatan">
    <div class="container">
        @include('partials.head', ['eyebrow' => 'Program Kerja', 'title' => 'Kegiatan yang kami jalankan', 'text' => 'Dari ruang kelas hingga lapangan, dari kampus sampai kampung halaman.', 'href' => route('program')])
        @include('blocks.program', ['program' => $program])
    </div>
</section>
