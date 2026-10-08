(function(){
  const body = document.body;
  const store = {
    get(k,d){ try{ const v = localStorage.getItem(k); return v ? JSON.parse(v) : d; }catch(e){ return d; } },
    set(k,v){ try{ localStorage.setItem(k, JSON.stringify(v)); }catch(e){} }
  };

  /* ===== Pencatatan penggunaan aplikasi ===== */
  const LOG_URL = '';
  const LOGK = 'log-penggunaan', QK = 'log-antrian';
  const devId = (() => { let d = store.get('perangkat', ''); if (!d) { d = 'HP-' + Math.random().toString(36).slice(2, 8).toUpperCase(); store.set('perangkat', d); } return d; })();
  const kode = body.dataset.user || 'UMUM';
  const menuLabel = body.dataset.menu || 'Aplikasi';
  const pad = n => String(n).padStart(2, '0');
  const stamp = d => `${d.getFullYear()}-${pad(d.getMonth()+1)}-${pad(d.getDate())} ${pad(d.getHours())}:${pad(d.getMinutes())}:${pad(d.getSeconds())}`;
  function logEv(kegiatan, ket, durasi){
    const e = {waktu: stamp(new Date()), kode: kode, perangkat: devId, kegiatan, keterangan: ket || '', durasi_detik: durasi || ''};
    const all = store.get(LOGK, []); all.push(e); store.set(LOGK, all.slice(-2000));
    const q = store.get(QK, []); q.push(e); store.set(QK, q.slice(-2000));
    kirim();
  }
  let sending = false;
  async function kirim(){
    if (!LOG_URL || sending || !navigator.onLine) return;
    const q = store.get(QK, []); if (!q.length) return;
    sending = true;
    try {
      await fetch(LOG_URL, {method:'POST', mode:'no-cors', headers:{'Content-Type':'text/plain'}, body: JSON.stringify(q)});
      const now = store.get(QK, []); store.set(QK, now.slice(q.length));
    } catch (err) {} finally { sending = false; }
  }
  window.addEventListener('online', kirim);
  setInterval(kirim, 60000);
  window.__logEval = (k, p) => logEv('kuis_selesai', ({p:'Pengetahuan', s:'Sikap', t:'Tindakan'})[k] + ' ' + p + '%');

  // Kunjungan dan lama membaca per menu
  let menuStart = Date.now(), hiddenAt = 0;
  function logBaca(){ const d = Math.round((Date.now() - menuStart)/1000); if (d >= 3) logEv('baca_menu', menuLabel, d); menuStart = Date.now(); }
  function mulaiKunjungan(){ logEv('kunjungan', 'Membuka ' + menuLabel); menuStart = Date.now(); }
  document.addEventListener('visibilitychange', () => {
    if (document.hidden) { logBaca(); hiddenAt = Date.now(); }
    else { if (Date.now() - hiddenAt > 30*60*1000) mulaiKunjungan(); else menuStart = Date.now(); }
  });
  window.addEventListener('pagehide', logBaca);
  mulaiKunjungan();

  /* Menu akun (dropdown ikon brand) */
  const brandBtn = document.getElementById('brand-btn');
  const brandDrop = document.getElementById('brand-dropdown');
  if (brandBtn && brandDrop){
    const closeDrop = () => { brandDrop.hidden = true; brandBtn.setAttribute('aria-expanded', 'false'); };
    brandBtn.addEventListener('click', e => {
      e.stopPropagation();
      const willOpen = brandDrop.hidden;
      brandDrop.hidden = !willOpen;
      brandBtn.setAttribute('aria-expanded', String(willOpen));
    });
    document.addEventListener('click', e => {
      if (!brandDrop.hidden && !brandDrop.contains(e.target) && !brandBtn.contains(e.target)) closeDrop();
    });
    document.addEventListener('keydown', e => { if (e.key === 'Escape') closeDrop(); });
  }

  /* Info sub-sections */
  const segs = document.querySelectorAll('.seg button[data-p]');
  function openPart(id){
    segs.forEach(b => b.setAttribute('aria-selected', b.dataset.p === id ? 'true' : 'false'));
    document.querySelectorAll('.part').forEach(p => p.classList.toggle('on', p.id === id));
    window.scrollTo(0,0);
  }
  segs.forEach(b => b.addEventListener('click', () => { openPart(b.dataset.p); logEv('buka_bagian', b.textContent.trim()); }));
  document.querySelectorAll('[data-goto]').forEach(b => b.addEventListener('click', () => { openPart(b.dataset.goto); if (b.dataset.scroll) { const t = document.getElementById(b.dataset.scroll); if (t) t.scrollIntoView({block:'center'}); } }));

  /* Porsi harian */
  const PORSI = [
    {i:'🍚', n:'Makanan pokok', ex:'nasi, jagung, ubi, sagu', a:5, b:6, u:'¾ gelas nasi (100 g)', z:'Sumber tenaga'},
    {i:'🐟', n:'Lauk hewani', ex:'ikan, telur, ayam, daging', a:4, b:4, u:'1 potong sedang ikan (50 g) atau 1 butir telur', z:'Protein dan zat besi'},
    {i:'🫘', n:'Lauk nabati', ex:'tempe, tahu, kacang-kacangan', a:4, b:4, u:'1 potong sedang tempe (50 g)', z:'Protein dan serat'},
    {i:'🥬', n:'Sayuran', ex:'kelor, bayam, kangkung, wortel', a:4, b:4, u:'1 mangkuk (100 g)', z:'Vitamin, mineral, serat'},
    {i:'🍌', n:'Buah-buahan', ex:'pisang, pepaya, jeruk', a:4, b:4, u:'1 potong sedang (100 g)', z:'Vitamin, mineral, serat'},
    {i:'🥄', n:'Minyak / lemak', ex:'termasuk santan, gorengan, tumisan', a:5, b:5, u:'1 sendok teh (5 g)', z:'Secukupnya', lim:true},
    {i:'🍬', n:'Gula', ex:'termasuk kue manis, teh manis', a:2, b:2, u:'1 sendok makan (10 g)', z:'Dibatasi', lim:true}
  ];
  const porsiBox = document.getElementById('porsi');
  if (porsiBox){
    const drawPorsi = tm => {
      porsiBox.innerHTML = PORSI.map(p => {
        const n = tm === 1 ? p.a : p.b, up = tm === 2 && p.b > p.a;
        let ico = '';
        for (let k = 0; k < n; k++) ico += (up && k >= p.a) ? `<span class="new">${p.i}</span>` : p.i;
        return `<div class="pr${p.lim?' lim':''}"><div class="pr-top"><b>${p.n}${up?'<span class="badge">+'+(p.b-p.a)+' porsi</span>':''}</b><span class="pr-n">${n} <small>porsi</small></span></div>
          <div class="pr-ico" aria-hidden="true">${ico}</div>
          <div class="pr-d">${p.ex}<br><em>1 porsi = ${p.u}</em> · ${p.z}</div></div>`;
      }).join('');
    };
    const tmBtns = document.querySelectorAll('[data-tm]');
    tmBtns.forEach(b => b.addEventListener('click', () => {
      tmBtns.forEach(x => x.setAttribute('aria-selected', x === b ? 'true' : 'false'));
      drawPorsi(+b.dataset.tm);
    }));
    drawPorsi(1);
  }

  /* Isi Piringku toggle */
  const prBtns = document.querySelectorAll('[data-pr]');
  prBtns.forEach(b => b.addEventListener('click', () => {
    prBtns.forEach(x => x.setAttribute('aria-selected', x === b ? 'true' : 'false'));
    document.querySelectorAll('.prv').forEach(v => v.classList.toggle('on', v.id === b.dataset.pr));
  }));

  /* Sumber per panel */
  const SRC = {
    'Siapa ibu hamil remaja?':'WHO (2023, 2024); Kemenkes RI (2022)',
    'Mengapa kehamilan remaja bisa terjadi?':'WHO (2022); UNICEF (2023)',
    'Kebutuhan gizi ibu hamil remaja':'Kemenkes RI (2019)',
    'Permasalahan yang sering dialami':'WHO (2024); Yastirin et al. (2024)',
    'Apa itu KEK pada ibu hamil?':'Kemenkes RI (2022); Widyawati & Sulistyoningtyas (2020)',
    'Penyebab dan dampak KEK pada ibu':'WHO (2022); UNICEF (2023); Kemenkes RI (2022)',
    'Penyebab dan dampak pada bayi':'UNICEF (2023); WHO (2017)',
    'Intervensi gizi pada ibu hamil KEK':'Kemenkes RI (2022)',
    'Suplementasi gizi':'Kemenkes RI (2022, 2024)',
    'Sumber gizi utama ibu hamil remaja':'Kemenkes RI (2022, 2023b)',
    'Porsi makan harian ibu hamil remaja':'Kemenkes RI (2023b)',
    'Mencegah KEK pada ibu hamil':'Kemenkes RI (2022, 2023a)',
    'Isi Piringku':'Kemenkes RI (2014); Kemenkes RI (2022)',
    'Cara mengukur':'Nugraha et al. (2019); Suryadi et al. (2023)',
    'Tempat periksa kehamilan':'Kemenkes RI (2024)',
    'Tablet tambah darah (TTD)':'Kemenkes RI (2022, 2024)',
    'Makanan tambahan (PMT)':'Kemenkes RI (2022)',
    'Segera ke bidan atau puskesmas bila':'Kemenkes RI (2024)',
    'Tips cegah KEK':'Kemenkes RI (2022)',
    'Menu gizi ibu hamil':'Kemenkes RI (2023b)',
    'Menu gizi harian ibu hamil KEK':'Kemenkes RI (2022, 2023b)',
    'Pentingnya pemeriksaan kehamilan':'Kemenkes RI (2024)',
    'Jadwal pemeriksaan kehamilan':'Kemenkes RI (2024)',
    'Tips meningkatkan nafsu makan':'Kemenkes RI (2022)',
    'Aktivitas fisik dan istirahat':'Kemenkes RI (2024)',
    'Peran keluarga':'UNICEF (2023); Kemenkes RI (2024)',
    'Mitos dan fakta':'Kemenkes RI (2022)'
  };
  document.querySelectorAll('.panel > h3, details.acc > summary').forEach(h => {
    const key = h.textContent.replace(/^[^A-Za-z0-9]+/, '').replace(/^\d+/, '').trim();
    const src = SRC[key]; if (!src) return;
    const box = h.tagName === 'SUMMARY' ? h.parentElement.querySelector('.acc-b') : h.parentElement;
    const pEl = document.createElement('p'); pEl.className = 'srcl';
    pEl.innerHTML = `Sumber: ${src}. <a href="#pustaka" data-pustaka>Daftar pustaka</a>`;
    box.appendChild(pEl);
  });
  document.addEventListener('click', e => {
    const a = e.target.closest('[data-pustaka]'); if (!a) return;
    e.preventDefault();
    const d = document.getElementById('pustaka');
    if (d) { d.open = true; d.scrollIntoView({block:'start'}); }
    else { window.location.href = '/menarik#pustaka'; }
  });
  if (location.hash === '#pustaka') {
    const d = document.getElementById('pustaka');
    if (d) { d.open = true; d.scrollIntoView({block:'start'}); }
  }
  /* Daftar isi */
  document.querySelectorAll('.toc a').forEach(a => a.addEventListener('click', e => {
    e.preventDefault(); const t = document.querySelector(a.getAttribute('href')); if (t) t.scrollIntoView({block:'start'});
  }));

  /* Panel peneliti: ketuk judul aplikasi 5 kali */
  const logOvl = document.getElementById('log-ovl');
  const h1 = document.querySelector('header.top h1');
  const esc = t => String(t).replace(/[&<>"]/g, c => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;'}[c]));
  function bukaLog(){
    const all = store.get(LOGK, []);
    const kunj = all.filter(e => e.kegiatan === 'kunjungan').length;
    const det = all.filter(e => e.kegiatan === 'baca_menu').reduce((a, e) => a + (+e.durasi_detik || 0), 0);
    const last = all.length ? all[all.length-1].waktu : '–';
    const antri = store.get(QK, []).length;
    document.getElementById('log-sum').innerHTML =
      `<div><b>${esc(kode)}</b><small>Pengguna (${devId})</small></div>` +
      `<div><b>${kunj}</b><small>Jumlah kunjungan</small></div>` +
      `<div><b>${Math.round(det/60)} menit</b><small>Total lama membaca</small></div>` +
      `<div><b style="font-size:.95rem">${esc(last)}</b><small>Aktivitas terakhir</small></div>`;
    document.getElementById('log-rows').innerHTML = all.slice().reverse().slice(0, 300).map(e =>
      `<tr><td>${esc(e.waktu)}</td><td>${esc(e.kegiatan.replace('_', ' '))}</td><td>${esc(e.keterangan)}${e.durasi_detik ? ' (' + e.durasi_detik + ' dtk)' : ''}</td></tr>`).join('') || '<tr><td colspan="3">Belum ada data.</td></tr>';
    document.getElementById('log-msg').textContent = LOG_URL ? (antri ? `${antri} data menunggu dikirim (perlu internet).` : 'Semua data sudah terkirim ke Google Sheets.') : 'Pengiriman otomatis belum diaktifkan. Gunakan tombol Salin atau Kirim.';
    logOvl.hidden = false;
  }
  function csv(){
    const all = store.get(LOGK, []);
    const head = 'waktu,kode,perangkat,kegiatan,keterangan,durasi_detik';
    return [head].concat(all.map(e => [e.waktu, e.kode, e.perangkat, e.kegiatan, e.keterangan, e.durasi_detik].map(v => '"' + String(v).replace(/"/g, '""') + '"').join(','))).join('\n');
  }
  if (logOvl && h1){
    let taps = 0, tapT = 0;
    h1.addEventListener('click', () => {
      const n = Date.now(); taps = (n - tapT < 1500) ? taps + 1 : 1; tapT = n;
      if (taps >= 5) { taps = 0; bukaLog(); }
    });
    document.getElementById('log-close').onclick = () => logOvl.hidden = true;
    document.getElementById('log-copy').onclick = async () => {
      const m = document.getElementById('log-msg');
      try { await navigator.clipboard.writeText(csv()); m.textContent = 'Data tersalin. Tempelkan ke Excel atau WhatsApp.'; }
      catch (e) { m.textContent = 'Gagal menyalin. Gunakan tombol Kirim.'; }
    };
    document.getElementById('log-share').onclick = async () => {
      const teks = 'Data penggunaan Infogizi - ' + kode + '\n' + csv();
      if (navigator.share) { try { await navigator.share({title:'Data penggunaan Infogizi', text: teks}); } catch (e) {} }
      else { window.open('https://wa.me/?text=' + encodeURIComponent(teks.slice(0, 6000)), '_blank'); }
    };
  }

  /* Checklist */
  const items = ['Makan 3 kali dan 2 kali selingan','Ada lauk hewani (ikan/telur/daging)','Makan sayur dan buah','Minum tablet tambah darah','Minum air putih minimal 8 gelas'];
  const ul = document.getElementById('checklist');
  if (ul){
    const today = new Date().toISOString().slice(0,10);
    let chk = store.get('chk', {});
    if (chk.date !== today) chk = {date: today, done: []};
    const drawChk = () => {
      ul.innerHTML = items.map((t,i) => `<li><label><input type="checkbox" data-i="${i}" ${chk.done.includes(i)?'checked':''}>${t}</label></li>`).join('');
      const n = chk.done.length;
      document.getElementById('chk-bar').style.width = (n/items.length*100)+'%';
      document.getElementById('chk-msg').textContent = n === items.length ? 'Semua target tercapai hari ini. Pertahankan besok!' : `${n} dari ${items.length} target tercapai.`;
    };
    ul.addEventListener('change', e => {
      const i = +e.target.dataset.i;
      chk.done = e.target.checked ? [...new Set([...chk.done, i])] : chk.done.filter(x => x !== i);
      store.set('chk', chk); drawChk();
    });
    drawChk();
  }

  /* Kuis: pengetahuan, sikap, perilaku */
  const KQ = [
    {ind:'Pengertian KEK', q:'Rina hamil 5 bulan. Hasil ukur LILA-nya 22 cm. Artinya…', o:['Rina tidak berisiko KEK','Rina berisiko KEK dan perlu segera ke bidan','Rina kelebihan berat badan'], a:1, e:'LILA di bawah 23,5 cm menandakan risiko KEK. Rina perlu segera diperiksa bidan dan mendapat makanan tambahan.'},
    {ind:'Penyebab KEK', q:'Kebiasaan mana yang dapat menyebabkan KEK?', o:['Makan 3 kali sehari dengan lauk','Sering melewatkan makan dan jarang makan lauk hewani','Minum air putih 8 gelas sehari'], a:1, e:'Makan tidak teratur dan kurang protein dalam waktu lama membuat tubuh kekurangan energi dan protein.'},
    {ind:'Faktor risiko KEK', q:'Siapa yang paling berisiko mengalami KEK?', o:['Ibu hamil usia 17 tahun yang sering tidak sarapan','Ibu hamil usia 25 tahun yang makan teratur','Ibu hamil usia 28 tahun yang rutin periksa'], a:0, e:'Usia di bawah 20 tahun dan pola makan tidak teratur adalah dua faktor risiko KEK.'},
    {ind:'Dampak KEK pada ibu', q:'Ibu hamil KEK sering lemas dan pucat karena berisiko mengalami…', o:['Anemia (kurang darah)','Kelebihan gizi','Kencing manis'], a:0, e:'KEK sering disertai anemia, sehingga ibu mudah lelah, pucat, dan pusing.'},
    {ind:'Dampak KEK pada bayi', q:'Jika tidak ditangani, anak dari ibu KEK berisiko mengalami… saat tumbuh besar.', o:['Stunting (tubuh lebih pendek dari seusianya)','Tumbuh lebih tinggi dari temannya','Lebih cepat tumbuh gigi'], a:0, e:'Bayi dari ibu KEK berisiko lahir dengan berat rendah dan mengalami stunting.'},
    {ind:'Pencegahan: gizi seimbang', q:'Isi piring yang dianjurkan setiap kali makan adalah…', o:['Setengah piring nasi, sisanya kerupuk','Setengah piring sayur dan buah, setengah piring nasi dan lauk','Sepiring penuh nasi dengan sedikit lauk'], a:1, e:'Isi Piringku: setengah piring sayur dan buah, setengah piring makanan pokok dan lauk pauk.'},
    {ind:'Pencegahan: TTD', q:'Tablet tambah darah sebaiknya diminum bersama…', o:['Teh manis','Kopi','Air putih atau jus jeruk'], a:2, e:'Teh, kopi, dan susu menghambat penyerapan zat besi. Air putih atau jus jeruk membantu.'},
    {ind:'Pencegahan: ANC', q:'Selama hamil, ibu sebaiknya memeriksakan kehamilan minimal…', o:['2 kali','4 kali','6 kali'], a:2, e:'Minimal 6 kali: 2 kali di trimester 1, 1 kali di trimester 2, dan 3 kali di trimester 3.'},
    {ind:'Pencegahan: ukur LILA', q:'Pita LILA dilingkarkan di bagian…', o:['Pergelangan tangan','Titik tengah antara bahu dan siku lengan kiri','Betis'], a:1, e:'Pita LILA dilingkarkan di titik tengah antara bahu dan siku, biasanya lengan kiri.'},
    {ind:'Pencegahan: PMT', q:'Jika LILA ibu di bawah 23,5 cm, bantuan gizi yang dapat diperoleh dari puskesmas adalah…', o:['Makanan tambahan (PMT)','Vitamin rambut','Obat pelangsing'], a:0, e:'Ibu hamil KEK berhak mendapat PMT berbahan pangan lokal dari puskesmas.'},
    {ind:'Suplementasi gizi', q:'Tablet tambah darah (TTD) untuk ibu hamil berisi…', o:['Zat besi dan asam folat','Vitamin C saja','Kalsium dan gula'], a:0, e:'TTD berisi zat besi dan asam folat untuk mencegah anemia dan mendukung pembentukan saraf janin.'},
    {ind:'Sumber gizi utama', q:'Kelompok makanan yang kaya zat besi adalah…', o:['Teh dan kopi','Hati ayam, ikan, dan daun kelor','Kerupuk dan permen'], a:1, e:'Hati ayam, ikan, daging, dan sayuran hijau seperti daun kelor kaya zat besi.'},
    {ind:'Isi Piringku ibu hamil KEK', q:'Anjuran makan yang tepat bagi ibu hamil KEK adalah…', o:['Makan sekali sehari dengan porsi besar','Mengurangi lauk agar tidak mual','Makan sedikit tapi sering, tambah lauk hewani, dan habiskan PMT'], a:2, e:'Ibu hamil KEK dianjurkan makan lebih sering dengan tambahan lauk hewani dan PMT sebagai selingan.'}
  ];
  const SO = ['Sangat setuju','Setuju','Tidak setuju','Sangat tidak setuju'];
  const SQ = [
    {asp:'Kognitif', s:'Mengukur LILA secara rutin penting agar risiko KEK cepat diketahui.', fav:true, good:'Tepat. Dengan mengukur LILA, risiko KEK bisa ditangani lebih awal.', bad:'KEK sering tidak terlihat dari luar. Mengukur LILA membantu Ibu mengetahuinya lebih awal.'},
    {asp:'Kognitif', s:'Selama badan tidak terlihat kurus, ibu hamil tidak perlu khawatir terkena KEK.', fav:false, good:'Tepat. KEK bisa terjadi walau badan tidak terlihat kurus.', bad:'KEK bisa terjadi walau badan tidak terlihat kurus. Cara memastikannya adalah mengukur LILA.'},
    {asp:'Afektif', s:'Saya merasa senang ketika berhasil makan lauk ikan atau telur hari ini.', fav:true, good:'Bagus! Rasa senang ini membantu Ibu menjadikan lauk hewani sebagai kebiasaan.', bad:'Tidak apa-apa. Coba mulai dari satu lauk hewani yang Ibu sukai, misalnya telur atau ikan bakar.'},
    {asp:'Afektif', s:'Saya merasa malu memeriksakan kehamilan karena usia saya masih muda.', fav:false, good:'Hebat. Memeriksakan kehamilan adalah tanda Ibu peduli pada diri dan bayi.', bad:'Perasaan itu wajar. Bidan siap membantu tanpa menghakimi, dan pemeriksaan penting untuk Ibu dan bayi.'},
    {asp:'Konatif', s:'Saya mau bertanya kepada bidan jika ragu tentang makanan yang boleh dimakan saat hamil.', fav:true, good:'Tepat. Bertanya ke bidan lebih aman daripada mengikuti kata orang.', bad:'Bidan adalah sumber informasi yang paling tepat. Simpan nomornya di menu Layanan supaya mudah dihubungi.'},
    {asp:'Konatif', s:'Saya akan berhenti minum TTD jika merasa mual, tanpa bertanya ke bidan.', fav:false, good:'Tepat. Jika mual, tanyakan ke bidan. TTD bisa diminum malam sebelum tidur.', bad:'Jangan berhenti sendiri. Tanyakan ke bidan; TTD bisa diminum malam sebelum tidur agar mual berkurang.'}
  ];
  const PO = ['Setiap hari','4–6 hari','1–3 hari','Tidak pernah'];
  const PQ = [
    {ind:'Tindakan: gizi seimbang', q:'sarapan sebelum beraktivitas?', tip:'Sarapan memberi tenaga untuk Ibu dan janin. Coba siapkan nasi dan telur sejak malam.'},
    {ind:'Tindakan: gizi seimbang', q:'makan lauk hewani (ikan, telur, ayam, atau daging)?', tip:'Usahakan ada lauk hewani setiap hari. Ikan dan telur mudah didapat dan terjangkau.'},
    {ind:'Tindakan: gizi seimbang', q:'makan sayur dan buah?', tip:'Isi setengah piring dengan sayur dan buah, misalnya sayur kelor dan pisang.'},
    {ind:'Tindakan: gizi seimbang', q:'makan selingan sehat di antara makan utama?', tip:'Selingan seperti bubur kacang hijau atau buah membantu memenuhi tambahan porsi.'},
    {ind:'Tindakan: kepatuhan anjuran', q:'minum tablet tambah darah (TTD)?', tip:'TTD perlu diminum 1 tablet setiap hari. Pasang pengingat di ponsel agar tidak lupa.'},
    {ind:'Tindakan: kepatuhan anjuran', q:'tetap makan makanan bergizi (ikan, telur, sayur) tanpa berpantang karena mitos?', tip:'Ikan, telur, dan sayur aman dan penting untuk Ibu hamil. Lihat menu Info Menarik untuk fakta selengkapnya.'}
  ];

  const evalBox = document.getElementById('evalbox');
  const qbox = document.getElementById('quiz');
  if (evalBox && qbox){
    const cat = p => p >= 76 ? ['Baik','g'] : p >= 56 ? ['Cukup','c'] : ['Perlu ditingkatkan','r'];
    function drawEval(){
      const e = store.get('eval', {});
      const row = (k,l) => { const v = e[k]; if (!v) return `<div class="ev"><b>${l}</b><span class="ev-n">–</span><small>Belum dikerjakan</small></div>`;
        const [c,cl] = cat(v.p); return `<div class="ev"><b>${l}</b><span class="ev-n ${cl}">${v.p}%</span><small class="${cl}">${c}</small><small>${v.d}</small></div>`; };
      evalBox.innerHTML = `<h3>Hasil evaluasi saya</h3><div class="evg">${row('p','Pengetahuan')}${row('s','Sikap')}${row('t','Tindakan')}</div><p class="tip">Baik: 76–100%, Cukup: 56–75%, Perlu ditingkatkan: di bawah 56%.</p>`;
    }
    function saveEval(k,p){ if (window.__logEval) window.__logEval(k,p); const e = store.get('eval', {}); e[k] = {p, d:new Date().toLocaleDateString('id-ID',{day:'numeric',month:'short'})}; store.set('eval', e); drawEval(); }
    drawEval();
    let qmode = 'p', qi = 0, score = 0;
    const bar = (i,n) => `<div class="progress"><i style="width:${i/n*100}%"></i></div>`;
    const meta = (l,i,n,r) => `<div class="q-meta"><span>${l} ${i+1} dari ${n}</span><span>${r||''}</span></div>`;
    function endBox(big, msg, extra){
      qbox.innerHTML = `<div style="text-align:center"><div class="score">${big}</div><p style="margin:10px 0 12px;font-weight:700">${msg}</p></div>${extra||''}<div style="text-align:center;margin-top:12px"><button class="btn" id="q-again">Ulangi</button></div>`;
      document.getElementById('q-again').onclick = () => { qi = 0; score = 0; drawQ(); };
    }
    function answerUI(opts, onPick){
      qbox.querySelectorAll('.opt').forEach(b => b.onclick = () => onPick(+b.dataset.i, b));
    }
    function nextBtn(ex, last, label){
      ex.innerHTML += `<div style="margin-top:10px"><button class="btn" id="q-next">${last ? label : 'Berikutnya'}</button></div>`;
      ex.classList.add('on');
      document.getElementById('q-next').onclick = () => { qi++; drawQ(); };
    }
    const missed = [];
    function drawQ(){
      if (qmode === 'p'){
        if (qi >= KQ.length){
          const msg = score >= 11 ? 'Hebat! Pengetahuan Ibu tentang KEK sudah sangat baik.' : score >= 8 ? 'Bagus. Baca lagi menu Informasi untuk soal yang belum tepat.' : 'Yuk pelajari lagi menu Informasi, lalu coba sekali lagi.';
          saveEval('p', Math.round(score/KQ.length*100));
          return endBox(`${score}/${KQ.length}`, msg);
        }
        const x = KQ[qi];
        qbox.innerHTML = meta('Soal',qi,KQ.length,'Skor '+score)+bar(qi,KQ.length)+`<span class="qtag">${x.ind}</span><h3>${x.q}</h3><div class="opts">${x.o.map((o,i)=>`<button class="opt" data-i="${i}">${o}</button>`).join('')}</div><div class="explain" id="ex"></div>`;
        answerUI(x.o, pick => {
          const ok = pick === x.a; if (ok) score++;
          qbox.querySelectorAll('.opt').forEach((o,i) => { o.disabled = true; if (i === x.a) o.classList.add('right'); else if (i === pick) o.classList.add('wrong'); });
          const ex = document.getElementById('ex'); ex.innerHTML = `<b>${ok?'Benar.':'Belum tepat.'}</b> ${x.e}`;
          nextBtn(ex, qi === KQ.length-1, 'Lihat skor');
        });
      } else if (qmode === 's'){
        if (qi >= SQ.length){
          const pct = Math.round(score / (SQ.length*4) * 100); saveEval('s', pct);
          const msg = pct >= 75 ? 'Sikap Ibu sangat mendukung pencegahan KEK. Pertahankan!' : pct >= 50 ? 'Sikap Ibu cukup mendukung. Baca lagi penjelasan pada pernyataan yang masih ragu.' : 'Masih ada sikap yang perlu diperkuat. Diskusikan dengan bidan atau keluarga, ya.';
          return endBox(`${pct}%`, msg);
        }
        const x = SQ[qi];
        qbox.innerHTML = meta('Pernyataan',qi,SQ.length)+bar(qi,SQ.length)+`<span class="qtag">Sikap ${x.asp.toLowerCase()}</span><p class="qhint">Seberapa setuju Ibu dengan pernyataan ini?</p><h3>“${x.s}”</h3><div class="opts">${SO.map((o,i)=>`<button class="opt" data-i="${i}">${o}</button>`).join('')}</div><div class="explain" id="ex"></div>`;
        answerUI(SO, (pick, btn) => {
          const positive = x.fav ? pick <= 1 : pick >= 2;
          score += x.fav ? 4 - pick : pick + 1;
          qbox.querySelectorAll('.opt').forEach(o => o.disabled = true);
          btn.classList.add(positive ? 'right' : 'wrong');
          const ex = document.getElementById('ex'); ex.innerHTML = positive ? x.good : x.bad;
          nextBtn(ex, qi === SQ.length-1, 'Lihat hasil');
        });
      } else {
        if (qi === 0) missed.length = 0;
        if (qi >= PQ.length){
          const good = PQ.length - missed.length; saveEval('t', Math.round(score/(PQ.length*3)*100));
          const hist = store.get('perilaku', []); hist.push({d:new Date().toLocaleDateString('id-ID',{day:'numeric',month:'short'}), s:score}); store.set('perilaku', hist.slice(-8));
          const prev = hist.length > 1 ? `<p class="tip" style="text-align:center">Hasil sebelumnya: ${Math.round(hist[hist.length-2].s/(PQ.length*3)*100)}% (${hist[hist.length-2].d})</p>` : '';
          const list = missed.length ? `<div class="explain on"><b>Kebiasaan yang perlu ditingkatkan:</b><ul style="margin:6px 0 0;padding-left:18px">${missed.map(m=>`<li>${m}</li>`).join('')}</ul></div>` : '';
          return endBox(`${Math.round(score/(PQ.length*3)*100)}%`, missed.length ? `${good} dari ${PQ.length} kebiasaan baik sudah rutin Ibu lakukan.` : 'Luar biasa! Semua kebiasaan baik sudah rutin Ibu lakukan.', prev + list);
        }
        const x = PQ[qi];
        qbox.innerHTML = meta('Pertanyaan',qi,PQ.length)+bar(qi,PQ.length)+`<span class="qtag">${x.ind}</span><p class="qhint">Dalam 7 hari terakhir, berapa hari Ibu…</p><h3>${x.q}</h3><div class="opts">${PO.map((o,i)=>`<button class="opt" data-i="${i}">${o}</button>`).join('')}</div><div class="explain" id="ex"></div>`;
        answerUI(PO, (pick, btn) => {
          score += 3 - pick;
          qbox.querySelectorAll('.opt').forEach(o => o.disabled = true);
          btn.classList.add(pick === 0 ? 'right' : 'wrong');
          if (pick > 0) missed.push(x.q.charAt(0).toUpperCase() + x.q.slice(1).replace('?',''));
          const ex = document.getElementById('ex'); ex.innerHTML = pick === 0 ? '<b>Hebat!</b> Pertahankan kebiasaan ini setiap hari.' : `<b>Ayo tingkatkan.</b> ${x.tip}`;
          nextBtn(ex, qi === PQ.length-1, 'Lihat hasil');
        });
      }
    }
    const qsBtns = document.querySelectorAll('[data-qs]');
    qsBtns.forEach(b => b.addEventListener('click', () => {
      qsBtns.forEach(x => x.setAttribute('aria-selected', x === b ? 'true' : 'false'));
      qmode = b.dataset.qs; qi = 0; score = 0; drawQ();
    }));
    drawQ();
  }

  /* LILA tape */
  const tape = document.getElementById('tape');
  if (tape){
    const MIN = 18, MAX = 34, CUT = 23.5;
    const pct = v => ((v - MIN) / (MAX - MIN) * 100);
    tape.style.setProperty('--cut', pct(CUT) + '%');
    let html = '';
    for (let v = MIN; v <= MAX; v += 0.5){
      const major = Number.isInteger(v);
      html += `<div class="tick ${major?'m':'s'}" style="left:${pct(v)}%"></div>`;
      if (major && v % 2 === 0) html += `<div class="tlabel" style="left:${pct(v)}%">${v}</div>`;
    }
    html += `<div class="cutline" style="left:calc(${pct(CUT)}% - 1.5px)"><span>23,5 cm</span></div>`;
    tape.insertAdjacentHTML('beforeend', html);
    const range = document.getElementById('lila-range'), num = document.getElementById('lila-num');
    const marker = document.getElementById('marker'), res = document.getElementById('lila-result');
    const fmt = v => v.toFixed(1).replace('.', ',');
    function show(v){
      if (isNaN(v)) return;
      marker.style.left = Math.min(100, Math.max(0, pct(v))) + '%';
      if (v < CUT){
        res.className = 'result risk';
        res.innerHTML = `<h3>${fmt(v)} cm: berisiko KEK</h3>Segera temui bidan atau puskesmas untuk pemeriksaan dan makanan tambahan (PMT). Tambah porsi lauk hewani dan minum TTD setiap hari.`;
      } else {
        res.className = 'result ok';
        res.innerHTML = `<h3>${fmt(v)} cm: tidak berisiko KEK</h3>Pertahankan makan gizi seimbang, minum TTD setiap hari, dan ukur LILA lagi saat periksa kehamilan.`;
      }
    }
    range.oninput = () => { num.value = range.value; show(+range.value); };
    num.oninput = () => { const v = parseFloat(num.value); if (!isNaN(v)) { range.value = Math.min(MAX, Math.max(MIN, v)); show(v); } };
    show(23.5);

    let hist = store.get('lila', []);
    const hul = document.getElementById('lila-hist');
    function drawHist(){
      hul.innerHTML = hist.length ? hist.slice().reverse().map(h => `<li><span>${h.d}</span><span class="${h.v < CUT ? 'r' : 'g'}">${fmt(h.v)} cm</span></li>`).join('') : '<li><span>Belum ada hasil tersimpan. Simpan hasil pertamamu untuk memantau perubahan.</span></li>';
    }
    document.getElementById('lila-save').onclick = () => {
      const v = parseFloat(num.value);
      if (isNaN(v) || v < 15 || v > 45){ res.className='result risk'; res.innerHTML = '<h3>Angka belum sesuai</h3>Masukkan hasil LILA antara 15 dan 45 cm.'; return; }
      hist.push({d: new Date().toLocaleDateString('id-ID',{day:'numeric',month:'short',year:'numeric'}), v});
      hist = hist.slice(-12); store.set('lila', hist); drawHist();
      logEv('simpan_lila', v.toFixed(1).replace('.', ',') + ' cm');
    };
    document.getElementById('lila-clear').onclick = () => { hist = []; store.set('lila', hist); drawHist(); };
    drawHist();
  }

  /* Bidan contact */
  const bi = document.getElementById('bidan');
  if (bi){
    const bl = document.getElementById('bidan-link');
    function drawBidan(){
      const n = store.get('bidan', '');
      bi.value = n;
      bl.innerHTML = n ? `Tersimpan. <a href="tel:${n.replace(/[^0-9+]/g,'')}" style="color:var(--danau);font-weight:800">Telepon bidan</a>` : '';
    }
    document.getElementById('bidan-save').onclick = () => { store.set('bidan', bi.value.trim()); drawBidan(); };
    drawBidan();
  }

  /* Myths */
  const M = [
    ['Ibu hamil harus makan dua kali lipat porsi biasa.','Yang dibutuhkan tambahan sekitar 180–300 kkal per hari, setara satu porsi kecil nasi dan lauk. Yang penting kualitas dan keragaman makanannya.'],
    ['Makan ikan saat hamil membuat bayi berbau amis.','Ikan adalah sumber protein dan lemak sehat untuk pertumbuhan otak janin. Tidak ada hubungan dengan bau badan bayi.'],
    ['Tablet tambah darah membuat bayi terlalu besar dan sulit lahir.','TTD mencegah anemia dan membantu suplai oksigen ke janin. TTD tidak membuat bayi terlalu besar.'],
    ['Kalau badan tidak terlihat kurus, pasti tidak KEK.','KEK bisa tidak terlihat dari luar. Cara pastinya adalah mengukur LILA dengan pita.'],
    ['Remaja yang hamil cukup makan seperti biasa.','Tubuh remaja masih tumbuh, jadi kebutuhan gizinya justru lebih tinggi dibanding ibu hamil dewasa.']
  ];
  const mb = document.getElementById('myths');
  if (mb){
    mb.innerHTML = M.map(([m,f]) => `<button class="myth" aria-expanded="false"><div class="m"><span class="tag">Mitos</span><p>${m}</p><div class="hint">Ketuk untuk lihat fakta</div></div><div class="f"><span class="tag">Fakta</span><p>${f}</p></div></button>`).join('');
    mb.addEventListener('click', e => { const b = e.target.closest('.myth'); if (!b) return; b.classList.toggle('open'); b.setAttribute('aria-expanded', b.classList.contains('open')); });
  }

  /* Section logging (accordion) */
  document.querySelectorAll('details.acc').forEach(d => d.addEventListener('toggle', () => { if (d.open) logEv('buka_topik', d.querySelector('summary').textContent.replace(/^[^A-Za-z0-9]+/, '').trim()); }));
})();
