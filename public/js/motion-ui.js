/* Animasi spring (Motion, di-vendor lokal) untuk halaman user.
   Progressive enhancement: tanpa Motion / reduced-motion → halaman tetap normal. */
(function () {
  var M = window.Motion;
  if (!M || typeof M.animate !== 'function') return;
  try {
    if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;
  } catch (e) { return; }
  document.documentElement.classList.add('motion-on');

  var animate = M.animate;
  var SPRING = { type: 'spring', stiffness: 170, damping: 22 };
  function go(el, keys, opts) {
    try { animate(el, keys, opts); } catch (e) { /* abaikan */ }
  }

  /* 1. Page enter */
  go('.app > main, .auth-card', { opacity: [0, 1], y: [16, 0] },
    { type: 'spring', stiffness: 140, damping: 20 });

  /* 2. Scroll reveal */
  var SEL = '.panel, .card-link, details.acc, .stat, .icons > div, .intv > div, .reasons > div, .nutri > div';
  function sibDelay(el) {
    try {
      var sibs = Array.prototype.filter.call(el.parentNode.children, function (c) {
        return c.matches && c.matches(SEL);
      });
      var i = sibs.indexOf(el);
      return i > 0 ? Math.min(i, 6) * 0.06 : 0;
    } catch (e) { return 0; }
  }
  if (typeof M.inView === 'function') {
    var targets = Array.prototype.slice.call(document.querySelectorAll(SEL));
    targets.forEach(function (el) { el.style.opacity = '0'; });
    var seen = new WeakSet();
    M.inView(SEL, function (el) {
      if (seen.has(el)) return;
      seen.add(el);
      go(el, { opacity: [0, 1], y: [18, 0] },
        { type: 'spring', stiffness: 150, damping: 22, delay: sibDelay(el) });
    }, { amount: 0.15 });
  }

  /* 3. Ikon nav aktif: pop saat halaman dibuka */
  var activeIcon = document.querySelector('nav.tabs a.active img, nav.tabs a.active svg');
  if (activeIcon) go(activeIcon, { scale: [0.6, 1] }, { type: 'spring', stiffness: 300, damping: 14 });

  /* 4. Ganti tab/segmen: konten baru meluncur masuk */
  document.addEventListener('click', function (e) {
    if (!e.target.closest('[data-p],[data-goto],[data-qs],[data-tm],[data-pr]')) return;
    requestAnimationFrame(function () {
      requestAnimationFrame(function () {
        var t = document.querySelector('.part.on') || document.getElementById('quiz');
        if (t) go(t, { opacity: [0.25, 1], x: [12, 0] }, { duration: 0.3 });
      });
    });
  });

  /* 5. Kuis: tekanan opsi + pop hasil + count-up skor */
  document.addEventListener('pointerdown', function (e) {
    var o = e.target.closest ? e.target.closest('.opt') : null;
    if (o) go(o, { scale: [1, 0.95] }, { duration: 0.12 });
  });
  function countUp(el, target, suffix) {
    try {
      animate(0, target, {
        duration: 0.8,
        onUpdate: function (v) { el.textContent = Math.round(v) + suffix; }
      });
    } catch (e) { /* biarkan teks asli */ }
  }
  var quizBox = document.getElementById('quiz');
  if (quizBox) {
    new MutationObserver(function () {
      var fresh = quizBox.querySelectorAll('.score:not([data-m]), .explain:not([data-m])');
      if (fresh.length) {
        fresh.forEach(function (el) {
          el.dataset.m = '1';
          go(el, { scale: [0.6, 1], opacity: [0, 1] }, { type: 'spring', stiffness: 220, damping: 15 });
          if (el.classList.contains('score')) {
            var t = el.textContent.trim();
            var m = t.match(/^([\d.,]+)\s*%/) || t.match(/^([\d.,]+)\//);
            if (m) countUp(el, parseFloat(m[1].replace(',', '.')), m[0].slice(m[1].length));
          }
        });
      } else {
        go(quizBox, { opacity: [0.3, 1], x: [10, 0] }, { duration: 0.25 });
      }
    }).observe(quizBox, { childList: true, subtree: true });
  }

  /* 6. LILA: hasil baru memantul (dibatasi biar slider tidak bergetar) */
  var lilaRes = document.getElementById('lila-result');
  if (lilaRes) {
    var lastText = '', lastTime = 0;
    new MutationObserver(function () {
      var txt = lilaRes.textContent;
      var now = Date.now();
      if (txt.trim() && (txt !== lastText) && (now - lastTime > 600)) {
        lastText = txt;
        lastTime = now;
        go(lilaRes, { scale: [0.92, 1], opacity: [0.3, 1] }, { type: 'spring', stiffness: 200, damping: 20 });
      }
    }).observe(lilaRes, { childList: true, subtree: true });
  }

  /* 7. Toast: meluncur dari bawah (keluar tetap pakai CSS) */
  function watchToast(wrap) {
    new MutationObserver(function (muts) {
      muts.forEach(function (mu) {
        mu.addedNodes.forEach(function (n) {
          if (n.classList && n.classList.contains('toast')) {
            go(n, { y: [24, 0], opacity: [0, 1] }, { type: 'spring', stiffness: 260, damping: 22 });
          }
        });
      });
    }).observe(wrap, { childList: true });
  }
  var tw = document.querySelector('.toast-wrap');
  if (tw) {
    watchToast(tw);
  } else {
    new MutationObserver(function (muts, obs) {
      var w = document.querySelector('.toast-wrap');
      if (w) { watchToast(w); obs.disconnect(); }
    }).observe(document.body, { childList: true });
  }

  /* 8. Header sticky: bayangan halus saat scroll */
  var head = document.querySelector('.app > header.top');
  if (head) {
    addEventListener('scroll', function () {
      head.classList.toggle('scrolled', scrollY > 8);
    }, { passive: true });
  }
})();
