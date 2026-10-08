<!DOCTYPE html>
<html lang="id" class="no-js">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <title>Masuk Pengurus | {{ config('himdes.singkatan') }}</title>
    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}?v={{ @filemtime(public_path('css/app.css')) }}">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}?v={{ @filemtime(public_path('css/admin.css')) }}">
</head>
<body class="login-body">
    @include('partials.icons')
    <div class="login">
        <section class="login-art" aria-hidden="true">
            <img src="{{ asset('images/logo.png') }}" alt="" width="150" height="161">
            <h2>{{ config('himdes.nama') }}</h2>
            <p>Panel pengelola situs {{ config('himdes.singkatan') }} {{ config('himdes.kota') }}.</p>
        </section>

        <section class="login-panel">
            <form method="post" action="{{ route('login.post') }}" class="login-form">
                @csrf
                <a class="login-back" href="{{ route('home') }}">&larr; Kembali ke situs</a>
                <h1>Masuk pengurus</h1>
                <p class="muted">Khusus pengurus yang mengelola konten situs.</p>

                <label class="field-block">
                    <span>Email</span>
                    <input type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" class="{{ $errors->has('email') ? 'is-invalid' : '' }}">
                </label>
                <label class="field-block">
                    <span>Kata sandi</span>
                    <input type="password" name="password" required autocomplete="current-password">
                </label>
                @error('email')<p class="form-error" role="alert">{{ $message }}</p>@enderror

                <label class="switch"><input type="checkbox" name="ingat" value="1"><span>Ingat saya di perangkat ini</span></label>
                <button type="submit" class="btn btn-primary btn-block"><svg class="ic"><use href="#i-lock"/></svg> Masuk</button>
            </form>
        </section>
    </div>
</body>
</html>
