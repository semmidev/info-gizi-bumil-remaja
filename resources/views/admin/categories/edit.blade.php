@extends('layouts.admin')

@section('title', 'Edit Kategori')
@section('heading', 'Edit Kategori')
@section('subtitle', $category->name)

@section('content')
  <div class="panel">
    <form method="POST" action="{{ route('admin.categories.update', $category) }}">
      @csrf @method('PUT')
      @include('admin.categories.form')
    </form>
  </div>
@endsection
