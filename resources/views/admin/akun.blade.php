@extends('admin.layout')

@section('title', 'Ganti kata sandi')
@section('heading', 'Ganti kata sandi')

@section('content')
    <form method="post" action="{{ route('admin.akun.update') }}" class="card adm-form narrow-form">
        @csrf @method('PUT')
        <div class="adm-grid one">
            <div class="field-block"><label for="pl">Kata sandi lama</label><input id="pl" type="password" name="password_lama" required autocomplete="current-password">@error('password_lama')<small class="err">{{ $message }}</small>@enderror</div>
            <div class="field-block"><label for="pb">Kata sandi baru</label><input id="pb" type="password" name="password" required autocomplete="new-password"><small class="hint">Minimal 8 karakter.</small>@error('password')<small class="err">{{ $message }}</small>@enderror</div>
            <div class="field-block"><label for="pc">Ulangi kata sandi baru</label><input id="pc" type="password" name="password_confirmation" required autocomplete="new-password"></div>
        </div>
        <div class="adm-actions"><button class="btn btn-primary" type="submit">Simpan</button></div>
    </form>
@endsection
