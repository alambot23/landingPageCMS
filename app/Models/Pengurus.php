<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengurus extends Model
{
    protected $table = 'pengurus';
    protected $guarded = [];
    protected $casts = ['is_kepala' => 'boolean'];

    public function divisi()
    {
        return $this->belongsTo(Divisi::class);
    }

    /** Dua huruf inisial untuk avatar bila foto belum diunggah. */
    public function getInisialAttribute(): string
    {
        $kata = preg_split('/\s+/', trim($this->nama));
        $awal = mb_substr($kata[0] ?? '', 0, 1);
        $akhir = count($kata) > 1 ? mb_substr(end($kata), 0, 1) : '';

        return mb_strtoupper($awal . $akhir);
    }

    public function getFotoUrlAttribute(): ?string
    {
        return $this->foto ? asset('storage/' . $this->foto) : null;
    }
}
