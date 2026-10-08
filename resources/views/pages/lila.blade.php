@extends('layouts.app')

@section('title', 'Pengukuran LILA')
@section('menu', 'Pengukuran LILA')

@section('content')
<section class="screen on" id="s-lila" aria-labelledby="h-lila">
    <h2 id="h-lila">Pengukuran LILA</h2>
    <p class="lead">Ukur lingkar lengan atas dengan pita LILA, lalu masukkan hasilnya.</p>

    <div class="panel">
      <h3>Cara mengukur</h3>
      <svg viewBox="0 0 320 130" width="100%" role="img" aria-label="Ilustrasi lengan kiri dengan pita LILA di titik tengah antara bahu dan siku">
        <rect x="20" y="40" width="250" height="52" rx="26" fill="var(--sabbe-soft)" stroke="var(--sabbe)" stroke-width="2"/>
        <circle cx="34" cy="66" r="22" fill="var(--sabbe-soft)" stroke="var(--sabbe)" stroke-width="2"/>
        <circle cx="270" cy="66" r="14" fill="var(--sabbe-soft)" stroke="var(--sabbe)" stroke-width="2"/>
        <text x="34" y="122" text-anchor="middle" font-size="12" font-weight="700" fill="var(--muted)" font-family="Nunito,sans-serif">Bahu</text>
        <text x="270" y="122" text-anchor="middle" font-size="12" font-weight="700" fill="var(--muted)" font-family="Nunito,sans-serif">Siku</text>
        <line x1="34" y1="22" x2="270" y2="22" stroke="var(--muted)" stroke-width="1.5" stroke-dasharray="4 4"/>
        <circle cx="152" cy="22" r="5" fill="var(--kunyit)"/>
        <text x="152" y="14" text-anchor="middle" font-size="12" font-weight="800" fill="var(--kunyit)" font-family="Nunito,sans-serif">titik tengah</text>
        <rect x="142" y="36" width="20" height="60" rx="4" fill="var(--danau)" opacity=".85"/>
        <text x="152" y="112" text-anchor="middle" font-size="12" font-weight="800" fill="var(--danau)" font-family="Nunito,sans-serif">pita LILA</text>
      </svg>
      <ol class="steps">
        <li><div><b>Tentukan bahu dan siku</b><small>Gunakan lengan kiri (lengan kanan bila kidal).</small></div></li>
        <li><div><b>Letakkan pita di antara bahu dan siku</b><small>Lengan dibiarkan lemas, baju tidak menekan.</small></div></li>
        <li><div><b>Tandai titik tengahnya</b></div></li>
        <li><div><b>Lingkarkan pita di titik tengah</b></div></li>
        <li><div><b>Jangan terlalu ketat</b></div></li>
        <li><div><b>Jangan terlalu longgar</b></div></li>
        <li><div><b>Baca angka di pita dengan teliti</b><small>Pita harus rata, tidak kusut atau terlipat.</small></div></li>
      </ol>
    </div>

    <div class="panel">
      <h3>Masukkan hasil ukur Ibu</h3>
      <div class="tape-wrap"><div class="tape" id="tape"><div class="marker" id="marker"></div></div></div>
      <div class="lila-in">
        <input type="range" id="lila-range" min="18" max="34" step="0.1" value="23.5" aria-label="Geser hasil LILA">
        <input type="number" id="lila-num" min="15" max="45" step="0.1" value="23.5" aria-label="Hasil LILA dalam cm"><span>cm</span>
      </div>
      <div class="result" id="lila-result"></div>
      <div style="display:flex;gap:10px;margin-top:12px;flex-wrap:wrap">
        <button class="btn" id="lila-save">Simpan hasil</button>
        <button class="btn ghost" id="lila-clear">Hapus riwayat</button>
      </div>
      <ul class="hist" id="lila-hist">
        @forelse ($lilaHistory as $m)
          <li>
            <span>{{ $m->measured_at->translatedFormat('j M Y') }}</span>
            <span class="{{ $m->value_cm < 23.5 ? 'r' : 'g' }}">{{ number_format((float) $m->value_cm, 1, ',', '.') }} cm</span>
          </li>
        @empty
          <li><span>Belum ada hasil tersimpan. Simpan hasil pertamamu untuk memantau perubahan.</span></li>
        @endforelse
      </ul>
      @include('admin.partials.pagination', ['paginator' => $lilaHistory])
    </div>
  </section>
<script>window.__DATA = @json($data);</script>
@endsection
