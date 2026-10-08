<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('slide', function (Blueprint $t) {
            $t->id();
            $t->string('judul');
            $t->text('subjudul')->nullable();
            $t->string('gambar')->nullable();
            $t->string('tombol_label')->nullable();
            $t->string('tombol_url')->nullable();
            $t->unsignedInteger('urutan')->default(0);
            $t->boolean('aktif')->default(true);
            $t->timestamps();
        });

        Schema::create('divisi', function (Blueprint $t) {
            $t->id();
            $t->string('nama');
            $t->text('deskripsi')->nullable();
            $t->string('ikon')->default('users');
            $t->unsignedInteger('urutan')->default(0);
            $t->timestamps();
        });

        Schema::create('ketua', function (Blueprint $t) {
            $t->id();
            $t->string('nama');
            $t->string('periode');
            $t->unsignedSmallInteger('tahun_mulai');
            $t->unsignedSmallInteger('tahun_selesai')->nullable();
            $t->string('kampus')->nullable();
            $t->string('foto')->nullable();
            $t->text('kata')->nullable();
            $t->text('capaian')->nullable();
            $t->boolean('aktif')->default(false);
            $t->timestamps();
        });

        Schema::create('pengaturan', function (Blueprint $t) {
            $t->id();
            $t->string('key')->unique();
            $t->text('value')->nullable();
            $t->timestamps();
        });

        Schema::table('pengurus', function (Blueprint $t) {
            $t->unsignedBigInteger('divisi_id')->nullable()->index();
            $t->boolean('is_kepala')->default(false);
        });
        DB::table('pengurus')->where('tingkat', 'bidang')->update(['tingkat' => 'divisi', 'is_kepala' => true]);

        Schema::table('program_kerja', fn (Blueprint $t) => $t->string('gambar')->nullable());
        Schema::table('prestasi', fn (Blueprint $t) => $t->string('gambar')->nullable());

        Schema::table('peluang', function (Blueprint $t) {
            $t->string('slug')->nullable()->unique();
            $t->longText('isi')->nullable();
            $t->string('gambar')->nullable();
        });
        foreach (DB::table('peluang')->get() as $row) {
            DB::table('peluang')->where('id', $row->id)->update(['slug' => Str::slug($row->judul) . '-' . $row->id]);
        }
    }

    public function down(): void
    {
        Schema::table('peluang', fn (Blueprint $t) => $t->dropColumn(['slug', 'isi', 'gambar']));
        Schema::table('prestasi', fn (Blueprint $t) => $t->dropColumn('gambar'));
        Schema::table('program_kerja', fn (Blueprint $t) => $t->dropColumn('gambar'));
        Schema::table('pengurus', fn (Blueprint $t) => $t->dropColumn(['divisi_id', 'is_kepala']));
        foreach (['pengaturan', 'ketua', 'divisi', 'slide'] as $table) {
            Schema::dropIfExists($table);
        }
    }
};
