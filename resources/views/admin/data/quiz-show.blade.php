@extends('layouts.admin')

@section('title', 'Detail Kuis')
@section('heading', 'Detail Hasil Kuis')
@section('subtitle', $attempt->user?->username ?? 'Pengguna terhapus')

@section('content')
  <div class="panel">
    <h3>Ringkasan</h3>
    <div class="akun-row"><span>Pengguna</span><b>{{ $attempt->user?->username ?? '–' }}</b></div>
    <div class="akun-row"><span>Jenis</span><b>{{ ucfirst($attempt->type) }}</b></div>
    <div class="akun-row"><span>Skor</span><b>{{ $attempt->raw_score }}/{{ $attempt->max_score }} ({{ $attempt->percentage }}%)</b></div>
    <div class="akun-row"><span>Tanggal</span><b>{{ $attempt->taken_at->translatedFormat('d F Y') }}</b></div>
  </div>

  <div class="panel">
    <h3>Jawaban</h3>
    @include('partials.quiz-answer-list', ['attempt' => $attempt])
  </div>

  <a class="btn ghost" href="{{ route('admin.data.quiz') }}" style="display:block; text-align:center">‹ Kembali</a>
@endsection
