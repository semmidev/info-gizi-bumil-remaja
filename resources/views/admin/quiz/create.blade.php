@extends('layouts.admin')

@section('title', 'Tambah Soal')
@section('heading', 'Tambah Soal')
@section('subtitle', 'Master kuis')

@section('content')
  <div class="panel">
    <form method="POST" action="{{ route('admin.quiz.store') }}">
      @csrf
      @include('admin.quiz.form', ['question' => new App\Models\QuizQuestion, 'defaultPosition' => $defaultPosition])
    </form>
  </div>
@endsection
