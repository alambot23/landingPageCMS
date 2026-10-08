<?php

namespace App\Models\Concerns;

/** Menyediakan gambar_url dan foto_url dari kolom gambar / foto. */
trait PunyaGambar
{
    public function getGambarUrlAttribute(): ?string
    {
        return ($this->attributes['gambar'] ?? null) ? asset('storage/' . $this->attributes['gambar']) : null;
    }

    public function getFotoUrlAttribute(): ?string
    {
        return ($this->attributes['foto'] ?? null) ? asset('storage/' . $this->attributes['foto']) : null;
    }

    public function getInisialAttribute(): string
    {
        $kata = preg_split('/\s+/', trim($this->nama ?? $this->judul ?? ''));
        $awal = mb_substr($kata[0] ?? '', 0, 1);
        $akhir = count($kata) > 1 ? mb_substr(end($kata), 0, 1) : '';

        return mb_strtoupper($awal . $akhir);
    }
}
