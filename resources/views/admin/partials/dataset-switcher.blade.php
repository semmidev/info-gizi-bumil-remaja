@php
$datasets = [
    ['route' => 'admin.data.lila', 'label' => 'Pengukuran LILA'],
    ['route' => 'admin.data.imt', 'label' => 'Pengukuran IMT'],
    ['route' => 'admin.data.quiz', 'label' => 'Hasil Kuis'],
    ['route' => 'admin.data.target', 'label' => 'Target Harian'],
    ['route' => 'admin.data.activity', 'label' => 'Aktivitas'],
];
$q = request()->filled('q') ? ['q' => request('q')] : [];
@endphp
<div class="filter-bar">
  <select aria-label="Jenis data" onchange="if(this.value)location.href=this.value">
    @foreach ($datasets as $d)
      <option value="{{ route($d['route'], $q) }}" @selected(request()->routeIs($d['route'] . '*'))>{{ $d['label'] }}</option>
    @endforeach
  </select>
</div>
