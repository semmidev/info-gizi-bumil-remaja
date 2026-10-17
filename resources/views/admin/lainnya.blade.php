@extends('layouts.admin')

@section('title', 'Lainnya')
@section('heading', 'Lainnya')
@section('subtitle', 'Kelola kuis, target, ekspor, dan akun')

@section('content')
  <div class="cards">
    <a class="card-link" href="{{ route('admin.quiz.index') }}"><i><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/><path d="M12 17h.01"/></svg></i><b>Manajemen Kuis</b><small>Soal &amp; opsi</small></a>
    <a class="card-link" href="{{ route('admin.target.index') }}"><i><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><circle cx="12" cy="12" r="6"/><circle cx="12" cy="12" r="2"/></svg></i><b>Manajemen Target</b><small>Target harian</small></a>
    <a class="card-link" href="{{ route('admin.categories.index') }}"><i><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M13.172 2a2 2 0 0 1 1.414.586l6.71 6.71a2.4 2.4 0 0 1 0 3.408l-4.592 4.592a2.4 2.4 0 0 1-3.408 0l-6.71-6.71A2 2 0 0 1 6 9.172V3a1 1 0 0 1 1-1z"/><path d="M2 7v6.172a2 2 0 0 0 .586 1.414l6.71 6.71a2.4 2.4 0 0 0 3.191.193"/><circle cx="10.5" cy="6.5" r=".5" fill="currentColor"/></svg></i><b>Manajemen Kategori</b><small>Kategori konten</small></a>
    <a class="card-link" href="{{ route('admin.contents.index') }}"><i><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M15 18h-5"/><path d="M18 14h-8"/><path d="M4 22h16a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2H8a2 2 0 0 0-2 2v16a2 2 0 0 1-4 0v-9a2 2 0 0 1 2-2h2"/><rect width="8" height="4" x="10" y="6" rx="1"/></svg></i><b>Manajemen Konten</b><small>Info menarik &amp; slide</small></a>
    <a class="card-link" href="{{ route('admin.export.index') }}"><i><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 15V3"/><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><path d="m7 10 5 5 5-5"/></svg></i><b>Ekspor CSV</b><small>Unduh data</small></a>
    <a class="card-link" href="{{ route('informasi') }}"><i><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="14" height="20" x="5" y="2" rx="2" ry="2"/><path d="M12 18h.01"/></svg></i><b>Buka Aplikasi</b><small>Lihat sisi pengguna</small></a>
    <a class="card-link" href="{{ route('akun') }}"><i><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg></i><b>Akun Saya</b><small>Ubah kata sandi</small></a>
  </div>

  <div class="panel">
    <h3>Keluar</h3>
    <p class="tip" style="margin-top:0">Akhiri sesi admin di perangkat ini.</p>
    <form method="POST" action="{{ route('logout') }}" data-confirm="Keluar dari akun admin?" data-confirm-title="Yakin keluar?" data-confirm-ok="Keluar">
      @csrf
      <button type="submit" class="btn danger">Keluar</button>
    </form>
  </div>
@endsection
