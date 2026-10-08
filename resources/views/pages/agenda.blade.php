@extends('layouts.app')

@section('title', 'Agenda Kegiatan | ' . config('himdes.singkatan'))

@section('content')
    @include('partials.page-hero', ['eyebrow' => 'Kalender Kegiatan', 'title' => 'Agenda kegiatan', 'text' => 'Simpan jadwal langsung ke Google Calendar agar tidak ketinggalan.'])

    <section class="section">
        <div class="container">
            <h2 class="subhead-lg">Akan datang</h2>
            @if ($agenda->isEmpty())
                <p class="empty">Belum ada agenda mendatang.</p>
            @else
                @include('blocks.agenda', ['agenda' => $agenda])
            @endif

            @if ($arsip->isNotEmpty())
                <h2 class="subhead-lg arsip-title">Sudah berlalu</h2>
                @include('blocks.agenda', ['agenda' => $arsip, 'lewat' => true])
            @endif
        </div>
    </section>
@endsection
