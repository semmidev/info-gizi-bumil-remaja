<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\Api\ActivityController;
use App\Http\Controllers\Api\UserDataController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\PageController;
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

    Route::get('/informasi', [PageController::class, 'informasi'])->name('informasi');
    Route::get('/kuis', [PageController::class, 'kuis'])->name('kuis');
    Route::get('/lila', [PageController::class, 'lila'])->name('lila');
    Route::get('/layanan', [PageController::class, 'layanan'])->name('layanan');
    Route::get('/menarik', [PageController::class, 'menarik'])->name('menarik');

    Route::prefix('api')->name('api.')->group(function () {
        Route::post('/activity', [ActivityController::class, 'store'])->name('activity.store');
        Route::get('/activity', [ActivityController::class, 'index'])->name('activity.index');
        Route::put('/target', [UserDataController::class, 'updateTarget'])->name('target.update');
        Route::post('/quiz-attempt', [UserDataController::class, 'storeQuizAttempt'])->name('quiz-attempt.store');
        Route::post('/lila', [UserDataController::class, 'storeLila'])->name('lila.store');
        Route::delete('/lila', [UserDataController::class, 'destroyLila'])->name('lila.destroy');
        Route::put('/bidan', [UserDataController::class, 'updateBidan'])->name('bidan.update');
    });
});
