<?php

namespace App\Models;

use App\Models\Concerns\PunyaGambar;
use Illuminate\Database\Eloquent\Model;

class Peluang extends Model
{
    use PunyaGambar;

    protected $table = 'peluang';
    protected $guarded = [];
    protected $casts = ['batas_waktu' => 'date'];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function scopeBerakhir($query)
    {
        return $query->whereNotNull('batas_waktu')->where('batas_waktu', '<', now()->startOfDay())->orderByDesc('batas_waktu');
    }

    /** Yang tenggat waktunya belum lewat (atau tanpa tenggat). */
    public function scopeAktif($query)
    {
        return $query->where(function ($q) {
            $q->whereNull('batas_waktu')->orWhere('batas_waktu', '>=', now()->startOfDay());
        })->orderByRaw('batas_waktu IS NULL')->orderBy('batas_waktu');
    }
}
