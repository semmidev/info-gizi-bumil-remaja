@extends('layouts.admin')

@section('title', 'Data IMT')
@section('heading', 'Data IMT')
@section('subtitle', 'Indeks massa tubuh (berat dan tinggi badan)')

@section('content')
  @include('admin.partials.dataset-switcher')
  <form class="filter-bar" method="GET" action="{{ route('admin.data.imt') }}">
    <input type="search" name="q" value="{{ request('q') }}" placeholder="Cari pengguna…">
    <select name="category" data-auto-submit>
      <option value="">Semua kategori</option>
      <option value="kurus" @selected(request('category') === 'kurus')>Kurus</option>
      <option value="normal" @selected(request('category') === 'normal')>Normal</option>
      <option value="overweight" @selected(request('category') === 'overweight')>Kelebihan berat badan</option>
      <option value="obesitas" @selected(request('category') === 'obesitas')>Obesitas</option>
    </select>
    <button class="btn small" type="submit">Cari</button>
  </form>

  <div class="panel">
    <div class="table-scroll">
      <table class="atable">
        <thead><tr><th>Pengguna</th><th>Berat</th><th>Tinggi</th><th>IMT</th><th>Kategori</th><th>Tanggal</th><th></th></tr></thead>
        <tbody>
          @forelse ($rows as $row)
            <tr>
              <td>{{ $row->user?->username ?? '–' }}</td>
              <td>{{ number_format((float) $row->weight_kg, 1, ',', '.') }} kg</td>
              <td>{{ number_format((float) $row->height_cm, 1, ',', '.') }} cm</td>
              <td>{{ number_format((float) $row->bmi, 1, ',', '.') }}</td>
              <td><span class="pill {{ (float) $row->bmi >= 18.5 && (float) $row->bmi < 25 ? 'ok' : 'risk' }}">{{ \App\Models\ImtMeasurement::kategori((float) $row->bmi) }}</span></td>
              <td>{{ $row->measured_at->translatedFormat('d M Y') }}</td>
              <td>
                <form method="POST" action="{{ route('admin.data.imt.destroy', $row) }}" data-confirm="Hapus pengukuran ini?">
                  @csrf @method('DELETE')
                  <button class="btn danger small" type="submit">Hapus</button>
                </form>
              </td>
            </tr>
          @empty
            <tr><td colspan="7" class="empty">Belum ada data.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
    @include('admin.partials.pagination', ['paginator' => $rows])
  </div>
@endsection
