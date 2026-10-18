(function () {
  /* Toast ringan (tanpa lib) */
  function toast(msg, type) {
    var wrap = document.querySelector('.toast-wrap');
    if (!wrap) { wrap = document.createElement('div'); wrap.className = 'toast-wrap'; wrap.setAttribute('aria-live', 'polite'); document.body.appendChild(wrap); }
    var el = document.createElement('div');
    el.className = 'toast' + (type ? ' ' + type : '');
    el.textContent = msg;
    wrap.appendChild(el);
    while (wrap.children.length > 3) wrap.firstChild.remove();
    setTimeout(function () { el.classList.add('out'); setTimeout(function () { el.remove(); }, 250); }, 3500);
  }

  /* Flash dari server tampil sebagai toast */
  document.querySelectorAll('[data-flash]').forEach(function (el) {
    toast(el.dataset.flash || el.textContent.trim(), 'ok');
    el.remove();
  });

  /* Header sticky: bayangan halus saat scroll (samakan dengan halaman user) */
  var adminHead = document.querySelector('.app > header.top');
  if (adminHead) {
    var onScroll = function () { adminHead.classList.toggle('scrolled', window.scrollY > 8); };
    window.addEventListener('scroll', onScroll, { passive: true });
    onScroll();
  }

  /* Transisi pindah halaman (View Transitions API + fallback CSS) */
  document.addEventListener('click', function (e) {
    var a = e.target.closest('nav.tabs a[href]');
    if (!a || e.metaKey || e.ctrlKey || e.shiftKey || e.altKey) return;
    var dest;
    try { dest = new URL(a.getAttribute('href'), location.origin); } catch (err) { return; }
    if (dest.origin !== location.origin || dest.pathname === location.pathname) return;
    if (!document.startViewTransition) return;
    e.preventDefault();
    try { document.startViewTransition(function () { location.href = dest.href; }); } catch (err2) { location.href = dest.href; }
  });

  /* Dropdown akun */
  var brandBtn = document.getElementById('brand-btn');
  var brandDrop = document.getElementById('brand-dropdown');
  if (brandBtn && brandDrop) {
    var closeDrop = function () { brandDrop.hidden = true; brandBtn.setAttribute('aria-expanded', 'false'); };
    brandBtn.addEventListener('click', function (e) {
      e.stopPropagation();
      var open = brandDrop.hidden;
      brandDrop.hidden = !open;
      brandBtn.setAttribute('aria-expanded', String(open));
    });
    document.addEventListener('click', function (e) {
      if (!brandDrop.hidden && !brandDrop.contains(e.target) && !brandBtn.contains(e.target)) closeDrop();
    });
    document.addEventListener('keydown', function (e) { if (e.key === 'Escape') closeDrop(); });
  }

  /* Auto-submit filter */
  document.querySelectorAll('[data-auto-submit]').forEach(function (el) {
    el.addEventListener('change', function () { el.form && el.form.submit(); });
  });

  /* Form kuis: tampilkan field sesuai jenis */
  var typeSel = document.querySelector('[data-quiz-type]');
  if (typeSel) {
    var syncQuizFields = function () {
      var t = typeSel.value;
      document.querySelectorAll('[data-for-type]').forEach(function (el) {
        el.hidden = el.dataset.forType.split(' ').indexOf(t) === -1;
      });
    };
    typeSel.addEventListener('change', syncQuizFields);
    syncQuizFields();
  }

  /* Form kuis: opsi jawaban dinamis + reindex jawaban benar */
  var optionsBox = document.getElementById('options-box');
  if (optionsBox) {
    var reindex = function () {
      optionsBox.querySelectorAll('.opt-row').forEach(function (row, i) {
        var radio = row.querySelector('input[type=radio]');
        if (radio) radio.value = i;
      });
    };
    var addBtn = document.getElementById('add-option');
    if (addBtn) {
      addBtn.addEventListener('click', function () {
        var row = document.createElement('div');
        row.className = 'opt-row';
        row.innerHTML = '<input type="radio" name="correct" value="0"><input type="text" name="options[]" placeholder="Tulis pilihan…"><button type="button" class="btn ghost small" data-remove>✕</button>';
        optionsBox.appendChild(row);
        reindex();
      });
    }
    optionsBox.addEventListener('click', function (e) {
      var btn = e.target.closest('[data-remove]');
      if (!btn) return;
      if (optionsBox.querySelectorAll('.opt-row').length > 2) {
        btn.parentNode.remove();
        reindex();
      }
    });
    reindex();
  }

  /* Modal konfirmasi */
  function confirmDialog(message, onYes, title, okLabel) {
    var ovl = document.createElement('div');
    ovl.className = 'ovl';
    ovl.innerHTML =
      '<div class="dlg" role="dialog" aria-modal="true">' +
        '<h3>' + (title || 'Yakin hapus?') + '</h3>' +
        '<p style="margin:8px 0 14px;font-weight:600">' + message + '</p>' +
        '<div class="dlg-b">' +
          '<button type="button" class="btn danger" data-yes>' + (okLabel || 'Hapus') + '</button>' +
          '<button type="button" class="btn ghost" data-no>Batal</button>' +
        '</div>' +
      '</div>';
    document.body.appendChild(ovl);
    ovl.querySelector('[data-yes]').onclick = function () { document.body.removeChild(ovl); onYes(); };
    ovl.querySelector('[data-no]').onclick = function () { document.body.removeChild(ovl); };
    ovl.addEventListener('click', function (e) { if (e.target === ovl) document.body.removeChild(ovl); });
  }

  document.addEventListener('submit', function (e) {
    var form = e.target.closest('form[data-confirm]');
    if (!form || form.dataset.confirmed) return;
    e.preventDefault();
    confirmDialog(form.dataset.confirm, function () { form.dataset.confirmed = '1'; form.submit(); }, form.dataset.confirmTitle, form.dataset.confirmOk);
  });

  /* Modal edit log aktivitas */
  var logEditOvl = document.getElementById('log-edit-ovl');
  if (logEditOvl) {
    var logEditForm = document.getElementById('log-edit-form');
    var logEditWaktu = document.getElementById('log-edit-waktu');
    var logEditDurasi = document.getElementById('log-edit-durasi');
    var closeLogEdit = function () { logEditOvl.hidden = true; };
    document.querySelectorAll('[data-log-edit]').forEach(function (btn) {
      btn.addEventListener('click', function () {
        logEditForm.setAttribute('action', btn.dataset.action);
        logEditWaktu.value = btn.dataset.waktu;
        logEditDurasi.value = btn.dataset.durasi || '';
        logEditOvl.hidden = false;
        logEditWaktu.focus();
      });
    });
    document.querySelectorAll('[data-log-edit-close]').forEach(function (btn) {
      btn.addEventListener('click', closeLogEdit);
    });
    logEditOvl.addEventListener('click', function (e) { if (e.target === logEditOvl) closeLogEdit(); });
    document.addEventListener('keydown', function (e) { if (e.key === 'Escape' && !logEditOvl.hidden) closeLogEdit(); });
  }
})();
