@extends('layouts.app')

@section('title', 'Akun Saya')
@section('menu', 'Akun')

@section('content')
<section class="screen on" id="s-akun">
  <h2>Akun Saya</h2>
  <p class="lead">Lihat info akunmu dan ganti kata sandi bila perlu.</p>

  <div class="panel">
    <h3>Informasi pengguna</h3>
    <div class="akun-row"><span>Nama pengguna</span><b>{{ $user->username }}</b></div>
    <div class="akun-row"><span>Bergabung</span><b>{{ $user->created_at->translatedFormat('j F Y') }}</b></div>
  </div>

  <div class="panel">
    <h3>Ubah kata sandi</h3>
    <p class="tip" style="margin-top:0">Masukkan kata sandi baru. Tidak perlu kata sandi lama.</p>
    <form method="POST" action="{{ route('akun.password') }}">
      @csrf
      @method('PUT')
      <div class="field">
        <label for="password">Kata sandi baru</label>
        <span class="hint">Minimal 6 karakter, pilih yang mudah kamu ingat.</span>
        <div class="pass-wrap">
          <input id="password" name="password" type="password" autocomplete="new-password" required>
          @include('partials.toggle-eye', ['target' => 'password'])
        </div>
        @error('password')<span class="err">{{ $message }}</span>@enderror
      </div>
      <button type="submit" class="btn-primary">Simpan kata sandi</button>
    </form>
  </div>
</section>
@endsection
