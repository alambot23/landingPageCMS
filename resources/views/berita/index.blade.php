@extends('layouts.app')

@section('title', 'Berita & Pengumuman | ' . config('himdes.singkatan'))

@section('content')
    @include('partials.page-hero', ['eyebrow' => 'Berita & Pengumuman', 'title' => 'Kabar terbaru ' . config('himdes.singkatan')])

    <section class="section">
        <div class="container">
            @if ($daftar->isEmpty())
                <p class="empty">Belum ada berita yang terbit.</p>
            @else
                <div class="grid grid-3">
                    @foreach ($daftar as $b)
                        @include('berita._kartu', ['b' => $b])
                    @endforeach
                </div>

                {{ $daftar->links() }}
            @endif
        </div>
    </section>
@endsection
