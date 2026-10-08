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
    <div class="akun-row"><span>Nama lengkap</span><b>{{ $user->full_name ?: '–' }}</b></div>
    <div class="akun-row"><span>Umur</span><b>{{ $user->age ? $user->age . ' tahun' : '–' }}</b></div>
    <div class="akun-row"><span>Alamat</span><b>{{ $user->address ?: '–' }}</b></div>
    <div class="akun-row"><span>Usia kehamilan</span><b>{{ $user->pregnancy_month ? $user->pregnancy_month . ' bulan' : '–' }}</b></div>
    <div class="akun-row"><span>Terakhir masuk</span><b>{{ $user->last_login_at ? $user->last_login_at->translatedFormat('d F Y, H:i') : '–' }}</b></div>
    <div class="akun-row"><span>Bergabung</span><b>{{ $user->created_at->translatedFormat('j F Y') }}</b></div>
  </div>

  <div class="panel">
    <h3>Data diri &amp; kehamilan</h3>
    <p class="tip" style="margin-top:0">Lengkapi data ini agar informasi yang kamu terima lebih sesuai.</p>
    <form method="POST" action="{{ route('akun.profile') }}">
      @csrf
      @method('PUT')
      <div class="field">
        <label for="full_name">Nama lengkap</label>
        <input id="full_name" name="full_name" type="text" value="{{ old('full_name', $user->full_name) }}" maxlength="100" placeholder="Contoh: Rina Amelia">
        @error('full_name')<span class="err">{{ $message }}</span>@enderror
      </div>
      <div class="field">
        <label for="age">Umur (tahun)</label>
        <input id="age" name="age" type="number" inputmode="numeric" value="{{ old('age', $user->age) }}" min="10" max="60" placeholder="Contoh: 17">
        @error('age')<span class="err">{{ $message }}</span>@enderror
      </div>
      <div class="field">
        <label for="pregnancy_month">Usia kehamilan (bulan)</label>
        <input id="pregnancy_month" name="pregnancy_month" type="number" inputmode="numeric" value="{{ old('pregnancy_month', $user->pregnancy_month) }}" min="1" max="9" placeholder="Contoh: 5">
        @error('pregnancy_month')<span class="err">{{ $message }}</span>@enderror
      </div>
      <div class="field">
        <label for="address">Alamat</label>
        <input id="address" name="address" type="text" value="{{ old('address', $user->address) }}" maxlength="255" placeholder="Desa / kecamatan, kota">
        @error('address')<span class="err">{{ $message }}</span>@enderror
      </div>
      <button type="submit" class="btn-primary">Simpan data diri</button>
    </form>
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
