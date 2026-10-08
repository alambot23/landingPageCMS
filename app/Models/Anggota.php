<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Anggota extends Model
{
    protected $table = 'anggota';
    protected $guarded = [];
    protected $casts = ['tampil' => 'boolean'];

    /** Hanya anggota yang menyetujui profilnya ditampilkan di direktori publik. */
    public function scopeDitampilkan($query)
    {
        return $query->where('tampil', true);
    }

    public function getInisialAttribute(): string
    {
        $kata = preg_split('/\s+/', trim($this->nama));
        $awal = mb_substr($kata[0] ?? '', 0, 1);
        $akhir = count($kata) > 1 ? mb_substr(end($kata), 0, 1) : '';

        return mb_strtoupper($awal . $akhir);
    }
}
