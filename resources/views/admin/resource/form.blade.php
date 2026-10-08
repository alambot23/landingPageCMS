@extends('admin.layout')

@php
    $kembali = isset($cfg['back']) ? route($cfg['back']) . '#carousel' : route('admin.res.index', $cfg['key']);
@endphp

@section('title', ($row ? 'Ubah ' : 'Tambah ') . $cfg['label'])
@section('heading', ($row ? 'Ubah ' : 'Tambah ') . strtolower($cfg['label']))

@section('content')
    <form method="post" enctype="multipart/form-data" class="card adm-form"
          action="{{ $row ? route('admin.res.update', [$cfg['key'], $row->id]) : route('admin.res.store', $cfg['key']) }}">
        @csrf
        @if ($row) @method('PUT') @endif

        @include('admin.fields', ['fields' => $fields, 'values' => $values, 'baru' => ! $row])

        <div class="adm-actions">
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a class="btn btn-outline" href="{{ $kembali }}">Batal</a>
        </div>
    </form>
@endsection
