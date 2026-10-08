<?php

namespace App\Http\Controllers;

use App\Models\Berita;

class BeritaController extends Controller
{
    public function index()
    {
        return view('berita.index', [
            'daftar' => Berita::terbit()->paginate(9),
        ]);
    }

    public function show(Berita $berita)
    {
        abort_if(is_null($berita->dipublikasi_pada) || $berita->dipublikasi_pada->isFuture(), 404);

        return view('berita.show', [
            'berita'  => $berita,
            'lainnya' => Berita::terbit()->where('id', '!=', $berita->id)->limit(3)->get(),
        ]);
    }
}
