(function () {
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

  /* Modal konfirmasi hapus */
  function confirmDialog(message, onYes) {
    var ovl = document.createElement('div');
    ovl.className = 'ovl';
    ovl.innerHTML =
      '<div class="dlg" role="dialog" aria-modal="true">' +
        '<h3>Yakin hapus?</h3>' +
        '<p style="margin:8px 0 14px;font-weight:600">' + message + '</p>' +
        '<div class="dlg-b">' +
          '<button type="button" class="btn danger" data-yes>Hapus</button>' +
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
    confirmDialog(form.dataset.confirm, function () { form.dataset.confirmed = '1'; form.submit(); });
  });
})();
