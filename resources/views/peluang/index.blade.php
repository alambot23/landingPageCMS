@extends('layouts.app')

@section('title', 'Beasiswa & Magang | ' . config('himdes.singkatan'))

@section('content')
    @include('partials.page-hero', ['eyebrow' => 'Beasiswa & Magang', 'title' => 'Peluang untuk berkembang', 'text' => 'Beasiswa, magang, lomba, dan lowongan yang dibagikan antaranggota. Perhatikan tenggat waktunya.'])

    <section class="section">
        <div class="container">
            @if ($peluang->isEmpty())
                <p class="empty">Belum ada info yang sedang dibuka.</p>
            @else
                @php $jenis = $peluang->pluck('jenis')->unique()->values(); @endphp
                <div class="chips js-only" role="group" aria-label="Filter jenis" data-filter-group="peluang">
                    <button type="button" class="chip is-active" data-filter="*">Semua</button>
                    @foreach ($jenis as $j)<button type="button" class="chip" data-filter="{{ $j }}">{{ $j }}</button>@endforeach
                </div>
                <div class="grid grid-3" data-filter-target="peluang">
                    @foreach ($peluang as $p)
                        @include('blocks.peluang-kartu', ['p' => $p])
                    @endforeach
                </div>
            @endif

            @if ($berakhir->isNotEmpty())
                <h2 class="subhead-lg arsip-title">Sudah berakhir</h2>
                <div class="grid grid-3">
                    @foreach ($berakhir as $p)
                        @include('blocks.peluang-kartu', ['p' => $p, 'lewat' => true])
                    @endforeach
                </div>
            @endif
        </div>
    </section>
@endsection
