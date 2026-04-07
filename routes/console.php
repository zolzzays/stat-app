<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

// Login page
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login.form');
Route::post('/login', [AuthController::class, 'login'])->name('login');

// Dashboard (auth middleware)
Route::get('/dashboard', [AuthController::class, 'dashboard'])->middleware('auth')->name('dashboard');

// Logout
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');