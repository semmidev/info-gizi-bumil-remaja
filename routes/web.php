<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\Admin\ChecklistItemController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DataController;
use App\Http\Controllers\Admin\ExportController;
use App\Http\Controllers\Admin\QuizController;
use App\Http\Controllers\Admin\UserController;
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
    Route::put('/akun/profil', [AccountController::class, 'updateProfile'])->name('akun.profile');
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

Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::view('/lainnya', 'admin.lainnya')->name('lainnya');

    Route::get('/pengguna', [UserController::class, 'index'])->name('users.index');
    Route::get('/pengguna/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/pengguna', [UserController::class, 'store'])->name('users.store');
    Route::get('/pengguna/{user}', [UserController::class, 'show'])->name('users.show');
    Route::get('/pengguna/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/pengguna/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/pengguna/{user}', [UserController::class, 'destroy'])->name('users.destroy');

    Route::get('/kuis', [QuizController::class, 'index'])->name('quiz.index');
    Route::get('/kuis/create', [QuizController::class, 'create'])->name('quiz.create');
    Route::post('/kuis', [QuizController::class, 'store'])->name('quiz.store');
    Route::get('/kuis/{quiz}/edit', [QuizController::class, 'edit'])->name('quiz.edit');
    Route::put('/kuis/{quiz}', [QuizController::class, 'update'])->name('quiz.update');
    Route::delete('/kuis/{quiz}', [QuizController::class, 'destroy'])->name('quiz.destroy');

    Route::get('/target', [ChecklistItemController::class, 'index'])->name('target.index');
    Route::get('/target/create', [ChecklistItemController::class, 'create'])->name('target.create');
    Route::post('/target', [ChecklistItemController::class, 'store'])->name('target.store');
    Route::get('/target/{target}/edit', [ChecklistItemController::class, 'edit'])->name('target.edit');
    Route::put('/target/{target}', [ChecklistItemController::class, 'update'])->name('target.update');
    Route::delete('/target/{target}', [ChecklistItemController::class, 'destroy'])->name('target.destroy');

    Route::get('/data/lila', [DataController::class, 'lila'])->name('data.lila');
    Route::delete('/data/lila/{lila}', [DataController::class, 'destroyLila'])->name('data.lila.destroy');
    Route::get('/data/kuis', [DataController::class, 'quiz'])->name('data.quiz');
    Route::get('/data/kuis/{attempt}', [DataController::class, 'quizShow'])->name('data.quiz.show');
    Route::delete('/data/kuis/{attempt}', [DataController::class, 'destroyQuiz'])->name('data.quiz.destroy');
    Route::get('/data/aktivitas', [DataController::class, 'activity'])->name('data.activity');
    Route::delete('/data/aktivitas/{log}', [DataController::class, 'destroyActivity'])->name('data.activity.destroy');
    Route::get('/data/target', [DataController::class, 'target'])->name('data.target');
    Route::delete('/data/target/{log}', [DataController::class, 'destroyTarget'])->name('data.target.destroy');

    Route::get('/ekspor', [ExportController::class, 'index'])->name('export.index');
    Route::get('/ekspor/{dataset}', [ExportController::class, 'download'])
        ->whereIn('dataset', ['users', 'quiz', 'lila', 'activity'])
        ->name('export.download');
});
