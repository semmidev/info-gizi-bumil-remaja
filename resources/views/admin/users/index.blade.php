@extends('layouts.admin')

@section('title', 'Pengguna')
@section('heading', 'Pengguna')
@section('subtitle', $users->total() . ' akun terdaftar')

@section('content')
  <div class="section-head">
    <h2>Daftar pengguna</h2>
    <a class="btn small" href="{{ route('admin.users.create') }}">+ Tambah</a>
  </div>

  <form class="filter-bar" method="GET" action="{{ route('admin.users.index') }}">
    <input type="search" name="q" value="{{ request('q') }}" placeholder="Cari nama pengguna…">
    <select name="role" data-auto-submit>
      <option value="">Semua peran</option>
      <option value="user" @selected(request('role') === 'user')>Pengguna</option>
      <option value="admin" @selected(request('role') === 'admin')>Admin</option>
    </select>
    <button class="btn small" type="submit">Cari</button>
  </form>

  <div class="panel">
    @forelse ($users as $user)
      <div class="list-item">
        <a class="li-main" href="{{ route('admin.users.show', $user) }}" style="text-decoration:none;color:inherit">
          <b>{{ $user->username }}</b>
          <small>{{ $user->bidan_phone ?: 'Tanpa nomor bidan' }} · {{ $user->created_at->translatedFormat('d M Y') }}</small>
        </a>
        <div class="li-side">
          <span class="pill {{ $user->role }}">{{ $user->role === 'admin' ? 'Admin' : 'Pengguna' }}</span>
          <div style="margin-top:6px; display:flex; gap:6px; justify-content:flex-end">
            <a class="btn ghost small" href="{{ route('admin.users.edit', $user) }}">Edit</a>
            <form method="POST" action="{{ route('admin.users.destroy', $user) }}" data-confirm="Hapus pengguna {{ $user->username }} beserta semua datanya?">
              @csrf @method('DELETE')
              <button class="btn danger small" type="submit" @disabled($user->is(auth()->user()))>Hapus</button>
            </form>
          </div>
        </div>
      </div>
    @empty
      <p class="empty">Tidak ada pengguna yang cocok.</p>
    @endforelse
  </div>

  @include('admin.partials.pagination', ['paginator' => $users])
@endsection
