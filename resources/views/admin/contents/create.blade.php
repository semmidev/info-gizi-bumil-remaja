@extends('layouts.admin')

@section('title', 'Tambah Konten')
@section('heading', 'Tambah Konten')
@section('subtitle', 'Konten info menarik')

@section('content')
  <div class="panel">
    <form method="POST" action="{{ route('admin.contents.store') }}" enctype="multipart/form-data">
      @csrf
      @include('admin.contents.form')
    </form>
  </div>
@endsection
