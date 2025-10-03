<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

// Profile routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Produk routes (buyer)
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');

// Cart routes (buyer)
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
Route::patch('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');

// Orders / Payment (buyer)
Route::middleware('auth')->group(function () {
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');   // daftar pesanan
    Route::get('/payment', function () {                                             // form payment
        return view('orders.payment');
    })->name('orders.payment');
    Route::post('/payment', [OrderController::class, 'store'])->name('orders.store'); // buat order
});

// Admin routes
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('products', AdminProductController::class);
    Route::resource('orders', AdminOrderController::class)->only(['index', 'show', 'update']);

});

require __DIR__.'/auth.php';
