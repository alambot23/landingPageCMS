<?php

namespace Database\Seeders;

use App\Models\Agenda;
use App\Models\Anggota;
use App\Models\Berita;
use App\Models\Divisi;
use App\Models\Ketua;
use App\Models\Pengaturan;
use App\Models\Slide;
use App\Models\Budaya;
use App\Models\Galeri;
use App\Models\KontakBantuan;
use App\Models\Panduan;
use App\Models\Peluang;
use App\Models\Pengurus;
use App\Models\Prestasi;
use App\Models\ProgramKerja;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class HimdesSeeder extends Seeder
{
    public function run(): void
    {
        $wa = config('himdes.whatsapp');

        // ---- Akun admin CMS ----------------------------------------------
        \App\Models\User::updateOrCreate(
            ['email' => config('himdes.admin_email')],
            ['name' => 'Admin HIMDES', 'password' => Hash::make(config('himdes.admin_password'))]
        );

        // ---- Pengaturan (pembimbing) -------------------------------------
        foreach ([
            'pembimbing_nama'    => 'Nama Pembimbing',
            'pembimbing_jabatan' => 'Dosen Pembimbing HIMDES',
            'pembimbing_kata'    => 'Contoh: Teruslah belajar, berorganisasi, dan jaga nama baik daerah asal di mana pun kalian berada. Ganti teks ini lewat CMS.',
        ] as $k => $v) {
            Pengaturan::simpan($k, $v);
        }

        // ---- Carousel beranda (tanpa gambar; unggah foto lewat CMS) -------
        foreach ([
            ['Rumah bagi putra-putri Deli Serdang di tanah rantau.', 'Wadah pemersatu, pengembangan diri, dan kekeluargaan mahasiswa asal Deli Serdang di Lhokseumawe.', 'Gabung Sekarang', '#daftar'],
            ['Agenda dan kegiatan terbaru', 'Kajian, olahraga, bakti sosial, dan malam keakraban. Simpan jadwalnya agar tidak ketinggalan.', 'Lihat Agenda', '/agenda'],
            ['Baru tiba di Lhokseumawe?', 'Panduan dari senior: tempat tinggal, transportasi, kuliner, dan kampus.', 'Buka Panduan Maba', '/panduan-maba'],
        ] as $i => [$judul, $sub, $label, $url]) {
            Slide::create(['judul' => $judul, 'subjudul' => $sub, 'tombol_label' => $label, 'tombol_url' => $url, 'urutan' => $i + 1, 'aktif' => true]);
        }

        // ---- Ketua umum: periode berjalan + riwayat -----------------------
        foreach ([
            ['Nama Ketua Umum', '2025/2026', 2025, null, true, 'Contoh: Kita datang dari kampung yang sama, dan di sini kita saling menjaga. Ganti kalimat ini lewat CMS.', 'Isi capaian masa jabatan di sini.'],
            ['Nama Ketua 2024/2025', '2024/2025', 2024, 2025, false, 'Contoh kata sambutan ketua periode sebelumnya.', 'Isi capaian masa jabatan di sini.'],
            ['Nama Ketua 2023/2024', '2023/2024', 2023, 2024, false, 'Contoh kata sambutan ketua periode sebelumnya.', null],
            ['Nama Ketua 2022/2023', '2022/2023', 2022, 2023, false, null, null],
        ] as [$nama, $periode, $mulai, $selesai, $aktif, $kata, $capaian]) {
            Ketua::create([
                'nama' => $nama, 'periode' => $periode, 'tahun_mulai' => $mulai, 'tahun_selesai' => $selesai,
                'kampus' => 'Isi kampus / jurusan', 'aktif' => $aktif, 'kata' => $kata, 'capaian' => $capaian,
            ]);
        }

        // ---- Pengurus inti (BPH) ------------------------------------------
        $urut = 0;
        foreach ([
            ['Nama Ketua Umum', 'Ketua Umum'],
            ['Nama Wakil Ketua', 'Wakil Ketua Umum'],
            ['Nama Sekretaris', 'Sekretaris Umum'],
            ['Nama Bendahara', 'Bendahara Umum'],
        ] as [$nama, $jabatan]) {
            Pengurus::create([
                'nama' => $nama, 'jabatan' => $jabatan, 'tingkat' => 'inti',
                'kampus' => 'Isi nama kampus', 'whatsapp' => $wa, 'urutan' => ++$urut,
            ]);
        }

        // ---- Divisi + kepala + anggota ------------------------------------
        foreach ([
            ['Pendidikan', 'Kajian akademik, pelatihan, dan pendampingan belajar anggota.', 'book'],
            ['Olahraga & Seni', 'Turnamen, latihan rutin, dan pentas seni budaya daerah.', 'trophy'],
            ['Sosial & Kemasyarakatan', 'Bakti sosial, solidaritas anggota, dan layanan bantuan cepat.', 'heart'],
            ['Humas & Media', 'Publikasi, dokumentasi, dan hubungan dengan pihak luar.', 'chat'],
        ] as $i => [$nama, $desk, $ikon]) {
            $d = Divisi::create(['nama' => $nama, 'deskripsi' => $desk, 'ikon' => $ikon, 'urutan' => $i + 1]);
            Pengurus::create([
                'nama' => 'Nama Kepala', 'jabatan' => 'Kepala Divisi ' . $nama, 'tingkat' => 'divisi', 'is_kepala' => true,
                'divisi_id' => $d->id, 'kampus' => 'Isi nama kampus', 'whatsapp' => $wa, 'urutan' => ++$urut,
            ]);
            foreach (['Anggota Satu', 'Anggota Dua'] as $n) {
                Pengurus::create([
                    'nama' => 'Nama ' . $n, 'jabatan' => 'Anggota Divisi', 'tingkat' => 'divisi',
                    'divisi_id' => $d->id, 'kampus' => 'Isi nama kampus', 'urutan' => ++$urut,
                ]);
            }
        }

        // ---- Program kerja -----------------------------------------------
        foreach ([
            ['Kajian & Pelatihan', 'Diskusi ilmiah, pelatihan organisasi, dan kelas berbagi ilmu antaranggota.', 'Pendidikan', 'book'],
            ['Penyambutan Mahasiswa Baru', 'Menyambut dan mendampingi maba asal Deli Serdang sejak tiba di Lhokseumawe.', 'Kekeluargaan', 'home'],
            ['Olahraga & Seni', 'Turnamen persahabatan, latihan rutin, dan pentas seni budaya daerah.', 'Olahraga & Seni', 'trophy'],
            ['Bakti Sosial', 'Aksi peduli lingkungan dan masyarakat sekitar kampus serta di kampung halaman.', 'Sosial', 'heart'],
            ['Malam Keakraban', 'Temu santai tahunan untuk mempererat persaudaraan seluruh angkatan.', 'Kekeluargaan', 'users'],
            ['Mudik & Silaturahmi', 'Koordinasi pulang kampung bersama dan temu alumni di Deli Serdang.', 'Kekeluargaan', 'globe'],
        ] as $i => [$judul, $desk, $kat, $ikon]) {
            ProgramKerja::create([
                'judul' => $judul, 'deskripsi' => $desk, 'kategori' => $kat,
                'ikon' => $ikon, 'urutan' => $i + 1,
            ]);
        }

        // ---- Prestasi (contoh) -------------------------------------------
        foreach ([
            ['Contoh: Juara 1 Turnamen Futsal Antar Himpunan', 'Juara 1', 'Kota', 2025, 'Isi deskripsi singkat prestasi di sini.'],
            ['Contoh: Penghargaan Himpunan Daerah Teraktif', 'Penghargaan', 'Kampus', 2024, 'Isi deskripsi singkat prestasi di sini.'],
            ['Contoh: Juara 2 Festival Budaya Nusantara', 'Juara 2', 'Provinsi', 2024, 'Isi deskripsi singkat prestasi di sini.'],
        ] as [$judul, $peringkat, $tingkat, $tahun, $desk]) {
            Prestasi::create(compact('judul', 'peringkat', 'tingkat', 'tahun') + ['deskripsi' => $desk]);
        }

        // ---- Berita & pengumuman -----------------------------------------
        foreach ([
            ['Selamat Datang Mahasiswa Baru Deli Serdang', 'Pengumuman', 'HIMDES membuka penyambutan untuk mahasiswa baru asal Deli Serdang di Lhokseumawe.', 5],
            ['Rapat Kerja dan Pelantikan Pengurus Baru', 'Berita', 'Pengurus periode baru resmi dilantik dan menyusun program kerja setahun ke depan.', 12],
            ['Pendaftaran Anggota Baru Dibuka', 'Pengumuman', 'Pendaftaran anggota HIMDES dibuka sepanjang tahun lewat WhatsApp admin.', 20],
        ] as $i => [$judul, $kategori, $ringkasan, $hariLalu]) {
            Berita::create([
                'judul' => $judul,
                'slug' => \Illuminate\Support\Str::slug($judul),
                'kategori' => $kategori,
                'ringkasan' => $ringkasan,
                'isi' => $ringkasan . "\n\nIni adalah artikel contoh. Ganti dengan isi berita yang sebenarnya melalui CMS.",
                'dipublikasi_pada' => now()->subDays($hariLalu),
            ]);
        }

        // ---- Galeri (tanpa foto; tampil sebagai placeholder) -------------
        foreach ([
            ['Malam Keakraban', 'Malam Keakraban 2025', 2025],
            ['Bakti Sosial', 'Bakti Sosial 2025', 2025],
            ['Turnamen Futsal', 'Olahraga 2025', 2025],
            ['Penyambutan Maba', 'Penyambutan Maba 2024', 2024],
            ['Pentas Seni Budaya', 'Pentas Seni 2024', 2024],
            ['Rapat Kerja', 'Rapat Kerja 2024', 2024],
        ] as $i => [$judul, $album, $tahun]) {
            Galeri::create(['judul' => $judul, 'album' => $album, 'tahun' => $tahun, 'urutan' => $i]);
        }

        // ---- Agenda (tanggal relatif dari hari ini) ----------------------
        foreach ([
            ['Kajian Akademik Bulanan', 'Diskusi ilmiah dan berbagi tips kuliah.', 'Sekretariat HIMDES', 7, 16],
            ['Turnamen Futsal Persahabatan', 'Pertandingan persahabatan antaranggota.', 'Lapangan Futsal, Lhokseumawe', 16, 15],
            ['Malam Keakraban', 'Temu santai seluruh angkatan.', 'Lokasi diumumkan kemudian', 30, 19],
        ] as [$judul, $desk, $lokasi, $hari, $jam]) {
            $mulai = now()->addDays($hari)->setTime($jam, 0);
            Agenda::create([
                'judul' => $judul, 'deskripsi' => $desk, 'lokasi' => $lokasi,
                'mulai' => $mulai, 'selesai' => $mulai->copy()->addHours(3),
            ]);
        }

        // ---- Panduan mahasiswa baru (contoh, sesuaikan; isi mendukung Markdown) ----
        foreach ([
            ['Persiapan', 'Checklist sebelum berangkat', "- KTP, KK, ijazah, dan berkas daftar ulang (fotokopi + asli)\n- Uang tunai secukupnya dan kartu ATM aktif\n- Obat pribadi dan perlengkapan mandi\n- Nomor kontak pengurus HIMDES dan senior\n\nKabari pengurus tanggal keberangkatanmu agar bisa dijemput atau berangkat bersama.", 'check'],
            ['Persiapan', 'Berangkat bersama rombongan', 'Koordinasikan jadwal berangkat dengan pengurus. Perjalanan bersama lebih aman dan hemat biaya.', 'users'],
            ['Kos', 'Cari kos dekat kampus', "Tanyakan ke senior dan pengurus HIMDES sebelum membayar.\n\n- Survei langsung bila bisa\n- Pastikan air, listrik, dan keamanan jelas\n- Tanyakan aturan tamu dan jam malam", 'home'],
            ['Kos', 'Patungan dengan sesama anggota', 'Berbagi kos atau kontrakan dengan sesama anggota bisa menghemat biaya bulanan.', 'users'],
            ['Transportasi', 'Dari Deli Serdang ke Lhokseumawe', 'Perjalanan darat lewat Medan menuju Aceh memakan waktu seharian. Koordinasikan berangkat bersama agar lebih aman dan hemat.', 'navigation'],
            ['Transportasi', 'Berkeliling di dalam kota', 'Sepeda motor adalah pilihan paling praktis. Tanyakan ke senior soal tarif ojek dan angkutan setempat.', 'navigation'],
            ['Kuliner', 'Makan hemat sehari-hari', 'Warung nasi dan kedai kopi sekitar kampus menawarkan menu terjangkau. Minta rekomendasi favorit senior.', 'utensils'],
            ['Kampus', 'Kampus-kampus di Lhokseumawe', 'Universitas Malikussaleh dan Politeknik Negeri Lhokseumawe adalah dua kampus yang banyak dituju mahasiswa perantau.', 'graduation'],
            ['Kampus', 'Administrasi awal kuliah', "Siapkan berkas untuk daftar ulang, KTM, dan KRS. Datang lebih pagi agar tidak antre panjang.", 'book'],
            ['Tips', 'Beradaptasi dengan budaya setempat', 'Pelajari kebiasaan dan adat masyarakat Aceh, bersikap sopan, dan terbuka bergaul. Itu kunci diterima dengan baik.', 'lightbulb'],
            ['Tips', 'Kelola uang bulanan', 'Catat pengeluaran, siapkan dana darurat, dan jangan ragu minta bantuan HIMDES bila kesulitan.', 'lightbulb'],
        ] as $i => [$kat, $judul, $isi, $ikon]) {
            Panduan::create(['kategori' => $kat, 'judul' => $judul, 'isi' => $isi, 'ikon' => $ikon === 'check' ? 'shield' : $ikon, 'urutan' => $i]);
        }

        // ---- Direktori anggota/alumni (contoh; hanya yang tampil=true) ----
        foreach ([
            ['Nama Anggota Satu', 'Universitas Malikussaleh', 'Teknik Informatika', 2023, 'Anggota'],
            ['Nama Anggota Dua', 'Universitas Malikussaleh', 'Manajemen', 2022, 'Anggota'],
            ['Nama Anggota Tiga', 'Politeknik Negeri Lhokseumawe', 'Teknik Elektro', 2023, 'Anggota'],
            ['Nama Alumni Satu', 'Universitas Malikussaleh', 'Hukum', 2019, 'Alumni'],
        ] as [$nama, $kampus, $jurusan, $angkatan, $status]) {
            Anggota::create(compact('nama', 'kampus', 'jurusan', 'angkatan', 'status') + ['tampil' => true]);
        }

        // ---- Info beasiswa, magang, lomba (contoh) -----------------------
        foreach ([
            ['Beasiswa', 'Contoh: Beasiswa Prestasi Mahasiswa', 'Kampus / Pemda', 'Isi persyaratan singkat di sini.', 45],
            ['Magang', 'Contoh: Program Magang Mahasiswa', 'Perusahaan mitra', 'Isi detail singkat di sini.', 30],
            ['Lomba', 'Contoh: Lomba Karya Tulis Ilmiah', 'Panitia lomba', 'Isi detail singkat di sini.', 21],
        ] as [$jenis, $judul, $penyelenggara, $desk, $hari]) {
            Peluang::create([
                'jenis' => $jenis, 'judul' => $judul, 'slug' => Str::slug($judul), 'penyelenggara' => $penyelenggara,
                'deskripsi' => $desk, 'batas_waktu' => now()->addDays($hari)->toDateString(),
                'isi' => "## Tentang program\n\n" . $desk . "\n\n## Persyaratan\n\n- Mahasiswa aktif\n- Mengisi formulir pendaftaran\n- Melampirkan berkas yang diminta\n\n*Teks contoh. Ganti lewat CMS.*",
            ]);
        }

        // ---- Konten budaya daerah (contoh) -------------------------------
        foreach ([
            ['Bahasa', 'Bahasa dan Ragam Etnis', 'Deli Serdang dihuni beragam etnis, di antaranya Melayu, Karo, Jawa, dan Batak. Sapaan dan ungkapan khas tiap suku bisa ditulis di sini.'],
            ['Kuliner', 'Cita Rasa Kampung Halaman', 'Tulis hidangan khas Deli Serdang yang paling dirindukan perantau beserta ceritanya.'],
            ['Tari', 'Seni Tari dan Pertunjukan', 'Perkenalkan tari dan seni pertunjukan daerah yang sering ditampilkan HIMDES.'],
            ['Cerita', 'Cerita Rakyat dan Sejarah', 'Kisah, sejarah, dan tokoh daerah yang membentuk identitas Deli Serdang.'],
        ] as $i => [$kat, $judul, $desk]) {
            Budaya::create(['kategori' => $kat, 'judul' => $judul, 'deskripsi' => $desk, 'urutan' => $i]);
        }

        // ---- Layanan bantuan cepat ---------------------------------------
        foreach ([
            ['Bidang Sosial', 'Anggota sakit, kena musibah, atau butuh pendampingan.', 'heart'],
            ['Pengaduan & Saran', 'Sampaikan keluhan, masukan, atau laporan secara langsung.', 'shield'],
            ['Ketua Umum', 'Hal mendesak yang perlu keputusan pimpinan.', 'phone'],
        ] as $i => [$label, $desk, $ikon]) {
            KontakBantuan::create([
                'label' => $label, 'deskripsi' => $desk, 'whatsapp' => $wa, 'ikon' => $ikon, 'urutan' => $i,
            ]);
        }
    }
}
