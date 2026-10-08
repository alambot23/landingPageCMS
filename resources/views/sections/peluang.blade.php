<section class="section section-tint" id="peluang">
    <div class="container">
        @include('partials.head', ['eyebrow' => 'Beasiswa & Magang', 'title' => 'Peluang untuk berkembang', 'text' => 'Beasiswa, magang, dan lomba yang dibagikan antaranggota. Perhatikan tenggat waktunya.', 'href' => route('peluang.index'), 'label' => 'Semua info'])

        @if ($peluang->isEmpty())
            <p class="empty">Belum ada info terbaru.</p>
        @else
            <div class="grid grid-3">
                @foreach ($peluang as $p)
                    @include('blocks.peluang-kartu', ['p' => $p])
                @endforeach
            </div>
        @endif
    </div>
</section>
