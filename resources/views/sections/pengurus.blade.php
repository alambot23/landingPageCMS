<section class="section" id="pengurus">
    <div class="container">
        @include('partials.head', ['eyebrow' => 'Struktur Pengurus', 'title' => 'Pengurus periode ' . config('himdes.periode'), 'text' => 'Badan pengurus harian yang menjaga roda organisasi tetap berputar.', 'href' => route('pengurus'), 'label' => 'Susunan lengkap & divisi'])

        @if ($inti->isEmpty())
            <p class="empty">Data pengurus belum tersedia.</p>
        @else
            <div class="people people-lg">
                @foreach ($inti as $p)
                    @include('sections._orang', ['p' => $p])
                @endforeach
            </div>
        @endif
    </div>
</section>
