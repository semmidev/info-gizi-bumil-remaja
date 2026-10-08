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
  </section>
<script>window.__DATA = @json($data);</script>
@endsection
