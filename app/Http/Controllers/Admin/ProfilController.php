<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengaturan;
use App\Models\Slide;
use App\Support\Upload;
use Illuminate\Http\Request;

class ProfilController extends Controller
{
    public function edit()
    {
        $set = Pengaturan::semua();
        $v = [];
        foreach (config('admin.profil') as $tab) {
            foreach ($tab['fields'] as $key => $f) {
                $v[$key] = $set[$key] ?? null;
            }
        }
        // Nilai bawaan (sudah digabung dengan CMS oleh AppServiceProvider)
        foreach (['nama', 'singkatan', 'kota', 'tagline', 'deskripsi', 'periode', 'whatsapp', 'instagram', 'email', 'alamat', 'peta_query', 'visi'] as $k) {
            $v[$k] = config("himdes.$k");
        }
        $v['misi'] = implode("\n", config('himdes.misi', []));
        $v['sejarah'] = implode("\n\n", config('himdes.sejarah', []));

        return view('admin.profil', [
            'tabs'   => config('admin.profil'),
            'values' => $v,
            'slides' => Slide::orderBy('urutan')->get(),
        ]);
    }

    public function update(Request $r)
    {
        $rules = $names = [];
        $fields = [];
        foreach (config('admin.profil') as $tab) {
            foreach ($tab['fields'] as $key => $f) {
                $fields[$key] = $f;
                $rules[$key] = $f['rules'] ?? 'nullable';
                $names[$key] = strtolower($f['label']);
            }
        }
        $r->validate($rules, [], $names);

        $set = Pengaturan::semua();
        foreach ($fields as $key => $f) {
            if ($f['type'] === 'image') {
                $lama = $set[$key] ?? null;
                if ($r->hasFile($key)) {
                    Upload::hapus($lama);
                    Pengaturan::simpan($key, Upload::simpan($r->file($key), 'profil'));
                } elseif ($r->boolean("hapus_$key")) {
                    Upload::hapus($lama);
                    Pengaturan::simpan($key, null);
                }
                continue;
            }
            $val = trim((string) $r->input($key));
            Pengaturan::simpan($key, $val === '' ? null : $val);
        }

        return redirect(route('admin.profil') . '#' . preg_replace('/\W/', '', (string) $r->input('_tab', 'carousel')))
            ->with('ok', 'Perubahan disimpan.');
    }
}
