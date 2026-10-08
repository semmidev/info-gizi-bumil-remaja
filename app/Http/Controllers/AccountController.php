<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AccountController extends Controller
{
    public function edit(Request $request): View
    {
        return view('account.edit', ['user' => $request->user()]);
    }

    public function updateProfile(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'full_name' => ['nullable', 'string', 'max:100'],
            'age' => ['nullable', 'integer', 'between:10,60'],
            'address' => ['nullable', 'string', 'max:255'],
            'pregnancy_month' => ['nullable', 'integer', 'between:1,9'],
        ], [
            'age.between' => 'Umur harus antara 10 dan 60 tahun.',
            'pregnancy_month.between' => 'Usia kehamilan harus antara 1 dan 9 bulan.',
        ]);

        $request->user()->update($data);

        return redirect()->route('akun')->with('sukses', 'Data diri berhasil disimpan.');
    }

    public function updatePassword(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'password' => ['required', 'string', 'min:6'],
        ], [
            'password.required' => 'Kata sandi baru wajib diisi.',
            'password.min' => 'Kata sandi minimal 6 karakter.',
        ]);

        $request->user()->update(['password' => $data['password']]);

        return redirect()->route('akun')->with('sukses', 'Kata sandimu berhasil diubah.');
    }
}
