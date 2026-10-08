@extends('layouts.admin')

@section('title', 'Ekspor')
@section('heading', 'Ekspor CSV')
@section('subtitle', 'Unduh data untuk penelitian')

@section('content')
  <div class="panel">
    <h3>Pilih data</h3>
    <p class="tip" style="margin-top:0">File CSV dapat dibuka di Excel atau Google Sheets.</p>
    <div class="form-actions" style="flex-direction:column">
      <a class="btn" href="{{ route('admin.export.download', 'users') }}">Pengguna ({{ $counts['users'] }})</a>
      <a class="btn" href="{{ route('admin.export.download', 'quiz') }}">Hasil kuis ({{ $counts['quiz'] }})</a>
      <a class="btn" href="{{ route('admin.export.download', 'lila') }}">Pengukuran LILA ({{ $counts['lila'] }})</a>
      <a class="btn" href="{{ route('admin.export.download', 'activity') }}">Aktivitas ({{ $counts['activity'] }})</a>
    </div>
  </div>
@endsection
