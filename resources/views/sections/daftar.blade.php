<section class="section" id="daftar">
    <div class="container">
        <div class="join">
            <div class="join-info reveal">
                <p class="eyebrow">Pendaftaran Anggota</p>
                <h2>Bergabunglah bersama kami</h2>
                <p>Isi data singkat di samping. Setelah menekan tombol kirim, WhatsApp akan terbuka dengan pesan pendaftaran yang sudah terisi otomatis. Tinggal dikirim ke admin.</p>

                <ol class="steps">
                    <li><span>1</span><div><strong>Isi formulir</strong><small>Data diri, kampus, dan asal daerah.</small></div></li>
                    <li><span>2</span><div><strong>Kirim lewat WhatsApp</strong><small>Pesan otomatis ke admin pendaftaran.</small></div></li>
                    <li><span>3</span><div><strong>Dapat balasan &amp; masuk grup</strong><small>Admin akan memandu langkah selanjutnya.</small></div></li>
                </ol>
            </div>

            <form class="card join-form reveal" id="joinForm"
                  data-wa="{{ preg_replace('/\D+/', '', config('himdes.whatsapp')) }}"
                  data-org="{{ config('himdes.singkatan') }} {{ config('himdes.kota') }}"
                  novalidate>
                <h3>Formulir pendaftaran</h3>

                <div class="form-grid">
                    <label class="field-block">
                        <span>Nama lengkap</span>
                        <input type="text" name="nama" required autocomplete="name" placeholder="Nama sesuai KTM">
                    </label>
                    <label class="field-block">
                        <span>Nomor WhatsApp</span>
                        <input type="tel" name="hp" required inputmode="tel" autocomplete="tel" placeholder="08xxxxxxxxxx">
                    </label>
                    <label class="field-block">
                        <span>Kampus</span>
                        <select name="kampus" required>
                            <option value="">Pilih kampus</option>
                            @foreach (config('himdes.kampus') as $k)
                                <option value="{{ $k }}">{{ $k }}</option>
                            @endforeach
                        </select>
                    </label>
                    <label class="field-block">
                        <span>Jurusan</span>
                        <input type="text" name="jurusan" required placeholder="Contoh: Teknik Informatika">
                    </label>
                    <label class="field-block">
                        <span>Angkatan</span>
                        <input type="number" name="angkatan" required min="2000" max="{{ date('Y') }}" inputmode="numeric" placeholder="{{ date('Y') }}">
                    </label>
                    <label class="field-block">
                        <span>Asal daerah</span>
                        <input type="text" name="asal" required placeholder="Kecamatan / desa di Deli Serdang">
                    </label>
                </div>

                <p class="form-error" id="joinError" role="alert" hidden>Mohon lengkapi semua kolom dengan benar.</p>

                <button type="submit" class="btn btn-primary btn-block">
                    <svg class="ic"><use href="#i-chat"/></svg> Kirim lewat WhatsApp
                </button>
                <p class="form-note">Data tidak disimpan di situs ini. Hanya dikirim lewat WhatsApp ke admin.</p>

                <noscript>
                    <p class="form-note">JavaScript nonaktif. Silakan
                        <a href="https://wa.me/{{ preg_replace('/\D+/', '', config('himdes.whatsapp')) }}">hubungi admin lewat WhatsApp</a>
                        secara langsung.</p>
                </noscript>
            </form>
        </div>
    </div>
</section>
