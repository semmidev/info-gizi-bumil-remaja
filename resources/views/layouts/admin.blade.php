<!DOCTYPE html>
<html lang="id" data-theme="light">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
<title>@yield('title', 'Admin') · Layanan Infogizi</title>
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="icon" type="image/png" href="{{ asset(auth()->user()?->logoPath() ?? 'logo/logo.png') }}">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/app.css') }}?v={{ filemtime(public_path('css/app.css')) }}">
</head>
<body data-menu="Admin">
<div class="app admin">
  <header class="top">
    <div class="brand">
      <div class="brand-menu">
        <button type="button" class="brand-btn" id="brand-btn" aria-haspopup="true" aria-expanded="false" aria-label="Menu akun" title="Menu">
          <img src="{{ asset(auth()->user()?->logoPath() ?? 'logo/logo.png') }}" alt="Logo" width="36" height="36">
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
      <div class="panel flash-msg" style="background:var(--kelor-soft);border:0" data-flash="{{ session('sukses') }}">
        <b style="color:var(--kelor)">{{ session('sukses') }}</b>
      </div>
    @endif

    @if ($errors->any())
      <div class="panel flash-msg" style="background:var(--bahaya-soft);border:0">
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
