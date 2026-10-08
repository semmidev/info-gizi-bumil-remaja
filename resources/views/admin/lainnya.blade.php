@extends('layouts.admin')

@section('title', 'Lainnya')
@section('heading', 'Lainnya')
@section('subtitle', 'Master data, ekspor, dan akun')

@section('content')
  <div class="cards">
    <a class="card-link" href="{{ route('admin.quiz.index') }}"><i>❓</i><b>Master Kuis</b><small>Soal & opsi</small></a>
    <a class="card-link" href="{{ route('admin.target.index') }}"><i>✅</i><b>Master Target</b><small>Target harian</small></a>
    <a class="card-link" href="{{ route('admin.export.index') }}"><i>⬇️</i><b>Ekspor CSV</b><small>Unduh data</small></a>
    <a class="card-link" href="{{ route('informasi') }}"><i>📱</i><b>Buka Aplikasi</b><small>Lihat sisi pengguna</small></a>
    <a class="card-link" href="{{ route('akun') }}"><i>👤</i><b>Akun Saya</b><small>Ubah kata sandi</small></a>
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
