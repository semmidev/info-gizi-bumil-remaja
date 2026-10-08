@extends('layouts.admin')

@section('title', 'Master Kuis')
@section('heading', 'Master Kuis')
@section('subtitle', $questions->flatten()->count() . ' soal')

@section('content')
  <div class="section-head">
    <h2>Daftar soal</h2>
    <a class="btn small" href="{{ route('admin.quiz.create') }}">+ Tambah</a>
  </div>

  @foreach (['pengetahuan' => 'Pengetahuan', 'sikap' => 'Sikap', 'tindakan' => 'Tindakan'] as $type => $label)
    <div class="panel">
      <h3>{{ $label }} ({{ $questions->get($type)?->count() ?? 0 }})</h3>
      @forelse ($questions->get($type, collect()) as $q)
        <div class="list-item">
          <div class="li-main">
            <b>{{ $q->indicator ?: \Illuminate\Support\Str::limit($q->text, 40) }}</b>
            <small>{{ \Illuminate\Support\Str::limit($q->text, 70) }} · {{ $q->options->count() }} opsi</small>
          </div>
          <div class="li-side">
            <div style="display:flex; gap:6px; justify-content:flex-end">
              <a class="btn ghost small" href="{{ route('admin.quiz.edit', $q) }}">Edit</a>
              <form method="POST" action="{{ route('admin.quiz.destroy', $q) }}" data-confirm="Hapus soal ini beserta opsinya?">
                @csrf @method('DELETE')
                <button class="btn danger small" type="submit">Hapus</button>
              </form>
            </div>
          </div>
        </div>
      @empty
        <p class="empty">Belum ada soal.</p>
      @endforelse
    </div>
  @endforeach
@endsection
