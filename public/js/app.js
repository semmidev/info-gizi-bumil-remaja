(function(){
  const body = document.body;
  const DATA = window.__DATA || {};
  const csrf = document.querySelector('meta[name="csrf-token"]')?.content || '';

  async function api(method, url, payload){
    const res = await fetch(url, {
      method,
      credentials: 'same-origin',
      headers: {'Content-Type':'application/json', 'Accept':'application/json', 'X-CSRF-TOKEN': csrf},
      body: payload === undefined ? undefined : JSON.stringify(payload)
    });
    if (!res.ok) throw new Error('HTTP ' + res.status);
    const text = await res.text();
    return text ? JSON.parse(text) : null;
  }

  /* ===== Pencatatan penggunaan aplikasi ===== */
  const QK = 'log-antrian';
  const deviceId = (() => {
    let d = '';
    try { d = localStorage.getItem('perangkat') || ''; } catch(e){}
    if (!d) { d = 'HP-' + Math.random().toString(36).slice(2, 8).toUpperCase(); try { localStorage.setItem('perangkat', d); } catch(e){} }
    return d;
  })();
  const menuLabel = body.dataset.menu || 'Aplikasi';
  let queue = [];
  try { queue = JSON.parse(localStorage.getItem(QK) || '[]'); } catch(e){ queue = []; }

  function logEv(event, description, duration){
    queue.push({event, description: description || '', duration_seconds: duration || null});
    if (queue.length > 500) queue = queue.slice(-500);
    try { localStorage.setItem(QK, JSON.stringify(queue)); } catch(e){}
    flush();
  }
  let sending = false;
  async function flush(){
    if (sending || !queue.length || !navigator.onLine) return;
    sending = true;
    const batch = queue.slice();
    try {
      await api('POST', '/api/activity', {device_id: deviceId, events: batch});
      queue = queue.slice(batch.length);
      try { localStorage.setItem(QK, JSON.stringify(queue)); } catch(e){}
    } catch(e) {} finally { sending = false; }
  }
  window.addEventListener('online', flush);
  setInterval(flush, 30000);

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
  const esc = t => String(t == null ? '' : t).replace(/[&<>"]/g, c => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;'}[c]));
  let logRows = [];
  async function bukaLog(){
    logOvl.hidden = false;
    document.getElementById('log-sum').innerHTML = '<div><b>…</b><small>Memuat data</small></div>';
    document.getElementById('log-rows').innerHTML = '<tr><td colspan="3">Memuat…</td></tr>';
    try {
      const res = await api('GET', '/api/activity');
      const s = res.summary || {};
      logRows = res.rows || [];
      document.getElementById('log-sum').innerHTML =
        `<div><b>${esc(s.user)}</b><small>Pengguna (${deviceId})</small></div>` +
        `<div><b>${esc(s.kunjungan)}</b><small>Jumlah kunjungan</small></div>` +
        `<div><b>${esc(s.minutes)} menit</b><small>Total lama membaca</small></div>` +
        `<div><b style="font-size:.95rem">${esc(s.last)}</b><small>Aktivitas terakhir</small></div>`;
      document.getElementById('log-rows').innerHTML = logRows.map(r =>
        `<tr><td>${esc(r.waktu)}</td><td>${esc(String(r.kegiatan).replace('_', ' '))}</td><td>${esc(r.keterangan)}${r.durasi_detik ? ' (' + r.durasi_detik + ' dtk)' : ''}</td></tr>`).join('') || '<tr><td colspan="3">Belum ada data.</td></tr>';
      document.getElementById('log-msg').textContent = 'Data tersimpan di server. Gunakan tombol Salin atau Kirim untuk mengekspor.';
    } catch(e) {
      document.getElementById('log-msg').textContent = 'Gagal memuat data. Periksa koneksi.';
      document.getElementById('log-rows').innerHTML = '<tr><td colspan="3">Gagal memuat.</td></tr>';
    }
  }
  function csv(){
    const head = 'waktu,kegiatan,keterangan,durasi_detik';
    return [head].concat(logRows.map(r => [r.waktu, r.kegiatan, r.keterangan, r.durasi_detik].map(v => '"' + String(v == null ? '' : v).replace(/"/g, '""') + '"').join(','))).join('\n');
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
      catch(e) { m.textContent = 'Gagal menyalin. Gunakan tombol Kirim.'; }
    };
    document.getElementById('log-share').onclick = async () => {
      const teks = 'Data penggunaan Infogizi\n' + csv();
      if (navigator.share) { try { await navigator.share({title:'Data penggunaan Infogizi', text: teks}); } catch(e) {} }
      else { window.open('https://wa.me/?text=' + encodeURIComponent(teks.slice(0, 6000)), '_blank'); }
    };
  }

  /* Checklist (Target saya hari ini) */
  const TARGETS = DATA.targets || [];
  const ul = document.getElementById('checklist');
  if (ul){
    const drawChk = () => {
      ul.innerHTML = TARGETS.map((t,i) => `<li><label><input type="checkbox" data-i="${i}" ${t.done?'checked':''}>${t.label}</label></li>`).join('');
      const n = TARGETS.filter(t => t.done).length;
      document.getElementById('chk-bar').style.width = (TARGETS.length ? n/TARGETS.length*100 : 0)+'%';
      document.getElementById('chk-msg').textContent = (n === TARGETS.length && TARGETS.length) ? 'Semua target tercapai hari ini. Pertahankan besok!' : `${n} dari ${TARGETS.length} target tercapai.`;
    };
    ul.addEventListener('change', e => {
      const i = +e.target.dataset.i;
      const t = TARGETS[i]; if (!t) return;
      t.done = e.target.checked;
      drawChk();
      api('PUT', '/api/target', {checklist_item_id: t.id, is_done: t.done}).catch(() => {});
    });
    drawChk();
  }

  /* Kuis: pengetahuan, sikap, tindakan */
  const QUIZ = DATA.quiz || {pengetahuan:[], sikap:[], tindakan:[]};
  const KQ = QUIZ.pengetahuan, SQ = QUIZ.sikap, PQ = QUIZ.tindakan;
  const EVAL = DATA.eval || {p:null, s:null, t:null};
  const PERILAKU = DATA.perilaku || [];
  const TYPE_OF = {p:'pengetahuan', s:'sikap', t:'tindakan'};

  const evalBox = document.getElementById('evalbox');
  const qbox = document.getElementById('quiz');
  if (evalBox && qbox){
    const cat = p => p >= 76 ? ['Baik','g'] : p >= 56 ? ['Cukup','c'] : ['Perlu ditingkatkan','r'];
    function drawEval(){
      const row = (k,l) => { const v = EVAL[k]; if (!v) return `<div class="ev"><b>${l}</b><span class="ev-n">–</span><small>Belum dikerjakan</small></div>`;
        const [c,cl] = cat(v.percentage); return `<div class="ev"><b>${l}</b><span class="ev-n ${cl}">${v.percentage}%</span><small class="${cl}">${c}</small><small>${v.date}</small></div>`; };
      evalBox.innerHTML = `<h3>Hasil evaluasi saya</h3><div class="evg">${row('p','Pengetahuan')}${row('s','Sikap')}${row('t','Tindakan')}</div><p class="tip">Baik: 76–100%, Cukup: 56–75%, Perlu ditingkatkan: di bawah 56%.</p>`;
    }
    async function saveEval(k, raw){
      logEv('kuis_selesai', ({p:'Pengetahuan', s:'Sikap', t:'Tindakan'})[k] + ': ' + raw);
      try {
        const res = await api('POST', '/api/quiz-attempt', {type: TYPE_OF[k], raw_score: raw});
        EVAL[k] = {percentage: res.percentage, date: res.date};
        if (k === 't') { PERILAKU.push({percentage: res.percentage, date: res.date}); if (PERILAKU.length > 8) PERILAKU.shift(); }
        drawEval();
      } catch(e) {}
    }
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
          saveEval('p', score);
          return endBox(`${score}/${KQ.length}`, msg);
        }
        const x = KQ[qi];
        const opts = x.options.map(o => o.label);
        const ai = x.options.findIndex(o => o.correct);
        qbox.innerHTML = meta('Soal',qi,KQ.length,'Skor '+score)+bar(qi,KQ.length)+`<span class="qtag">${x.indicator}</span><h3>${x.text}</h3><div class="opts">${opts.map((o,i)=>`<button class="opt" data-i="${i}">${o}</button>`).join('')}</div><div class="explain" id="ex"></div>`;
        answerUI(opts, pick => {
          const ok = pick === ai; if (ok) score++;
          qbox.querySelectorAll('.opt').forEach((o,i) => { o.disabled = true; if (i === ai) o.classList.add('right'); else if (i === pick) o.classList.add('wrong'); });
          const ex = document.getElementById('ex'); ex.innerHTML = `<b>${ok?'Benar.':'Belum tepat.'}</b> ${x.explanation}`;
          nextBtn(ex, qi === KQ.length-1, 'Lihat skor');
        });
      } else if (qmode === 's'){
        if (qi >= SQ.length){
          const pct = Math.round(score / (SQ.length*4) * 100); saveEval('s', score);
          const msg = pct >= 75 ? 'Sikap Ibu sangat mendukung pencegahan KEK. Pertahankan!' : pct >= 50 ? 'Sikap Ibu cukup mendukung. Baca lagi penjelasan pada pernyataan yang masih ragu.' : 'Masih ada sikap yang perlu diperkuat. Diskusikan dengan bidan atau keluarga, ya.';
          return endBox(`${pct}%`, msg);
        }
        const x = SQ[qi];
        const opts = x.options.map(o => o.label);
        qbox.innerHTML = meta('Pernyataan',qi,SQ.length)+bar(qi,SQ.length)+`<span class="qtag">Sikap ${String(x.aspect).toLowerCase()}</span><p class="qhint">Seberapa setuju Ibu dengan pernyataan ini?</p><h3>“${x.text}”</h3><div class="opts">${opts.map((o,i)=>`<button class="opt" data-i="${i}">${o}</button>`).join('')}</div><div class="explain" id="ex"></div>`;
        answerUI(opts, (pick, btn) => {
          const favorable = x.favorable;
          const positive = favorable ? pick <= 1 : pick >= 2;
          score += favorable ? 4 - pick : pick + 1;
          qbox.querySelectorAll('.opt').forEach(o => o.disabled = true);
          btn.classList.add(positive ? 'right' : 'wrong');
          const ex = document.getElementById('ex'); ex.innerHTML = positive ? x.good : x.bad;
          nextBtn(ex, qi === SQ.length-1, 'Lihat hasil');
        });
      } else {
        if (qi === 0) missed.length = 0;
        if (qi >= PQ.length){
          const good = PQ.length - missed.length; saveEval('t', score);
          const prev = PERILAKU.length > 1 ? `<p class="tip" style="text-align:center">Hasil sebelumnya: ${PERILAKU[PERILAKU.length-2].percentage}% (${PERILAKU[PERILAKU.length-2].date})</p>` : '';
          const list = missed.length ? `<div class="explain on"><b>Kebiasaan yang perlu ditingkatkan:</b><ul style="margin:6px 0 0;padding-left:18px">${missed.map(m=>`<li>${m}</li>`).join('')}</ul></div>` : '';
          return endBox(`${Math.round(score/(PQ.length*3)*100)}%`, missed.length ? `${good} dari ${PQ.length} kebiasaan baik sudah rutin Ibu lakukan.` : 'Luar biasa! Semua kebiasaan baik sudah rutin Ibu lakukan.', prev + list);
        }
        const x = PQ[qi];
        const opts = x.options.map(o => o.label);
        qbox.innerHTML = meta('Pertanyaan',qi,PQ.length)+bar(qi,PQ.length)+`<span class="qtag">${x.indicator}</span><p class="qhint">Dalam 7 hari terakhir, berapa hari Ibu…</p><h3>${x.text}</h3><div class="opts">${opts.map((o,i)=>`<button class="opt" data-i="${i}">${o}</button>`).join('')}</div><div class="explain" id="ex"></div>`;
        answerUI(opts, (pick, btn) => {
          score += 3 - pick;
          qbox.querySelectorAll('.opt').forEach(o => o.disabled = true);
          btn.classList.add(pick === 0 ? 'right' : 'wrong');
          if (pick > 0) missed.push(x.text.charAt(0).toUpperCase() + x.text.slice(1).replace('?',''));
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

    let hist = DATA.lila || [];
    const hul = document.getElementById('lila-hist');
    function drawHist(){
      hul.innerHTML = hist.length ? hist.slice(-12).slice().reverse().map(h => `<li><span>${h.date}</span><span class="${h.value < CUT ? 'r' : 'g'}">${fmt(h.value)} cm</span></li>`).join('') : '<li><span>Belum ada hasil tersimpan. Simpan hasil pertamamu untuk memantau perubahan.</span></li>';
    }
    document.getElementById('lila-save').onclick = async () => {
      const v = parseFloat(num.value);
      if (isNaN(v) || v < 15 || v > 45){ res.className='result risk'; res.innerHTML = '<h3>Angka belum sesuai</h3>Masukkan hasil LILA antara 15 dan 45 cm.'; return; }
      try {
        const saved = await api('POST', '/api/lila', {value_cm: v});
        hist.push(saved);
        drawHist();
        logEv('simpan_lila', v.toFixed(1).replace('.', ',') + ' cm');
      } catch(e) {}
    };
    document.getElementById('lila-clear').onclick = async () => {
      try { await api('DELETE', '/api/lila'); } catch(e) {}
      hist = []; drawHist();
    };
    drawHist();
  }

  /* Bidan contact */
  const bi = document.getElementById('bidan');
  if (bi){
    const bl = document.getElementById('bidan-link');
    let saved = DATA.bidan || '';
    function drawBidan(){
      bi.value = saved;
      bl.innerHTML = saved ? `Tersimpan. <a href="tel:${saved.replace(/[^0-9+]/g,'')}" style="color:var(--danau);font-weight:800">Telepon bidan</a>` : '';
    }
    document.getElementById('bidan-save').onclick = async () => {
      saved = bi.value.trim();
      drawBidan();
      try { await api('PUT', '/api/bidan', {bidan_phone: saved}); } catch(e) {}
    };
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
