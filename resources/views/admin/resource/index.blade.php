@extends('admin.layout')

@section('title', $cfg['plural'])
@section('heading', $cfg['plural'])

@section('content')
    <div class="adm-bar">
        <form method="get" class="adm-search" role="search">
            <svg class="ic"><use href="#i-search"/></svg>
            <input type="search" name="q" value="{{ request('q') }}" placeholder="Cari {{ strtolower($cfg['plural']) }}" aria-label="Cari">
        </form>
        <a class="btn btn-primary btn-sm" href="{{ route('admin.res.create', $cfg['key']) }}"><svg class="ic"><use href="#i-plus"/></svg> Tambah {{ strtolower($cfg['label']) }}</a>
    </div>
    @isset($cfg['intro'])<p class="adm-intro">{{ $cfg['intro'] }}</p>@endisset

    <div class="card tbl-wrap">
        <table class="tbl">
            <thead>
                <tr>
                    @foreach ($cfg['columns'] as $c)<th scope="col">{{ $c[1] }}</th>@endforeach
                    <th scope="col"><span class="sr-only">Aksi</span></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($rows as $row)
                    <tr>
                        @foreach ($cfg['columns'] as $c)
                            @php $tipe = $c[2] ?? 'text'; $v = data_get($row, $c[0]); @endphp
                            <td data-label="{{ $c[1] }}">
                                @switch($tipe)
                                    @case('image')
                                    @case('avatar')
                                        @if ($v)<img class="thumb {{ $tipe === 'avatar' ? 'thumb-round' : '' }}" src="{{ asset('storage/' . $v) }}" alt="" loading="lazy">
                                        @else<span class="thumb thumb-ph {{ $tipe === 'avatar' ? 'thumb-round' : '' }}"><svg class="ic"><use href="#i-image"/></svg></span>@endif
                                        @break
                                    @case('bool')
                                        <span class="tag {{ $v ? '' : 'tag-off' }}">{{ $v ? 'Ya' : 'Tidak' }}</span>
                                        @break
                                    @case('date')
                                        {{ $v ? \Illuminate\Support\Carbon::parse($v)->translatedFormat('d M Y') : '-' }}
                                        @break
                                    @case('datetime')
                                        @if ($v){{ \Illuminate\Support\Carbon::parse($v)->translatedFormat('d M Y, H:i') }}@else<span class="tag tag-off">Draf</span>@endif
                                        @break
                                    @default
                                        {{ \Illuminate\Support\Str::limit((string) $v, 70) ?: '-' }}
                                @endswitch
                            </td>
                        @endforeach
                        <td class="row-actions" data-label="">
                            <a class="btn btn-outline btn-sm" href="{{ route('admin.res.edit', [$cfg['key'], $row->id]) }}"><svg class="ic"><use href="#i-edit"/></svg> Ubah</a>
                            <form method="post" action="{{ route('admin.res.destroy', [$cfg['key'], $row->id]) }}" data-confirm="Hapus data ini? Tindakan ini tidak bisa dibatalkan.">@csrf @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" aria-label="Hapus"><svg class="ic"><use href="#i-trash"/></svg></button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr class="tbl-empty"><td colspan="{{ count($cfg['columns']) + 1 }}">Belum ada data{{ request('q') ? ' yang cocok dengan pencarianmu' : '' }}.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{ $rows->links() }}
@endsection
