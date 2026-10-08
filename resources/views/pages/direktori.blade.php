@extends('layouts.app')

@section('title', 'Direktori Anggota & Alumni | ' . config('himdes.singkatan'))

@section('content')
    @include('partials.page-hero', ['eyebrow' => 'Direktori Anggota & Alumni', 'title' => 'Temukan sesama perantau', 'text' => 'Cari kakak tingkat atau teman satu kampus. Hanya anggota yang sudah memberi persetujuan yang ditampilkan.'])

    <section class="section">
        <div class="container">
            @if ($anggota->isEmpty())
                <p class="empty">Direktori belum tersedia.</p>
            @else
                <form class="filters js-only" onsubmit="return false" role="search">
                    <label class="field field-search">
                        <span class="sr-only">Cari nama atau jurusan</span>
                        <svg class="ic"><use href="#i-search"/></svg>
                        <input type="search" id="dirSearch" placeholder="Cari nama atau jurusan" autocomplete="off">
                    </label>
                    <label class="field">
                        <span class="sr-only">Kampus</span>
                        <select id="dirKampus">
                            <option value="">Semua kampus</option>
                            @foreach ($kampusList as $k)<option value="{{ $k }}">{{ $k }}</option>@endforeach
                        </select>
                    </label>
                    <label class="field">
                        <span class="sr-only">Angkatan</span>
                        <select id="dirAngkatan">
                            <option value="">Semua angkatan</option>
                            @foreach ($angkatan as $th)<option value="{{ $th }}">{{ $th }}</option>@endforeach
                        </select>
                    </label>
                </form>

                <div class="grid grid-4" id="directoryGrid">
                    @foreach ($anggota as $m)
                        <article class="card member reveal" data-kampus="{{ $m->kampus }}" data-angkatan="{{ $m->angkatan }}" data-search="{{ mb_strtolower($m->nama . ' ' . $m->jurusan) }}">
                            <div class="avatar avatar-initial avatar-sm" aria-hidden="true">{{ $m->inisial }}</div>
                            <h3>{{ $m->nama }}</h3>
                            <p class="muted small">{{ $m->jurusan }}</p>
                            <p class="muted small">{{ $m->kampus }}</p>
                            <div class="member-tags">
                                <span class="tag">Angkatan {{ $m->angkatan }}</span>
                                <span class="tag {{ $m->status === 'Alumni' ? 'tag-gold' : '' }}">{{ $m->status }}</span>
                            </div>
                        </article>
                    @endforeach
                </div>
                <p class="empty" id="directoryEmpty" hidden>Tidak ada yang cocok dengan pencarianmu.</p>
            @endif
        </div>
    </section>
@endsection
