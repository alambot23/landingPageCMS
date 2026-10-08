<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Berita extends Model
{
    protected $table = 'berita';
    protected $guarded = [];
    protected $casts = ['dipublikasi_pada' => 'datetime'];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /** Hanya berita yang sudah terbit (tanggal publikasi sudah lewat). */
    public function scopeTerbit($query)
    {
        return $query->whereNotNull('dipublikasi_pada')
            ->where('dipublikasi_pada', '<=', now())
            ->orderByDesc('dipublikasi_pada');
    }

    public function getGambarUrlAttribute(): ?string
    {
        return $this->gambar ? asset('storage/' . $this->gambar) : null;
    }
}
