<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\ProductController  as AdminProductController;

// Auth routes (Breeze)
require __DIR__ . '/auth.php';

// Paksa redirectnya ke product, karna guest bisa langsung liat produk
Route::redirect('/', '/products');

// Katalog PRODUK (PUBLIK)
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');


// Beberapa page yg harus login
Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('/dashboard', 'dashboard')->name('dashboard');

    // Admin-only untuk membuat produk 
    Route::middleware('admin')
        ->prefix('admin')->name('admin.')
        ->group(function () {
            // CRUD Category (tanpa show)
            Route::resource('categories', AdminCategoryController::class)->except('show');

            // CRUD Product (tanpa show)
            Route::resource('products',  AdminProductController::class)->except('show');
        });

    // Profile
    Route::get('/profile',  [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile',[ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile',[ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Route utama admin
Route::get('admin/products/create', [\App\Http\Controllers\Admin\ProductController::class, 'create'])
    ->middleware('admin')
    ->name('admin.products.create');

Route::post('admin/products', [\App\Http\Controllers\Admin\ProductController::class, 'store'])
    ->middleware('admin')
    ->name('admin.products.store');

// Alias: biar route('products.create') tetap jalan, tapi diarahkan ke admin
Route::get('products/create', function () {
    return redirect()->route('admin.products.create');
})->middleware(['auth','verified','admin'])->name('products.create');

Route::post('products', function (\Illuminate\Http\Request $request) {
    return redirect()->route('admin.products.store');
})->middleware(['auth','verified','admin'])->name('products.store');
