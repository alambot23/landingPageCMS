<section class="section" id="prestasi">
    <div class="container">
        @include('partials.head', ['eyebrow' => 'Prestasi', 'title' => 'Jejak pencapaian', 'text' => 'Bukti bahwa perantau bisa berprestasi di mana pun berada.', 'href' => route('prestasi')])
        @include('blocks.prestasi', ['prestasi' => $prestasi])
    </div>
</section>
