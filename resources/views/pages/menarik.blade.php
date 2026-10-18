@extends('layouts.app')

@section('title', 'Info Menarik')
@section('menu', 'Info Menarik')

@section('content')
  <section class="screen on" id="s-menarik" aria-labelledby="h-menarik">
    <h2 id="h-menarik">Info Menarik</h2>
    <p class="lead">Ketuk setiap topik untuk membaca isinya.</p>

    @if (($contents ?? collect())->isNotEmpty())
      <div class="panel">
        <div class="kgrid">
          @foreach ($contents as $konten)
            <details class="kcard">
              <summary>
                <span class="kcard-cover">
                  @if ($konten->coverUrl())
                    <img src="{{ $konten->coverUrl() }}" alt="{{ $konten->title }}" loading="lazy">
                  @else
                    <span class="kcard-ph">📰</span>
                  @endif
                </span>
                <span class="kcard-meta">
                  @if ($konten->category)<span class="kcard-tag">{{ $konten->category->name }}</span>@endif
                  <b>{{ $konten->title }}</b>
                  <small class="kcard-more">Lihat detail</small>
                </span>
              </summary>
              <div class="kcard-body">
                @if ($konten->description)
                <p class="tip" style="margin-top:0">{{ $konten->description }}</p>@endif
                @forelse ($konten->images as $slide)
                  <img class="kslide" src="{{ $slide->imageUrl() }}" alt="{{ $konten->title }} {{ $loop->iteration }}"
                    loading="lazy">
                @empty
                  <p class="empty">Belum ada gambar.</p>
                @endforelse
                <button type="button" class="btn ghost small kcard-close" data-kcard-close>Tutup</button>
              </div>
            </details>
          @endforeach
        </div>
      </div>
    @endif

    <details class="acc">
      <summary><i>💡</i>Mitos dan fakta</summary>
      <div class="acc-b">
        <div id="myths"></div>
      </div>
    </details>
    <details class="acc" id="pustaka">
      <summary><i>📚</i>Daftar pustaka</summary>
      <div class="acc-b">
        <ol class="refs">
          <li>Kementerian Kesehatan RI. (2014). <i>Pedoman gizi seimbang</i> (Permenkes No. 41 Tahun 2014). Kemenkes RI.
          </li>
          <li>Kementerian Kesehatan RI. (2019). <i>Angka kecukupan gizi yang dianjurkan untuk masyarakat Indonesia</i>
            (Permenkes No. 28 Tahun 2019). Kemenkes RI.</li>
          <li>Kementerian Kesehatan RI. (2022). <i>Pedoman gizi ibu hamil</i>. Kemenkes RI.</li>
          <li>Kementerian Kesehatan RI. (2023a). <i>Rencana aksi nasional percepatan penurunan stunting</i>. Kemenkes RI.
          </li>
          <li>Kementerian Kesehatan RI. (2023b). <i>Buku resep makanan lokal balita dan ibu hamil</i>. Kemenkes RI.</li>
          <li>Kementerian Kesehatan RI. (2024). <i>Buku kesehatan ibu dan anak</i> (Edisi revisi 2024). Kemenkes RI.</li>
          <li>Nugraha, A., Putri, D., &amp; Sari, R. (2019). Panduan pengukuran lingkar lengan atas (LILA) untuk ibu
            hamil. <i>Jurnal Gizi Klinik Indonesia, 12</i>(1), 12–18.</li>
          <li>Suryadi, A., Wulandari, S., &amp; Sari, P. (2023). Panduan teknis pengukuran LILA pada ibu hamil. <i>Jurnal
              Gizi dan Kesehatan, 14</i>(1), 34–42.</li>
          <li>UNICEF. (2023). <i>State of the world’s children 2023: Nutrition and health</i>. United Nations Children’s
            Fund.</li>
          <li>Widyawati, W., &amp; Sulistyoningtyas, S. (2020). Karakteristik ibu hamil kekurangan energi kronik (KEK) di
            Puskesmas Pajangan Bantul. <i>Jurnal JKFT, 5</i>(2), 68.</li>
          <li>World Health Organization. (2017). <i>Global nutrition targets 2025: Low birth weight policy brief</i>. WHO.
          </li>
          <li>World Health Organization. (2022). <i>Adolescent pregnancy: Guidelines for prevention and care</i>. WHO.
          </li>
          <li>World Health Organization. (2023). <i>Adolescent health and development</i>. WHO.</li>
          <li>World Health Organization. (2024). <i>Adolescent pregnancy</i> [Fact sheet]. WHO.</li>
          <li>Yastirin, P. A., Sahara, R., &amp; Sehmawati. (2024). Dampak kesehatan ibu pada kehamilan remaja. <i>Jurnal
              Profesi Bidan Indonesia, 4</i>(2).</li>
        </ol>
      </div>
    </details>
  </section>
@endsection
