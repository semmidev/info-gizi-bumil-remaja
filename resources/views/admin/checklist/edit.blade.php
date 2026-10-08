@extends('layouts.admin')

@section('title', 'Edit Target')
@section('heading', 'Edit Target')
@section('subtitle', 'Master target harian')

@section('content')
  <div class="panel">
    <form method="POST" action="{{ route('admin.target.update', $item) }}">
      @csrf @method('PUT')
      @include('admin.checklist.form')
    </form>
  </div>
@endsection
