@extends('layouts.admin')

@section('title', 'Edit Soal')
@section('heading', 'Edit Soal')
@section('subtitle', 'Master kuis')

@section('content')
  <div class="panel">
    <form method="POST" action="{{ route('admin.quiz.update', $question) }}">
      @csrf @method('PUT')
      @include('admin.quiz.form', ['defaultPosition' => $defaultPosition])
    </form>
  </div>
@endsection
