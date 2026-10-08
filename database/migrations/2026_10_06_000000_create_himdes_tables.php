<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengurus', function (Blueprint $t) {
            $t->id();
            $t->string('nama');
            $t->string('jabatan');
            $t->string('tingkat')->default('inti'); // inti | bidang
            $t->string('kampus')->nullable();
            $t->string('foto')->nullable();
            $t->string('whatsapp')->nullable();
            $t->string('instagram')->nullable();
            $t->unsignedInteger('urutan')->default(0);
            $t->timestamps();
        });

        Schema::create('program_kerja', function (Blueprint $t) {
            $t->id();
            $t->string('judul');
            $t->text('deskripsi');
            $t->string('kategori')->nullable();
            $t->string('ikon')->default('users');
            $t->unsignedInteger('urutan')->default(0);
            $t->timestamps();
        });

        Schema::create('prestasi', function (Blueprint $t) {
            $t->id();
            $t->string('judul');
            $t->string('peringkat')->nullable();
            $t->string('tingkat')->nullable(); // Kampus | Kota | Provinsi | Nasional
            $t->unsignedSmallInteger('tahun');
            $t->text('deskripsi')->nullable();
            $t->timestamps();
        });

        Schema::create('berita', function (Blueprint $t) {
            $t->id();
            $t->string('judul');
            $t->string('slug')->unique();
            $t->string('kategori')->default('Berita'); // Berita | Pengumuman
            $t->text('ringkasan');
            $t->longText('isi');
            $t->string('gambar')->nullable();
            $t->timestamp('dipublikasi_pada')->nullable();
            $t->timestamps();
        });

        Schema::create('galeri', function (Blueprint $t) {
            $t->id();
            $t->string('judul');
            $t->string('album');
            $t->unsignedSmallInteger('tahun');
            $t->string('gambar')->nullable();
            $t->string('video_url')->nullable();
            $t->unsignedInteger('urutan')->default(0);
            $t->timestamps();
        });

        Schema::create('agenda', function (Blueprint $t) {
            $t->id();
            $t->string('judul');
            $t->text('deskripsi')->nullable();
            $t->string('lokasi')->nullable();
            $t->dateTime('mulai');
            $t->dateTime('selesai')->nullable();
            $t->timestamps();
        });

        Schema::create('panduan', function (Blueprint $t) {
            $t->id();
            $t->string('kategori'); // Kos | Transportasi | Kuliner | Kampus | Tips
            $t->string('judul');
            $t->text('isi');
            $t->string('ikon')->default('lightbulb');
            $t->unsignedInteger('urutan')->default(0);
            $t->timestamps();
        });

        Schema::create('anggota', function (Blueprint $t) {
            $t->id();
            $t->string('nama');
            $t->string('kampus');
            $t->string('jurusan');
            $t->unsignedSmallInteger('angkatan');
            $t->string('status')->default('Anggota'); // Anggota | Alumni
            $t->boolean('tampil')->default(false);    // true = anggota setuju profilnya ditampilkan
            $t->timestamps();
        });

        Schema::create('peluang', function (Blueprint $t) {
            $t->id();
            $t->string('jenis'); // Beasiswa | Magang | Lomba | Lowongan
            $t->string('judul');
            $t->string('penyelenggara')->nullable();
            $t->text('deskripsi')->nullable();
            $t->string('tautan')->nullable();
            $t->date('batas_waktu')->nullable();
            $t->timestamps();
        });

        Schema::create('budaya', function (Blueprint $t) {
            $t->id();
            $t->string('kategori'); // Bahasa | Kuliner | Tari | Cerita
            $t->string('judul');
            $t->text('deskripsi');
            $t->string('gambar')->nullable();
            $t->unsignedInteger('urutan')->default(0);
            $t->timestamps();
        });

        Schema::create('kontak_bantuan', function (Blueprint $t) {
            $t->id();
            $t->string('label');
            $t->string('deskripsi');
            $t->string('whatsapp');
            $t->string('ikon')->default('heart');
            $t->unsignedInteger('urutan')->default(0);
            $t->timestamps();
        });
    }

    public function down(): void
    {
        foreach ([
            'kontak_bantuan', 'budaya', 'peluang', 'anggota', 'panduan',
            'agenda', 'galeri', 'berita', 'prestasi', 'program_kerja', 'pengurus',
        ] as $table) {
            Schema::dropIfExists($table);
        }
    }
};
