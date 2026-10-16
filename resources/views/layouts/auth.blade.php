<!DOCTYPE html>
<html lang="id" data-theme="light">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
  <title>@yield('title', 'Masuk') · Layanan Infogizi Ibu Hamil Remaja</title>
  <link rel="icon" type="image/png" href="{{ asset('logo/logo-hijab.png') }}">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Baloo+2:wght@500;600;700;800&family=Nunito:wght@400;600;700;800&display=swap"
    rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>

<body data-menu="@yield('menu', 'Aplikasi')" data-user="UMUM">
  <div class="auth-app">
    <div class="auth-logo">
      <img src="{{ asset('logo/logo-hijab.png') }}" alt="Layanan Infogizi" width="76" height="76">
      <h1>Layanan Infogizi Ibu Hamil Remaja</h1>
      <p>Cegak KEK, jaga ibu dan bayi</p>
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
