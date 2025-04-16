<?php

use App\Http\Controllers\ClubController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TeacherController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/clubs', [ClubController::class, 'clubs'])->name('clubs');
Route::get('/teachers', [TeacherController::class, 'teachers'])->name('teachers');

require __DIR__.'/auth.php';
