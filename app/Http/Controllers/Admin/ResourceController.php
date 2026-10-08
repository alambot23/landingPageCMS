<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Support\Upload;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

/** CRUD generik: perilaku tiap resource dibaca dari config/admin.php. */
class ResourceController extends Controller
{
    private function cfg(string $key): array
    {
        $c = config("admin.resources.$key");
        abort_unless($c, 404);

        return $c + ['key' => $key];
    }

    private function back(array $cfg): string
    {
        return isset($cfg['back']) ? route($cfg['back']) . '#carousel' : route('admin.res.index', $cfg['key']);
    }

    /** Isi opsi untuk select relasi dan datalist. */
    private function fields(array $cfg): array
    {
        $fields = $cfg['fields'];
        foreach ($fields as $n => &$f) {
            if (isset($f['rel'])) {
                [$model, $kolom] = $f['rel'];
                $f['options'] = $model::orderBy($kolom)->pluck($kolom, 'id')->all();
            }
            if (isset($f['list'])) {
                $f['datalist'] = $cfg['model']::whereNotNull($n)->distinct()->orderBy($n)->pluck($n)->all();
            }
        }

        return $fields;
    }

    private function nilaiAwal(array $cfg, $row = null): array
    {
        $v = [];
        foreach ($cfg['fields'] as $n => $f) {
            $raw = $row ? ($row->getAttributes()[$n] ?? null) : ($f['default'] ?? null);
            if ($raw === 'now') {
                $raw = now();
            }
            if ($raw && $f['type'] === 'datetime') {
                $raw = Carbon::parse($raw)->format('Y-m-d\TH:i');
            } elseif ($raw && $f['type'] === 'date') {
                $raw = Carbon::parse($raw)->format('Y-m-d');
            }
            $v[$n] = $raw;
        }

        return $v;
    }

    private function rules(array $cfg, bool $baru): array
    {
        $rules = $names = [];
        foreach ($cfg['fields'] as $n => $f) {
            $names[$n] = strtolower($f['label']);
            if ($f['type'] === 'bool') {
                continue;
            }
            if ($f['type'] === 'image' && ($f['multi'] ?? false) && $baru) {
                $rules[$n] = 'required|array|max:30';
                $rules["$n.*"] = $f['rules'];
                $names["$n.*"] = 'foto';
                continue;
            }
            $rules[$n] = $f['rules'] ?? 'nullable';
        }

        return [$rules, $names];
    }

    private function kumpulkan(Request $r, array $cfg): array
    {
        $data = [];
        foreach ($cfg['fields'] as $n => $f) {
            if ($f['type'] === 'image') {
                continue;
            }
            if ($f['type'] === 'bool') {
                $data[$n] = $r->boolean($n);
                continue;
            }
            $v = $r->input($n);
            $v = is_string($v) ? trim($v) : $v;
            if ($v === '' || $v === null) {
                $v = (array_key_exists('default', $f) && $f['default'] !== 'now') ? $f['default'] : null;
            }
            $data[$n] = $v;
        }
        // Foto tanpa judul memakai nama album.
        if (isset($cfg['multi']) && empty($data['judul'])) {
            $data['judul'] = $data['album'] ?? 'Foto';
        }

        return $data;
    }

    private function slug(string $model, string $judul): string
    {
        $dasar = Str::slug($judul) ?: 'item';
        $slug = $dasar;
        for ($i = 2; $model::where('slug', $slug)->exists(); $i++) {
            $slug = "$dasar-$i";
        }

        return $slug;
    }

    private function gambar(array $cfg): array
    {
        return array_keys(array_filter($cfg['fields'], fn ($f) => $f['type'] === 'image'));
    }

    // ------------------------------------------------------------------

    public function index(Request $r, string $resource)
    {
        $cfg = $this->cfg($resource);
        $q = $cfg['model']::query()->with($cfg['with'] ?? []);

        if ($s = trim((string) $r->query('q'))) {
            $q->where(function ($w) use ($cfg, $s) {
                foreach ($cfg['search'] as $kolom) {
                    $w->orWhere($kolom, 'like', "%$s%");
                }
            });
        }
        [$kolom, $arah] = $cfg['order'];

        return view('admin.resource.index', [
            'cfg'  => $cfg,
            'rows' => $q->orderBy($kolom, $arah)->orderByDesc('id')->paginate(15)->withQueryString(),
        ]);
    }

    public function create(string $resource)
    {
        $cfg = $this->cfg($resource);

        return view('admin.resource.form', [
            'cfg' => $cfg, 'fields' => $this->fields($cfg), 'values' => $this->nilaiAwal($cfg), 'row' => null,
        ]);
    }

    public function store(Request $r, string $resource)
    {
        $cfg = $this->cfg($resource);
        [$rules, $names] = $this->rules($cfg, true);
        $r->validate($rules, [], $names);

        $data = $this->kumpulkan($r, $cfg);
        $model = $cfg['model'];
        if (isset($cfg['slug'])) {
            $data['slug'] = $this->slug($model, (string) $data[$cfg['slug']]);
        }

        $multi = $cfg['multi'] ?? null;
        $dibuat = [];
        if ($multi) {
            foreach ($r->file($multi) as $file) {
                $dibuat[] = $model::create($data + [$multi => Upload::simpan($file, $cfg['key'])]);
            }
        } else {
            foreach ($this->gambar($cfg) as $n) {
                if ($r->hasFile($n)) {
                    $data[$n] = Upload::simpan($r->file($n), $cfg['key']);
                }
            }
            $dibuat[] = $model::create($data);
        }

        $this->eksklusif($cfg, end($dibuat), $data);

        return redirect($this->back($cfg))->with('ok', 'Tersimpan.');
    }

    public function edit(string $resource, int $id)
    {
        $cfg = $this->cfg($resource);
        $row = $cfg['model']::findOrFail($id);

        return view('admin.resource.form', [
            'cfg' => $cfg, 'fields' => $this->fields($cfg), 'values' => $this->nilaiAwal($cfg, $row), 'row' => $row,
        ]);
    }

    public function update(Request $r, string $resource, int $id)
    {
        $cfg = $this->cfg($resource);
        $row = $cfg['model']::findOrFail($id);
        [$rules, $names] = $this->rules($cfg, false);
        $r->validate($rules, [], $names);

        $data = $this->kumpulkan($r, $cfg);
        foreach ($this->gambar($cfg) as $n) {
            if ($r->hasFile($n)) {
                Upload::hapus($row->getAttributes()[$n] ?? null);
                $data[$n] = Upload::simpan($r->file($n), $cfg['key']);
            } elseif ($r->boolean("hapus_$n")) {
                Upload::hapus($row->getAttributes()[$n] ?? null);
                $data[$n] = null;
            }
        }
        $row->update($data);
        $this->eksklusif($cfg, $row, $data);

        return redirect($this->back($cfg))->with('ok', 'Perubahan disimpan.');
    }

    public function destroy(string $resource, int $id)
    {
        $cfg = $this->cfg($resource);
        $row = $cfg['model']::findOrFail($id);
        foreach ($this->gambar($cfg) as $n) {
            Upload::hapus($row->getAttributes()[$n] ?? null);
        }
        $row->delete();

        return redirect($this->back($cfg))->with('ok', 'Dihapus.');
    }

    /** Hanya satu baris yang boleh aktif (mis. ketua yang sedang menjabat). */
    private function eksklusif(array $cfg, $row, array $data): void
    {
        $f = $cfg['exclusive'] ?? null;
        if ($f && $row && ! empty($data[$f])) {
            $cfg['model']::where('id', '!=', $row->id)->update([$f => false]);
        }
    }
}
