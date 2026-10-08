<section class="section section-tint" id="tentang">
    <div class="container">
        @include('partials.head', ['eyebrow' => 'Tentang Kami', 'title' => 'Satu daerah, satu keluarga', 'text' => 'Siapa kami, apa yang kami cita-citakan, dan dari mana kami berasal.', 'href' => route('tentang'), 'label' => 'Sejarah & linimasa'])

        <div class="about-grid">
            <div class="about-story reveal">
                <p>{{ config('himdes.sejarah')[0] ?? '' }}</p>

                <ul class="origin" aria-label="Asal dan tujuan">
                    <li><svg class="ic"><use href="#i-home"/></svg><span><small>Asal daerah</small><strong>Deli Serdang</strong></span></li>
                    <li class="origin-arrow" aria-hidden="true"><svg class="ic"><use href="#i-arrow"/></svg></li>
                    <li><svg class="ic"><use href="#i-graduation"/></svg><span><small>Tanah rantau</small><strong>{{ config('himdes.kota') }}</strong></span></li>
                </ul>
            </div>

            <div class="about-cards">
                <article class="card card-accent reveal">
                    <h3>Visi</h3>
                    <p>{{ config('himdes.visi') }}</p>
                </article>
                <article class="card reveal">
                    <h3>Misi</h3>
                    <ol class="mission">
                        @foreach (array_slice(config('himdes.misi'), 0, 3) as $misi)
                            <li>{{ $misi }}</li>
                        @endforeach
                    </ol>
                </article>
            </div>
        </div>
    </div>
</section>
