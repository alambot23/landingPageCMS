<?php

namespace App\Http\Controllers;

use App\Models\Peluang;

class PeluangController extends Controller
{
    public function index()
    {
        return view('peluang.index', [
            'peluang'  => Peluang::aktif()->get(),
            'berakhir' => Peluang::berakhir()->limit(6)->get(),
        ]);
    }

    public function show(Peluang $peluang)
    {
        return view('peluang.show', [
            'p'      => $peluang,
            'lainnya' => Peluang::aktif()->where('id', '!=', $peluang->id)->limit(3)->get(),
        ]);
    }
}
