@extends('layouts.app')

@section('title', 'Informasi')
@section('menu', 'Informasi')

@section('content')
<section class="screen on" id="s-info" aria-labelledby="h-info">
    <h2 id="h-info">Informasi</h2>
    <div class="about">
      <b>Tentang media ini</b>
      <p>Media infografis ini membantu ibu hamil remaja (usia 10–19 tahun) memahami, menyikapi, dan melakukan tindakan pencegahan Kekurangan Energi Kronik (KEK) secara mandiri.</p>
      <div class="about-g"><span>👩 Sasaran: ibu hamil remaja</span><span>🎯 Tujuan: mencegah KEK</span></div>
    </div>
    <p class="lead">Mulai dari mengenal kehamilan remaja, lalu pelajari KEK dan cara mencegahnya.</p>

    <div class="seg" role="tablist" aria-label="Bagian informasi">
      <button role="tab" aria-selected="true" data-p="p-remaja">Ibu Hamil Remaja</button>
      <button role="tab" aria-selected="false" data-p="p-kek">KEK pada Ibu Hamil</button>
    </div>

    <!-- BAGIAN A -->
    <div class="part on" id="p-remaja">
      <nav class="toc" aria-label="Isi bagian A"><b>Isi bagian ini</b><div>
        <a href="#a1">1. Definisi</a><a href="#a2">2. Alasan</a><a href="#a3">3. Kebutuhan gizi</a><a href="#a4">4. Permasalahan</a></div></nav>
      <div class="panel" id="a1">
        <h3><span class="num">1</span>Siapa ibu hamil remaja?</h3>
        <div class="age">
          <div class="age-bar">
            <div class="age-seg a1"><b>10–14</b>remaja awal</div>
            <div class="age-seg a2"><b>15–19</b>remaja akhir</div>
            <div class="age-seg a3"><b>20+</b>dewasa</div>
          </div>
          <div class="age-brace"></div><p class="age-lbl">Ibu hamil remaja: hamil di bawah usia 20 tahun</p>
        </div>
        <p>Menurut WHO, remaja adalah mereka yang berusia 10–19 tahun. Kehamilan yang terjadi pada usia ini disebut kehamilan remaja.</p>
        <p class="tip">Di usia ini organ reproduksi belum berfungsi sempurna, sehingga kehamilan dan persalinan lebih mudah mengalami komplikasi.</p>
      </div>

      <div class="panel" id="a2">
        <h3><span class="num">2</span>Mengapa kehamilan remaja bisa terjadi?</h3>
        <div class="reasons">
          <div><i>💍</i><b>Menikah di usia muda</b><small>Masih ada kebiasaan menikah di usia anak karena tradisi atau tekanan ekonomi.</small></div>
          <div><i>📚</i><b>Kurang informasi kesehatan reproduksi</b><small>Belum memahami masa subur dan cara merencanakan kehamilan.</small></div>
          <div><i>🏠</i><b>Ekonomi dan pendidikan keluarga</b><small>Keterbatasan biaya dan sekolah membatasi akses informasi dan layanan.</small></div>
          <div><i>🗣️</i><b>Jarang dibicarakan di keluarga</b><small>Remaja mencari informasi dari teman atau internet yang belum tentu benar.</small></div>
          <div><i>🏥</i><b>Layanan ramah remaja terbatas</b><small>Malu atau takut dinilai membuat remaja enggan bertanya ke tenaga kesehatan.</small></div>
        </div>
        <p class="tip">Apa pun alasannya, yang terpenting sekarang adalah menjaga kesehatan ibu dan bayi. Ibu tidak sendiri, bidan dan kader siap membantu.</p>
      </div>

      <div class="panel" id="a3">
        <h3><span class="num">3</span>Kebutuhan gizi ibu hamil remaja</h3>
        <div class="duo"><div class="c">Gizi untuk tubuh ibu yang masih tumbuh</div><div class="plus">+</div><div class="c k">Gizi untuk janin yang sedang tumbuh</div></div>
        <p>Karena dua pertumbuhan terjadi bersamaan, kebutuhan gizi ibu hamil remaja meningkat. Inilah yang paling bertambah saat hamil:</p>
        <div class="nutri">
          <div><i>⚡</i><b>Energi</b><span>+180 kkal (trimester I)<br>+300 kkal (trimester II–III)</span></div>
          <div><i>🐟</i><b>Protein</b><span>+1 g (trimester I), +10 g (trimester II)<br>+30 g (trimester III)</span></div>
          <div><i>🩸</i><b>Zat besi</b><span>+9 mg<br>(trimester II–III)</span></div>
          <div><i>🥬</i><b>Asam folat</b><span>+200 mcg<br>sejak awal hamil</span></div>
          <div><i>🥛</i><b>Kalsium</b><span>+200 mg<br>sepanjang kehamilan</span></div>
          <div><i>🍊</i><b>Vitamin A dan C</b><span>+300 RE dan +10 mg</span></div>
        </div>
        <p class="tip">Tambahan +300 kkal kira-kira sama dengan sepiring kecil nasi dan sepotong ikan, bukan makan dua kali lipat. Sumber: AKG 2019.</p>
        <button class="btn ghost" data-goto="p-kek" data-scroll="b7">Lihat porsi makan harian</button>
      </div>

      <div class="panel" id="a4">
        <h3><span class="num">4</span>Permasalahan yang sering dialami</h3>
        <div class="probs">
          <div class="pb" style="background:var(--sabbe-soft)"><b>Kesehatan ibu</b><small>Anemia, KEK, preeklamsia, infeksi, persalinan lama</small></div>
          <div class="pb" style="background:var(--danau-soft)"><b>Kesehatan bayi</b><small>Berat lahir rendah (BBLR) dan lahir prematur</small></div>
          <div class="pb" style="background:var(--kunyit-soft)"><b>Perasaan</b><small>Stres, cemas, dan bingung menjalani peran baru</small></div>
          <div class="pb" style="background:var(--kelor-soft)"><b>Sekolah dan ekonomi</b><small>Putus sekolah dan bergantung pada keluarga atau pasangan</small></div>
          <div class="pb wide" style="background:var(--surface);border:2px solid var(--line)"><b>Lingkungan sosial</b><small>Stigma dan omongan orang sekitar yang membuat ibu enggan memeriksakan diri</small></div>
        </div>
        <p class="tip">Salah satu masalah gizi yang paling sering adalah KEK. Lanjutkan ke bagian berikutnya.</p>
        <button class="btn" data-goto="p-kek" style="margin-top:6px">Lanjut: KEK pada Ibu Hamil</button>
      </div>
    </div>

    <!-- BAGIAN B -->
    <div class="part" id="p-kek">
      <nav class="toc" aria-label="Isi bagian B"><b>Isi bagian ini</b><div>
        <a href="#b1">1. Definisi KEK</a><a href="#b2">2. Dampak pada ibu</a><a href="#b3">3. Dampak pada bayi</a><a href="#b4">4. Intervensi gizi</a><a href="#b5">5. Suplementasi</a><a href="#b6">6. Sumber gizi</a><a href="#b7">7. Porsi harian</a><a href="#b8">8. Pencegahan</a><a href="#b9">9. Isi Piringku</a></div></nav>
      <div class="panel" id="b1">
        <h3><span class="num">1</span>Apa itu KEK pada ibu hamil?</h3>
        <div class="big-def">
          <div class="ring"><div><b>&lt;23,5</b><span>cm LILA</span></div></div>
          <div><p>Kekurangan Energi Kronik (KEK) adalah kondisi kurang energi dan protein yang berlangsung lama. Ibu hamil disebut KEK bila lingkar lengan atas (LILA) kurang dari 23,5 cm.</p></div>
        </div>
        <p style="margin-top:12px;font-weight:700">Tanda yang perlu diwaspadai:</p>
        <div class="icons">
          <div><i>📏</i>LILA &lt;23,5 cm</div><div><i>😮‍💨</i>Mudah lelah</div><div><i>🫥</i>Wajah pucat</div>
          <div><i>💫</i>Sering pusing</div><div><i>🍽️</i>Nafsu makan turun</div><div><i>⚖️</i>Berat badan naiknya kurang</div>
        </div>
      </div>

      <div class="panel" id="b2">
        <h3><span class="num">2</span>Penyebab dan dampak KEK pada ibu</h3>
        <h4 class="sub">Penyebab</h4>
        <div class="chips">
          <span>Hamil di usia &lt;20 tahun</span><span>Pola makan tidak teratur</span><span>Jarang makan lauk hewani</span><span>Kurang zat besi</span><span>Pantangan makan saat hamil</span><span>Pengetahuan gizi kurang</span><span>Keterbatasan ekonomi</span><span>Anemia dan infeksi</span>
        </div>
        <h4 class="sub">Dampak pada ibu</h4>
        <div class="icons">
          <div style="background:var(--sabbe-soft)"><i>🩸</i>Anemia</div><div style="background:var(--sabbe-soft)"><i>⏳</i>Persalinan lama</div><div style="background:var(--sabbe-soft)"><i>🚨</i>Perdarahan setelah melahirkan</div>
          <div style="background:var(--sabbe-soft)"><i>🦠</i>Mudah infeksi</div><div style="background:var(--sabbe-soft)"><i>⚠️</i>Komplikasi persalinan</div><div style="background:var(--sabbe-soft)"><i>🪫</i>Tubuh lemah</div>
        </div>
      </div>

      <div class="panel" id="b3">
        <h3><span class="num">3</span>Penyebab dan dampak pada bayi</h3>
        <h4 class="sub">Bagaimana KEK ibu sampai ke bayi</h4>
        <ol class="flow">
          <li>Ibu kurang makan dalam waktu lama</li>
          <li>Tubuh ibu memakai cadangan lemak dan otot</li>
          <li>Plasenta (ari-ari) tidak berfungsi optimal</li>
          <li>Gizi dan oksigen ke janin berkurang</li>
        </ol>
        <h4 class="sub">Dampak pada bayi</h4>
        <div class="split">
          <div class="baby"><h4>Saat lahir</h4><ul><li>Berat lahir rendah (&lt;2.500 g)</li><li>Lahir prematur</li><li>Sulit bernapas (asfiksia)</li><li>Pertumbuhan janin terhambat</li></ul></div>
          <div class="mom"><h4>Jangka panjang</h4><ul><li>Berisiko stunting</li><li>Perkembangan otak kurang optimal</li><li>Mudah sakit</li></ul></div>
        </div>
      </div>

      <div class="panel" id="b4">
        <h3><span class="num">4</span>Intervensi gizi pada ibu hamil KEK</h3>
        <p>Bila LILA ibu di bawah 23,5 cm, tenaga kesehatan akan memberikan:</p>
        <div class="intv">
          <div><i>🍱</i><b>Makanan tambahan (PMT)</b><small>Berbahan pangan lokal dari puskesmas, dimakan sebagai tambahan, bukan pengganti makan utama.</small></div>
          <div><i>💊</i><b>Suplementasi gizi</b><small>Tablet tambah darah setiap hari dan suplemen lain sesuai anjuran (lihat poin 5).</small></div>
          <div><i>🗣️</i><b>Konseling gizi</b><small>Bidan atau ahli gizi membantu menyusun porsi dan menu sesuai kondisi ibu.</small></div>
          <div><i>📈</i><b>Pemantauan rutin</b><small>LILA dan berat badan diukur setiap periksa kehamilan.</small></div>
        </div>
      </div>

      <div class="panel" id="b5">
        <h3><span class="num">5</span>Suplementasi gizi</h3>
        <div class="supp">
          <div class="sp1"><div class="sp-h"><i>💊</i><b>Tablet tambah darah (TTD)</b></div>
            <p>Berisi zat besi dan asam folat untuk mencegah anemia dan KEK.</p>
            <ul><li>1 tablet setiap hari, minimal 90 tablet selama hamil</li><li>Minum dengan air putih atau jus jeruk, bukan teh, kopi, atau susu</li><li>Diminum malam sebelum tidur agar tidak mual</li><li>Tinja berwarna hitam merupakan hal yang normal</li></ul></div>
          <div class="sp2"><div class="sp-h"><i>🥬</i><b>Asam folat</b></div>
            <p>Penting sejak awal kehamilan untuk pembentukan otak dan saraf janin. Sudah terkandung dalam TTD.</p></div>
          <div class="sp3"><div class="sp-h"><i>🥛</i><b>Kalsium</b></div>
            <p>Untuk tulang dan gigi ibu serta janin. Diminum sesuai anjuran tenaga kesehatan, dengan jarak waktu dari TTD karena kalsium menghambat penyerapan zat besi.</p></div>
        </div>
        <p class="tip">Minum suplemen hanya yang diberikan atau dianjurkan bidan atau dokter.</p>
      </div>

      <div class="panel" id="b6">
        <h3><span class="num">6</span>Sumber gizi utama ibu hamil remaja</h3>
        <div class="src">
          <div><i>🍚</i><div><b>Karbohidrat</b><small>Sumber tenaga</small><span>Nasi, jagung, ubi, sagu, roti</span></div></div>
          <div><i>🐟</i><div><b>Protein</b><small>Membangun tubuh ibu dan janin</small><span>Ikan, telur, ayam, daging, tempe, tahu, kacang hijau</span></div></div>
          <div><i>🩸</i><div><b>Zat besi</b><small>Membentuk darah, mencegah anemia</small><span>Hati ayam, daging, ikan, daun kelor, bayam</span></div></div>
          <div><i>🥬</i><div><b>Asam folat</b><small>Pembentukan otak dan saraf janin</small><span>Sayuran hijau, kacang-kacangan, hati</span></div></div>
          <div><i>🥛</i><div><b>Kalsium</b><small>Tulang dan gigi ibu serta janin</small><span>Susu, ikan teri, tahu, tempe, sayuran hijau</span></div></div>
          <div><i>🍊</i><div><b>Vitamin C</b><small>Membantu penyerapan zat besi</small><span>Jeruk, jambu biji, pepaya, tomat</span></div></div>
        </div>
        <h4 class="sub">Pangan lokal yang mudah didapat</h4>
        <div class="chips"><span>Ikan air tawar dari danau dan sungai</span><span>Telur</span><span>Daun kelor</span><span>Tempe dan tahu</span><span>Kacang hijau</span><span>Pisang dan pepaya</span></div>
      </div>

      <div class="panel" id="b7">
        <h3><span class="num">7</span>Porsi makan harian ibu hamil remaja</h3>
        <p>Jumlah porsi makan dalam sehari menurut trimester:</p>
        <div class="seg seg-sm" role="tablist" aria-label="Pilih trimester">
          <button role="tab" aria-selected="true" data-tm="1">Trimester I</button>
          <button role="tab" aria-selected="false" data-tm="2">Trimester II–III</button>
        </div>
        <div class="porsi" id="porsi"></div>
        <p class="tip">Bagi ke 3 kali makan utama dan 2–3 kali selingan. Sumber: Kementerian Kesehatan RI (2023).</p>
      </div>

      <div class="panel" id="b8">
        <h3><span class="num">8</span>Mencegah KEK pada ibu hamil</h3>
        <ol class="steps">
          <li><div><b>Makan gizi seimbang setiap hari</b><small>Ikuti Isi Piringku dan porsi harian sesuai trimester.</small></div></li>
          <li><div><b>Minum tablet tambah darah setiap hari</b><small>Minimal 90 tablet selama hamil.</small></div></li>
          <li><div><b>Periksa kehamilan minimal 6 kali</b><small>Di posyandu, bidan desa, atau puskesmas.</small></div></li>
          <li><div><b>Ukur LILA dan timbang berat badan</b><small>Pantau sendiri lewat menu Pengukuran LILA.</small></div></li>
          <li><div><b>Hindari pantangan makan yang tidak perlu</b><small>Tanyakan ke bidan bila ragu dengan suatu makanan.</small></div></li>
          <li><div><b>Libatkan keluarga</b><small>Minta dukungan suami dan orang tua untuk makan teratur dan periksa rutin.</small></div></li>
        </ol>
      </div>

      <div class="panel" id="b9">
        <h3><span class="num">9</span>Isi Piringku</h3>
        <div class="seg seg-sm" role="tablist" aria-label="Pilih isi piring">
          <button role="tab" aria-selected="true" data-pr="pr-hamil">Ibu hamil</button>
          <button role="tab" aria-selected="false" data-pr="pr-kek">Ibu hamil KEK</button>
        </div>
        <div class="prv on" id="pr-hamil">
          <div class="piring">
          <svg viewBox="0 0 220 220" role="img" aria-label="Isi Piringku: setengah piring sayur dan buah, setengah piring makanan pokok dan lauk pauk">
            <circle cx="110" cy="110" r="108" fill="var(--surface)" stroke="var(--line)" stroke-width="3"/>
            <path d="M110,110 L110,10 A100,100 0 0 1 196.6,160 Z" fill="#7DBE5E"/>
            <path d="M110,110 L196.6,160 A100,100 0 0 1 110,210 Z" fill="#F2A541"/>
            <path d="M110,110 L110,210 A100,100 0 0 1 23.4,60 Z" fill="#F4E3B5"/>
            <path d="M110,110 L23.4,60 A100,100 0 0 1 110,10 Z" fill="#E77F8C"/>
            <g stroke="var(--surface)" stroke-width="3"><line x1="110" y1="110" x2="110" y2="10"/><line x1="110" y1="110" x2="196.6" y2="160"/><line x1="110" y1="110" x2="110" y2="210"/><line x1="110" y1="110" x2="23.4" y2="60"/></g>
            <g font-family="Nunito,sans-serif" font-weight="800" font-size="11" text-anchor="middle" fill="#24313B">
              <text x="160" y="72" font-size="24">🥬</text><text x="160" y="90">Sayur</text>
              <text x="140" y="156" font-size="22">🍌</text><text x="140" y="172">Buah</text>
              <text x="62" y="140" font-size="24">🍚</text><text x="62" y="158">Makanan</text><text x="62" y="170">pokok</text>
              <text x="78" y="54" font-size="20">🐟</text><text x="78" y="70">Lauk</text>
            </g>
          </svg>
          <ul class="piring-key">
            <li><i style="background:#7DBE5E"></i><span><b>Sayur</b> paling banyak, sepertiga piring</span></li>
            <li><i style="background:#F2A541"></i><span><b>Buah</b> seperenam piring</span></li>
            <li><i style="background:#F4E3B5"></i><span><b>Nasi atau pengganti</b> sepertiga piring</span></li>
            <li><i style="background:#E77F8C"></i><span><b>Lauk</b> ikan, telur, tempe, tahu</span></li>
          </ul>
        </div>
          <p class="tip">Setiap kali makan: setengah piring sayur dan buah, setengah piring nasi dan lauk. Makan 3 kali sehari ditambah 2–3 kali selingan.</p>
        </div>
        <div class="prv" id="pr-kek">
          <svg viewBox="0 0 330 220" role="img" aria-label="Isi Piringku ibu hamil KEK: piring seimbang ditambah lauk hewani tambahan dan makanan tambahan">

            <circle cx="110" cy="110" r="108" fill="var(--surface)" stroke="var(--line)" stroke-width="3"/>
            <path d="M110,110 L110,10 A100,100 0 0 1 196.6,160 Z" fill="#7DBE5E"/>
            <path d="M110,110 L196.6,160 A100,100 0 0 1 110,210 Z" fill="#F2A541"/>
            <path d="M110,110 L110,210 A100,100 0 0 1 23.4,60 Z" fill="#F4E3B5"/>
            <path d="M110,110 L23.4,60 A100,100 0 0 1 110,10 Z" fill="#E77F8C"/>
            <g stroke="var(--surface)" stroke-width="3"><line x1="110" y1="110" x2="110" y2="10"/><line x1="110" y1="110" x2="196.6" y2="160"/><line x1="110" y1="110" x2="110" y2="210"/><line x1="110" y1="110" x2="23.4" y2="60"/></g>
            <g font-family="Nunito,sans-serif" font-weight="800" font-size="11" text-anchor="middle" fill="#24313B">
              <text x="160" y="72" font-size="24">🥬</text><text x="160" y="90">Sayur</text>
              <text x="140" y="156" font-size="22">🍌</text><text x="140" y="172">Buah</text>
              <text x="62" y="140" font-size="24">🍚</text><text x="62" y="158">Makanan</text><text x="62" y="170">pokok</text>
              <text x="78" y="54" font-size="20">🐟</text><text x="78" y="70">Lauk</text>
            </g>

            <g font-family="Nunito,sans-serif" font-weight="800" text-anchor="middle" fill="var(--ink)">
              <text x="232" y="66" font-size="22" fill="var(--sabbe)">+</text>
              <circle cx="285" cy="58" r="36" fill="#E77F8C" stroke="var(--surface)" stroke-width="3"/>
              <text x="285" y="58" font-size="20">🥚</text><text x="285" y="76" font-size="9.5" fill="#24313B">Lauk hewani</text><text x="285" y="87" font-size="9.5" fill="#24313B">tambahan</text>
              <text x="232" y="166" font-size="22" fill="var(--sabbe)">+</text>
              <circle cx="285" cy="160" r="36" fill="#F2A541" stroke="var(--surface)" stroke-width="3"/>
              <text x="285" y="160" font-size="20">🍪</text><text x="285" y="178" font-size="9.5" fill="#24313B">Selingan</text><text x="285" y="189" font-size="9.5" fill="#24313B">PMT</text>
            </g>
          </svg>
          <ol class="steps">
            <li><div><b>Isi piring tetap seimbang</b><small>Setengah piring sayur dan buah, setengah piring nasi dan lauk.</small></div></li>
            <li><div><b>Tambah lauk hewani setiap makan</b><small>Misalnya ikan ditambah telur, atau ayam ditambah tempe.</small></div></li>
            <li><div><b>Makan sedikit tapi sering</b><small>3 kali makan utama dan 2–3 kali selingan.</small></div></li>
            <li><div><b>Habiskan PMT dari puskesmas</b><small>Sebagai selingan di antara makan utama, bukan pengganti makan.</small></div></li>
            <li><div><b>Pilih makanan padat energi</b><small>Bubur kacang hijau, susu, atau masakan bersantan secukupnya.</small></div></li>
          </ol>
          <p class="note-kek">Gambar ini adalah anjuran penatalaksanaan gizi bagi ibu hamil KEK, bukan Isi Piringku resmi. Jumlah porsi yang tepat ditentukan bersama bidan atau ahli gizi.</p>
        </div>
      </div>

      <div class="panel">
        <h3>Target saya hari ini</h3>
        <div class="progress" aria-hidden="true"><i id="chk-bar"></i></div>
        <ul class="check" id="checklist"></ul>
        <p class="tip" id="chk-msg"></p>
      </div>

      <div class="panel">
        <h3>Riwayat target</h3>
        @forelse ($targetHistory as $day)
          @php
            $dateKey = $day->log_date->toDateString();
            $logs = $targetLogsByDate->get($dateKey, collect());
            $doneCount = $logs->where('is_done', true)->count();
          @endphp
          <div class="list-item" style="align-items:flex-start">
            <div class="li-main" style="width:100%">
              <b>{{ $day->log_date->translatedFormat('d M Y') }} · {{ $doneCount }}/{{ $targetTotal }}</b>
              <div style="margin-top:6px; display:grid; gap:4px">
                @foreach ($logs as $log)
                  <small style="white-space:normal">{{ $log->is_done ? '✓' : '○' }} {{ $log->checklistItem?->label ?? '–' }}</small>
                @endforeach
              </div>
            </div>
          </div>
        @empty
          <p class="empty">Belum ada riwayat target.</p>
        @endforelse
        @include('admin.partials.pagination', ['paginator' => $targetHistory])
      </div>
    </div>
  </section>
<script>window.__DATA = @json($data);</script>
@endsection
