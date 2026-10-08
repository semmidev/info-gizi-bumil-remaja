@extends('layouts.app')

@section('title', 'Kuis')
@section('menu', 'Kuis')

@section('content')
<section class="screen on" id="s-kuis" aria-labelledby="h-kuis">
    <h2 id="h-kuis">Kuis</h2>
    <p class="lead">Evaluasi pengetahuan, sikap, dan tindakan Ibu dalam mencegah KEK. Setiap jawaban langsung diberi penjelasan.</p>
    <div class="panel evalbox" id="evalbox"></div>
    <div class="seg seg3" role="tablist" aria-label="Jenis kuis">
      <button role="tab" aria-selected="true" data-qs="p">Pengetahuan</button>
      <button role="tab" aria-selected="false" data-qs="s">Sikap</button>
      <button role="tab" aria-selected="false" data-qs="b">Tindakan</button>
    </div>
    <div class="panel" id="quiz"></div>

    <div class="panel">
      <h3>Riwayat kuis</h3>
      <p class="tip" style="margin-top:0">Ketuk salah satu untuk melihat jawabanmu dan pembahasannya.</p>
      @forelse ($history as $attempt)
        <details class="acc">
          <summary>
            <span>{{ ['pengetahuan' => 'Pengetahuan', 'sikap' => 'Sikap', 'tindakan' => 'Tindakan'][$attempt->type] ?? ucfirst($attempt->type) }}</span>
            <span class="pill {{ $attempt->percentage >= 76 ? 'ok' : ($attempt->percentage >= 56 ? 'user' : 'risk') }}">{{ $attempt->percentage }}%</span>
            <small style="color:var(--muted); font-weight:700; margin-left:auto">{{ $attempt->taken_at->translatedFormat('d M Y') }}</small>
          </summary>
          <div class="acc-b">
            @include('partials.quiz-answer-list', ['attempt' => $attempt])
          </div>
        </details>
      @empty
        <p class="empty">Belum ada riwayat kuis. Kerjakan kuis di atas untuk mulai menyimpan riwayat.</p>
      @endforelse
      @include('admin.partials.pagination', ['paginator' => $history])
    </div>
  </section>
<script>window.__DATA = @json($data);</script>
@endsection
