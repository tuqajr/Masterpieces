<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\TestimonialController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\TestimonialController as AdminTestimonialController;


// Static Pages
Route::get('/', [WelcomeController::class, 'index'])->name('home');
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
        if (Auth::user()->is_admin) {
            return redirect()->route('admin.dashboard');
        } else {
            /** @var \App\Models\User $user */
            $user = Auth::user();
            $orders = $user->orders()->latest()->take(5)->get();
            return view('dashboard', ['orders' => $orders]);
        }
    }
    return redirect()->route('login');
})->middleware(['auth', 'verified'])->name('dashboard');


// Profile Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    Route::get('/profile/show', [ProfileController::class, 'show'])->name('profile.show');

    // Add this route for favorites
    Route::get('/profile/favorites', [ProfileController::class, 'favorites'])->name('profile.favorites');
});


// Shop and Product Routes
Route::get('/shop', [ShopController::class, 'index'])->name('shop.index');
Route::get('/product/{id}', [ProductController::class, 'show'])->name('product.show');
Route::get('/shop/{id}', [ShopController::class, 'show'])->name('shop.show');

// Cart Count API
Route::get('/cart/count', function () {
    if (Auth::check()) {
        $count = \App\Models\CartItem::where('user_id', Auth::id())->sum('quantity');
        return response()->json(['count' => $count]);
    } else {
        return response()->json(['count' => 0]);
    }
})->name('cart.count');

// Cart Routes
Route::middleware(['auth'])->group(function () {
    Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
    
    Route::get('/cart', [CartController::class, 'show'])->name('cart.show');
    
    Route::patch('/cart/update/{cartItem}', [CartController::class, 'update'])->name('cart.update');
    
    Route::delete('/cart/remove/{cartItem}', [CartController::class, 'remove'])->name('cart.remove');
    
    Route::delete('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
});

Route::get('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');

// Order Routes (User)
Route::middleware(['auth'])->group(function () {
    // Submit order
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
    
    // Thank you page
    Route::get('/orders/{order}/thank-you', [OrderController::class, 'thankYou'])->name('orders.thank-you');
    
    // Order history
    Route::get('/my-orders', [OrderController::class, 'userOrders'])->name('orders.index');
    
    // Order details
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    
    // Cancel order
    Route::post('/orders/{order}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel');

    Route::get('/my-orders', [OrderController::class, 'userOrders'])->name('orders.index');

});

// Admin Routes (All in one group)
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Products
    Route::resource('products', AdminProductController::class);
    
    // Orders
    Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
    Route::patch('/orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.update-status');
    
    // Users
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/all_users', [UserController::class, 'index'])->name('all_user_dashboard'); // Your custom route
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::patch('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
});

Route::post('/favorites/toggle/{product}', [FavoriteController::class, 'toggle'])->name('favorites.toggle');

// Favorites Routes (only for authenticated users)
Route::middleware(['auth'])->group(function () {
    Route::post('/favorites/toggle', [FavoriteController::class, 'toggle'])->name('favorites.toggle');
    
    // Show user favorites
    Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorites.index');
    
    // Remove from favorites
    Route::delete('/favorites/remove/{product}', [FavoriteController::class, 'remove'])->name('favorites.remove');
});

Route::post('/testimonial', [TestimonialController::class, 'store'])->name('testimonial.store');


Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/testimonials/pending', [AdminTestimonialController::class, 'pending'])->name('testimonials.pending');
    Route::post('/testimonials/{id}/approve', [AdminTestimonialController::class, 'approve'])->name('testimonials.approve');
    Route::post('/testimonials/{id}/reject', [AdminTestimonialController::class, 'reject'])->name('testimonials.reject');
});

Route::delete('/admin/products/images/{id}', [AdminProductController::class, 'destroyImage'])->name('admin.products.images.destroy');
Route::get('/admin/products/{product}/edit', [ProductController::class, 'edit'])->name('admin.products.edit');
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
require __DIR__.'/auth.php';