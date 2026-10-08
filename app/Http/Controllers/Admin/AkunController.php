<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AkunController extends Controller
{
    public function edit()
    {
        return view('admin.akun');
    }

    public function update(Request $r)
    {
        $r->validate([
            'password_lama' => 'required|current_password',
            'password'      => ['required', 'confirmed', Password::min(8)],
        ], [], ['password_lama' => 'kata sandi lama', 'password' => 'kata sandi baru']);

        $r->user()->update(['password' => Hash::make($r->password)]);

        return back()->with('ok', 'Kata sandi diperbarui.');
    }
}
