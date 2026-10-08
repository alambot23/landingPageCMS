<?php

namespace App\Models;

use App\Models\Concerns\PunyaGambar;
use Illuminate\Database\Eloquent\Model;

class Budaya extends Model
{
    use PunyaGambar;

    protected $table = 'budaya';
    protected $guarded = [];
}
