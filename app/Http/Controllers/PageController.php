<?php

namespace App\Http\Controllers;

use App\Models\{Agenda, Anggota, Budaya, Divisi, Galeri, Ketua, Panduan, Pengurus, Prestasi, ProgramKerja};
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function tentang()
    {
        return view('pages.tentang', ['ketua' => Ketua::orderByDesc('tahun_mulai')->get()]);
    }

    public function pengurus()
    {
        return view('pages.pengurus', [
            'inti'    => Pengurus::where('tingkat', 'inti')->orderBy('urutan')->get(),
            'divisi'  => Divisi::with('pengurus')->orderBy('urutan')->get(),
            'lainnya' => Pengurus::where('tingkat', '!=', 'inti')->whereNull('divisi_id')->orderBy('urutan')->get(),
        ]);
    }

    public function program()
    {
        return view('pages.program', ['program' => ProgramKerja::orderBy('urutan')->get()]);
    }

    public function prestasi()
    {
        return view('pages.prestasi', ['prestasi' => Prestasi::orderByDesc('tahun')->get()]);
    }

    public function galeri(Request $r)
    {
        $album = $r->query('album');

        return view('pages.galeri', [
            'albums' => Galeri::selectRaw('album, max(tahun) as tahun, count(*) as jumlah')->groupBy('album')->orderByDesc('tahun')->get(),
            'aktif'  => $album,
            'galeri' => Galeri::when($album, fn ($q) => $q->where('album', $album))
                ->orderByDesc('tahun')->orderBy('urutan')->orderByDesc('id')->paginate(24)->withQueryString(),
        ]);
    }

    public function panduan()
    {
        return view('pages.panduan', ['panduan' => Panduan::orderBy('urutan')->orderBy('id')->get()->groupBy('kategori')]);
    }

    public function agenda()
    {
        return view('pages.agenda', [
            'agenda' => Agenda::mendatang()->get(),
            'arsip'  => Agenda::where('mulai', '<', now()->startOfDay())
                ->where(fn ($q) => $q->whereNull('selesai')->orWhere('selesai', '<', now()))
                ->orderByDesc('mulai')->limit(10)->get(),
        ]);
    }

    public function direktori()
    {
        $anggota = Anggota::ditampilkan()->orderByDesc('angkatan')->orderBy('nama')->get();

        return view('pages.direktori', [
            'anggota'    => $anggota,
            'kampusList' => $anggota->pluck('kampus')->unique()->sort()->values(),
            'angkatan'   => $anggota->pluck('angkatan')->unique()->sortDesc()->values(),
        ]);
    }

    public function budaya()
    {
        return view('pages.budaya', ['budaya' => Budaya::orderBy('urutan')->get()]);
    }
}
