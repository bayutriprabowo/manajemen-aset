<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\MasterItemTypeController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// users
Route::middleware('auth')->group(function () {
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users.create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users.store', [UserController::class, 'store'])->name('users.store');
    Route::get('/users.edit/{id}', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users.update/{id}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');
});

// master tipe item
Route::middleware('auth')->group(function () {
    Route::get('/types', [MasterItemTypeController::class, 'index'])->name('types.index');
});

require __DIR__ . '/auth.php';
