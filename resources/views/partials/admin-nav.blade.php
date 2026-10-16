<nav class="tabs nav-4" aria-label="Menu admin">
  <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
    <img src="{{ asset('icons/nav-admin-beranda.png') }}" width="26" height="26" alt="">Beranda
  </a>
  <a href="{{ route('admin.users.index') }}" class="{{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
    <img src="{{ asset('icons/nav-admin-pengguna.png') }}" width="26" height="26" alt="">Pengguna
  </a>
  <a href="{{ route('admin.data.lila') }}" class="{{ request()->routeIs('admin.data.*') ? 'active' : '' }}">
    <img src="{{ asset('icons/nav-admin-data.png') }}" width="26" height="26" alt="">Data
  </a>
  <a href="{{ route('admin.lainnya') }}" class="{{ request()->routeIs('admin.lainnya', 'admin.quiz.*', 'admin.target.*', 'admin.export.*') ? 'active' : '' }}">
    <img src="{{ asset('icons/nav-admin-lainnya.png') }}" width="26" height="26" alt="">Lainnya
  </a>
</nav>
