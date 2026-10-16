@extends('layouts.admin')

@section('title', 'Edit Konten')
@section('heading', 'Edit Konten')
@section('subtitle', $content->title)

@section('content')
  <div class="panel">
    <h3>Data konten</h3>
    <form method="POST" action="{{ route('admin.contents.update', $content) }}" enctype="multipart/form-data">
      @csrf @method('PUT')
      @include('admin.contents.form')
    </form>
  </div>

  <div class="panel" id="slides">
    <h3>Slide gambar ({{ $content->images->count() }})</h3>
    @forelse ($content->images as $slide)
      <div class="list-item">
        <div class="li-main" style="display:flex; gap:10px; align-items:center">
          <img src="{{ $slide->imageUrl() }}" alt="Slide" style="width:64px; height:64px; object-fit:cover; border-radius:12px; flex:none">
          <form method="POST" action="{{ route('admin.contents.slides.update', $slide) }}" style="display:flex; gap:6px; align-items:center">
            @csrf @method('PUT')
            <input type="number" name="position" min="0" value="{{ $slide->position }}" aria-label="Urutan slide" style="width:70px; font:inherit; font-weight:700; padding:8px 10px; border-radius:12px; border:2px solid var(--line); background:var(--bg); color:var(--ink)">
            <button class="btn ghost small" type="submit">Simpan</button>
          </form>
        </div>
        <div class="li-side">
          <form method="POST" action="{{ route('admin.contents.slides.destroy', $slide) }}" data-confirm="Hapus slide ini?">
            @csrf @method('DELETE')
            <button class="btn danger small" type="submit">Hapus</button>
          </form>
        </div>
      </div>
    @empty
      <p class="empty">Belum ada slide. Tambahkan gambar di bawah.</p>
    @endforelse
  </div>

  <div class="panel">
    <h3>Tambah slide</h3>
    <form method="POST" action="{{ route('admin.contents.slides.store', $content) }}" enctype="multipart/form-data">
      @csrf
      <div class="field">
        <label for="slide-image">Gambar (maks 2MB)</label>
        <input id="slide-image" name="image" type="file" accept="image/*" required>
        @error('image')<span class="err">{{ $message }}</span>@enderror
      </div>
      <div class="field">
        <label for="slide-position">Urutan</label>
        <input id="slide-position" name="position" type="number" min="0" value="{{ old('position', $nextPosition) }}" required>
        @error('position')<span class="err">{{ $message }}</span>@enderror
      </div>
      <button type="submit" class="btn-primary">Tambah slide</button>
    </form>
  </div>
@endsection
