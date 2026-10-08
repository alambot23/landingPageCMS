<?php

namespace App\Providers;

use App\Models\Pengaturan;
use Carbon\Carbon;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Nama hari dan bulan dalam bahasa Indonesia (translatedFormat).
        Carbon::setLocale(config('app.locale', 'id'));
        Paginator::defaultView('vendor.pagination.himdes');

        $this->muatPengaturan();
    }

    /** Nilai dari CMS (tabel pengaturan) menimpa bawaan di config/himdes.php. */
    private function muatPengaturan(): void
    {
        config(['himdes.pembimbing' => ['nama' => null, 'jabatan' => null, 'kata' => null, 'foto' => null]]);

        try {
            $s = array_filter(Pengaturan::semua(), fn ($v) => $v !== null && trim($v) !== '');
        } catch (\Throwable $e) {
            return; // tabel belum ada (sebelum migrasi)
        }

        foreach (['nama', 'singkatan', 'kota', 'tagline', 'deskripsi', 'periode', 'whatsapp', 'instagram', 'email', 'alamat', 'peta_query', 'visi'] as $k) {
            if (isset($s[$k])) {
                config(["himdes.$k" => trim($s[$k])]);
            }
        }
        if (isset($s['misi'])) {
            config(['himdes.misi' => array_values(array_filter(array_map('trim', preg_split('/\R/', $s['misi']))))]);
        }
        if (isset($s['sejarah'])) {
            config(['himdes.sejarah' => array_values(array_filter(array_map('trim', preg_split('/\R{2,}/', trim($s['sejarah'])))))]);
        }

        config(['himdes.pembimbing' => [
            'nama'    => $s['pembimbing_nama'] ?? null,
            'jabatan' => $s['pembimbing_jabatan'] ?? null,
            'kata'    => $s['pembimbing_kata'] ?? null,
            'foto'    => isset($s['pembimbing_foto']) ? asset('storage/' . $s['pembimbing_foto']) : null,
        ]]);
    }
}
