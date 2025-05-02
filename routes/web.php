<?php

use App\Http\Controllers\Admin\ArticlesController as AdminArticlesController;
use App\Http\Controllers\ArticlesController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\StatisticsController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\consultantController;
use App\Http\Controllers\Dashboard\Seller\ProductController as SellerProductController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;


Route::get('/', [HomeController::class, 'index'])->name('home');

// ==========================
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');



// ===========================
Route::group(['prefix' => 'consultants'], function () {
    Route::get('/', [consultantController::class, 'index'])->name('consultants');
    Route::get('/{id}', [consultantController::class, 'show'])->name('consultants.show');
});


// ===========================
Route::get('/articles', [ArticlesController::class, 'index'])->name('articles');
Route::get('/articles/{id}', [ArticlesController::class, 'show'])->name('articles.show');

// ===========================
Route::get('/contact', function () {
    return view('contact');
})->name('contact');
Route::middleware('auth')->group(function () {
    Route::prefix('/admin')->group(function () {
        Route::get('/', [StatisticsController::class, 'index'])->name('admin.dashboard');

        // Route::get('/users', function () {
        //     return view('admin.users');
        // })->name('admin.users');
        Route::group(['prefix' => 'products'], function () {
            Route::get('/', [AdminProductController::class, 'index'])->name('admin.products.index');
            Route::get('/create', [AdminProductController::class, 'create'])->name('admin.products.create');
            Route::post('/store', [AdminProductController::class, 'store'])->name('admin.products.store');
            Route::get('/{product}', [AdminProductController::class, 'show'])->name('admin.products.show');
            Route::get('/{product}/edit', [AdminProductController::class, 'edit'])->name('admin.products.edit');
            Route::put('/{product}/update', [AdminProductController::class, 'update'])->name('admin.products.update');
            Route::delete('/{product}/destroy', [AdminProductController::class, 'destroy'])->name('admin.products.destroy');
        });

        Route::get('/orders', function () {
            return view('admin.orders');
        })->name('admin.orders');

        // Route::get('/articles', function () {
        //     return view('admin.articles.index');
        // })->name('admin.articles');
        // Route::prefix('/admin')->group(function () {
        Route::get('articles', [AdminArticlesController::class, 'index'])->name('admin.articles');
        Route::post('articles/store', [AdminArticlesController::class, 'store'])->name('admin.articles.store');
        Route::put('articles/{article}/update', [AdminArticlesController::class, 'update'])->name('admin.articles.update');
        Route::get('articles/{article}/edit', [AdminArticlesController::class, 'edit'])->name('admin.articles.edit');
        // Route::get('articles/{article}', [ArticlesController::class, 'show'])->name('admin.articles.show');
        Route::delete('articles/{article}/destroy', [AdminArticlesController::class, 'destroy'])->name('admin.articles.destroy');
        // });
        Route::resource('users', UsersController::class);

        Route::resource('categories', CategoryController::class);
    });

    // Seller and Buyer Routes
    Route::prefix('/seller')->group(function () {
        Route::get('/', function () {
            return view('dashboard.seller.consultations');
        })->name('seller.consultations');
        Route::get('/products', [SellerProductController::class, 'index'])->name('seller.products.index');
        Route::get('/products/create', [SellerProductController::class, 'create'])->name('seller.products.create');
        Route::post('/products/store', [SellerProductController::class, 'store'])->name('seller.products.store');

        Route::get('/orders', function () {
            return view('dashboard.seller.orders');
        })->name('seller.orders');
    });
    // Buyer Routes
    Route::prefix('/buyer')->group(function () {
        Route::get('/mysells', function () {
            return view('dashboard.buyer.mysells');
        })->name('buyer.mysells');
    });

    // Consultant Routes
    Route::prefix('/conslut')->group(function () {
        Route::get('/order-conslut', function () {
            return view('dashboard.conslut.order-conslut');
        })->name('conslut.order-conslut');
    });

    Route::get('/profile', [ProfileController::class, 'showProfile'])->name('profile');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
});


Route::get('/cart', function () {
    return view('cart.index');
})->name('cart');

Route::get('/login', function () {
    return view('auth.login');
});


// Authentication Routes
Route::middleware('guest')->group(function () {
    // Login Routes
    Route::get('/login', [App\Http\Controllers\Auth\AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [App\Http\Controllers\Auth\AuthController::class, 'login']);

    // Registration Routes
    Route::get('/register', [App\Http\Controllers\Auth\RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [App\Http\Controllers\Auth\RegisterController::class, 'register']);

    // Password Reset Routes
    Route::get('/forgot-password', [App\Http\Controllers\Auth\PasswordResetController::class, 'showForgotPasswordForm'])->name('password.request');
    Route::post('/forgot-password', [App\Http\Controllers\Auth\PasswordResetController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('/reset-password/{token}', [App\Http\Controllers\Auth\PasswordResetController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password', [App\Http\Controllers\Auth\PasswordResetController::class, 'resetPassword'])->name('password.update');

    // Verification Routes
    Route::get('/verify', [App\Http\Controllers\Auth\RegisterController::class, 'showVerificationForm'])->name('verification.show');
    Route::post('/verify', [App\Http\Controllers\Auth\RegisterController::class, 'verifyCode'])->name('verification.verify');
    Route::get('/verification-success', [App\Http\Controllers\Auth\RegisterController::class, 'showVerificationSuccess'])->name('verification.success');
});

// Logout Route
Route::post('/logout', [App\Http\Controllers\Auth\AuthController::class, 'logout'])->name('logout')->middleware('auth');


// Add these routes to your web.php file

// Admin routes
// Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    // Articles routes
    // Route::resource('articles', ArticlesController::class);
// });
