@extends('layouts.auth')

@section('title', 'Masuk')
@section('menu', 'Masuk')

@section('content')
  <h2>Masuk ke akunmu</h2>
  <p class="sub">Isi nama pengguna dan kata sandimu untuk lanjut.</p>

  <form method="POST" action="{{ route('login') }}">
    @csrf
    <div class="field">
      <label for="username">Nama pengguna</label>
      <input id="username" name="username" type="text" value="{{ old('username') }}" autocomplete="username" autofocus
        required>
      @error('username')<span class="err">{{ $message }}</span>@enderror
    </div>

    <div class="field">
      <label for="password">Kata sandi</label>
      <div class="pass-wrap">
        <input id="password" name="password" type="password" autocomplete="current-password" required>
        @include('partials.toggle-eye', ['target' => 'password'])
      </div>
      @error('password')<span class="err">{{ $message }}</span>@enderror
    </div>

    <button type="submit" class="btn-primary">Masuk</button>
  </form>

  <p class="auth-alt">Belum punya akun? <a href="{{ route('register') }}">Daftar dulu, yuk</a></p>
@endsection
