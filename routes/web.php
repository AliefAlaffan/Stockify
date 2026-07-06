<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductAttributeController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| Authenticated Routes (semua role)
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    // Dashboard - nanti akan diarahkan sesuai role masing-masing
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Profile bawaan Breeze
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    /*
    |--------------------------------------------------------------------------
    | Admin Only Routes
    |--------------------------------------------------------------------------
    */
    Route::middleware(['role:Admin'])->group(function () {

        Route::resource('categories', CategoryController::class)->except(['create', 'edit']);

       Route::resource('suppliers', SupplierController::class)->except(['create', 'edit']);

        // ...
    });


    Route::middleware(['role:Admin,Manajer Gudang'])->group(function () {

        Route::resource('products', ProductController::class);

        Route::get('/products/{product}/attributes', [ProductAttributeController::class, 'index'])
            ->name('products.attributes.index');
        Route::post('/products/{product}/attributes', [ProductAttributeController::class, 'store'])
            ->name('products.attributes.store');
        Route::put('/products/{product}/attributes/{attribute}', [ProductAttributeController::class, 'update'])
            ->name('products.attributes.update');
        Route::delete('/products/{product}/attributes/{attribute}', [ProductAttributeController::class, 'destroy'])
            ->name('products.attributes.destroy');
    });

    /*
    |--------------------------------------------------------------------------
    | Manajer Gudang Only Routes
    |--------------------------------------------------------------------------
    */
    Route::middleware(['role:Manajer Gudang'])->group(function () {

        // Stock Opname
        // Route::get('/stock-opname', [StockOpnameController::class, 'index'])->name('stock-opname.index');
        // Route::post('/stock-opname', [StockOpnameController::class, 'store'])->name('stock-opname.store');
    });

    /*
    |--------------------------------------------------------------------------
    | Manajer Gudang & Staff Gudang Routes
    |--------------------------------------------------------------------------
    */
    Route::middleware(['role:Manajer Gudang,Staff Gudang'])->group(function () {

        // Transaksi Barang Masuk
        // Route::get('/stock-transactions/in', [StockTransactionController::class, 'createIn'])->name('stock-transactions.create-in');
        // Route::post('/stock-transactions/in', [StockTransactionController::class, 'storeIn'])->name('stock-transactions.store-in');

        // Transaksi Barang Keluar
        // Route::get('/stock-transactions/out', [StockTransactionController::class, 'createOut'])->name('stock-transactions.create-out');
        // Route::post('/stock-transactions/out', [StockTransactionController::class, 'storeOut'])->name('stock-transactions.store-out');
    });

    /*
    |--------------------------------------------------------------------------
    | Staff Gudang Only Routes
    |--------------------------------------------------------------------------
    */
    Route::middleware(['role:Staff Gudang'])->group(function () {

        // Konfirmasi Penerimaan & Pengeluaran Barang
        // Route::put('/stock-transactions/{id}/confirm-in', [StockTransactionController::class, 'confirmIn'])->name('stock-transactions.confirm-in');
        // Route::put('/stock-transactions/{id}/confirm-out', [StockTransactionController::class, 'confirmOut'])->name('stock-transactions.confirm-out');
    });

    /*
    |--------------------------------------------------------------------------
    | Semua Role (view saja) - Supplier list, Product list
    |--------------------------------------------------------------------------
    */
    // Route::get('/suppliers', [SupplierController::class, 'index'])->name('suppliers.index');
    // Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    // Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');
});

require __DIR__.'/auth.php';