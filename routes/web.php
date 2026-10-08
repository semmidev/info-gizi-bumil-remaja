<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/informasi');

Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('/register', [RegisteredUserController::class, 'store']);
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store']);
});

Route::middleware(['auth', 'role:user,admin'])->group(function () {
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

    Route::get('/akun', [AccountController::class, 'edit'])->name('akun');
    Route::put('/akun/password', [AccountController::class, 'updatePassword'])->name('akun.password');

    Route::view('/informasi', 'pages.informasi')->name('informasi');
    Route::view('/kuis', 'pages.kuis')->name('kuis');
    Route::view('/lila', 'pages.lila')->name('lila');
    Route::view('/layanan', 'pages.layanan')->name('layanan');
    Route::view('/menarik', 'pages.menarik')->name('menarik');
});
