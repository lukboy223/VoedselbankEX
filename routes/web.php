<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SupplierController;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth')->group(function () {
    Route::get('/leveranciers', [SupplierController::class, 'index'])->name('supplier.index');
    Route::get('/leveranciers/create', [SupplierController::class, 'create'])->name('supplier.create');
    Route::post('/leveranciers', [SupplierController::class, 'store'])->name('supplier.store');
    Route::get('/leveranciers/{id}/edit', [SupplierController::class, 'edit'])->name('supplier.edit');
    Route::put('/leveranciers/{id}', [SupplierController::class, 'update'])->name('supplier.update');
    Route::delete('/leveranciers/{id}', [SupplierController::class, 'destroy'])->name('supplier.destroy');
});

require __DIR__.'/auth.php';
