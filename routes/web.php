<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

// Static Pages
Route::view('/', 'welcome')->name('home');
Route::view('/about', 'about')->name('about');
Route::view('/contact', 'contact')->name('contact');
Route::view('/learn', 'learn')->name('learn');

// Auth Routes
Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'store']);
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

Route::get('/register', [RegisteredUserController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisteredUserController::class, 'register']);

// Dashboard Redirect
Route::get('/dashboard', function () {
    if (Auth::check()) {
        return Auth::user()->is_admin
            ? redirect()->route('admin.dashboard')
            : view('dashboard');
    }
    return redirect()->route('login');
})->middleware(['auth', 'verified'])->name('dashboard');

// Profile Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Shop Routes
Route::get('/shop', [ShopController::class, 'index'])->name('shop.index');

// Product Routes
Route::get('/product/{id}', [ProductController::class, 'show'])->name('product.show');

// Cart Routes
Route::middleware('auth')->group(function () {
    Route::get('/cart', [CartController::class, 'show'])->name('cart.show');
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
    Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
    Route::post('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
});

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Products
    Route::resource('products', AdminProductController::class);

    // Orders
    Route::resource('orders', OrderController::class);
    Route::patch('orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.update-status');

    // Users
    Route::resource('users', UserController::class)->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);
});

require __DIR__.'/auth.php';