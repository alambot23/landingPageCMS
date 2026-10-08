<?php

namespace App\Models;

use App\Models\Concerns\PunyaGambar;
use Illuminate\Database\Eloquent\Model;

class Ketua extends Model
{
    use PunyaGambar;

    protected $table = 'ketua';
    protected $guarded = [];
    protected $casts = ['aktif' => 'boolean'];
}
