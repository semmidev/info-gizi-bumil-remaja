<nav class="tabs" aria-label="Menu utama">
  <a href="{{ route('informasi') }}" class="{{ request()->routeIs('informasi') ? 'active' : '' }}"
    @if(request()->routeIs('informasi')) aria-current="page" @endif>
    <img src="{{ asset('icons/nav-informasi.webp') }}" width="24" height="24" alt="">Informasi
  </a>
  <a href="{{ route('lila') }}" class="{{ request()->routeIs('lila') ? 'active' : '' }}" @if(request()->routeIs('lila'))
  aria-current="page" @endif>
    <img src="{{ asset('icons/nav-lila.webp') }}" width="24" height="24" alt="">LILA &amp; IMT
  </a>
  <a href="{{ route('layanan') }}" class="{{ request()->routeIs('layanan') ? 'active' : '' }}"
    @if(request()->routeIs('layanan')) aria-current="page" @endif>
    <img src="{{ asset('icons/nav-layanan.webp') }}" width="24" height="24" alt="">Layanan
  </a>
  <a href="{{ route('menarik') }}" class="{{ request()->routeIs('menarik') ? 'active' : '' }}"
    @if(request()->routeIs('menarik')) aria-current="page" @endif>
    <img src="{{ asset('icons/nav-menarik.webp') }}" width="24" height="24" alt="">Info Menarik
  </a>
  <a href="{{ route('kuis') }}" class="{{ request()->routeIs('kuis') ? 'active' : '' }}" @if(request()->routeIs('kuis'))
  aria-current="page" @endif>
    <img src="{{ asset('icons/nav-kuis.webp') }}" width="24" height="24" alt="">Kuis
  </a>
</nav>
