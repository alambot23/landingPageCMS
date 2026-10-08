<?php

namespace App\Models;

use App\Models\Concerns\PunyaGambar;
use Illuminate\Database\Eloquent\Model;

class Prestasi extends Model
{
    use PunyaGambar;

    protected $table = 'prestasi';
    protected $guarded = [];
}
