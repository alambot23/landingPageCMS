<?php

namespace App\Models;

use App\Models\Concerns\PunyaGambar;
use Illuminate\Database\Eloquent\Model;

class ProgramKerja extends Model
{
    use PunyaGambar;

    protected $table = 'program_kerja';
    protected $guarded = [];
}
