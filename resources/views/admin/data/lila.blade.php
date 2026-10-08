@extends('layouts.admin')

@section('title', 'Data LILA')
@section('heading', 'Data LILA')
@section('subtitle', 'Pengukuran lingkar lengan atas')

@section('content')
  <form class="filter-bar" method="GET" action="{{ route('admin.data.lila') }}">
    <input type="search" name="q" value="{{ request('q') }}" placeholder="Cari pengguna…">
    <select name="risk" data-auto-submit>
      <option value="">Semua</option>
      <option value="1" @selected(request('risk') === '1')>Berisiko KEK</option>
      <option value="0" @selected(request('risk') === '0')>Normal</option>
    </select>
    <button class="btn small" type="submit">Cari</button>
  </form>

  <div class="panel">
    <div class="table-scroll">
      <table class="atable">
        <thead><tr><th>Pengguna</th><th>LILA</th><th>Status</th><th>Tanggal</th><th></th></tr></thead>
        <tbody>
          @forelse ($rows as $row)
            <tr>
              <td>{{ $row->user?->username ?? '–' }}</td>
              <td>{{ number_format((float) $row->value_cm, 1, ',', '.') }} cm</td>
              <td><span class="pill {{ $row->value_cm < 23.5 ? 'risk' : 'ok' }}">{{ $row->value_cm < 23.5 ? 'Berisiko' : 'Normal' }}</span></td>
              <td>{{ $row->measured_at->translatedFormat('d M Y') }}</td>
              <td>
                <form method="POST" action="{{ route('admin.data.lila.destroy', $row) }}" data-confirm="Hapus pengukuran ini?">
                  @csrf @method('DELETE')
                  <button class="btn danger small" type="submit">Hapus</button>
                </form>
              </td>
            </tr>
          @empty
            <tr><td colspan="5" class="empty">Belum ada data.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
    @include('admin.partials.pagination', ['paginator' => $rows])
  </div>
@endsection
