<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    public function create(): View
    {
        return view('auth.register');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'username' => ['required', 'string', 'min:3', 'max:20', 'alpha_dash', Rule::unique('users', 'username')],
            'password' => ['required', 'string', 'min:6'],
        ], [
            'username.required' => 'Nama pengguna wajib diisi.',
            'username.min' => 'Nama pengguna minimal 3 huruf.',
            'username.max' => 'Nama pengguna maksimal 20 huruf.',
            'username.alpha_dash' => 'Nama pengguna hanya boleh huruf, angka, minus, dan garis bawah.',
            'username.unique' => 'Nama pengguna ini sudah dipakai. Coba yang lain ya.',
            'password.required' => 'Kata sandi wajib diisi.',
            'password.min' => 'Kata sandi minimal 6 karakter.',
        ]);

        $user = User::create([
            'username' => $data['username'],
            'password' => $data['password'],
            'role' => 'user',
            'last_login_at' => now(),
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('informasi')->with('sukses', 'Selamat datang, '.$user->username.'! Akunmu sudah siap.');
    }
}
