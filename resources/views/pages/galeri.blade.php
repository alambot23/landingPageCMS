@extends('layouts.app')

@section('title', 'Dokumentasi Kegiatan | ' . config('himdes.singkatan'))

@section('content')
    @include('partials.page-hero', ['eyebrow' => 'Dokumentasi', 'title' => 'Potret kebersamaan', 'text' => 'Foto dan video kegiatan, dikelompokkan per album.'])

    <section class="section">
        <div class="container">
            @if ($albums->isNotEmpty())
                <nav class="chips" aria-label="Filter album">
                    <a class="chip {{ $aktif ? '' : 'is-active' }}" href="{{ route('galeri') }}">Semua</a>
                    @foreach ($albums as $a)
                        <a class="chip {{ $aktif === $a->album ? 'is-active' : '' }}" href="{{ route('galeri', ['album' => $a->album]) }}">{{ $a->album }} <small>({{ $a->jumlah }})</small></a>
                    @endforeach
                </nav>
            @endif

            @include('blocks.galeri', ['galeri' => $galeri])
            {{ $galeri->links() }}
        </div>
    </section>
@endsection
