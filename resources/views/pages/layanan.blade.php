@extends('layouts.app')

@section('title', 'Layanan Info')
@section('menu', 'Layanan Info')

@section('content')
<section class="screen on" id="s-layanan" aria-labelledby="h-layanan">
    <h2 id="h-layanan">Layanan Info Ibu Hamil Remaja</h2>
    <p class="lead">Di mana periksa, apa yang didapat, dan kapan harus segera ke fasilitas kesehatan.</p>

    <div class="panel">
      <h3>Tempat periksa kehamilan</h3>
      <div class="intv">
        <div><i>🏘️</i><b>Posyandu</b><small>Timbang berat badan, ukur LILA, dapat TTD, dan penyuluhan gizi.</small></div>
        <div><i>👩‍⚕️</i><b>Bidan desa atau pustu</b><small>Pemeriksaan kehamilan rutin dan konsultasi.</small></div>
        <div><i>🏥</i><b>Puskesmas</b><small>Pemeriksaan lengkap, cek Hb, konseling gizi, PMT, dan pemeriksaan dokter.</small></div>
      </div>
      <p class="tip">Jadwal pemeriksaan ada di menu Info Menarik.</p>
    </div>

    <div class="panel">
      <h3>Tablet tambah darah (TTD)</h3>
      <p>Minum 1 tablet setiap hari, minimal 90 tablet selama hamil. TTD gratis di posyandu dan puskesmas.</p>
      <div class="split" style="margin-top:10px">
        <div class="baby" style="background:var(--kelor-soft)"><h4>Minum dengan</h4><ul><li>Air putih</li><li>Jus jeruk atau buah</li></ul></div>
        <div class="mom" style="background:var(--bahaya-soft)"><h4>Hindari bersama</h4><ul><li>Teh dan kopi</li><li>Susu</li></ul></div>
      </div>
      <p class="tip">Diminum malam sebelum tidur bisa mengurangi rasa mual.</p>
    </div>

    <div class="panel">
      <h3>Makanan tambahan (PMT)</h3>
      <p>Ibu hamil dengan LILA di bawah 23,5 cm berhak mendapat PMT berbahan pangan lokal dari puskesmas. Tanyakan ke bidan desa saat pemeriksaan.</p>
    </div>

    <div class="panel danger">
      <h3>Segera ke bidan atau puskesmas bila</h3>
      <ul>
        <li>Keluar darah dari jalan lahir</li>
        <li>Sakit kepala hebat, pandangan kabur, kaki/tangan/wajah bengkak</li>
        <li>Demam tinggi</li>
        <li>Gerakan janin berkurang atau tidak terasa</li>
        <li>Keluar air ketuban sebelum waktunya</li>
        <li>Muntah terus-menerus dan tidak bisa makan</li>
      </ul>
    </div>

    <div class="panel">
      <h3>Nomor bidan desa saya</h3>
      <p class="tip" style="margin-top:0">Simpan nomornya di sini supaya mudah dihubungi.</p>
      <div class="contact">
        <input type="tel" id="bidan" placeholder="Contoh: 0812…" aria-label="Nomor telepon bidan desa">
        <button class="btn" id="bidan-save">Simpan</button>
      </div>
      <p id="bidan-link" class="tip"></p>
    </div>
  </section>
@endsection
