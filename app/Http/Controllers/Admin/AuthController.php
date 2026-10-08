<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function form()
    {
        return Auth::check() ? redirect()->route('admin.dashboard') : view('admin.login');
    }

    public function masuk(Request $r)
    {
        $data = $r->validate(['email' => 'required|email', 'password' => 'required']);

        if (! Auth::attempt($data, $r->boolean('ingat'))) {
            return back()->withInput($r->only('email'))->withErrors(['email' => 'Email atau kata sandi salah.']);
        }

        $r->session()->regenerate();

        return redirect()->intended(route('admin.dashboard'));
    }

    public function keluar(Request $r)
    {
        Auth::logout();
        $r->session()->invalidate();
        $r->session()->regenerateToken();

        return redirect()->route('home');
    }
}
