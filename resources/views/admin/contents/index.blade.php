@extends('layouts.admin')

@section('title', 'Manajemen Konten')
@section('heading', 'Manajemen Konten')
@section('subtitle', $contents->count() . ' konten info menarik')

@section('content')
  <div class="section-head">
    <h2>Daftar konten</h2>
    <a class="btn small" href="{{ route('admin.contents.create') }}">+ Tambah</a>
  </div>

  <div class="panel">
    @forelse ($contents as $content)
      <div class="list-item">
        <div class="li-main">
          <b>{{ $content->position }}. {{ $content->title }}</b>
          <small>{{ $content->category?->name ?? '–' }} · {{ $content->images->count() }} slide</small>
        </div>
        <div class="li-side">
          <div style="display:flex; gap:6px; justify-content:flex-end">
            <a class="btn ghost small" href="{{ route('admin.contents.edit', $content) }}">Edit</a>
            <form method="POST" action="{{ route('admin.contents.destroy', $content) }}" data-confirm="Hapus konten ini beserta slidenya?">
              @csrf @method('DELETE')
              <button class="btn danger small" type="submit">Hapus</button>
            </form>
          </div>
        </div>
      </div>
    @empty
      <p class="empty">Belum ada konten.</p>
    @endforelse
  </div>
@endsection
