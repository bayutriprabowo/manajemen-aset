<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\MasterItemTypeController;
use App\Http\Controllers\MasterCompanyController;

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
    Route::get('/item_types', [MasterItemTypeController::class, 'index'])->name('item_types.index');
    Route::get('/item_types.create', [MasterItemTypeController::class, 'create'])->name('item_types.create');
    Route::post('/item_types.store', [MasterItemTypeController::class, 'store'])->name('item_types.store');
    Route::get('/item_types.edit/{id}', [MasterItemTypeController::class, 'edit'])->name('item_types.edit');
    Route::put('item_types.update/{id}', [MasterItemTypeController::class, 'update'])->name('item_types.update');
    Route::delete('item_types/{id}', [MasterItemTypeController::class, 'destroy'])->name('item_types.destroy');
});

// company
Route::middleware('auth')->group(function () {
    Route::get('/companies', [MasterCompanyController::class, 'index'])->name('companies.index');
    Route::get('/companies.create', [MasterCompanyController::class, 'create'])->name('companies.create');
    Route::post('/companies.store', [MasterCompanyController::class, 'store'])->name('companies.store');
    Route::get('/companies.edit/{id}', [MasterCompanyController::class, 'edit'])->name('companies.edit');
    Route::put('companies.update/{id}', [MasterCompanyController::class, 'update'])->name('companies.update');
    Route::delete('companies/{id}', [MasterCompanyController::class, 'destroy'])->name('companies.destroy');
});

require __DIR__ . '/auth.php';
