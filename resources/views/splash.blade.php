<!DOCTYPE html>
<html lang="id" data-theme="light">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
  <title>Selamat Datang · Layanan Infogizi Ibu Hamil Remaja</title>
  <link rel="icon" type="image/png" href="{{ asset('logo/logo.png') }}">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>

<body data-menu="Selamat Datang" data-user="UMUM">
  <div class="splash">
    <button type="button" class="splash-skip" id="splash-skip">Lewati</button>

    <div class="splash-track" id="splash-track">
      <section class="splash-slide bg-pink">
        <div class="splash-inner">
          <span class="splash-logo"><img src="{{ asset('logo/logo.png') }}" alt="Logo Layanan Infogizi"></span>
          <h1>Layanan Infogizi Ibu Hamil Remaja</h1>
          <p>Cegak KEK, jaga ibu dan bayi.</p>
          <p class="muted">Media edukasi gizi untuk remaja yang terlanjur hamil agar tetap sehat sampai melahirkan.</p>
        </div>
      </section>

      <section class="splash-slide bg-warn">
        <div class="splash-inner">
          <span class="splash-tag">Penting dibaca</span>
          <h2>Remaja yang terlanjur hamil</h2>
          <div class="about" style="max-width:360px; text-align:left; margin:0">
            <b>⚠️ Penting</b>
            <p>Media ini untuk remaja yang TERLANJUR hamil agar tetap sehat. Jika belum hamil, tunda kehamilan sampai usia
              matang ≥ 20 tahun untuk mencegah anemia, KEK, preeklamsia, BBLR, stunting, hingga risiko kematian ibu &amp;
              bayi.</p>
          </div>
        </div>
      </section>

      <section class="splash-slide bg-blue">
        <div class="splash-inner">
          <span class="splash-tag">Yang bisa kamu lakukan</span>
          <h2>Kenali, pantau, dan rawat</h2>
          <ul class="splash-feats">
          <li>
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M12 16v-4"/><path d="M12 8h.01"/></svg>
            <span><b>Informasi</b><small>Kenali kehamilan remaja dan risiko KEK</small></span>
          </li>
          <li>
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21.3 15.3a2.4 2.4 0 0 1 0 3.4l-2.6 2.6a2.4 2.4 0 0 1-3.4 0L2.7 8.7a2.41 2.41 0 0 1 0-3.4l2.6-2.6a2.41 2.41 0 0 1 3.4 0Z"/><path d="m14.5 12.5 2-2"/><path d="m11.5 9.5 2-2"/><path d="m8.5 6.5 2-2"/><path d="m17.5 15.5 2-2"/></svg>
            <span><b>Pengukuran LILA &amp; IMT</b><small>Pantau status gizi dari waktu ke waktu</small></span>
          </li>
          <li>
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 7v4"/><path d="M14 21v-3a2 2 0 0 0-4 0v3"/><path d="M14 9h-4"/><path d="M18 11h2a2 2 0 0 1 2 2v6a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2v-9a2 2 0 0 1 2-2h2"/><path d="M18 21V5a2 2 0 0 0-2-2H8a2 2 0 0 0-2 2v16"/></svg>
            <span><b>Layanan Info</b><small>Tempat periksa dan nomor bidan desa</small></span>
          </li>
          <li>
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M15 14c.2-1 .7-1.7 1.5-2.5 1-.9 1.5-2.2 1.5-3.5A6 6 0 0 0 6 8c0 1 .2 2.2 1.5 3.5.7.7 1.3 1.5 1.5 2.5"/><path d="M9 18h6"/><path d="M10 22h4"/></svg>
            <span><b>Info Menarik</b><small>Tips, menu gizi, mitos dan fakta</small></span>
          </li>
          <li>
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/><path d="M12 17h.01"/></svg>
            <span><b>Kuis</b><small>Uji pengetahuan, sikap, dan tindakan</small></span>
          </li>
          </ul>
        </div>
      </section>
    </div>

    <div class="splash-foot">
      <div class="splash-dots" id="splash-dots"><i class="on"></i><i></i><i></i></div>
      <button type="button" class="btn-primary" id="splash-next">Lanjut</button>
    </div>
  </div>

  <script>
    (function () {
      var loginUrl = @json(route('login'));
      var track = document.getElementById('splash-track');
      var dots = Array.prototype.slice.call(document.querySelectorAll('#splash-dots i'));
      var next = document.getElementById('splash-next');
      var skip = document.getElementById('splash-skip');
      var total = dots.length;
      var i = 0;

      function go(n) {
        i = Math.max(0, Math.min(total - 1, n));
        track.style.transform = 'translateX(-' + (i * 100) + '%)';
        dots.forEach(function (d, k) { d.classList.toggle('on', k === i); });
        next.textContent = i === total - 1 ? 'Masuk' : 'Lanjut';
      }

      function leave() { window.location.href = loginUrl; }

      next.addEventListener('click', function () { i === total - 1 ? leave() : go(i + 1); });
      skip.addEventListener('click', leave);

      var sx = 0, sy = 0, sw = false;
      var splash = document.querySelector('.splash');
      splash.addEventListener('pointerdown', function (e) { sw = true; sx = e.clientX; sy = e.clientY; });
      splash.addEventListener('pointerup', function (e) {
        if (!sw) return; sw = false;
        var dx = e.clientX - sx, dy = e.clientY - sy;
        if (Math.abs(dx) < 45 || Math.abs(dx) < Math.abs(dy)) return;
        go(dx < 0 ? i + 1 : i - 1);
      });
      splash.addEventListener('pointercancel', function () { sw = false; });

      go(0);
    })();
  </script>
</body>

</html>
