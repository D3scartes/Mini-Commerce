<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;

use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Home (redirect ke products)
Route::get('/', [ProductController::class, 'index'])->name('home');

// Dashboard
Route::get('/dashboard', function () {
    if (Auth::check() && Auth::user()->role === 'admin') {
        $orders = \App\Models\Order::with('items.product', 'user')
            ->latest()
            ->take(10)
            ->get();
        return view('admin.dashboard', compact('orders'));
    }
    return view('dashboard'); // buyer biasa
})->middleware(['auth', 'verified'])->name('dashboard');

// Profile (user)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Produk (buyer/public)
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');

// Cart (buyer) — harus login
Route::middleware('auth')->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');

    // AJAX qty +/-
    Route::patch('/cart/{cart}/increment', [CartController::class, 'increment'])->name('cart.increment');
    Route::patch('/cart/{cart}/decrement', [CartController::class, 'decrement'])->name('cart.decrement');

    // Legacy/fallback
    Route::patch('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
});

// Orders / Payment (buyer)
Route::middleware('auth')->group(function () {
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/payment', function () {
        return view('orders.payment');
    })->name('orders.payment');
    Route::post('/payment', [OrderController::class, 'store'])->name('orders.store');
});

// Admin (hanya admin & verified)
Route::middleware(['auth', 'verified', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        // CRUD Category (tanpa show)
        Route::resource('categories', AdminCategoryController::class)->except(['show']);

        // CRUD Product (lengkap; pakai ->except(['show']) kalau ingin tanpa show)
        Route::resource('products', AdminProductController::class);

        // Orders (index, show, update)
        Route::resource('orders', AdminOrderController::class)->only(['index', 'show', 'update']);
    });

require __DIR__ . '/auth.php';
