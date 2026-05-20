<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminProductController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CustomOrderController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\StorefrontController;
use Illuminate\Support\Facades\Route;

Route::get('/', [StorefrontController::class, 'home'])->name('home');
Route::get('/shop', [StorefrontController::class, 'shop'])->name('shop');
Route::get('/interior-services', [StorefrontController::class, 'services'])->name('services');
Route::get('/rooms/{category}', [StorefrontController::class, 'category'])->name('rooms.show');
Route::get('/products/{slug}', [StorefrontController::class, 'product'])->name('products.show');

Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/register/verify-otp', [AuthController::class, 'showRegistrationOtp'])->name('register.otp');
    Route::post('/register/verify-otp', [AuthController::class, 'verifyRegistrationOtp'])->name('register.otp.verify');
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/adminlogin', [AuthController::class, 'showAdminLogin'])->name('admin.login');
    Route::post('/adminlogin', [AuthController::class, 'adminLogin'])->name('admin.login.submit');
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

Route::get('/cart', [CartController::class, 'show'])->name('cart.show');
Route::post('/cart/{product}', [CartController::class, 'add'])->name('cart.add');
Route::patch('/cart', [CartController::class, 'update'])->name('cart.update');

Route::middleware('auth')->group(function () {
    Route::get('/checkout', [OrderController::class, 'checkout'])->name('checkout');
    Route::post('/checkout/razorpay-order', [OrderController::class, 'createRazorpayOrder'])->name('checkout.razorpay-order');
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::patch('/orders/{order}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel');
    Route::get('/customorders', [CustomOrderController::class, 'index'])->name('customorders.index');
    Route::post('/customorders', [CustomOrderController::class, 'store'])->name('customorders.store');
    Route::patch('/customorders/{customOrder}/status', [CustomOrderController::class, 'updateStatus'])->name('customorders.status');

    Route::get('/admin', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::resource('/admin/products', AdminProductController::class)->except('show')->names('admin.products');
    Route::get('/admin/orders', [AdminProductController::class, 'orders'])->name('admin.orders');
    Route::patch('/admin/orders/{order}/status', [OrderController::class, 'updateStatus'])->name('admin.orders.status');
});
