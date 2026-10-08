@extends('layouts.app')

@section('title', 'Prestasi | ' . config('himdes.singkatan'))

@section('content')
    @include('partials.page-hero', ['eyebrow' => 'Prestasi', 'title' => 'Jejak pencapaian', 'text' => 'Bukti bahwa perantau bisa berprestasi di mana pun berada.'])
    <section class="section"><div class="container">@include('blocks.prestasi', ['prestasi' => $prestasi])</div></section>
@endsection
