<?php

/*
|--------------------------------------------------------------------------
| Identitas & kontak HIMDES
|--------------------------------------------------------------------------
| Semua teks identitas ada di sini supaya mudah diganti. Nanti saat CMS
| dibuat, nilai-nilai ini bisa dipindahkan ke tabel "pengaturan".
| PENTING: ganti nomor WhatsApp, Instagram, email, dan alamat dengan data asli.
*/

return [
    'nama'       => 'Himpunan Mahasiswa Deli Serdang',
    'singkatan'  => 'HIMDES',
    'kota'       => 'Lhokseumawe',
    'tagline'    => 'Rumah bagi putra-putri Deli Serdang di tanah rantau.',
    'deskripsi'  => 'Wadah pemersatu, pengembangan diri, dan kekeluargaan mahasiswa asal Deli Serdang yang menimba ilmu di Lhokseumawe.',
    'periode'    => env('HIMDES_PERIODE', '2025/2026'),

    // Nomor WhatsApp admin pendaftaran, format internasional tanpa "+" atau "0" di depan.
    'whatsapp'   => env('HIMDES_WHATSAPP', '6281200000000'),
    'instagram'  => env('HIMDES_INSTAGRAM', 'himdes_lhokseumawe'),
    'email'      => env('HIMDES_EMAIL', 'himdes.lhokseumawe@gmail.com'),
    'alamat'     => env('HIMDES_ALAMAT', 'Sekretariat HIMDES, Lhokseumawe, Aceh'),
    'peta_query' => env('HIMDES_PETA', 'Lhokseumawe, Aceh'),

    // Akun admin awal (dibuat oleh seeder). Ganti password setelah login pertama.
    'admin_email'    => env('HIMDES_ADMIN_EMAIL', 'admin@himdes.test'),
    'admin_password' => env('HIMDES_ADMIN_PASSWORD', 'ganti-password-ini'),

    'sejarah' => [
        'HIMDES lahir dari kebutuhan sederhana: mahasiswa asal Deli Serdang yang jauh dari rumah ingin punya tempat untuk saling menguatkan, berbagi informasi, dan tetap dekat dengan akar daerahnya.',
        'Sejak berdiri, HIMDES Lhokseumawe menjadi keluarga kedua bagi para perantau, mulai dari menyambut mahasiswa baru, mengadakan kegiatan akademik dan sosial, hingga menjaga tali silaturahmi antaranggota dan alumni.',
    ],

    'visi' => 'Menjadi himpunan yang solid, berprestasi, dan bermanfaat bagi anggota, daerah asal, serta masyarakat tempat kami merantau.',

    'misi' => [
        'Mempererat persaudaraan antarmahasiswa Deli Serdang di perantauan.',
        'Mengembangkan potensi akademik, organisasi, dan kepemimpinan anggota.',
        'Menjaga dan memperkenalkan budaya daerah asal.',
        'Hadir membantu anggota dalam suka maupun duka.',
        'Menjalin kerja sama yang baik dengan kampus, pemerintah daerah, dan organisasi lain.',
    ],

    // Daftar yang dipakai di formulir pendaftaran
    'kampus' => [
        'Universitas Malikussaleh',
        'Politeknik Negeri Lhokseumawe',
        'Lainnya',
    ],
];
