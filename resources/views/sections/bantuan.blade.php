<section class="section section-dark" id="bantuan">
    <div class="container">
        <header class="section-head section-head-light reveal">
            <p class="eyebrow eyebrow-light">Layanan Bantuan Cepat</p>
            <h2>Kamu tidak sendirian di perantauan</h2>
            <p>Sakit, kena musibah, atau butuh teman bicara? Hubungi kami kapan saja lewat WhatsApp.</p>
        </header>

        @if ($bantuan->isEmpty())
            <p class="empty empty-light">Kontak bantuan belum tersedia.</p>
        @else
            <div class="grid grid-3">
                @foreach ($bantuan as $k)
                    @php
                        $pesan = 'Halo, saya anggota/mahasiswa asal Deli Serdang. Saya ingin menghubungi ' . $k->label . ' HIMDES terkait: ';
                    @endphp
                    <article class="card card-dark help reveal">
                        <span class="icon-badge icon-badge-light"><svg class="ic"><use href="#i-{{ $k->ikon }}"/></svg></span>
                        <h3>{{ $k->label }}</h3>
                        <p>{{ $k->deskripsi }}</p>
                        <a class="btn btn-light btn-sm" href="https://wa.me/{{ preg_replace('/\D+/', '', $k->whatsapp) }}?text={{ rawurlencode($pesan) }}" target="_blank" rel="noopener">
                            <svg class="ic"><use href="#i-chat"/></svg> Hubungi lewat WhatsApp
                        </a>
                    </article>
                @endforeach
            </div>
        @endif

        <p class="help-note">Dalam keadaan darurat medis, segera hubungi layanan gawat darurat setempat terlebih dahulu, lalu kabari kami.</p>
    </div>
</section>
