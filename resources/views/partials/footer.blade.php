<footer class="site-footer">
    <div class="container footer-grid">
        <div class="footer-brand">
            <img src="{{ asset('images/logo.png') }}" alt="Logo {{ config('himdes.singkatan') }}" width="64" height="69" loading="lazy">
            <div>
                <strong>{{ config('himdes.nama') }}</strong>
                <p>{{ config('himdes.tagline') }}</p>
            </div>
        </div>

        <div>
            <h4>Jelajahi</h4>
            <ul>
                <li><a href="{{ route('tentang') }}">Tentang kami</a></li>
                <li><a href="{{ route('pengurus') }}">Pengurus</a></li>
                <li><a href="{{ route('program') }}">Program kerja</a></li>
                <li><a href="{{ route('berita.index') }}">Berita</a></li>
                <li><a href="{{ route('galeri') }}">Dokumentasi</a></li>
            </ul>
        </div>

        <div>
            <h4>Informasi</h4>
            <ul>
                <li><a href="{{ route('panduan') }}">Panduan maba</a></li>
                <li><a href="{{ route('agenda') }}">Agenda</a></li>
                <li><a href="{{ route('peluang.index') }}">Beasiswa &amp; magang</a></li>
                <li><a href="{{ route('prestasi') }}">Prestasi</a></li>
            </ul>
        </div>

        <div>
            <h4>Hubungi</h4>
            <ul>
                <li><a href="https://wa.me/{{ preg_replace('/\D+/', '', config('himdes.whatsapp')) }}" rel="noopener" target="_blank">WhatsApp</a></li>
                <li><a href="https://instagram.com/{{ ltrim(config('himdes.instagram'), '@') }}" rel="noopener" target="_blank">Instagram</a></li>
                <li><a href="mailto:{{ config('himdes.email') }}">Email</a></li>
            </ul>
        </div>
    </div>
    <div class="container footer-bottom">
        <span>&copy; {{ date('Y') }} {{ config('himdes.nama') }}. Seluruh hak cipta dilindungi.</span>
        <span class="footer-meta">
            Periode {{ config('himdes.periode') }}
            <a class="admin-link" href="{{ route('login') }}" rel="nofollow"><svg class="ic"><use href="#i-lock"/></svg>Masuk pengurus</a>
        </span>
    </div>
</footer>
