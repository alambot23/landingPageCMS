@extends('admin.layout')

@section('title', 'Beranda & Profil')
@section('heading', 'Beranda & Profil')

@section('content')
    <div class="tabs adm-tabs" role="tablist" aria-label="Bagian">
        <button type="button" class="tab is-active" role="tab" data-tab="carousel">Carousel</button>
        @foreach ($tabs as $key => $t)
            <button type="button" class="tab" role="tab" data-tab="{{ $key }}">{{ $t['label'] }}</button>
        @endforeach
    </div>

    <div data-panel="carousel">
        <div class="adm-bar">
            <p class="adm-intro">Slide yang tampil paling atas di beranda. Urutan kecil tampil lebih dulu.</p>
            <a class="btn btn-primary btn-sm" href="{{ route('admin.res.create', 'slide') }}"><svg class="ic"><use href="#i-plus"/></svg> Tambah slide</a>
        </div>
        <div class="slide-list">
            @forelse ($slides as $s)
                <article class="card slide-card {{ $s->aktif ? '' : 'is-off' }}">
                    <div class="slide-thumb">
                        @if ($s->gambar_url)<img src="{{ $s->gambar_url }}" alt="">@else<span class="thumb-ph"><svg class="ic"><use href="#i-image"/></svg></span>@endif
                    </div>
                    <div class="slide-info">
                        <strong>{{ $s->judul }}</strong>
                        <small>Urutan {{ $s->urutan }}{{ $s->aktif ? '' : ', disembunyikan' }}{{ $s->gambar_url ? '' : ', tanpa gambar' }}</small>
                    </div>
                    <div class="row-actions">
                        <a class="btn btn-outline btn-sm" href="{{ route('admin.res.edit', ['slide', $s->id]) }}"><svg class="ic"><use href="#i-edit"/></svg> Ubah</a>
                        <form method="post" action="{{ route('admin.res.destroy', ['slide', $s->id]) }}" data-confirm="Hapus slide ini?">@csrf @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" aria-label="Hapus {{ $s->judul }}"><svg class="ic"><use href="#i-trash"/></svg></button>
                        </form>
                    </div>
                </article>
            @empty
                <p class="empty">Belum ada slide. Beranda memakai tampilan bawaan sampai kamu menambahkan slide.</p>
            @endforelse
        </div>
    </div>

    <form method="post" action="{{ route('admin.profil.update') }}" enctype="multipart/form-data" id="profilForm">
        @csrf
        <input type="hidden" name="_tab" id="tabField" value="carousel">
        @foreach ($tabs as $key => $t)
            <div data-panel="{{ $key }}" class="card adm-form">
                <h2 class="adm-h2">{{ $t['label'] }}</h2>
                @include('admin.fields', ['fields' => $t['fields'], 'values' => $values, 'baru' => false])
            </div>
        @endforeach
        <div class="adm-actions" data-panel="{{ implode(' ', array_keys($tabs)) }}">
            <button type="submit" class="btn btn-primary">Simpan perubahan</button>
        </div>
    </form>
@endsection
