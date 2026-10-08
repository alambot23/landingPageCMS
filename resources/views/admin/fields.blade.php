{{-- Dipakai bersama oleh formulir resource dan halaman Beranda & Profil. --}}
<div class="adm-grid">
    @foreach ($fields as $name => $f)
        @php
            $type = $f['type'];
            $val = old($name, $values[$name] ?? null);
            $multi = ($f['multi'] ?? false) && ($baru ?? false);
            $err = $errors->first($name) ?: $errors->first($name . '.*');
            $lebar = (bool) ($f['wide'] ?? false);
        @endphp
        <div class="field-block {{ $lebar ? 'span-2' : '' }}">
            @if ($type === 'bool')
                <label class="switch">
                    <input type="hidden" name="{{ $name }}" value="0">
                    <input type="checkbox" name="{{ $name }}" value="1" @checked((bool) $val)>
                    <span>{{ $f['label'] }}</span>
                </label>
            @else
                <label for="f-{{ $name }}">{{ $f['label'] }}@if (str_contains($f['rules'] ?? '', 'required'))<em aria-label="wajib"> *</em>@endif</label>

                @if (in_array($type, ['text', 'url', 'number', 'date']))
                    <input id="f-{{ $name }}" type="{{ $type }}" name="{{ $name }}" value="{{ $val }}" class="{{ $err ? 'is-invalid' : '' }}"
                           @if (isset($f['datalist'])) list="dl-{{ $name }}" autocomplete="off" @endif>
                    @if (isset($f['datalist']))
                        <datalist id="dl-{{ $name }}">@foreach ($f['datalist'] as $o)<option value="{{ $o }}">@endforeach</datalist>
                    @endif
                @elseif ($type === 'datetime')
                    <input id="f-{{ $name }}" type="datetime-local" name="{{ $name }}" value="{{ $val }}" class="{{ $err ? 'is-invalid' : '' }}">
                @elseif ($type === 'textarea' || $type === 'markdown')
                    <textarea id="f-{{ $name }}" name="{{ $name }}" rows="{{ $f['rows'] ?? ($type === 'markdown' ? 14 : 4) }}" class="{{ $err ? 'is-invalid' : '' }}">{{ $val }}</textarea>
                @elseif ($type === 'select')
                    <select id="f-{{ $name }}" name="{{ $name }}" class="{{ $err ? 'is-invalid' : '' }}">
                        @if (isset($f['empty']))<option value="">{{ $f['empty'] }}</option>@endif
                        @foreach ($f['options'] as $k => $label)
                            <option value="{{ $k }}" @selected((string) $val === (string) $k)>{{ $label }}</option>
                        @endforeach
                    </select>
                @elseif ($type === 'image')
                    @php $lama = $values[$name] ?? null; @endphp
                    @if ($lama)
                        <img class="img-prev" src="{{ asset('storage/' . $lama) }}" alt="Gambar saat ini">
                    @endif
                    <input id="f-{{ $name }}" type="file" name="{{ $multi ? $name . '[]' : $name }}" accept="image/jpeg,image/png,image/webp" data-preview @if ($multi) multiple @endif>
                    <div class="prev-grid" hidden></div>
                    @if ($lama)
                        <label class="switch switch-sm"><input type="checkbox" name="hapus_{{ $name }}" value="1"><span>Hapus gambar ini</span></label>
                    @endif
                @endif

                @if ($type === 'markdown')
                    <small class="hint">Mendukung Markdown: <code>## Judul</code>, <code>**tebal**</code>, <code>*miring*</code>, <code>- daftar</code>, <code>[teks](https://tautan)</code>. Pisahkan paragraf dengan baris kosong.</small>
                @endif
                @if (! empty($f['hint']))<small class="hint">{{ $f['hint'] }}</small>@endif
            @endif
            @if ($err)<small class="err">{{ $err }}</small>@endif
        </div>
    @endforeach
</div>
