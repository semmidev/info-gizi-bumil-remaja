@extends('layouts.admin')

@section('title', 'Aktivitas')
@section('heading', 'Aktivitas')
@section('subtitle', 'Jejak penggunaan aplikasi')

@section('content')
  @include('admin.partials.dataset-switcher')
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
                <div style="display:flex;gap:6px;flex-wrap:wrap">
                  <button type="button" class="btn small" data-log-edit
                    data-action="{{ route('admin.data.activity.update', $row) }}"
                    data-waktu="{{ $row->created_at->format('Y-m-d\TH:i') }}"
                    data-durasi="{{ $row->duration_seconds }}">Edit</button>
                  <form method="POST" action="{{ route('admin.data.activity.destroy', $row) }}" data-confirm="Hapus log aktivitas ini?">
                    @csrf @method('DELETE')
                    <button class="btn danger small" type="submit">Hapus</button>
                  </form>
                </div>
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

  <div class="ovl" id="log-edit-ovl" hidden>
    <form class="dlg dlg-w" role="dialog" aria-modal="true" aria-labelledby="log-edit-h" method="POST" id="log-edit-form">
      @csrf
      @method('PUT')
      <h3 id="log-edit-h">Edit aktivitas</h3>
      <label for="log-edit-waktu">Waktu</label>
      <input type="datetime-local" id="log-edit-waktu" name="waktu" required>
      <label for="log-edit-durasi">Durasi (detik)</label>
      <input type="number" id="log-edit-durasi" name="durasi" min="0" max="86400" placeholder="Kosongkan bila tanpa durasi">
      <div class="dlg-b">
        <button type="submit" class="btn">Simpan</button>
        <button type="button" class="btn ghost small" data-log-edit-close>Batal</button>
      </div>
    </form>
  </div>
@endsection
