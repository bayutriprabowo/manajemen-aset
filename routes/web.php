<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\MasterItemTypeController;
use App\Http\Controllers\MasterCompanyController;
use App\Http\Controllers\MasterDepartmentController;
use App\Http\Controllers\MasterItemController;
use App\Http\Controllers\MasterItemStatusController;
use App\Http\Controllers\MasterSectionController;
use App\Http\Controllers\MasterVendorController;
use App\Http\Controllers\MasterVendorItemController;
use App\Http\Controllers\TransactionItemProcurementController;

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

// master item
Route::middleware('auth')->group(function () {
    Route::get('/items', [MasterItemController::class, 'index'])->name('items.index');
    Route::get('/items.create', [MasterItemController::class, 'create'])->name('items.create');
    Route::post('/items.store', [MasterItemController::class, 'store'])->name('items.store');
    Route::get('/items.edit/{id}', [MasterItemController::class, 'edit'])->name('items.edit');
    Route::put('items.update/{id}', [MasterItemController::class, 'update'])->name('items.update');
    Route::delete('items/{id}', [MasterItemController::class, 'destroy'])->name('items.destroy');
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
// master kondisi barang
Route::middleware('auth')->group(function () {
    Route::get('/item_statuses', [MasterItemStatusController::class, 'index'])->name('item_statuses.index');
    Route::get('/item_statuses.create', [MasterItemStatusController::class, 'create'])->name('item_statuses.create');
    Route::post('/item_statuses.store', [MasterItemStatusController::class, 'store'])->name('item_statuses.store');
    Route::get('/item_statuses.edit/{id}', [MasterItemStatusController::class, 'edit'])->name('item_statuses.edit');
    Route::put('item_statuses.update/{id}', [MasterItemStatusController::class, 'update'])->name('item_statuses.update');
    Route::delete('item_statuses/{id}', [MasterItemStatusController::class, 'destroy'])->name('item_statuses.destroy');
});

// vendor
Route::middleware('auth')->group(function () {
    Route::get('/vendors', [MasterVendorController::class, 'index'])->name('vendors.index');
    Route::get('/vendors.create', [MasterVendorController::class, 'create'])->name('vendors.create');
    Route::post('/vendors.store', [MasterVendorController::class, 'store'])->name('vendors.store');
    Route::get('/vendors.edit/{id}', [MasterVendorController::class, 'edit'])->name('vendors.edit');
    Route::put('vendors.update/{id}', [MasterVendorController::class, 'update'])->name('vendors.update');
    Route::delete('vendors/{id}', [MasterVendorController::class, 'destroy'])->name('vendors.destroy');
});
// vendor item
Route::middleware('auth')->group(function () {
    Route::get('/vendor_items/{id}', [MasterVendorItemController::class, 'index'])->name('vendor_items.index');
    Route::get('/vendor_items.create/{id}', [MasterVendorItemController::class, 'create'])->name('vendor_items.create');
    Route::post('/vendor_items.store/{id}', [MasterVendorItemController::class, 'store'])->name('vendor_items.store');
    Route::delete('vendor_items/{id}/{vendorId}', [MasterVendorItemController::class, 'destroy'])->name('vendor_items.destroy');
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

// department
Route::middleware('auth')->group(function () {
    Route::get('/departments', [MasterDepartmentController::class, 'index'])->name('departments.index');
    Route::get('/departments.create', [MasterDepartmentController::class, 'create'])->name('departments.create');
    Route::post('/departments.store', [MasterDepartmentController::class, 'store'])->name('departments.store');
    Route::get('/departments.edit/{id}', [MasterDepartmentController::class, 'edit'])->name('departments.edit');
    Route::put('departments.update/{id}', [MasterDepartmentController::class, 'update'])->name('departments.update');
    Route::delete('departments/{id}', [MasterDepartmentController::class, 'destroy'])->name('departments.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/sections', [MasterSectionController::class, 'index'])->name('sections.index');
    Route::get('/sections.create', [MasterSectionController::class, 'create'])->name('sections.create');
    Route::post('/sections.store', [MasterSectionController::class, 'store'])->name('sections.store');
    Route::get('/sections.edit/{id}', [MasterSectionController::class, 'edit'])->name('sections.edit');
    Route::put('sections.update/{id}', [MasterSectionController::class, 'update'])->name('sections.update');
    Route::delete('sections/{id}', [MasterSectionController::class, 'destroy'])->name('sections.destroy');
});
// procurement belum selesai
Route::middleware('auth')->group(function () {
    Route::get('/procurements', [TransactionItemProcurementController::class, 'index'])->name('procurements.index');
    Route::get('/procurements.create', [TransactionItemProcurementController::class, 'create'])->name('procurements.create');
    Route::post('/procurements.store', [TransactionItemProcurementController::class, 'store'])->name('procurements.store');
    Route::get('/procurement.edit/{id}', [TransactionItemProcurementController::class, 'edit'])->name('procurements.edit');
    Route::put('procurements.update/{id}', [TransactionItemProcurementController::class, 'update'])->name('procurements.update');
    Route::delete('procurements/{id}', [TransactionItemProcurementController::class, 'destroy'])->name('procurements.destroy');
});

require __DIR__ . '/auth.php';
