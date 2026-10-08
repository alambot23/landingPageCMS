<?php

namespace App\Models;

use App\Models\Concerns\PunyaGambar;
use Illuminate\Database\Eloquent\Model;

class Divisi extends Model
{
    use PunyaGambar;

    protected $table = 'divisi';
    protected $guarded = [];

    public function pengurus()
    {
        return $this->hasMany(Pengurus::class)->orderByDesc('is_kepala')->orderBy('urutan');
    }
}
