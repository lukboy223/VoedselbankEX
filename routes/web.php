<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SupplierController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

Route::get('/', function () {
    return view('welcome');
});


// Klantenoverzicht route
Route::get('/customers', [CustomerController::class, 'index'])->name('customers.index');
// create klant route
// Deze route toont een formulier om een nieuwe klant aan te maken
Route::get('/customers/create', [CustomerController::class, 'create'])->name('customers.create');
Route::post('/customers', [CustomerController::class, 'store'])->name('customers.store');
// Edit klant route
Route::get('/customers/edit/{id}', [CustomerController::class, 'edit'])->name('customers.edit');
Route::patch('/customers/{id}', [CustomerController::class, 'update'])->name('customers.update');
// Delete klant route
Route::delete('/customers/{id}', [CustomerController::class, 'destroy'])->name('customers.destroy');

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
    Route::get('/leveranciers/show/{id}', [SupplierController::class, 'show'])->name('supplier.show');
    Route::get('/leveranciers/create', [SupplierController::class, 'create'])->name('supplier.create');
    Route::post('/leveranciers', [SupplierController::class, 'store'])->name('supplier.store');
    Route::get('/leveranciers/{id}/edit', [SupplierController::class, 'edit'])->name('supplier.edit');
    Route::put('/leveranciers/{id}', [SupplierController::class, 'update'])->name('supplier.update');
    Route::delete('/leveranciers/{id}/delete', [SupplierController::class, 'destroy'])->name('supplier.destroy');
});

require __DIR__.'/auth.php';
