<?php

use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
    // jika admin, hitung statistik dan kirim ke view admin.dashboard
    if (Auth::check() && Auth::user()->role === 'admin') {
        $orders = Order::with('items', 'user')->latest()->get();

        $now = Carbon::now();
        $startOfMonth = $now->copy()->startOfMonth()->startOfDay();
        $endOfMonth   = $now->copy()->endOfMonth()->endOfDay();

        $salesCount = Order::whereBetween('created_at', [$startOfMonth, $endOfMonth])
                          ->where('status', 'Selesai')
                          ->count();

        $salesTotal = DB::table('order_items')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->whereBetween('orders.created_at', [$startOfMonth, $endOfMonth])
            ->where('orders.status', 'Selesai')
            ->select(DB::raw('SUM(order_items.qty * products.price) as total'))
            ->value('total') ?? 0;

        $totalOrders = Order::count();

        return view('admin.dashboard', compact('orders', 'salesCount', 'salesTotal', 'totalOrders'));
    }

    // untuk selain admin
    return view('dashboard');
})->name('dashboard');


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
    Route::get('/payment', [OrderController::class, 'payment'])->name('orders.payment');
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
// AJAX Live Search Produk (public/buyer)
Route::get('/ajax/products/search', [ProductController::class, 'ajaxSearch'])->name('products.ajax.search');

require __DIR__ . '/auth.php';
