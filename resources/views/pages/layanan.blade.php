@extends('layouts.app')

@section('title', 'Layanan Info')
@section('menu', 'Layanan Info')

@section('content')
  <section class="screen on" id="s-layanan" aria-labelledby="h-layanan">
    <h2 id="h-layanan">Layanan Info</h2>
    <p class="lead">Di mana periksa, apa yang didapat, kapan harus ke faskes.</p>

    <div class="panel">
      <!-- <h3>Tempat periksa kehamilan</h3> -->
      <img class="illus" src="{{ asset('content/tempat-periksa-kehamilan.jpeg') }}"
        alt="Tempat periksa kehamilan: Posyandu untuk timbang berat badan, ukur LILA, dapat TTD, dan penyuluhan gizi; bidan desa atau pustu untuk pemeriksaan kehamilan rutin dan konsultasi; puskesmas untuk pemeriksaan lengkap, cek Hb, konseling gizi, PMT, dan pemeriksaan dokter. Jadwal pemeriksaan ada di menu Info Menarik.">
    </div>

    <div class="panel">
      <!-- <h3>Tablet tambah darah (TTD)</h3> -->
      <img class="illus" src="{{ asset('content/tablet-tambah-darah.jpeg') }}"
        alt="Tablet tambah darah (TTD): minum 1 tablet setiap hari, minimal 90 tablet selama hamil, gratis di posyandu dan puskesmas. Minum dengan air putih atau jus jeruk/buah. Hindari diminum bersama teh, kopi, atau susu. Diminum malam sebelum tidur bisa mengurangi rasa mual.">
    </div>

    <div class="panel">
      <!-- <h3>Makanan tambahan (PMT)</h3> -->
      <img class="illus" src="{{ asset('content/makanan-tambahan.jpeg') }}"
        alt="Makanan tambahan (PMT): ibu hamil dengan LILA di bawah 23,5 cm berhak mendapat PMT berbahan pangan lokal dari puskesmas. Tanyakan ke bidan desa saat pemeriksaan. PMT membantu memenuhi kebutuhan gizi ibu hamil dan janin.">
    </div>

    <div class="panel danger">
      <!-- <h3>Segera ke bidan atau puskesmas bila</h3> -->
      <img class="illus" src="{{ asset('content/segera-ke-bidan.jpeg') }}"
        alt="Segera ke bidan atau puskesmas bila: keluar darah dari jalan lahir; sakit kepala hebat, pandangan kabur, kaki/tangan/wajah bengkak; demam tinggi; gerakan janin berkurang atau tidak terasa; keluar air ketuban sebelum waktunya; muntah terus-menerus dan tidak bisa makan.">
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
  <script>window.__DATA = @json($data);</script>
@endsection
