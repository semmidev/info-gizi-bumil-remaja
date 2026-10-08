@extends('layouts.admin')

@section('title', 'Data Kuis')
@section('heading', 'Hasil Kuis')
@section('subtitle', 'Riwayat pengerjaan kuis')

@section('content')
  <form class="filter-bar" method="GET" action="{{ route('admin.data.quiz') }}">
    <input type="search" name="q" value="{{ request('q') }}" placeholder="Cari pengguna…">
    <select name="type" data-auto-submit>
      <option value="">Semua jenis</option>
      <option value="pengetahuan" @selected(request('type') === 'pengetahuan')>Pengetahuan</option>
      <option value="sikap" @selected(request('type') === 'sikap')>Sikap</option>
      <option value="tindakan" @selected(request('type') === 'tindakan')>Tindakan</option>
    </select>
    <button class="btn small" type="submit">Cari</button>
  </form>

  <div class="panel">
    <div class="table-scroll">
      <table class="atable">
        <thead><tr><th>Pengguna</th><th>Jenis</th><th>Skor</th><th>Nilai</th><th>Tanggal</th><th></th></tr></thead>
        <tbody>
          @forelse ($rows as $row)
            <tr>
              <td>{{ $row->user?->username ?? '–' }}</td>
              <td>{{ ucfirst($row->type) }}</td>
              <td>{{ $row->raw_score }}/{{ $row->max_score }}</td>
              <td>{{ $row->percentage }}%</td>
              <td>{{ $row->taken_at->translatedFormat('d M Y') }}</td>
              <td>
                <form method="POST" action="{{ route('admin.data.quiz.destroy', $row) }}" data-confirm="Hapus hasil kuis ini?">
                  @csrf @method('DELETE')
                  <button class="btn danger small" type="submit">Hapus</button>
                </form>
              </td>
            </tr>
          @empty
            <tr><td colspan="6" class="empty">Belum ada data.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
    @include('admin.partials.pagination', ['paginator' => $rows])
  </div>
@endsection
