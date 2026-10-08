<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    public function create(): View
    {
        return view('auth.login');
    }

    public function store(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ], [
            'username.required' => 'Nama pengguna wajib diisi.',
            'password.required' => 'Kata sandi wajib diisi.',
        ]);

        if (! Auth::attempt($credentials, true)) {
            throw ValidationException::withMessages([
                'username' => 'Nama pengguna atau kata sandi belum cocok.',
            ]);
        }

        $request->session()->regenerate();

        $user = $request->user();
        $user->update(['last_login_at' => now()]);
        $home = $user->role === 'admin' ? route('admin.dashboard') : route('informasi');

        // Hanya hormati URL "intended" bila sesuai area peran pengguna.
        $intended = $request->session()->pull('url.intended');
        $intendedPath = $intended ? parse_url($intended, PHP_URL_PATH) : null;
        $intendedIsAdmin = is_string($intendedPath) && str_starts_with($intendedPath, '/admin');

        $useIntended = $intended && ($user->role === 'admin' ? $intendedIsAdmin : ! $intendedIsAdmin);

        return redirect()->to($useIntended ? $intended : $home);
    }

    public function destroy(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
