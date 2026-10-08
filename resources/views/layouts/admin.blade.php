<!DOCTYPE html>
<html lang="id" data-theme="light">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
<title>@yield('title', 'Admin') · Layanan Infogizi</title>
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Baloo+2:wght@500;600;700;800&family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body data-menu="Admin">
<div class="app">
  <header class="top">
    <div class="brand">
      <div class="brand-menu">
        <button type="button" class="brand-btn" id="brand-btn" aria-haspopup="true" aria-expanded="false" aria-label="Menu akun" title="Menu">
          <svg width="48" height="48" viewBox="0 0 48 48" aria-hidden="true"><circle cx="24" cy="24" r="23" fill="rgba(255,255,255,.18)"/><circle cx="24" cy="14" r="6" fill="#fff"/><path d="M15 40c0-9 3-17 9-17 4 0 6 3 6 6 4 1 6 4 6 7 0 2-1 4-3 4z" fill="#fff"/><circle cx="29" cy="33" r="4.5" fill="none" stroke="#B8336A" stroke-width="2" stroke-dasharray="2 2"/></svg>
        </button>
        <span class="brand-cap">Menu</span>
        <div class="dropdown" id="brand-dropdown" hidden>
          <div class="dropdown-head">
            <b>{{ auth()->user()->username ?? 'Admin' }}</b>
            <small>Admin</small>
          </div>
          <a href="{{ route('admin.dashboard') }}">Beranda admin</a>
          <a href="{{ route('informasi') }}">Buka aplikasi</a>
          <a href="{{ route('akun') }}">Akun saya</a>
          <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit">Keluar</button>
          </form>
        </div>
      </div>
      <div><h1>@yield('heading', 'Admin Infogizi')</h1><p>@yield('subtitle', 'Kelola pengguna & data')</p></div>
    </div>
  </header>

  <main>
    @if (session('sukses'))
      <div class="panel" style="background:var(--kelor-soft);border:0">
        <b style="color:var(--kelor)">{{ session('sukses') }}</b>
      </div>
    @endif

    @if ($errors->any())
      <div class="panel" style="background:var(--bahaya-soft);border:0">
        @foreach ($errors->all() as $error)
          <b style="color:var(--bahaya); display:block">{{ $error }}</b>
        @endforeach
      </div>
    @endif

    @yield('content')
  </main>

  @include('partials.admin-nav')
</div>
<script src="{{ asset('js/pass.js') }}"></script>
<script src="{{ asset('js/admin.js') }}"></script>
</body>
</html>
