<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\PurchaseController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

// Supplier Management Routes
Route::prefix('suppliers')->name('suppliers.')->group(function () {
    Route::get('/', [SupplierController::class, 'index'])->name('index');
    Route::get('/create', [SupplierController::class, 'create'])->name('create');
    Route::post('/', [SupplierController::class, 'store'])->name('store');
    Route::get('/history', [App\Http\Controllers\PurchaseController::class, 'index'])->name('history');
    Route::get('/search', [SupplierController::class, 'search'])->name('search');
    
    // Evaluation Routes
    Route::get('/{id}/evaluation', [SupplierController::class, 'evaluation'])->name('evaluation');
    Route::post('/{id}/evaluation', [SupplierController::class, 'storeEvaluation'])->name('storeEvaluation'); 
    
    Route::get('/contracts', [SupplierController::class, 'contracts'])->name('contracts');
    Route::get('/{id}', [SupplierController::class, 'show'])->name('show');
    Route::get('/{id}/edit', [SupplierController::class, 'edit'])->name('edit');
    Route::put('/{id}', [SupplierController::class, 'update'])->name('update');
    Route::delete('/{id}', [SupplierController::class, 'destroy'])->name('destroy');
});