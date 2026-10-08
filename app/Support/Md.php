<?php

namespace App\Support;

use Illuminate\Support\Str;

class Md
{
    /** Markdown ringan -> HTML aman (tag HTML mentah dibuang). */
    public static function html(?string $teks): string
    {
        return Str::markdown((string) $teks, ['html_input' => 'strip', 'allow_unsafe_links' => false]);
    }
}
