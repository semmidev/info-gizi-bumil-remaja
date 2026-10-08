@extends('layouts.admin')

@section('title', 'Log Target')
@section('heading', 'Log Target')
@section('subtitle', 'Target harian per pengguna')

@section('content')
  <form class="filter-bar" method="GET" action="{{ route('admin.data.target') }}">
    <input type="search" name="q" value="{{ request('q') }}" placeholder="Cari pengguna…">
    <input type="date" name="date" value="{{ request('date') }}" data-auto-submit>
    <button class="btn small" type="submit">Cari</button>
  </form>

  <div class="panel">
    <div class="table-scroll">
      <table class="atable">
        <thead><tr><th>Tanggal</th><th>Pengguna</th><th>Target</th><th>Status</th><th></th></tr></thead>
        <tbody>
          @forelse ($rows as $row)
            <tr>
              <td>{{ $row->log_date->translatedFormat('d M Y') }}</td>
              <td>{{ $row->user?->username ?? '–' }}</td>
              <td>{{ $row->checklistItem?->label ?? '–' }}</td>
              <td><span class="pill {{ $row->is_done ? 'ok' : 'muted' }}">{{ $row->is_done ? 'Selesai' : 'Belum' }}</span></td>
              <td>
                <form method="POST" action="{{ route('admin.data.target.destroy', $row) }}" data-confirm="Hapus log target ini?">
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
