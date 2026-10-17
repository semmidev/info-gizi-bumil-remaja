@extends('layouts.app')

@section('title', 'Informasi')
@section('menu', 'Informasi')

@section('content')
  <section class="screen on" id="s-info" aria-labelledby="h-info">
    <h2 id="h-info">Informasi</h2>
    <div class="about">
      <b>⚠️ Penting</b>
      <p>Media ini untuk remaja yang TERLANJUR hamil agar tetap sehat. Jika belum hamil, tunda kehamilan sampai usia
        matang ≥ 20 tahun untuk mencegah anemia, KEK, preeklamsia, BBLR, stunting, hingga risiko kematian ibu &amp; bayi.
      </p>
    </div>
    <p class="lead">Mulai dari mengenal kehamilan remaja, lalu pelajari KEK dan cara mencegahnya.</p>

    <div class="seg" role="tablist" aria-label="Bagian informasi">
      <button role="tab" aria-selected="true" data-p="p-remaja">Ibu Hamil Remaja</button>
      <button role="tab" aria-selected="false" data-p="p-kek">KEK pada Ibu Hamil</button>
    </div>

    <!-- BAGIAN A -->
    <div class="part on" id="p-remaja">
      <nav class="toc" aria-label="Isi bagian A"><b>Isi bagian ini</b>
        <div>
          <a href="#a1">1. Definisi</a><a href="#a2">2. Alasan</a><a href="#a3">3. Kebutuhan gizi</a><a href="#a4">4.
            Permasalahan</a>
        </div>
      </nav>
      <div class="panel" id="a1">
        <h3><span class="num">1</span>Siapa ibu hamil remaja?</h3>
        <div class="age">
          <div class="age-bar">
            <div class="age-seg a1"><img class="age-ico" src="{{ asset('icons/ibu-hami-remaja/10-14-tahun.png') }}" alt=""><span><b>10–14</b>remaja awal</span></div>
            <div class="age-seg a2"><img class="age-ico" src="{{ asset('icons/ibu-hami-remaja/15-19-tahun.png') }}" alt=""><span><b>15–19</b>remaja akhir</span></div>
            <div class="age-seg a3"><img class="age-ico" src="{{ asset('icons/ibu-hami-remaja/20-tahun.png') }}" alt=""><span><b>20+</b>dewasa</span></div>
          </div>
          <img class="age-concl" src="{{ asset('icons/ibu-hami-remaja/kesimpulan.png') }}" alt="Ibu hamil remaja: hamil di bawah usia 20 tahun">
        </div>
        <p>Menurut WHO, remaja adalah mereka yang berusia 10–19 tahun. Kehamilan yang terjadi pada usia ini disebut
          kehamilan remaja.</p>
        <p class="tip">Di usia ini organ reproduksi belum berfungsi sempurna, sehingga kehamilan dan persalinan lebih
          mudah mengalami komplikasi.</p>
      </div>

      <div class="panel" id="a2">
        <h3><span class="num">2</span>Mengapa kehamilan remaja bisa terjadi?</h3>
        <div class="reasons">
          <div style="background:#E4F5FD"><i><img src="{{ asset('icons/mengapa-kehamilan-remaja-bisa-terjadi/menikah-diusia-muda.png') }}" alt=""></i><b>Menikah di usia muda</b><small>Masih ada kebiasaan menikah di usia anak karena tradisi atau
              tekanan ekonomi.</small></div>
          <div style="background:#FFF7E3"><i><img src="{{ asset('icons/mengapa-kehamilan-remaja-bisa-terjadi/kurang-informasi-kesehatan.png') }}" alt=""></i><b>Kurang informasi kesehatan reproduksi</b><small>Belum memahami masa subur dan cara merencanakan
              kehamilan.</small></div>
          <div style="background:#FFF7E1"><i><img src="{{ asset('icons/mengapa-kehamilan-remaja-bisa-terjadi/ekonomi-dan-pendidikan-keluarga.png') }}" alt=""></i><b>Ekonomi dan pendidikan keluarga</b><small>Keterbatasan biaya dan sekolah membatasi akses
              informasi dan layanan.</small></div>
          <div style="background:#F0EDFE"><i><img src="{{ asset('icons/mengapa-kehamilan-remaja-bisa-terjadi/jarang-dibicarakan-keluarga.png') }}" alt=""></i><b>Jarang dibicarakan di keluarga</b><small>Remaja mencari informasi dari teman atau internet
              yang belum tentu benar.</small></div>
          <div style="background:#FEE8F2"><i><img src="{{ asset('icons/mengapa-kehamilan-remaja-bisa-terjadi/layanan-ramah-remaja-terbatas.png') }}" alt=""></i><b>Layanan ramah remaja terbatas</b><small>Malu atau takut dinilai membuat remaja enggan bertanya
              ke tenaga kesehatan.</small></div>
        </div>
        <p class="tip">Apa pun alasannya, yang terpenting sekarang adalah menjaga kesehatan ibu dan bayi. Ibu tidak
          sendiri, bidan dan kader siap membantu.</p>
      </div>

      <div class="panel" id="a3">
        <h3><span class="num">3</span>Kebutuhan gizi ibu hamil remaja</h3>
        <div class="duo">
          <div class="c" style="background:#E4F5FF">
            <img src="{{ asset('icons/kebutuhan-gizi-hamil/gizi-untuk-tubuh-ibu.png') }}" alt="">
            <span>Gizi untuk tubuh ibu yang masih tumbuh</span>
          </div>
          <div class="plus">+</div>
          <div class="c k" style="background:#8EA0BD">
            <img src="{{ asset('icons/kebutuhan-gizi-hamil/gizi-untuk-janin.png') }}" alt="">
            <span>Gizi untuk janin yang sedang tumbuh</span>
          </div>
        </div>
        <p>Karena dua pertumbuhan terjadi bersamaan, kebutuhan gizi ibu hamil remaja meningkat. Inilah yang paling
          bertambah saat hamil:</p>
        <div class="nutri">
          <div style="background:#FAF5D6"><i><img src="{{ asset('icons/kebutuhan-gizi-hamil/energi.png') }}" alt=""></i><b>Energi</b><span>+180 kkal (trimester I)<br>+300 kkal (trimester II–III)</span></div>
          <div style="background:#EAF6FD"><i><img src="{{ asset('icons/kebutuhan-gizi-hamil/protein.png') }}" alt=""></i><b>Protein</b><span>+1 g (trimester I), +10 g (trimester II)<br>+30 g (trimester III)</span></div>
          <div style="background:#FDEEF5"><i><img src="{{ asset('icons/kebutuhan-gizi-hamil/zat-besi.png') }}" alt=""></i><b>Zat besi</b><span>+9 mg<br>(trimester II–III)</span></div>
          <div style="background:#E9F6EC"><i><img src="{{ asset('icons/kebutuhan-gizi-hamil/asam-folat.png') }}" alt=""></i><b>Asam folat</b><span>+200 mcg<br>sejak awal hamil</span></div>
          <div style="background:#EFEAFE"><i><img src="{{ asset('icons/kebutuhan-gizi-hamil/kalsium.png') }}" alt=""></i><b>Kalsium</b><span>+200 mg<br>sepanjang kehamilan</span></div>
          <div style="background:#FDE2CD"><i><img src="{{ asset('icons/kebutuhan-gizi-hamil/vitamin-a-c.png') }}" alt=""></i><b>Vitamin A dan C</b><span>+300 RE dan +10 mg</span></div>
        </div>
        <p class="tip">Tambahan +300 kkal kira-kira sama dengan sepiring kecil nasi dan sepotong ikan, bukan makan dua
          kali lipat. Sumber: AKG 2019.</p>
        <img class="illus" src="{{ asset('perbandingan-suplemen-ibu-hamil.svg') }}"
          alt="Perbandingan suplementasi untuk ibu hamil: TTD berisi Fe 60 mg dan folat 400 mcg minimal 90 tablet, dibanding MMS dengan 15 mikronutrien untuk mencegah anemia, KEK, BBLR, dan stunting. Jangan diminum bersamaan, gunakan salah satu TTD atau MMS, dan cek kadar Hb 2 kali selama kehamilan.">
        <button class="btn ghost" data-goto="p-kek" data-scroll="b7">Lihat porsi makan harian</button>
      </div>

      <div class="panel" id="a4">
        <h3><span class="num">4</span>Permasalahan yang sering dialami</h3>
        <div class="probs">
          <div class="pb" style="background:#FDE8EF"><i><img src="{{ asset('icons/permasalahan-yang-sering-dialami/kesehatan-ibu.png') }}" alt=""></i><b>Kesehatan ibu</b><small>Anemia, KEK, preeklamsia, infeksi, persalinan lama</small></div>
          <div class="pb" style="background:#E4F5FF"><i><img src="{{ asset('icons/permasalahan-yang-sering-dialami/kesehatan-bayi.png') }}" alt=""></i><b>Kesehatan bayi</b><small>Berat lahir rendah (BBLR) dan lahir prematur</small></div>
          <div class="pb" style="background:#FDF6DA"><i><img src="{{ asset('icons/permasalahan-yang-sering-dialami/perasaan.png') }}" alt=""></i><b>Perasaan</b><small>Stres, cemas, dan bingung menjalani peran baru</small></div>
          <div class="pb" style="background:#EBF9EC"><i><img src="{{ asset('icons/permasalahan-yang-sering-dialami/sekolah-dan-ekonomi.png') }}" alt=""></i><b>Sekolah dan ekonomi</b><small>Putus sekolah dan bergantung pada keluarga atau pasangan</small></div>
          <div class="pb wide" style="background:#F0EDFE"><i><img src="{{ asset('icons/permasalahan-yang-sering-dialami/lingkungan-sosial.png') }}" alt=""></i><b>Lingkungan sosial</b><small>Stigma dan omongan orang sekitar yang membuat ibu enggan memeriksakan diri</small></div>
        </div>
        <p class="tip">Salah satu masalah gizi yang paling sering adalah KEK. Lanjutkan ke bagian berikutnya.</p>
        <button class="btn" data-goto="p-kek" style="margin-top:6px">Lanjut: KEK pada Ibu Hamil</button>
      </div>
    </div>

    <!-- BAGIAN B -->
    <div class="part" id="p-kek">
      <nav class="toc" aria-label="Isi bagian B"><b>Isi bagian ini</b>
        <div>
          <a href="#b1">1. Definisi KEK</a><a href="#b2">2. Dampak pada ibu</a><a href="#b3">3. Dampak pada bayi</a><a
            href="#b4">4. Intervensi gizi</a><a href="#b5">5. Suplementasi</a><a href="#b6">6. Sumber gizi</a><a
            href="#b7">7. Porsi harian</a><a href="#b8">8. Pencegahan</a><a href="#b9">9. Isi Piringku</a>
        </div>
      </nav>
      <div class="panel" id="b1">
        <h3><span class="num">1</span>Apa itu KEK pada ibu hamil?</h3>
        <div class="big-def">
          <div class="ring">
            <div><b>&lt;23,5</b><span>cm LILA</span></div>
          </div>
          <div>
            <p>KEK (Kekurangan Energi Kronis pada Ibu Hamil Remaja) adalah Kondisi ibu hamil yang mengalami kekurangan
              energi dan zat
              gizi secara
              kronis dalam
              jangka waktu lama.
              Jika tidak ditangani dapat mengganggu kesehatan ibu dan tumbuh kembang janin. Ibu hamil disebut KEK bila
              lingkar lengan atas (LILA) kurang dari 23,5 cm.</p>
          </div>
        </div>
        <img class="illus" src="{{ asset('indikator-kek.svg') }}"
          alt="Indikator baru KEK: LILA kurang dari 23,5 cm dan IMT kurang dari 18,5 kg/m². Rumus IMT = berat badan dibagi tinggi badan (meter) kuadrat.">
        <p style="margin-top:12px;font-weight:700">Tanda yang perlu diwaspadai:</p>
        <div class="icons">
          <div style="background:#EBF5FE"><i><img src="{{ asset('icons/tanda-diwaspadai/lila-icon.png') }}" alt=""></i>LILA &lt;23,5 cm</div>
          <div style="background:#FEF0F0"><i><img src="{{ asset('icons/tanda-diwaspadai/mudah-lelah-icon.png') }}" alt=""></i>Mudah lelah</div>
          <div style="background:#FEF9E3"><i><img src="{{ asset('icons/tanda-diwaspadai/wajah-pucat-icon.png') }}" alt=""></i>Wajah pucat</div>
          <div style="background:#ECFAED"><i><img src="{{ asset('icons/tanda-diwaspadai/sering-pusing-icon.png') }}" alt=""></i>Sering pusing</div>
          <div style="background:#EDECFA"><i><img src="{{ asset('icons/tanda-diwaspadai/nafsu-makan-turun-icon.png') }}" alt=""></i>Nafsu makan turun</div>
          <div style="background:#E8F5FD"><i><img src="{{ asset('icons/tanda-diwaspadai/berat-badan-kurang-icon.png') }}" alt=""></i>Berat badan naiknya kurang</div>
        </div>
      </div>

      <div class="panel" id="b2">
        <h3><span class="num">2</span>Penyebab dan dampak KEK pada ibu</h3>
        <h4 class="sub">Penyebab</h4>
        <div class="chips">
          <span>Hamil di usia &lt;20 tahun</span><span>Pola makan tidak teratur</span><span>Jarang makan lauk
            hewani</span><span>Kurang zat besi</span><span>Pantangan makan saat hamil</span><span>Pengetahuan gizi
            kurang</span><span>Keterbatasan ekonomi</span><span>Anemia dan infeksi</span>
        </div>
        <h4 class="sub">Dampak pada ibu</h4>
        <div class="icons">
          <div style="background:var(--sabbe-soft)"><i><img src="{{ asset('icons/dampak-pada-ibu/anemia.png') }}" alt=""></i>Anemia</div>
          <div style="background:var(--sabbe-soft)"><i><img src="{{ asset('icons/dampak-pada-ibu/persalinan-lama.png') }}" alt=""></i>Persalinan lama</div>
          <div style="background:var(--sabbe-soft)"><i><img src="{{ asset('icons/dampak-pada-ibu/pendarahan.png') }}" alt=""></i>Perdarahan setelah melahirkan</div>
          <div style="background:var(--sabbe-soft)"><i><img src="{{ asset('icons/dampak-pada-ibu/mudah-infeksi.png') }}" alt=""></i>Mudah infeksi</div>
          <div style="background:var(--sabbe-soft)"><i><img src="{{ asset('icons/dampak-pada-ibu/kompilasi-persalinan.png') }}" alt=""></i>Komplikasi persalinan</div>
          <div style="background:var(--sabbe-soft)"><i><img src="{{ asset('icons/dampak-pada-ibu/tubuh-lemah.png') }}" alt=""></i>Tubuh lemah</div>
        </div>
      </div>

      <div class="panel" id="b3">
        <h3><span class="num">3</span>Penyebab dan dampak pada bayi</h3>
        <h4 class="sub">Bagaimana KEK ibu sampai ke bayi</h4>
        <ol class="flow">
          <li style="background:#FEF4D9"><img src="{{ asset('icons/dampak-pada-bayi/ibu-kurang-makan.png') }}" alt="">Ibu kurang makan dalam waktu lama</li>
          <li style="background:#FEF4D9"><img src="{{ asset('icons/dampak-pada-bayi/tubuh-ibu-pakai-cadangan.png') }}" alt="">Tubuh ibu memakai cadangan lemak dan otot</li>
          <li style="background:#FEF4D9"><img src="{{ asset('icons/dampak-pada-bayi/plasenta.png') }}" alt="">Plasenta (ari-ari) tidak berfungsi optimal</li>
          <li style="background:#E65F78;color:#fff"><img src="{{ asset('icons/dampak-pada-bayi/gizi-dan-oksigen.png') }}" alt="">Gizi dan oksigen ke janin berkurang</li>
        </ol>
        <h4 class="sub">Dampak pada bayi</h4>
        <div class="split">
          <div class="baby" style="background:#E1F7EB">
            <h4>Saat lahir</h4>
            <ul>
              <li>Berat lahir rendah (&lt;2.500 g)</li>
              <li>Lahir prematur</li>
              <li>Sulit bernapas (asfiksia)</li>
              <li>Pertumbuhan janin terhambat</li>
            </ul>
            <img src="{{ asset('icons/dampak-pada-bayi/saat-lahir.png') }}" alt="">
          </div>
          <div class="mom" style="background:#FFECF0">
            <h4>Jangka panjang</h4>
            <ul>
              <li>Berisiko stunting</li>
              <li>Perkembangan otak kurang optimal</li>
              <li>Mudah sakit</li>
            </ul>
            <img src="{{ asset('icons/dampak-pada-bayi/jangka-panjang.png') }}" alt="">
          </div>
        </div>
      </div>

      <div class="panel" id="b4">
        <h3><span class="num">4</span>Intervensi gizi pada ibu hamil KEK</h3>
        <p>Bila LILA ibu di bawah 23,5 cm, tenaga kesehatan akan memberikan:</p>
        <div class="intv">
          <div><i>🍱</i><b>Makanan tambahan (PMT)</b><small>Berbahan pangan lokal dari puskesmas, dimakan sebagai
              tambahan, bukan pengganti makan utama.</small></div>
          <div><i>💊</i><b>Suplementasi gizi</b><small>Tablet tambah darah setiap hari dan suplemen lain sesuai anjuran
              (lihat poin 5).</small></div>
          <div><i>🗣️</i><b>Konseling gizi</b><small>Bidan atau ahli gizi membantu menyusun porsi dan menu sesuai kondisi
              ibu.</small></div>
          <div><i>📈</i><b>Pemantauan rutin</b><small>LILA dan berat badan diukur setiap periksa kehamilan.</small></div>
        </div>
      </div>

      <div class="panel" id="b5">
        <h3><span class="num">5</span>Suplementasi gizi</h3>
        <div class="supp">
          <div class="sp1">
            <div class="sp-h"><i>💊</i><b>Tablet tambah darah (TTD)</b></div>
            <p>Berisi zat besi dan asam folat untuk mencegah anemia dan KEK.</p>
            <ul>
              <li>1 tablet setiap hari, minimal 90 tablet selama hamil</li>
              <li>Minum dengan air putih atau jus jeruk, bukan teh, kopi, atau susu</li>
              <li>Diminum malam sebelum tidur agar tidak mual</li>
              <li>Tinja berwarna hitam merupakan hal yang normal</li>
            </ul>
          </div>
          <div class="sp2">
            <div class="sp-h"><i>🥬</i><b>Asam folat</b></div>
            <p>Penting sejak awal kehamilan untuk pembentukan otak dan saraf janin. Sudah terkandung dalam TTD.</p>
          </div>
          <div class="sp3">
            <div class="sp-h"><i>🥛</i><b>Kalsium</b></div>
            <p>Untuk tulang dan gigi ibu serta janin. Diminum sesuai anjuran tenaga kesehatan, dengan jarak waktu dari TTD
              karena kalsium menghambat penyerapan zat besi.</p>
          </div>
        </div>
        <p class="tip">Minum suplemen hanya yang diberikan atau dianjurkan bidan atau dokter.</p>
      </div>

      <div class="panel" id="b6">
        <h3><span class="num">6</span>Sumber gizi utama ibu hamil remaja</h3>
        <div class="src">
          <div><i>🍚</i>
            <div><b>Karbohidrat</b><small>Sumber tenaga</small><span>Nasi, jagung, ubi, sagu, roti</span></div>
          </div>
          <div><i>🐟</i>
            <div><b>Protein</b><small>Membangun tubuh ibu dan janin</small><span>Ikan, telur, ayam, daging, tempe, tahu,
                kacang hijau</span></div>
          </div>
          <div><i>🩸</i>
            <div><b>Zat besi</b><small>Membentuk darah, mencegah anemia</small><span>Hati ayam, daging, ikan, daun kelor,
                bayam</span></div>
          </div>
          <div><i>🥬</i>
            <div><b>Asam folat</b><small>Pembentukan otak dan saraf janin</small><span>Sayuran hijau, kacang-kacangan,
                hati</span></div>
          </div>
          <div><i>🥛</i>
            <div><b>Kalsium</b><small>Tulang dan gigi ibu serta janin</small><span>Susu, ikan teri, tahu, tempe, sayuran
                hijau</span></div>
          </div>
          <div><i>🍊</i>
            <div><b>Vitamin C</b><small>Membantu penyerapan zat besi</small><span>Jeruk, jambu biji, pepaya, tomat</span>
            </div>
          </div>
        </div>
        <h4 class="sub">Pangan lokal yang mudah didapat</h4>
        <div class="chips"><span>Ikan air tawar dari danau dan sungai</span><span>Telur</span><span>Daun
            kelor</span><span>Tempe dan tahu</span><span>Kacang hijau</span><span>Pisang dan pepaya</span></div>
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
          <li>
            <div><b>Makan gizi seimbang setiap hari</b><small>Ikuti Isi Piringku dan porsi harian sesuai
                trimester.</small></div>
          </li>
          <li>
            <div><b>Minum tablet tambah darah setiap hari</b><small>Minimal 90 tablet selama hamil.</small></div>
          </li>
          <li>
            <div><b>Periksa kehamilan minimal 6 kali</b><small>Di posyandu, bidan desa, atau puskesmas.</small></div>
          </li>
          <li>
            <div><b>Ukur LILA dan timbang berat badan</b><small>Pantau sendiri lewat menu Pengukuran LILA.</small></div>
          </li>
          <li>
            <div><b>Hindari pantangan makan yang tidak perlu</b><small>Tanyakan ke bidan bila ragu dengan suatu
                makanan.</small></div>
          </li>
          <li>
            <div><b>Libatkan keluarga</b><small>Minta dukungan suami dan orang tua untuk makan teratur dan periksa
                rutin.</small></div>
          </li>
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
            <svg viewBox="0 0 220 220" role="img"
              aria-label="Isi Piringku: setengah piring sayur dan buah, setengah piring makanan pokok dan lauk pauk">
              <circle cx="110" cy="110" r="108" fill="var(--surface)" stroke="var(--line)" stroke-width="3" />
              <path d="M110,110 L110,10 A100,100 0 0 1 196.6,160 Z" fill="#7DBE5E" />
              <path d="M110,110 L196.6,160 A100,100 0 0 1 110,210 Z" fill="#F2A541" />
              <path d="M110,110 L110,210 A100,100 0 0 1 23.4,60 Z" fill="#F4E3B5" />
              <path d="M110,110 L23.4,60 A100,100 0 0 1 110,10 Z" fill="#E77F8C" />
              <g stroke="var(--surface)" stroke-width="3">
                <line x1="110" y1="110" x2="110" y2="10" />
                <line x1="110" y1="110" x2="196.6" y2="160" />
                <line x1="110" y1="110" x2="110" y2="210" />
                <line x1="110" y1="110" x2="23.4" y2="60" />
              </g>
              <g font-family="Inter,sans-serif" font-weight="800" font-size="11" text-anchor="middle" fill="#24313B">
                <text x="160" y="72" font-size="24">🥬</text><text x="160" y="90">Sayur</text>
                <text x="140" y="156" font-size="22">🍌</text><text x="140" y="172">Buah</text>
                <text x="62" y="140" font-size="24">🍚</text><text x="62" y="158">Makanan</text><text x="62"
                  y="170">pokok</text>
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
          <p class="tip">Setiap kali makan: setengah piring sayur dan buah, setengah piring nasi dan lauk. Makan 3 kali
            sehari ditambah 2–3 kali selingan.</p>
        </div>
        <div class="prv" id="pr-kek">
          <img class="illus" src="{{ asset('isi-piringku-kek-pmt.svg') }}"
            alt="Isi Piringku untuk ibu hamil KEK ditambah PMT: setengah piring sayur dan buah, seperempat piring makanan pokok, dan seperempat piring lauk hewani dan nabati. Makan sedikit tapi sering, 3 kali makan utama dan 2–3 kali selingan. PMT pemulihan wajib dihabiskan sendiri dalam 1 hari dan diberikan untuk pemulihan ibu KEK selama 90 hari.">
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
                  <small style="white-space:normal">{{ $log->is_done ? '✓' : '○' }}
                    {{ $log->checklistItem?->label ?? '–' }}</small>
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
