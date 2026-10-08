@extends('layouts.admin')

@section('title', 'Tambah Target')
@section('heading', 'Tambah Target')
@section('subtitle', 'Master target harian')

@section('content')
  <div class="panel">
    <form method="POST" action="{{ route('admin.target.store') }}">
      @csrf
      @include('admin.checklist.form')
    </form>
  </div>
@endsection
