@extends('layouts.admin')

@section('title', 'Edit Pengguna')
@section('heading', 'Edit Pengguna')
@section('subtitle', $user->username)

@section('content')
  <div class="panel">
    <form method="POST" action="{{ route('admin.users.update', $user) }}">
      @csrf @method('PUT')
      @include('admin.users.form', ['isEdit' => true])
    </form>
  </div>
@endsection
