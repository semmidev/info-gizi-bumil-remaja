<!DOCTYPE html>
<html lang="id" data-theme="light">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
  <title>@yield('title', 'Layanan Infogizi Ibu Hamil Remaja')</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="icon" type="image/png" href="{{ asset(auth()->user()?->logoPath() ?? 'logo/logo.png') }}">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap"
    rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/app.css') }}">
  <script>try{if(!matchMedia('(prefers-reduced-motion: reduce)').matches)document.documentElement.classList.add('motion-on')}catch(e){}</script>
</head>

<body data-menu="@yield('menu', 'Aplikasi')" data-user="{{ auth()->user()->username ?? 'UMUM' }}">
  <div class="app">
    <header class="top">
      <div class="brand">
        <div class="brand-menu">
          <button type="button" class="brand-btn" id="brand-btn" aria-haspopup="true" aria-expanded="false"
            aria-label="Menu akun" title="Menu akun">
            <img src="{{ asset(auth()->user()?->logoPath() ?? 'logo/logo.png') }}" alt="Logo" width="36" height="36">
          </button>
          <span class="brand-cap">Akun</span>
          <div class="dropdown" id="brand-dropdown" hidden>
            <div class="dropdown-head">
              <b>{{ auth()->user()->username ?? 'Pengguna' }}</b>
            </div>
            <a href="{{ route('akun') }}">Akun saya</a>
            @if(auth()->check() && auth()->user()->role === 'admin')
              <a href="{{ route('admin.dashboard') }}">Buka Dashboard Admin</a>
            @endif
            <form method="POST" action="{{ route('logout') }}">
              @csrf
              <button type="submit">Keluar</button>
            </form>
          </div>
        </div>
        <div>
          <h1>Layanan Infogizi Ibu Hamil Remaja</h1>
          <div style="line-height: 1.2; font-size: 13px;">
            <div>Layanan Infogizi Ibu Hamil Remaja</div>
            <div>Cegak KEK, jaga ibu dan bayi</div>
          </div>
        </div>
      </div>
    </header>

    <main>
      @if (session('sukses'))
        <div class="panel flash-msg" style="background:var(--kelor-soft);border:0" data-flash="{{ session('sukses') }}">
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
        <div class="logtbl">
          <table>
            <thead>
              <tr>
                <th>Waktu</th>
                <th>Kegiatan</th>
                <th>Keterangan</th>
              </tr>
            </thead>
            <tbody id="log-rows"></tbody>
          </table>
        </div>
        <div class="dlg-b">
          <button class="btn" id="log-copy">Salin data (CSV)</button>
          <button class="btn ghost" id="log-share">Kirim</button>
          <button class="btn ghost" id="log-close">Tutup</button>
        </div>
        <p class="tip" id="log-msg"></p>
      </div>
    </div>

    @include('partials.nav')

    @php
      $profileUser = auth()->user();
      $showProfileModal = $profileUser && $profileUser->needsProfileCompletion() && !request()->routeIs('akun');
      $missing = [];
      if ($showProfileModal) {
        if (!trim((string) $profileUser->full_name))
          $missing[] = 'nama lengkap';
        if (!$profileUser->age)
          $missing[] = 'umur';
        if (!trim((string) $profileUser->address))
          $missing[] = 'alamat';
        $missing = implode(', ', $missing);
      }
    @endphp
    @if($showProfileModal)
      @include('partials.profile-modal', ['missing' => $missing])
    @endif
  </div>
  <script src="{{ asset('js/pass.js') }}"></script>
  <script src="{{ asset('js/app.js') }}"></script>
  <script defer src="{{ asset('js/vendor/motion.min.js') }}"></script>
  <script defer src="{{ asset('js/motion-ui.js') }}"></script>
</body>

</html>
