@extends('layouts.admin')

@section('title', 'Master Target')
@section('heading', 'Master Target')
@section('subtitle', $items->count() . ' target harian')

@section('content')
  <div class="section-head">
    <h2>Target harian</h2>
    <a class="btn small" href="{{ route('admin.target.create') }}">+ Tambah</a>
  </div>

  <div class="panel">
    @forelse ($items as $item)
      <div class="list-item">
        <div class="li-main">
          <b>{{ $item->position }}. {{ $item->label }}</b>
        </div>
        <div class="li-side">
          <div style="display:flex; gap:6px; justify-content:flex-end">
            <a class="btn ghost small" href="{{ route('admin.target.edit', $item) }}">Edit</a>
            <form method="POST" action="{{ route('admin.target.destroy', $item) }}" data-confirm="Hapus target ini? Log pengguna terkait ikut terhapus.">
              @csrf @method('DELETE')
              <button class="btn danger small" type="submit">Hapus</button>
            </form>
          </div>
        </div>
      </div>
    @empty
      <p class="empty">Belum ada target.</p>
    @endforelse
  </div>
@endsection
