<?php

use App\Http\Controllers\Admin\ArticlesController as AdminArticlesController;
use App\Http\Controllers\ArticlesController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\StatisticsController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\consultantController;
use App\Http\Controllers\Dashboard\Buyer\BuyerOrderController;
use App\Http\Controllers\Dashboard\consultant\ConsultantOrderController;
use App\Http\Controllers\Dashboard\Seller\consultationController;
use App\Http\Controllers\Dashboard\Seller\ProductController as SellerProductController;
use App\Http\Controllers\Dashboard\Seller\SellerOrderController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\paymentController;
use App\Http\Controllers\ProductController;

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Route;


Route::get('/', [HomeController::class, 'index'])->name('home');

// ==========================
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');
Route::post('/rate-product', [ProductController::class, 'rate'])->name('products.rate');



// ===========================
Route::group(['prefix' => 'consultants'], function () {
    Route::get('/', [consultantController::class, 'index'])->name('consultants');
    Route::get('/{id}', [consultantController::class, 'show'])->name('consultants.show');
    Route::get('/consultation-order/{id}', [consultantController::class, 'consultationOrder'])->name('consultants.consultation-order');
    Route::post('/consultation-store', [consultantController::class, 'consultationStore'])->name('consultants.consultation.store')->middleware('auth');
});
Route::delete('/certificates/{certificate}/', [CertificateController::class, 'destroy'])->name('certificates.destroy');
Route::post('/certificates', [CertificateController::class, 'store'])->name('certificates.store');


// ===========================
Route::get('/articles', [ArticlesController::class, 'index'])->name('articles');
Route::get('/articles/{id}', [ArticlesController::class, 'show'])->name('articles.show');
Route::post('review', [ArticlesController::class, 'storeReview'])->name('articles.review.store');


// ===========================
Route::get('/contact', function () {
    return view('contact');
})->name('contact');
Route::prefix('/dashboard')->middleware('auth')->group(function () {
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


    Route::get('/orders', [SellerOrderController::class, 'index'])->name('seller.orders');
    Route::put('/orders/{id}/update-status', [SellerOrderController::class, 'updateStatus'])->name('seller.orders.update-status');



    // Seller and Buyer Routes
    Route::prefix('/seller')->group(function () {
        Route::get('/products', [SellerProductController::class, 'index'])->name('seller.products.index');
        Route::get('/products/create', [SellerProductController::class, 'create'])->name('seller.products.create');
        Route::post('/products/store', [SellerProductController::class, 'store'])->name('seller.products.store');
        Route::get('/consultations', [consultationController::class, 'index'])->name('seller.consultations');
        Route::get('/consultations/cancelled/{id}', [consultationController::class, 'cancelledOrder'])->name('seller.orders.cancelled');

        // Route::get('/orders', function () {
        //     return view('dashboard.seller.orders');
        // })->name('seller.orders');
    });
    // Buyer Routes
    Route::prefix('/buyer')->group(function () {
        Route::get('/orders', [BuyerOrderController::class, 'index'])->name('buyer.mysells');
    });

    // Consultant Routes
    Route::prefix('/consultants')->group(function () {
        Route::get('/consultation-order', [ConsultantOrderController::class, 'index'])->name('dashboard.consultants.consultation-order');
        Route::post('/consultation-order/update', [ConsultantOrderController::class, 'updateOrder'])->name('dashboard.consultants.orders.update');
    });

    Route::get('/profile', [ProfileController::class, 'showProfile'])->name('profile');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
});

// Add this route with your other payment routes
Route::post('/payment/store-session', [App\Http\Controllers\paymentController::class, 'storeSession'])->name('payment.store-session');
// Payment Routes
Route::post('/payment/process', [App\Http\Controllers\paymentController::class, 'process'])->name('payment.process');
Route::get('/payment/callback', [App\Http\Controllers\paymentController::class, 'callback'])->name('payment.callback');
Route::get('/orders/success/{id}', [App\Http\Controllers\paymentController::class, 'success'])->name('orders.success');
// Create payment intent for Stripe Elements
Route::post('/payment/create-intent', [App\Http\Controllers\paymentController::class, 'createIntent'])->name('payment.create-intent');
// Cart Routes
Route::get('/cart', [App\Http\Controllers\CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{id}', [App\Http\Controllers\CartController::class, 'add'])->name('cart.add');
Route::post('/cart/update', [App\Http\Controllers\CartController::class, 'update'])->name('cart.update');
Route::get('/cart/remove/{rowId}', [App\Http\Controllers\CartController::class, 'remove'])->name('cart.remove');
Route::get('/cart/clear', [App\Http\Controllers\CartController::class, 'clear'])->name('cart.clear');
Route::get('/cart/checkout', [App\Http\Controllers\CartController::class, 'checkout'])->name('cart.checkout');

// Route::get('/cart', function () {
//     return view('cart.index');
// })->name('cart');

Route::get('/login', function () {
    return view('auth.login');
});

// Stripe Routes
Route::get('/payment/{id}', [paymentController::class, 'index'])->name('payment.index');
Route::post('/stripe/payment', [paymentController::class, 'handlePayment'])->name('stripe.payment');


Route::middleware(['auth'])->group(function () {
    Route::post('/chat', [ChatController::class, 'index'])->name('chat');
    Route::get('/chat/messages', [ChatController::class, 'getMessages'])->name('chat.messages');
    Route::post('/chat/send', [ChatController::class, 'sendMessage'])->name('chat.send');
    Route::post('/chat/mark-as-read', [ChatController::class, 'markAsRead'])->name('chat.markAsRead');
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
