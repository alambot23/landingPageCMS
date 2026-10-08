<section class="section section-tint" id="kontak">
    <div class="container">
        <header class="section-head reveal">
            <p class="eyebrow">Kontak</p>
            <h2>Hubungi &amp; kunjungi kami</h2>
        </header>

        <div class="contact-grid">
            <ul class="contact-list reveal">
                <li>
                    <span class="icon-badge icon-badge-sm"><svg class="ic"><use href="#i-chat"/></svg></span>
                    <div><small>WhatsApp</small>
                        <a href="https://wa.me/{{ preg_replace('/\D+/', '', config('himdes.whatsapp')) }}" target="_blank" rel="noopener">+{{ preg_replace('/\D+/', '', config('himdes.whatsapp')) }}</a></div>
                </li>
                <li>
                    <span class="icon-badge icon-badge-sm"><svg class="ic"><use href="#i-instagram"/></svg></span>
                    <div><small>Instagram</small>
                        <a href="https://instagram.com/{{ config('himdes.instagram') }}" target="_blank" rel="noopener">&#64;{{ config('himdes.instagram') }}</a></div>
                </li>
                <li>
                    <span class="icon-badge icon-badge-sm"><svg class="ic"><use href="#i-mail"/></svg></span>
                    <div><small>Email</small>
                        <a href="mailto:{{ config('himdes.email') }}">{{ config('himdes.email') }}</a></div>
                </li>
                <li>
                    <span class="icon-badge icon-badge-sm"><svg class="ic"><use href="#i-pin"/></svg></span>
                    <div><small>Sekretariat</small>
                        <span>{{ config('himdes.alamat') }}</span></div>
                </li>
            </ul>

            <div class="map reveal">
                <iframe title="Peta lokasi sekretariat {{ config('himdes.singkatan') }}"
                        src="https://www.google.com/maps?q={{ urlencode(config('himdes.peta_query')) }}&amp;output=embed"
                        loading="lazy" referrerpolicy="no-referrer-when-downgrade" allowfullscreen></iframe>
            </div>
        </div>
    </div>
</section>
