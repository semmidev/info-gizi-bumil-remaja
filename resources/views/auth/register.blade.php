@extends('layouts.auth')

@section('title', 'Daftar')
@section('menu', 'Daftar')

@section('content')
  <h2>Buat akun baru</h2>
  <p class="sub">
    Yuk, mulai perjalanan sehatmu sekarang!
  </p>

  <form method="POST" action="{{ route('register') }}">
    @csrf
    <div class="field">
      <label for="username">Nama pengguna</label>
      <span class="hint">Boleh huruf, angka, atau garis bawah. Contoh: rina_17</span>
      <input id="username" name="username" type="text" value="{{ old('username') }}" autocomplete="username" autofocus
        required>
      @error('username')<span class="err">{{ $message }}</span>@enderror
    </div>

    <div class="field">
      <label for="password">Kata sandi</label>
      <span class="hint">Minimal 6 karakter, pilih yang mudah kamu ingat.</span>
      <div class="pass-wrap">
        <input id="password" name="password" type="password" autocomplete="new-password" required>
        @include('partials.toggle-eye', ['target' => 'password'])
      </div>
      @error('password')<span class="err">{{ $message }}</span>@enderror
    </div>

    <button type="submit" class="btn-primary">Daftar dan mulai</button>
  </form>

  <p class="auth-alt">Sudah punya akun? <a href="{{ route('login') }}">Masuk di sini</a></p>
@endsection
