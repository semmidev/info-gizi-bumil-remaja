@extends('layouts.admin')

@section('title', 'Manajemen Kategori')
@section('heading', 'Manajemen Kategori')
@section('subtitle', $categories->count() . ' kategori konten')

@section('content')
  <div class="section-head">
    <h2>Kategori konten</h2>
    <a class="btn small" href="{{ route('admin.categories.create') }}">+ Tambah</a>
  </div>

  <div class="panel">
    @forelse ($categories as $category)
      <div class="list-item">
        <div class="li-main">
          <b>{{ $category->position }}. {{ $category->name }}</b>
          <small>{{ $category->contents_count }} konten</small>
        </div>
        <div class="li-side">
          <div style="display:flex; gap:6px; justify-content:flex-end">
            <a class="btn ghost small" href="{{ route('admin.categories.edit', $category) }}">Edit</a>
            <form method="POST" action="{{ route('admin.categories.destroy', $category) }}" data-confirm="Hapus kategori ini?">
              @csrf @method('DELETE')
              <button class="btn danger small" type="submit">Hapus</button>
            </form>
          </div>
        </div>
      </div>
    @empty
      <p class="empty">Belum ada kategori.</p>
    @endforelse
  </div>
@endsection
