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
  <link rel="stylesheet" href="{{ asset('css/app.css') }}?v={{ filemtime(public_path('css/app.css')) }}">
</head>

<body data-menu="Selamat Datang" data-user="UMUM">
  <div class="splash">
    <div class="splash-track" id="splash-track">
      <section class="splash-slide splash-fig">
        <img src="{{ asset('landing/1.png') }}"
          alt="Selamat datang di Layanan Infogizi Ibu Hamil Remaja: Cegah KEK, jaga ibu dan bayi">
      </section>

      <section class="splash-slide splash-fig">
        <img src="{{ asset('landing/2.png') }}"
          alt="Edukasi gizi bagi ibu hamil remaja: informasi dan edukasi gizi kehamilan, pencegahan KEK, serta cara menjaga kesehatan ibu dan bayi">
      </section>

      <section class="splash-slide splash-fig">
        <img src="{{ asset('landing/3.png') }}"
          alt="Kebutuhan gizi ibu hamil remaja: tanda risiko KEK, kebutuhan gizi, pilihan makanan bergizi, dan pemeriksaan kehamilan rutin">
      </section>
    </div>

    <div class="splash-foot">
      <button type="button" class="splash-skip" id="splash-skip">Lewati</button>
      <button type="button" class="btn-primary" id="splash-next"><span id="splash-next-label">Lanjut</span>
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"
          stroke-linejoin="round" aria-hidden="true">
          <path d="M5 12h14" />
          <path d="m13 6 6 6-6 6" />
        </svg>
      </button>
    </div>
  </div>

  <script>
    (function () {
      var loginUrl = @json(route('login'));
      var track = document.getElementById('splash-track');
      var next = document.getElementById('splash-next');
      var nextLabel = document.getElementById('splash-next-label');
      var skip = document.getElementById('splash-skip');
      var total = 3;
      var i = 0;

      function go(n) {
        i = Math.max(0, Math.min(total - 1, n));
        track.style.transform = 'translateX(-' + (i * 100) + '%)';
        nextLabel.textContent = i === total - 1 ? 'Masuk' : 'Lanjut';
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
