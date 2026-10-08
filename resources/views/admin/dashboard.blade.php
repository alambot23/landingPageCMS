@extends('admin.layout')

@section('title', 'Dashboard')
@section('heading', 'Dashboard')

@section('content')
    <section class="card adm-hello">
        <div>
            <h2>Halo, {{ auth()->user()->name }}</h2>
            <p class="muted">Kelola seluruh isi situs dari sini. Perubahan langsung tampil di situs publik.</p>
        </div>
        <div class="adm-quick">
            <a class="btn btn-primary btn-sm" href="{{ route('admin.res.create', 'berita') }}"><svg class="ic"><use href="#i-plus"/></svg> Tulis berita</a>
            <a class="btn btn-outline btn-sm" href="{{ route('admin.res.create', 'galeri') }}"><svg class="ic"><use href="#i-image"/></svg> Unggah foto</a>
            <a class="btn btn-outline btn-sm" href="{{ route('admin.res.create', 'agenda') }}"><svg class="ic"><use href="#i-calendar"/></svg> Tambah agenda</a>
            <a class="btn btn-outline btn-sm" href="{{ route('admin.profil') }}"><svg class="ic"><use href="#i-home"/></svg> Carousel & profil</a>
        </div>
    </section>

    <h2 class="adm-h2">Isi situs</h2>
    <div class="stat-grid">
        @foreach ($kartu as $k)
            <a class="card stat" href="{{ route('admin.res.index', $k['key']) }}">
                <strong>{{ $k['total'] }}</strong>
                <span>{{ $k['label'] }}</span>
            </a>
        @endforeach
    </div>

    @if (\Illuminate\Support\Facades\Hash::check(config('himdes.admin_password'), auth()->user()->password))
        <div class="alert alert-warn">Kata sandi akun masih sama dengan bawaan instalasi. <a href="{{ route('admin.akun') }}">Ganti kata sandi sekarang</a>.</div>
    @endif
@endsection
