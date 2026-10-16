<nav class="tabs" aria-label="Menu utama">
  <a href="{{ route('informasi') }}" class="{{ request()->routeIs('informasi') ? 'active' : '' }}" @if(request()->routeIs('informasi')) aria-current="page" @endif>
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><circle cx="12" cy="12" r="9"/><path d="M12 11v6M12 7.5v.5"/></svg>Informasi
  </a>
  <a href="{{ route('lila') }}" class="{{ request()->routeIs('lila') ? 'active' : '' }}" @if(request()->routeIs('lila')) aria-current="page" @endif>
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><rect x="2" y="8" width="20" height="8" rx="2"/><path d="M6 8v3M10 8v4M14 8v3M18 8v4"/></svg>Pengukuran LILA
  </a>
  <a href="{{ route('layanan') }}" class="{{ request()->routeIs('layanan') ? 'active' : '' }}" @if(request()->routeIs('layanan')) aria-current="page" @endif>
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M4 21V9l8-6 8 6v12z"/><path d="M12 10v6M9 13h6"/></svg>Layanan
  </a>
  <a href="{{ route('kuis') }}" class="{{ request()->routeIs('kuis') ? 'active' : '' }}" @if(request()->routeIs('kuis')) aria-current="page" @endif>
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M9.5 9a2.5 2.5 0 1 1 3.5 2.3c-.6.3-1 .9-1 1.6V14"/><path d="M12 17.5v.5"/><rect x="3" y="3" width="18" height="18" rx="5"/></svg>Kuis
  </a>
  <a href="{{ route('akun') }}" class="{{ request()->routeIs('akun*') ? 'active' : '' }}" @if(request()->routeIs('akun*')) aria-current="page" @endif>
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><circle cx="12" cy="8" r="3.5"/><path d="M5 20c0-3.3 3.1-6 7-6s7 2.7 7 6"/></svg>Akun
  </a>
</nav>
