@extends('layouts.admin')

@section('title', 'Aktivitas')
@section('heading', 'Aktivitas')
@section('subtitle', 'Jejak penggunaan aplikasi')

@section('content')
  <form class="filter-bar" method="GET" action="{{ route('admin.data.activity') }}">
    <input type="search" name="q" value="{{ request('q') }}" placeholder="Cari pengguna…">
    <select name="event" data-auto-submit>
      <option value="">Semua kegiatan</option>
      @foreach ($events as $event)
        <option value="{{ $event }}" @selected(request('event') === $event)>{{ str_replace('_', ' ', $event) }}</option>
      @endforeach
    </select>
    <button class="btn small" type="submit">Cari</button>
  </form>

  <div class="panel">
    <div class="table-scroll">
      <table class="atable">
        <thead><tr><th>Waktu</th><th>Pengguna</th><th>Kegiatan</th><th>Keterangan</th><th>Durasi</th><th></th></tr></thead>
        <tbody>
          @forelse ($rows as $row)
            <tr>
              <td>{{ $row->created_at->translatedFormat('d M H:i') }}</td>
              <td>{{ $row->user?->username ?? '–' }}</td>
              <td>{{ str_replace('_', ' ', $row->event) }}</td>
              <td>{{ $row->description ?: '–' }}</td>
              <td>{{ $row->duration_seconds ? $row->duration_seconds . 's' : '–' }}</td>
              <td>
                <form method="POST" action="{{ route('admin.data.activity.destroy', $row) }}" data-confirm="Hapus log aktivitas ini?">
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
