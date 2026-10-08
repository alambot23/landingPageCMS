<section class="section section-tint" id="panduan">
    <div class="container">
        <div class="maba reveal">
            <div>
                <p class="eyebrow eyebrow-light">Panduan Mahasiswa Baru</p>
                <h2>Baru tiba di {{ config('himdes.kota') }}? Mulai dari sini.</h2>
                <p class="lead">Rangkuman dari senior agar kamu cepat betah, dari mencari kos sampai beradaptasi dengan lingkungan baru.</p>
                <a href="{{ route('panduan') }}" class="btn btn-light">Buka panduan lengkap <svg class="ic"><use href="#i-arrow"/></svg></a>
            </div>
            @if ($kategoriPanduan->isNotEmpty())
                <ul class="maba-chips" aria-label="Topik panduan">
                    @foreach ($kategoriPanduan as $kat)
                        <li><a href="{{ route('panduan') }}#{{ Str::slug($kat) }}">{{ $kat }}</a></li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
</section>
