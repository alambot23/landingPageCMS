<?php

namespace App\Models;

use App\Models\Concerns\PunyaGambar;
use Illuminate\Database\Eloquent\Model;

class Slide extends Model
{
    use PunyaGambar;

    protected $table = 'slide';
    protected $guarded = [];
    protected $casts = ['aktif' => 'boolean'];
}
