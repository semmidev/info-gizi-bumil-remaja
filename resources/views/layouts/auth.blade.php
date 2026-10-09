<!DOCTYPE html>
<html lang="id" data-theme="light">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
<title>@yield('title', 'Masuk') · Layanan Infogizi Ibu Hamil Remaja</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Baloo+2:wght@500;600;700;800&family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body data-menu="@yield('menu', 'Aplikasi')" data-user="UMUM">
<div class="auth-app">
  <div class="auth-logo">
    <svg viewBox="0 0 48 48" aria-hidden="true"><circle cx="24" cy="24" r="23" fill="var(--sabbe-soft)"/><circle cx="24" cy="14" r="6" fill="var(--sabbe)"/><path d="M15 40c0-9 3-17 9-17 4 0 6 3 6 6 4 1 6 4 6 7 0 2-1 4-3 4z" fill="var(--sabbe)"/><circle cx="29" cy="33" r="4.5" fill="none" stroke="#fff" stroke-width="2" stroke-dasharray="2 2"/></svg>
    <h1>Layanan Infogizi</h1>
    <p>Ibu Hamil Remaja · Cegah KEK</p>
  </div>

  <div class="auth-card">
    @if (session('sukses'))
      <div class="flash flash-msg" data-flash="{{ session('sukses') }}">{{ session('sukses') }}</div>
    @endif
    @yield('content')
  </div>

  <p class="auth-foot">Media edukasi ini tidak menggantikan pemeriksaan oleh bidan atau dokter.</p>
</div>
<script src="{{ asset('js/pass.js') }}"></script>
<script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
