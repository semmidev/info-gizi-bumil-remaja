@extends('layouts.admin')

@section('title', 'Tambah Pengguna')
@section('heading', 'Tambah Pengguna')
@section('subtitle', 'Buat akun baru')

@section('content')
  <div class="panel">
    <form method="POST" action="{{ route('admin.users.store') }}">
      @csrf
      @include('admin.users.form', ['user' => new App\Models\User, 'isEdit' => false])
    </form>
  </div>
@endsection
