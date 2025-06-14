<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\TestimonialController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\TestimonialController as AdminTestimonialController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Models\User;

/*
|--------------------------------------------------------------------------
| Static Pages
|--------------------------------------------------------------------------
*/
Route::get('/', [WelcomeController::class, 'index'])->name('home');
Route::view('/about', 'about')->name('about');
Route::view('/contact', 'contact')->name('contact');
Route::view('/learn', 'learn')->name('learn');

/*
|--------------------------------------------------------------------------
| Authentication
|--------------------------------------------------------------------------
*/
Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'store']);
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

Route::get('/register', [RegisteredUserController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisteredUserController::class, 'register']);

/*
|--------------------------------------------------------------------------
| Dashboard Redirect
|--------------------------------------------------------------------------
*/
Route::get('/dashboard', function() {
    /** @var User|null $user */
    $user = Auth::user();

    if ($user && $user->is_admin) {
        return redirect()->route('admin.dashboard');
    }

    if ($user) {
        $orders = $user->orders()
                       ->latest()
                       ->take(5)
                       ->get();
        return view('dashboard', compact('orders'));
    }

    return redirect()->route('login');
})->middleware(['auth', 'verified'])->name('dashboard');

/*
|--------------------------------------------------------------------------
| Profile & Favorites (User)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function() {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/profile/show', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/favorites', [ProfileController::class, 'favorites'])->name('profile.favorites');

    Route::post('/favorites/toggle', [FavoriteController::class, 'toggle'])
         ->name('favorites.toggle');
    Route::get('/favorites', [FavoriteController::class, 'index'])
         ->name('favorites.index');
    Route::delete('/favorites/{product}', [FavoriteController::class, 'remove'])
         ->name('favorites.remove');
});

/*
|--------------------------------------------------------------------------
| Shop & Products
|--------------------------------------------------------------------------
*/
Route::get('/shop', [ShopController::class, 'index'])->name('shop.index');
Route::get('/shop/{id}', [ShopController::class, 'show'])->name('shop.show');
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/product/{id}', [ProductController::class, 'show'])->name('product.show');

/*
|--------------------------------------------------------------------------
| Cart
|--------------------------------------------------------------------------
*/
Route::get('/cart/count', function() {
    $count = Auth::check()
        ? \App\Models\CartItem::where('user_id', Auth::id())->sum('quantity')
        : 0;
    return response()->json(['count' => $count]);
})->name('cart.count');

Route::middleware('auth')->group(function() {
    Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
    Route::get('/cart', [CartController::class, 'show'])->name('cart.show');
    Route::patch('/cart/update/{cartItem}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/remove/{cartItem}', [CartController::class, 'remove'])->name('cart.remove');
    Route::delete('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
    Route::get('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
});

/*
|--------------------------------------------------------------------------
| User Orders
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function() {
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
    Route::get('/orders/{order}/thank-you', [OrderController::class, 'thankYou'])->name('orders.thank-you');
    Route::get('/orders', [OrderController::class, 'userOrders'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::post('/orders/{order}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel');
});

/*
|--------------------------------------------------------------------------
| Testimonials
|--------------------------------------------------------------------------
*/
Route::post('/testimonial', [TestimonialController::class, 'store'])
     ->name('testimonial.store');

/*
|--------------------------------------------------------------------------
| Admin Area
|--------------------------------------------------------------------------
*/
Route::prefix('admin')
     ->name('admin.')
     ->middleware(['auth', \App\Http\Middleware\IsAdmin::class])
     ->group(function () {
         
         // Dashboard
         Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
         
         // Users Dashboard - This is the missing route that was causing the error
         Route::get('/all-users-dashboard', [AdminUserController::class, 'index'])->name('all_user_dashboard');

         // Users Management
         Route::resource('users', AdminUserController::class);

         // Orders Management
         Route::resource('orders', AdminOrderController::class)
              ->only(['index', 'show', 'destroy']);
         Route::patch('/orders/{order}/status', [AdminOrderController::class, 'updateStatus'])
              ->name('orders.status');
         Route::patch('/orders/{order}/payment-status', [AdminOrderController::class, 'updatePaymentStatus'])
              ->name('orders.payment-status');

         // Products & Categories Management
         Route::resource('products', AdminProductController::class);
         Route::delete('/products/images/{id}', [AdminProductController::class, 'destroyImage'])
              ->name('products.images.destroy');
         Route::resource('categories', AdminCategoryController::class);

         // Testimonials Management
         Route::get('/testimonials/pending', [AdminTestimonialController::class, 'pending'])
              ->name('testimonials.pending');
         Route::post('/testimonials/{id}/approve', [AdminTestimonialController::class, 'approve'])
              ->name('testimonials.approve');
         Route::post('/testimonials/{id}/reject', [AdminTestimonialController::class, 'reject'])
              ->name('testimonials.reject');
     });

require __DIR__.'/auth.php';