@extends('layouts.app')

@section('title', 'Info Menarik')
@section('menu', 'Info Menarik')

@section('content')
<section class="screen on" id="s-menarik" aria-labelledby="h-menarik">
    <h2 id="h-menarik">Info Menarik</h2>
    <p class="lead">Ketuk setiap topik untuk membaca isinya.</p>

    <details class="acc" open><summary><i>✅</i>Tips cegah KEK</summary><div class="acc-b">
      <ol class="steps">
        <li><div><b>Jangan lewatkan sarapan</b><small>Siapkan bahan sejak malam agar pagi lebih mudah.</small></div></li>
        <li><div><b>Ada lauk hewani setiap hari</b><small>Ikan dan telur murah dan mudah didapat.</small></div></li>
        <li><div><b>Sediakan selingan sehat</b><small>Pisang, ubi rebus, atau bubur kacang hijau.</small></div></li>
        <li><div><b>Minum TTD setiap malam</b><small>Pasang pengingat di ponsel.</small></div></li>
        <li><div><b>Ukur LILA tiap periksa</b><small>Catat hasilnya di menu Pengukuran LILA.</small></div></li>
        <li><div><b>Tanyakan ke bidan bila ragu</b><small>Terutama soal pantangan makanan.</small></div></li>
      </ol></div></details>

    <details class="acc"><summary><i>🍽️</i>Menu gizi ibu hamil</summary><div class="acc-b">
      <p class="tip" style="margin-top:0">Contoh menu sehari untuk ibu hamil dengan LILA normal.</p>
      <ul class="menu-day">
        <li><b>Pagi</b><span>Nasi, telur dadar, sayur bening kelor</span></li>
        <li><b>Selingan</b><span>Bubur kacang hijau</span></li>
        <li><b>Siang</b><span>Nasi, ikan bakar, tempe goreng, sayur kangkung, pisang</span></li>
        <li><b>Selingan</b><span>Segelas susu dan pepaya</span></li>
        <li><b>Malam</b><span>Nasi, ikan kuah kuning, tahu, sayur bayam, jeruk</span></li>
      </ul></div></details>

    <details class="acc"><summary><i>🍲</i>Menu gizi harian ibu hamil KEK</summary><div class="acc-b">
      <p class="tip" style="margin-top:0">Lebih sering makan, lebih banyak lauk hewani, dan ada PMT.</p>
      <ul class="menu-day">
        <li><b>Pagi</b><span>Nasi, telur rebus dan tempe goreng, sayur bening kelor</span></li>
        <li><b>Pukul 10.00</b><span>PMT dari puskesmas dan segelas susu</span></li>
        <li><b>Siang</b><span>Nasi, ikan bakar dan tahu, sayur bayam, pisang</span></li>
        <li><b>Pukul 16.00</b><span>Bubur kacang hijau dengan santan</span></li>
        <li><b>Malam</b><span>Nasi, ayam atau ikan kuah kuning, tempe, sayur kangkung, jeruk</span></li>
        <li><b>Sebelum tidur</b><span>Segelas susu atau PMT, lalu minum TTD dengan air putih</span></li>
      </ul>
      <p class="tip">Sesuaikan dengan anjuran bidan atau ahli gizi. Beri jarak antara susu dan TTD.</p></div></details>

    <details class="acc"><summary><i>🩺</i>Pentingnya pemeriksaan kehamilan</summary><div class="acc-b">
      <div class="icons">
        <div><i>📏</i>Deteksi KEK lewat LILA</div><div><i>🩸</i>Cek anemia (Hb)</div><div><i>⚖️</i>Pantau berat badan</div>
        <div><i>👶</i>Pantau tumbuh janin</div><div><i>💊</i>Dapat TTD dan PMT</div><div><i>🚨</i>Kenali tanda bahaya</div>
      </div>
      <p class="tip">Masalah yang ditemukan lebih awal lebih mudah ditangani.</p></div></details>

    <details class="acc"><summary><i>📅</i>Jadwal pemeriksaan kehamilan</summary><div class="acc-b">
      <div class="tri">
        <div><b>2×</b><div class="dots"><i></i><i></i></div><small>Trimester 1<br>(0–12 minggu)</small></div>
        <div><b>1×</b><div class="dots"><i></i></div><small>Trimester 2<br>(13–27 minggu)</small></div>
        <div><b>3×</b><div class="dots"><i></i><i></i><i></i></div><small>Trimester 3<br>(28 minggu–lahir)</small></div>
      </div>
      <p class="tip">Minimal 6 kali, 2 kali di antaranya diperiksa dokter (trimester 1 dan 3).</p></div></details>

    <details class="acc"><summary><i>😋</i>Tips meningkatkan nafsu makan</summary><div class="acc-b">
      <ul class="tips">
        <li>Makan sedikit tapi sering, 5–6 kali sehari</li>
        <li>Pilih makanan yang disukai dan variasikan menunya</li>
        <li>Sajikan selagi hangat dan menarik</li>
        <li>Minum di sela waktu makan, bukan saat makan, agar perut tidak cepat penuh</li>
        <li>Makan bersama keluarga</li>
        <li>Saat mual pagi hari, mulai dengan biskuit atau roti kering</li>
        <li>Hindari bau masakan yang menyengat</li>
        <li>Jalan santai sebelum makan</li>
      </ul></div></details>

    <details class="acc"><summary><i>🚶‍♀️</i>Aktivitas fisik dan istirahat</summary><div class="acc-b">
      <div class="split">
        <div style="background:var(--kelor-soft)"><h4>Aktivitas</h4><ul><li>Jalan kaki santai sekitar 30 menit sehari</li><li>Ikut senam hamil</li><li>Pekerjaan rumah ringan</li><li>Hindari mengangkat beban berat</li></ul></div>
        <div style="background:var(--danau-soft)"><h4>Istirahat</h4><ul><li>Tidur malam sekitar 8 jam</li><li>Tidur siang 1–2 jam</li><li>Tidur miring ke kiri</li><li>Hentikan aktivitas bila pusing atau sesak</li></ul></div>
      </div></div></details>

    <details class="acc"><summary><i>👨‍👩‍👧</i>Peran keluarga</summary><div class="acc-b">
      <div class="intv">
        <div><i>🛒</i><b>Menyediakan makanan bergizi</b><small>Ikan, telur, sayur, dan buah ada di rumah setiap hari.</small></div>
        <div><i>⏰</i><b>Mengingatkan</b><small>Waktu makan, minum TTD, dan jadwal periksa.</small></div>
        <div><i>🛵</i><b>Mengantar periksa</b><small>Ke posyandu, bidan, atau puskesmas.</small></div>
        <div><i>🧺</i><b>Membantu pekerjaan rumah</b><small>Agar ibu cukup istirahat.</small></div>
        <div><i>💬</i><b>Memberi dukungan</b><small>Mendengarkan, tidak menyalahkan, dan tidak memaksakan pantangan.</small></div>
      </div></div></details>

    <details class="acc"><summary><i>💡</i>Mitos dan fakta</summary><div class="acc-b">
      <div id="myths"></div></div></details>
      <details class="acc" id="pustaka"><summary><i>📚</i>Daftar pustaka</summary><div class="acc-b">
      <ol class="refs">
        <li>Kementerian Kesehatan RI. (2014). <i>Pedoman gizi seimbang</i> (Permenkes No. 41 Tahun 2014). Kemenkes RI.</li>
        <li>Kementerian Kesehatan RI. (2019). <i>Angka kecukupan gizi yang dianjurkan untuk masyarakat Indonesia</i> (Permenkes No. 28 Tahun 2019). Kemenkes RI.</li>
        <li>Kementerian Kesehatan RI. (2022). <i>Pedoman gizi ibu hamil</i>. Kemenkes RI.</li>
        <li>Kementerian Kesehatan RI. (2023a). <i>Rencana aksi nasional percepatan penurunan stunting</i>. Kemenkes RI.</li>
        <li>Kementerian Kesehatan RI. (2023b). <i>Buku resep makanan lokal balita dan ibu hamil</i>. Kemenkes RI.</li>
        <li>Kementerian Kesehatan RI. (2024). <i>Buku kesehatan ibu dan anak</i> (Edisi revisi 2024). Kemenkes RI.</li>
        <li>Nugraha, A., Putri, D., &amp; Sari, R. (2019). Panduan pengukuran lingkar lengan atas (LILA) untuk ibu hamil. <i>Jurnal Gizi Klinik Indonesia, 12</i>(1), 12–18.</li>
        <li>Suryadi, A., Wulandari, S., &amp; Sari, P. (2023). Panduan teknis pengukuran LILA pada ibu hamil. <i>Jurnal Gizi dan Kesehatan, 14</i>(1), 34–42.</li>
        <li>UNICEF. (2023). <i>State of the world’s children 2023: Nutrition and health</i>. United Nations Children’s Fund.</li>
        <li>Widyawati, W., &amp; Sulistyoningtyas, S. (2020). Karakteristik ibu hamil kekurangan energi kronik (KEK) di Puskesmas Pajangan Bantul. <i>Jurnal JKFT, 5</i>(2), 68.</li>
        <li>World Health Organization. (2017). <i>Global nutrition targets 2025: Low birth weight policy brief</i>. WHO.</li>
        <li>World Health Organization. (2022). <i>Adolescent pregnancy: Guidelines for prevention and care</i>. WHO.</li>
        <li>World Health Organization. (2023). <i>Adolescent health and development</i>. WHO.</li>
        <li>World Health Organization. (2024). <i>Adolescent pregnancy</i> [Fact sheet]. WHO.</li>
        <li>Yastirin, P. A., Sahara, R., &amp; Sehmawati. (2024). Dampak kesehatan ibu pada kehamilan remaja. <i>Jurnal Profesi Bidan Indonesia, 4</i>(2).</li>
      </ol></div></details>
</section>
@endsection
