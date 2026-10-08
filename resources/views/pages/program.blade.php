@extends('layouts.app')

@section('title', 'Program Kerja | ' . config('himdes.singkatan'))

@section('content')
    @include('partials.page-hero', ['eyebrow' => 'Program Kerja', 'title' => 'Kegiatan yang kami jalankan', 'text' => 'Dari ruang kelas hingga lapangan, dari kampus sampai kampung halaman.'])
    <section class="section"><div class="container">@include('blocks.program', ['program' => $program])</div></section>
@endsection
