<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductAttributeController;
use App\Http\Controllers\StockTransactionController;
use App\Http\Controllers\StockOpnameController;
use App\Http\Controllers\DashboardController;

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

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

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

        // Transaksi Barang Masuk (input oleh Manajer Gudang)
        Route::get('/stock-transactions/in', [StockTransactionController::class, 'indexIn'])->name('stock-transactions.in.index');
        Route::get('/stock-transactions/in/create', [StockTransactionController::class, 'createIn'])->name('stock-transactions.in.create');
        Route::post('/stock-transactions/in', [StockTransactionController::class, 'storeIn'])->name('stock-transactions.in.store');

        // Transaksi Barang Keluar (input oleh Manajer Gudang)
        Route::get('/stock-transactions/out', [StockTransactionController::class, 'indexOut'])->name('stock-transactions.out.index');
        Route::get('/stock-transactions/out/create', [StockTransactionController::class, 'createOut'])->name('stock-transactions.out.create');
        Route::post('/stock-transactions/out', [StockTransactionController::class, 'storeOut'])->name('stock-transactions.out.store');

        Route::get('/stock-opname', [StockOpnameController::class, 'index'])->name('stock-opname.index');
        Route::post('/stock-opname', [StockOpnameController::class, 'store'])->name('stock-opname.store');
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

        // Konfirmasi Penerimaan Barang
        Route::get('/stock-transactions/confirm/incoming', [StockTransactionController::class, 'pendingIncoming'])->name('stock-transactions.confirm.incoming');
        Route::put('/stock-transactions/confirm/incoming/{id}', [StockTransactionController::class, 'confirmIncoming'])->name('stock-transactions.confirm.incoming.update');

        // Konfirmasi Pengeluaran Barang
        Route::get('/stock-transactions/confirm/outgoing', [StockTransactionController::class, 'pendingOutgoing'])->name('stock-transactions.confirm.outgoing');
        Route::put('/stock-transactions/confirm/outgoing/{id}', [StockTransactionController::class, 'confirmOutgoing'])->name('stock-transactions.confirm.outgoing.update');
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