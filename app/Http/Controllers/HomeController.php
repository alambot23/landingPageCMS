<?php

namespace App\Http\Controllers;

use App\Models\{Agenda, Anggota, Berita, Galeri, KontakBantuan, Ketua, Panduan, Peluang, Pengurus, Prestasi, ProgramKerja, Slide};

class HomeController extends Controller
{
    public function index()
    {
        $ketua = Ketua::where('aktif', true)->orderByDesc('tahun_mulai')->first()
            ?? Ketua::orderByDesc('tahun_mulai')->first();

        return view('home', [
            'slides'     => Slide::where('aktif', true)->orderBy('urutan')->get(),
            'stat'       => [
                'Pengurus'      => Pengurus::count(),
                'Program Kerja' => ProgramKerja::count(),
                'Prestasi'      => Prestasi::count(),
                'Anggota'       => Anggota::count(),
            ],
            'ketua'      => $ketua,
            'ketuaLalu'  => Ketua::when($ketua, fn ($q) => $q->where('id', '!=', $ketua->id))->orderByDesc('tahun_mulai')->limit(4)->get(),
            'inti'       => Pengurus::where('tingkat', 'inti')->orderBy('urutan')->get(),
            'program'    => ProgramKerja::orderBy('urutan')->limit(6)->get(),
            'prestasi'   => Prestasi::orderByDesc('tahun')->limit(3)->get(),
            'berita'     => Berita::terbit()->limit(3)->get(),
            'galeri'     => Galeri::orderByDesc('tahun')->orderByDesc('id')->limit(8)->get(),
            'kategoriPanduan' => Panduan::orderBy('urutan')->pluck('kategori')->unique()->values(),
            'agenda'     => Agenda::mendatang()->limit(3)->get(),
            'peluang'    => Peluang::aktif()->limit(3)->get(),
            'bantuan'    => KontakBantuan::orderBy('urutan')->get(),
        ]);
    }
}
