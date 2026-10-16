@extends('layouts.admin')

@section('title', 'Tambah Kategori')
@section('heading', 'Tambah Kategori')
@section('subtitle', 'Kategori konten info menarik')

@section('content')
  <div class="panel">
    <form method="POST" action="{{ route('admin.categories.store') }}">
      @csrf
      @include('admin.categories.form')
    </form>
  </div>
@endsection
