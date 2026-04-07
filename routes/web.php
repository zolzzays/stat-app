<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PowerPlantTypeController;
use App\Http\Controllers\PowerPlantController;
use App\Http\Controllers\PlantOutputController;
use App\Http\Controllers\EnergySalesController;
use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\HrCountController;
use App\Http\Controllers\Admin\UserController;

Route::middleware('web')->group(function () {

    // Root руу redirect хийх
    Route::get('/', function () {
        return redirect()->route('login.form');
    });

    // Login page
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login.form');
    Route::post('/login', [AuthController::class, 'login'])->name('login');

    // Dashboard (auth middleware)
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->middleware('auth')->name('dashboard');

    // Logout
    Route::match(['get', 'post'], '/logout', [AuthController::class, 'logout'])->name('logout');

    Route::prefix('power-plant-type')->group(function () {
        Route::get('/', [PowerPlantTypeController::class, 'index'])->name('powerplant.index');
        Route::get('/create', [PowerPlantTypeController::class, 'create'])->name('powerplant.create');
        Route::post('/store', [PowerPlantTypeController::class, 'store'])->name('powerplant.store');
        Route::get('/edit/{id}', [PowerPlantTypeController::class, 'edit'])->name('powerplant.edit');
        Route::post('/update/{id}', [PowerPlantTypeController::class, 'update'])->name('powerplant.update');
        Route::get('/delete/{id}', [PowerPlantTypeController::class, 'destroy'])->name('powerplant.delete');
    });

    Route::resource('power_plants', PowerPlantController::class)->middleware('auth');
    Route::resource('plant_output', PlantOutputController::class)->middleware('auth');
    Route::resource('energy_sales', EnergySalesController::class)->middleware('auth');
    Route::resource('organizations', OrganizationController::class)->middleware('auth');
    Route::resource('hr_count', HrCountController::class)->middleware('auth');

    // Хэрэглэгч удирдах
    Route::prefix('users')->middleware('auth')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('users.index');
        Route::get('/create', [UserController::class, 'create'])->name('users.create');
        Route::post('/', [UserController::class, 'store'])->name('users.store');
        Route::get('/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
        Route::post('/{id}', [UserController::class, 'update'])->name('users.update');
        Route::get('/{id}/delete', [UserController::class, 'destroy'])->name('users.destroy');
    });

});