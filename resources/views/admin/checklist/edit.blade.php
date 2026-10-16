@extends('layouts.admin')

@section('title', 'Edit Target')
@section('heading', 'Edit Target')
@section('subtitle', 'Manajemen target harian')

@section('content')
  <div class="panel">
    <form method="POST" action="{{ route('admin.target.update', $item) }}">
      @csrf @method('PUT')
      @include('admin.checklist.form')
    </form>
  </div>
@endsection
