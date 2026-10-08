<!DOCTYPE html>
<html lang="id" data-theme="light">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
<title>@yield('title', 'Layanan Infogizi Ibu Hamil Remaja')</title>
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Baloo+2:wght@500;600;700;800&family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body data-menu="@yield('menu', 'Aplikasi')" data-user="{{ auth()->user()->username ?? 'UMUM' }}">
<div class="app">
  <header class="top">
    <div class="brand">
      <div class="brand-menu">
        <button type="button" class="brand-btn" id="brand-btn" aria-haspopup="true" aria-expanded="false" aria-label="Menu akun" title="Menu akun">
          <svg width="48" height="48" viewBox="0 0 48 48" aria-hidden="true"><circle cx="24" cy="24" r="23" fill="rgba(255,255,255,.18)"/><circle cx="24" cy="14" r="6" fill="#fff"/><path d="M15 40c0-9 3-17 9-17 4 0 6 3 6 6 4 1 6 4 6 7 0 2-1 4-3 4z" fill="#fff"/><circle cx="29" cy="33" r="4.5" fill="none" stroke="#B8336A" stroke-width="2" stroke-dasharray="2 2"/></svg>
        </button>
        <span class="brand-cap">Akun</span>
        <div class="dropdown" id="brand-dropdown" hidden>
          <div class="dropdown-head">
            <b>{{ auth()->user()->username ?? 'Pengguna' }}</b>
          </div>
          <a href="{{ route('akun') }}">Akun saya</a>
          <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit">Keluar</button>
          </form>
        </div>
      </div>
      <div><h1>Layanan Infogizi Ibu Hamil Remaja</h1><p>Cegah KEK, jaga ibu dan bayi</p></div>
    </div>
  </header>

  <main>
    @if (session('sukses'))
      <div class="panel" style="background:var(--kelor-soft);border:0">
        <b style="color:var(--kelor)">{{ session('sukses') }}</b>
      </div>
    @endif
    @yield('content')
  </main>

  <p class="note">Media edukasi ini tidak menggantikan pemeriksaan oleh bidan atau dokter.</p>

  <div class="ovl" id="log-ovl" hidden>
    <div class="dlg dlg-w" role="dialog" aria-modal="true" aria-labelledby="log-h">
      <h3 id="log-h">Data penggunaan (khusus peneliti)</h3>
      <div class="logsum" id="log-sum"></div>
      <div class="logtbl"><table><thead><tr><th>Waktu</th><th>Kegiatan</th><th>Keterangan</th></tr></thead><tbody id="log-rows"></tbody></table></div>
      <div class="dlg-b">
        <button class="btn" id="log-copy">Salin data (CSV)</button>
        <button class="btn ghost" id="log-share">Kirim</button>
        <button class="btn ghost" id="log-close">Tutup</button>
      </div>
      <p class="tip" id="log-msg"></p>
    </div>
  </div>

  @include('partials.nav')
</div>
<script src="{{ asset('js/pass.js') }}"></script>
<script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
