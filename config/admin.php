<?php

use App\Models\{Agenda, Anggota, Berita, Budaya, Divisi, Galeri, KontakBantuan, Ketua, Panduan, Peluang, Pengurus, Prestasi, ProgramKerja, Slide};

$ikon = [
    'book' => 'Buku', 'home' => 'Rumah', 'trophy' => 'Piala', 'heart' => 'Hati', 'users' => 'Orang',
    'globe' => 'Dunia', 'navigation' => 'Navigasi', 'utensils' => 'Makanan', 'graduation' => 'Topi toga',
    'lightbulb' => 'Lampu', 'shield' => 'Perisai', 'phone' => 'Telepon', 'chat' => 'Obrolan',
    'calendar' => 'Kalender', 'award' => 'Penghargaan', 'briefcase' => 'Tas kerja',
];
$img = ['type' => 'image', 'rules' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:6144'];

/*
| Definisi CMS. Satu resource = satu halaman daftar + formulir tambah/ubah.
| Tipe field: text, url, number, date, datetime, textarea, markdown, select, bool, image.
| Untuk menambah kolom baru: tambah di migrasi, lalu tambah satu baris di 'fields'.
*/
return [
    'menu' => [
        'Utama' => [
            ['admin.dashboard', 'Dashboard', 'grid'],
            ['admin.profil', 'Beranda & Profil', 'home'],
            ['ketua', 'Ketua & Linimasa', 'award'],
        ],
        'Organisasi' => [
            ['divisi', 'Divisi', 'layers'],
            ['pengurus', 'Pengurus', 'users'],
            ['program', 'Program Kerja', 'book'],
            ['prestasi', 'Prestasi', 'trophy'],
        ],
        'Konten' => [
            ['berita', 'Berita', 'file'],
            ['galeri', 'Dokumentasi', 'image'],
            ['agenda', 'Agenda', 'calendar'],
            ['peluang', 'Beasiswa & Magang', 'briefcase'],
            ['panduan', 'Panduan Maba', 'lightbulb'],
        ],
        'Lainnya' => [
            ['anggota', 'Direktori Anggota', 'graduation'],
            ['budaya', 'Budaya Daerah', 'globe'],
            ['bantuan', 'Bantuan Cepat', 'heart'],
        ],
    ],

    // Halaman "Beranda & Profil": pengaturan tunggal (disimpan di tabel pengaturan).
    'profil' => [
        'pembimbing' => ['label' => 'Pembimbing', 'fields' => [
            'pembimbing_nama'    => ['type' => 'text', 'label' => 'Nama pembimbing', 'rules' => 'nullable|max:120'],
            'pembimbing_jabatan' => ['type' => 'text', 'label' => 'Jabatan / gelar', 'rules' => 'nullable|max:120', 'hint' => 'Contoh: Dosen Pembimbing HIMDES'],
            'pembimbing_foto'    => ['type' => 'image', 'label' => 'Foto pembimbing', 'rules' => $img['rules'], 'hint' => 'Disarankan potret tegak (rasio 4:5).'],
            'pembimbing_kata'    => ['type' => 'textarea', 'label' => 'Kata-kata / pesan', 'rules' => 'nullable|max:1200', 'wide' => true],
        ]],
        'visimisi' => ['label' => 'Visi, Misi & Sejarah', 'fields' => [
            'visi'    => ['type' => 'textarea', 'label' => 'Visi', 'rules' => 'nullable|max:800', 'wide' => true],
            'misi'    => ['type' => 'textarea', 'label' => 'Misi', 'rules' => 'nullable|max:3000', 'wide' => true, 'rows' => 7, 'hint' => 'Satu misi per baris.'],
            'sejarah' => ['type' => 'textarea', 'label' => 'Sejarah singkat', 'rules' => 'nullable|max:6000', 'wide' => true, 'rows' => 8, 'hint' => 'Pisahkan paragraf dengan satu baris kosong.'],
        ]],
        'identitas' => ['label' => 'Identitas & Kontak', 'fields' => [
            'nama'      => ['type' => 'text', 'label' => 'Nama lengkap organisasi', 'rules' => 'nullable|max:150'],
            'singkatan' => ['type' => 'text', 'label' => 'Singkatan', 'rules' => 'nullable|max:30'],
            'kota'      => ['type' => 'text', 'label' => 'Kota', 'rules' => 'nullable|max:60'],
            'periode'   => ['type' => 'text', 'label' => 'Periode kepengurusan', 'rules' => 'nullable|max:20', 'hint' => 'Contoh: 2025/2026'],
            'tagline'   => ['type' => 'text', 'label' => 'Tagline', 'rules' => 'nullable|max:200', 'wide' => true],
            'deskripsi' => ['type' => 'textarea', 'label' => 'Deskripsi singkat (SEO)', 'rules' => 'nullable|max:300', 'wide' => true, 'rows' => 3],
            'whatsapp'  => ['type' => 'text', 'label' => 'WhatsApp admin', 'rules' => 'nullable|max:20', 'hint' => 'Format 62812xxxxxxx'],
            'instagram' => ['type' => 'text', 'label' => 'Instagram (tanpa @)', 'rules' => 'nullable|max:60'],
            'email'     => ['type' => 'text', 'label' => 'Email', 'rules' => 'nullable|email|max:120'],
            'peta_query' => ['type' => 'text', 'label' => 'Lokasi untuk peta', 'rules' => 'nullable|max:200'],
            'alamat'    => ['type' => 'textarea', 'label' => 'Alamat sekretariat', 'rules' => 'nullable|max:300', 'wide' => true, 'rows' => 2],
        ]],
    ],

    'resources' => [
        'slide' => [
            'model' => Slide::class, 'label' => 'Slide', 'plural' => 'Carousel beranda', 'order' => ['urutan', 'asc'],
            'back' => 'admin.profil',
            'columns' => [['gambar', 'Gambar', 'image'], ['judul', 'Judul'], ['aktif', 'Tampil', 'bool']],
            'search' => ['judul'],
            'fields' => [
                'judul'        => ['type' => 'text', 'label' => 'Judul', 'rules' => 'required|max:120', 'wide' => true],
                'subjudul'     => ['type' => 'textarea', 'label' => 'Teks pendukung', 'rules' => 'nullable|max:300', 'wide' => true, 'rows' => 3],
                'gambar'       => $img + ['label' => 'Gambar latar', 'hint' => 'Lanskap, minimal 1600 px lebar. Kosongkan untuk latar biru polos.', 'wide' => true],
                'tombol_label' => ['type' => 'text', 'label' => 'Teks tombol', 'rules' => 'nullable|max:40'],
                'tombol_url'   => ['type' => 'text', 'label' => 'Tautan tombol', 'rules' => 'nullable|max:255', 'hint' => 'Contoh: /berita atau #daftar atau https://...'],
                'urutan'       => ['type' => 'number', 'label' => 'Urutan', 'rules' => 'nullable|integer|min:0', 'default' => 0],
                'aktif'        => ['type' => 'bool', 'label' => 'Tampilkan di beranda', 'default' => true],
            ],
        ],

        'ketua' => [
            'model' => Ketua::class, 'label' => 'Ketua Umum', 'plural' => 'Ketua Umum & Linimasa', 'order' => ['tahun_mulai', 'desc'],
            'exclusive' => 'aktif',
            'intro' => 'Ketua yang ditandai "sedang menjabat" tampil di beranda. Semua ketua tampil di linimasa halaman Tentang.',
            'columns' => [['foto', 'Foto', 'avatar'], ['nama', 'Nama'], ['periode', 'Periode'], ['aktif', 'Menjabat', 'bool']],
            'search' => ['nama', 'periode'],
            'fields' => [
                'nama'          => ['type' => 'text', 'label' => 'Nama', 'rules' => 'required|max:120'],
                'periode'       => ['type' => 'text', 'label' => 'Periode', 'rules' => 'required|max:20', 'hint' => 'Contoh: 2025/2026'],
                'tahun_mulai'   => ['type' => 'number', 'label' => 'Tahun mulai', 'rules' => 'required|integer|min:1990|max:2100'],
                'tahun_selesai' => ['type' => 'number', 'label' => 'Tahun selesai', 'rules' => 'nullable|integer|min:1990|max:2100', 'hint' => 'Kosongkan bila masih menjabat.'],
                'kampus'        => ['type' => 'text', 'label' => 'Kampus / jurusan', 'rules' => 'nullable|max:150'],
                'foto'          => $img + ['label' => 'Foto', 'hint' => 'Potret tegak (rasio 4:5) paling pas.'],
                'kata'          => ['type' => 'textarea', 'label' => 'Kata-kata / sambutan', 'rules' => 'nullable|max:1200', 'wide' => true],
                'capaian'       => ['type' => 'textarea', 'label' => 'Capaian masa jabatan', 'rules' => 'nullable|max:1500', 'wide' => true, 'rows' => 3],
                'aktif'         => ['type' => 'bool', 'label' => 'Sedang menjabat (tampil di beranda)'],
            ],
        ],

        'divisi' => [
            'model' => Divisi::class, 'label' => 'Divisi', 'plural' => 'Divisi', 'order' => ['urutan', 'asc'],
            'columns' => [['nama', 'Nama'], ['urutan', 'Urutan']],
            'search' => ['nama'],
            'fields' => [
                'nama'      => ['type' => 'text', 'label' => 'Nama divisi', 'rules' => 'required|max:120'],
                'ikon'      => ['type' => 'select', 'label' => 'Ikon', 'options' => $ikon, 'rules' => 'required', 'default' => 'users'],
                'deskripsi' => ['type' => 'textarea', 'label' => 'Tugas divisi', 'rules' => 'nullable|max:500', 'wide' => true, 'rows' => 3],
                'urutan'    => ['type' => 'number', 'label' => 'Urutan', 'rules' => 'nullable|integer|min:0', 'default' => 0],
            ],
        ],

        'pengurus' => [
            'model' => Pengurus::class, 'label' => 'Pengurus', 'plural' => 'Pengurus', 'order' => ['urutan', 'asc'], 'with' => ['divisi'],
            'intro' => 'Pilih tingkat "Inti" untuk BPH (tampil di beranda). Anggota divisi dipilihkan divisinya; centang "Kepala divisi" untuk ketuanya.',
            'columns' => [['foto', 'Foto', 'avatar'], ['nama', 'Nama'], ['jabatan', 'Jabatan'], ['divisi.nama', 'Divisi']],
            'search' => ['nama', 'jabatan'],
            'fields' => [
                'nama'      => ['type' => 'text', 'label' => 'Nama', 'rules' => 'required|max:120'],
                'jabatan'   => ['type' => 'text', 'label' => 'Jabatan', 'rules' => 'required|max:120'],
                'tingkat'   => ['type' => 'select', 'label' => 'Tingkat', 'options' => ['inti' => 'Inti (BPH)', 'divisi' => 'Divisi'], 'rules' => 'required|in:inti,divisi', 'default' => 'divisi'],
                'divisi_id' => ['type' => 'select', 'label' => 'Divisi', 'rel' => [Divisi::class, 'nama'], 'rules' => 'nullable|exists:divisi,id', 'empty' => 'Tanpa divisi'],
                'is_kepala' => ['type' => 'bool', 'label' => 'Kepala divisi'],
                'kampus'    => ['type' => 'text', 'label' => 'Kampus / jurusan', 'rules' => 'nullable|max:150'],
                'foto'      => $img + ['label' => 'Foto'],
                'whatsapp'  => ['type' => 'text', 'label' => 'WhatsApp', 'rules' => 'nullable|max:20'],
                'instagram' => ['type' => 'text', 'label' => 'Instagram', 'rules' => 'nullable|max:60'],
                'urutan'    => ['type' => 'number', 'label' => 'Urutan', 'rules' => 'nullable|integer|min:0', 'default' => 0],
            ],
        ],

        'program' => [
            'model' => ProgramKerja::class, 'label' => 'Program kerja', 'plural' => 'Program Kerja', 'order' => ['urutan', 'asc'],
            'columns' => [['gambar', 'Foto', 'image'], ['judul', 'Judul'], ['kategori', 'Kategori']],
            'search' => ['judul', 'kategori'],
            'fields' => [
                'judul'     => ['type' => 'text', 'label' => 'Judul', 'rules' => 'required|max:150', 'wide' => true],
                'kategori'  => ['type' => 'text', 'label' => 'Kategori', 'rules' => 'nullable|max:60'],
                'ikon'      => ['type' => 'select', 'label' => 'Ikon', 'options' => $ikon, 'rules' => 'required', 'default' => 'users'],
                'gambar'    => $img + ['label' => 'Foto kegiatan', 'wide' => true, 'hint' => 'Rasio 16:10 paling pas.'],
                'deskripsi' => ['type' => 'textarea', 'label' => 'Deskripsi', 'rules' => 'required|max:1000', 'wide' => true],
                'urutan'    => ['type' => 'number', 'label' => 'Urutan', 'rules' => 'nullable|integer|min:0', 'default' => 0],
            ],
        ],

        'prestasi' => [
            'model' => Prestasi::class, 'label' => 'Prestasi', 'plural' => 'Jejak Pencapaian', 'order' => ['tahun', 'desc'],
            'columns' => [['gambar', 'Foto', 'image'], ['judul', 'Judul'], ['peringkat', 'Peringkat'], ['tahun', 'Tahun']],
            'search' => ['judul'],
            'fields' => [
                'judul'     => ['type' => 'text', 'label' => 'Judul pencapaian', 'rules' => 'required|max:200', 'wide' => true],
                'peringkat' => ['type' => 'text', 'label' => 'Peringkat', 'rules' => 'nullable|max:60', 'hint' => 'Contoh: Juara 1'],
                'tingkat'   => ['type' => 'select', 'label' => 'Tingkat', 'options' => ['Kampus' => 'Kampus', 'Kota' => 'Kota', 'Provinsi' => 'Provinsi', 'Nasional' => 'Nasional', 'Internasional' => 'Internasional'], 'rules' => 'nullable', 'empty' => '-'],
                'tahun'     => ['type' => 'number', 'label' => 'Tahun', 'rules' => 'required|integer|min:1990|max:2100', 'default' => date('Y')],
                'gambar'    => $img + ['label' => 'Foto (opsional)'],
                'deskripsi' => ['type' => 'textarea', 'label' => 'Deskripsi', 'rules' => 'nullable|max:1000', 'wide' => true],
            ],
        ],

        'berita' => [
            'model' => Berita::class, 'label' => 'Berita', 'plural' => 'Berita & Pengumuman', 'order' => ['dipublikasi_pada', 'desc'], 'slug' => 'judul',
            'columns' => [['gambar', 'Gambar', 'image'], ['judul', 'Judul'], ['kategori', 'Kategori'], ['dipublikasi_pada', 'Terbit', 'datetime']],
            'search' => ['judul', 'kategori'],
            'fields' => [
                'judul'            => ['type' => 'text', 'label' => 'Judul', 'rules' => 'required|max:200', 'wide' => true],
                'kategori'         => ['type' => 'select', 'label' => 'Kategori', 'options' => ['Berita' => 'Berita', 'Pengumuman' => 'Pengumuman', 'Kegiatan' => 'Kegiatan'], 'rules' => 'required', 'default' => 'Berita'],
                'dipublikasi_pada' => ['type' => 'datetime', 'label' => 'Waktu terbit', 'rules' => 'nullable|date', 'default' => 'now', 'hint' => 'Kosongkan = draf (tidak tampil). Isi waktu mendatang = terbit terjadwal.'],
                'gambar'           => $img + ['label' => 'Gambar sampul', 'wide' => true],
                'ringkasan'        => ['type' => 'textarea', 'label' => 'Ringkasan', 'rules' => 'required|max:400', 'wide' => true, 'rows' => 3],
                'isi'              => ['type' => 'markdown', 'label' => 'Isi berita', 'rules' => 'required', 'wide' => true],
            ],
        ],

        'galeri' => [
            'model' => Galeri::class, 'label' => 'Foto', 'plural' => 'Dokumentasi Kegiatan', 'order' => ['id', 'desc'], 'multi' => 'gambar',
            'intro' => 'Saat menambah, kamu bisa memilih banyak foto sekaligus; semuanya masuk ke album yang sama.',
            'columns' => [['gambar', 'Foto', 'image'], ['judul', 'Judul'], ['album', 'Album'], ['tahun', 'Tahun']],
            'search' => ['judul', 'album'],
            'fields' => [
                'album'     => ['type' => 'text', 'label' => 'Album', 'rules' => 'required|max:120', 'list' => 'album', 'hint' => 'Ketik album baru atau pilih yang sudah ada.'],
                'tahun'     => ['type' => 'number', 'label' => 'Tahun', 'rules' => 'required|integer|min:1990|max:2100', 'default' => date('Y')],
                'gambar'    => $img + ['label' => 'Foto', 'wide' => true, 'multi' => true, 'hint' => 'JPG, PNG, atau WebP, maksimal 6 MB per foto.'],
                'judul'     => ['type' => 'text', 'label' => 'Judul / keterangan', 'rules' => 'nullable|max:150', 'hint' => 'Kosong = pakai nama album.'],
                'video_url' => ['type' => 'url', 'label' => 'Tautan video (opsional)', 'rules' => 'nullable|url|max:255'],
                'urutan'    => ['type' => 'number', 'label' => 'Urutan', 'rules' => 'nullable|integer|min:0', 'default' => 0],
            ],
        ],

        'agenda' => [
            'model' => Agenda::class, 'label' => 'Agenda', 'plural' => 'Agenda Kegiatan', 'order' => ['mulai', 'desc'],
            'columns' => [['judul', 'Judul'], ['mulai', 'Mulai', 'datetime'], ['lokasi', 'Lokasi']],
            'search' => ['judul', 'lokasi'],
            'fields' => [
                'judul'     => ['type' => 'text', 'label' => 'Nama acara', 'rules' => 'required|max:200', 'wide' => true],
                'mulai'     => ['type' => 'datetime', 'label' => 'Mulai', 'rules' => 'required|date'],
                'selesai'   => ['type' => 'datetime', 'label' => 'Selesai', 'rules' => 'nullable|date|after_or_equal:mulai'],
                'lokasi'    => ['type' => 'text', 'label' => 'Lokasi', 'rules' => 'nullable|max:200', 'wide' => true],
                'deskripsi' => ['type' => 'textarea', 'label' => 'Deskripsi', 'rules' => 'nullable|max:1000', 'wide' => true],
            ],
        ],

        'peluang' => [
            'model' => Peluang::class, 'label' => 'Info', 'plural' => 'Beasiswa & Magang', 'order' => ['id', 'desc'], 'slug' => 'judul',
            'columns' => [['gambar', 'Gambar', 'image'], ['judul', 'Judul'], ['jenis', 'Jenis'], ['batas_waktu', 'Batas', 'date']],
            'search' => ['judul', 'penyelenggara', 'jenis'],
            'fields' => [
                'judul'         => ['type' => 'text', 'label' => 'Judul', 'rules' => 'required|max:200', 'wide' => true],
                'jenis'         => ['type' => 'select', 'label' => 'Jenis', 'options' => ['Beasiswa' => 'Beasiswa', 'Magang' => 'Magang', 'Lomba' => 'Lomba', 'Lowongan' => 'Lowongan'], 'rules' => 'required', 'default' => 'Beasiswa'],
                'batas_waktu'   => ['type' => 'date', 'label' => 'Batas pendaftaran', 'rules' => 'nullable|date'],
                'penyelenggara' => ['type' => 'text', 'label' => 'Penyelenggara', 'rules' => 'nullable|max:150'],
                'tautan'        => ['type' => 'url', 'label' => 'Tautan pendaftaran', 'rules' => 'nullable|url|max:255'],
                'gambar'        => $img + ['label' => 'Poster / gambar', 'wide' => true],
                'deskripsi'     => ['type' => 'textarea', 'label' => 'Ringkasan', 'rules' => 'nullable|max:400', 'wide' => true, 'rows' => 3],
                'isi'           => ['type' => 'markdown', 'label' => 'Detail & persyaratan', 'rules' => 'nullable', 'wide' => true],
            ],
        ],

        'panduan' => [
            'model' => Panduan::class, 'label' => 'Panduan', 'plural' => 'Panduan Mahasiswa Baru', 'order' => ['urutan', 'asc'],
            'columns' => [['kategori', 'Kategori'], ['judul', 'Judul'], ['urutan', 'Urutan']],
            'search' => ['judul', 'kategori'],
            'fields' => [
                'kategori' => ['type' => 'text', 'label' => 'Kategori', 'rules' => 'required|max:60', 'list' => 'kategori', 'hint' => 'Contoh: Persiapan, Kos, Transportasi, Kuliner, Kampus, Tips.'],
                'ikon'     => ['type' => 'select', 'label' => 'Ikon', 'options' => $ikon, 'rules' => 'required', 'default' => 'lightbulb'],
                'judul'    => ['type' => 'text', 'label' => 'Judul', 'rules' => 'required|max:200', 'wide' => true],
                'isi'      => ['type' => 'markdown', 'label' => 'Isi panduan', 'rules' => 'required', 'wide' => true],
                'urutan'   => ['type' => 'number', 'label' => 'Urutan', 'rules' => 'nullable|integer|min:0', 'default' => 0, 'hint' => 'Kategori mengikuti urutan item pertamanya.'],
            ],
        ],

        'anggota' => [
            'model' => Anggota::class, 'label' => 'Anggota', 'plural' => 'Direktori Anggota', 'order' => ['angkatan', 'desc'],
            'columns' => [['nama', 'Nama'], ['kampus', 'Kampus'], ['angkatan', 'Angkatan'], ['tampil', 'Tampil', 'bool']],
            'search' => ['nama', 'kampus', 'jurusan'],
            'fields' => [
                'nama'     => ['type' => 'text', 'label' => 'Nama', 'rules' => 'required|max:120'],
                'kampus'   => ['type' => 'text', 'label' => 'Kampus', 'rules' => 'required|max:150'],
                'jurusan'  => ['type' => 'text', 'label' => 'Jurusan', 'rules' => 'required|max:150'],
                'angkatan' => ['type' => 'number', 'label' => 'Angkatan', 'rules' => 'required|integer|min:1990|max:2100', 'default' => date('Y')],
                'status'   => ['type' => 'select', 'label' => 'Status', 'options' => ['Anggota' => 'Anggota', 'Alumni' => 'Alumni'], 'rules' => 'required', 'default' => 'Anggota'],
                'tampil'   => ['type' => 'bool', 'label' => 'Anggota setuju profilnya ditampilkan di situs'],
            ],
        ],

        'budaya' => [
            'model' => Budaya::class, 'label' => 'Konten budaya', 'plural' => 'Budaya Daerah', 'order' => ['urutan', 'asc'],
            'columns' => [['gambar', 'Gambar', 'image'], ['judul', 'Judul'], ['kategori', 'Kategori']],
            'search' => ['judul'],
            'fields' => [
                'judul'     => ['type' => 'text', 'label' => 'Judul', 'rules' => 'required|max:150', 'wide' => true],
                'kategori'  => ['type' => 'select', 'label' => 'Kategori', 'options' => ['Bahasa' => 'Bahasa', 'Kuliner' => 'Kuliner', 'Tari' => 'Tari', 'Cerita' => 'Cerita'], 'rules' => 'required'],
                'urutan'    => ['type' => 'number', 'label' => 'Urutan', 'rules' => 'nullable|integer|min:0', 'default' => 0],
                'gambar'    => $img + ['label' => 'Gambar', 'wide' => true],
                'deskripsi' => ['type' => 'textarea', 'label' => 'Deskripsi', 'rules' => 'required|max:1000', 'wide' => true],
            ],
        ],

        'bantuan' => [
            'model' => KontakBantuan::class, 'label' => 'Kontak', 'plural' => 'Bantuan Cepat', 'order' => ['urutan', 'asc'],
            'columns' => [['label', 'Layanan'], ['whatsapp', 'WhatsApp']],
            'search' => ['label'],
            'fields' => [
                'label'     => ['type' => 'text', 'label' => 'Nama layanan', 'rules' => 'required|max:100'],
                'whatsapp'  => ['type' => 'text', 'label' => 'Nomor WhatsApp', 'rules' => 'required|max:20', 'hint' => 'Format 62812xxxxxxx'],
                'ikon'      => ['type' => 'select', 'label' => 'Ikon', 'options' => $ikon, 'rules' => 'required', 'default' => 'heart'],
                'urutan'    => ['type' => 'number', 'label' => 'Urutan', 'rules' => 'nullable|integer|min:0', 'default' => 0],
                'deskripsi' => ['type' => 'textarea', 'label' => 'Deskripsi', 'rules' => 'required|max:300', 'wide' => true, 'rows' => 3],
            ],
        ],
    ],
];
