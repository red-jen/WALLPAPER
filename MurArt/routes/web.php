<?php

use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\Auth\LoginController;

use App\Http\Controllers\Auth\AuthentificationController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
// use App\Http\Controllers\Designer\DashboardController as DesignerDashboardController;
use App\Http\Controllers\Designer\DesignController;
use Illuminate\Console\View\Components\Warn;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\TagController;

use App\Http\Controllers\Admin\PaperController;
// use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\Admin\ReviewController as AdminReviewController;
// use App\Http\Controllers\Client\DashboardController as ClientDashboardController;
use App\Http\Controllers\Client\DashboardController as ClientDashboardController;
use App\Http\Controllers\Client\ArtworkController as ClientArtworkController;
use App\Http\Controllers\admin\WallpaperController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\Client\ShopController;

use App\Http\Controllers\Client\DesignController as ClientDesignController;


use App\Http\Controllers\Admin\ArtworkController;
// Home route
Route::get('/order', [ShopController::class, 'index'])->name('orders.index');

Route::get('/contact/submit', [ShopController::class, 'index'])->name('contact.submit');
// Route::get('/admin/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])
//     ->name('admin.dashboard')
//     ->middleware(['auth', 'admin']);
// Basic pages
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [PageController::class, 'about'])->name('about');



Route::post('/newsletter/subscribe', [NewsletterController::class, 'subscribe'])->name('newsletter.subscribe');

Route::get('/n', [HomeController::class, 'iondex'])->name('client.home');

Route::get('/aabout', [HomeController::class, 'abaout'])->name('profile.show');

Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
// Route::get('/contact', [HomeController::class, 'contact'])->name('dashboard');

Route::post('/contact', [HomeController::class, 'contact'])->name('dashboard');
Route::get('/nav', function () {
    return view('layouts.navbar');
})->name('navbar');

// Authentication Routes

Route::get('/login', [AuthentificationController::class, 'showLoginForm'])->name('login');
Route::get('/logout', [AuthentificationController::class, 'logout'])->name('logout');
Route::post('/login', [AuthentificationController::class, 'login']);
Route::get('designer.designs.create', function () {
    return view('designer/designs/create');
})->name('designer.designs.create');

// Route::get('designer.designs.store', function (){
//     return view('designer/designs/store');})->name('designer.designs.store');

Route::get('/register', [AuthentificationController::class, 'showRegistrationForm'])->name('registerform');

Route::post('/register', [AuthentificationController::class, 'register'])->name('register');
Route::get('admin.category.create', function () {
    return view('admin/categories/create');
})->name('admin.category.create');


// Client routes with middleware protection
Route::prefix('client')->name('client.')->middleware(['auth', 'client'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [App\Http\Controllers\Client\DashboardController::class, 'index'])
        ->name('dashboard');

        // Cart
        Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/artworks/{artwork}/cart', [CartController::class, 'addArtwork'])->name('artworks.addToCart');
Route::delete('/cart/{item}', [CartController::class, 'removeItem'])->name('cart.removeItem');
Route::put('/cart/{item}', [CartController::class, 'updateItem'])->name('cart.updateItem');
Route::get('/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
// Route::get('/shop', [CartController::class, 'check'])->name('shop.index');

    // Orders
    Route::prefix('orders')->name('orders.')->group(function () {
        Route::get('/', [App\Http\Controllers\Client\OrderController::class, 'index'])->name('index');
        Route::get('/{order}', [App\Http\Controllers\Client\OrderController::class, 'show'])->name('show');
    });

    Route::get('/designs/{design}/create-artwork', [ClientDesignController::class, 'createWithDesign'])
    ->name('designs.create-artwork');



    // Profile
    Route::get('/profile', [App\Http\Controllers\Client\ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [App\Http\Controllers\Client\ProfileController::class, 'update'])->name('profile.update');
});





// Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::get('/faq', [PageController::class, 'faq'])->name('faq');
Route::get('/returns', [PageController::class, 'returns'])->name('returns');


// Route::get('/dasshop', [CartController::class, 'check'])->name('client.dashboard');
// Don't forget to import the controller at the top of the file




// Purchase routes
Route::post('/checkout/process', [CartController::class, 'processCheckout'])->name('checkout.process');
Route::get('/checkout/success', [CartController::class, 'checkoutSuccess'])->name('checkout.success');
Route::get('/checkout/cancel', [CartController::class, 'checkoutCancel'])->name('checkout.cancel');





Route::get('/artworks', [ClientArtworkController::class, 'index'])->name('artworks.index');
Route::get('/artworks/create', [ClientArtworkController::class, 'create'])->name('artworks.create');
Route::post('/artworks', [ClientArtworkController::class, 'store'])->name('artworks.store');
Route::get('/artworks/{artwork}', [ClientArtworkController::class, 'show'])->name('artworks.show');
Route::get('/artworks/{artwork}/edit', [ClientArtworkController::class, 'edit'])->name('artworks.edit');
Route::put('/artworks/{artwork}', [ClientArtworkController::class, 'update'])->name('artworks.update');
Route::delete('/artworks/{artwork}', [ClientArtworkController::class, 'destroy'])->name('artworks.destroy');


// Add these routes after your existing artwork routes in web.php
Route::post('/artworks/{artwork}/preview/approve', [ClientArtworkController::class, 'approvePreview'])
    ->name('artworks.preview.approve');

Route::post('/artworks/{artwork}/preview/reject', [ClientArtworkController::class, 'rejectPreview'])
    ->name('artworks.preview.reject');


Route::get('/designs', [ClientDesignController::class, 'index'])
    ->name('designs.index');
Route::get('/designs/{design}', [ClientDesignController::class, 'show'])
    ->name('designs.show');

//shops
Route::get('/shop', [ShopController::class, 'index'])->name('shop.index');
Route::get('/shop/{artwork}', [ShopController::class, 'show'])->name('shop.show');
Route::post('/shop/{artwork}/review', [ShopController::class, 'storeReview'])->middleware('auth')->name('shop.review.store');
// Route::post('/shop/{artwork}/cart', [ShopController::class, 'addToCart'])->name('shop.cart.add');

// Shop routes
Route::post('/shop/{wallpaper}/cart', [ShopController::class, 'addToCart'])->name('shop.cart.add');

// Wallpaper reviews route
Route::post('/wallpapers/{wallpaper}/review', [ReviewController::class, 'storeWallpaperReview'])->middleware('auth')->name('wallpapers.review.store');



Route::get('/designs', [ClientDesignController::class, 'index'])
    ->name('designs.index');
Route::get('/designs/{design}', [ClientDesignController::class, 'show'])
    ->name('designs.show');
Route::get('/designs/{design}/create-artwork', [ClientDesignController::class, 'createWithDesign'])
    ->name('designs.create-artwork');


// Newsletter subscription

// Route::post('designer.designs.create', function (){
//     return view('designer/designs/create');})->name('designer.designs.create');

//     Route::post('/designer/store', [DesignController::class, 'store'])->name('designer.designs.store');

// Designer routes with middleware protection
Route::get('/papers', [App\Http\Controllers\PaperController::class, 'index'])->name('papers.index');
Route::get('/papers/{paper}', [App\Http\Controllers\PaperController::class, 'show'])->name('papers.show');
Route::prefix('designer')->name('designer.')->middleware(['auth', 'designer'])->group(function () {
    // Designs Management
    Route::prefix('designs')->name('designs.')->group(function () {
        Route::get('/', [DesignController::class, 'index'])->name('index');
        Route::get('/create', [DesignController::class, 'create'])->name('create');
        Route::post('/', [DesignController::class, 'store'])->name('store');
        Route::get('/{design}', [DesignController::class, 'show'])->name('show');
        Route::get('/{design}/edit', [DesignController::class, 'edit'])->name('edit');
        Route::put('/{design}', [DesignController::class, 'update'])->name('update');
        Route::delete('/{design}', [DesignController::class, 'destroy'])->name('destroy');
    });

    // Dashboard - assuming we'll need one for designers too
    Route::get('/dashboard', [App\Http\Controllers\Designer\DashboardController::class, 'index'])
        ->name('dashboard');
});

// Review routes - require authentication
Route::post('/designs/{design}/review', [ReviewController::class, 'store'])->name('reviews.store');
Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');
// Admin review management




// Admin routes with middleware protection
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    // Dashboard

    Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])
    ->name('dashboard');
    // ->middleware(['auth', 'admin']);
    // Remove the duplicate dashboard route from here if it exists
    // Other admin routes remain the same

    // Settings Management
    Route::prefix('settings')->name('settings.')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\SettingsController::class, 'index'])->name('index');
        Route::post('/update', [App\Http\Controllers\Admin\SettingsController::class, 'update'])->name('update');
    });

    // Reviews Management
    Route::get('/reviews', [AdminReviewController::class, 'index'])->name('reviews.index');
    Route::put('/reviews/{review}/approve', [AdminReviewController::class, 'approve'])->name('reviews.approve');
    Route::delete('/reviews/{review}', [AdminReviewController::class, 'destroy'])->name('reviews.destroy');

    // Wallpapers Management
    Route::prefix('wallpapers')->name('wallpapers.')->group(function () {
        Route::get('/', [WallpaperController::class, 'index'])->name('index');
        Route::get('/create', [WallpaperController::class, 'create'])->name('create');
        Route::post('/', [WallpaperController::class, 'store'])->name('store');
        Route::get('/{wallpaper}', [WallpaperController::class, 'show'])->name('show');
        Route::get('/{wallpaper}/edit', [WallpaperController::class, 'edit'])->name('edit');
        Route::put('/{wallpaper}', [WallpaperController::class, 'update'])->name('update');
        Route::delete('/{wallpaper}', [WallpaperController::class, 'destroy'])->name('destroy');
        Route::put('/{wallpaper}/stock', [WallpaperController::class, 'updateStock'])->name('updateStock');
        Route::post('/{wallpaper}/reorder', [WallpaperController::class, 'reorderImages'])->name('reorderImages');
    });

    // Artworks Management
    Route::prefix('artworks')->name('artworks.')->group(function () {
        Route::get('/', [ArtworkController::class, 'index'])->name('index');
        Route::get('/{artwork}/edit', [ArtworkController::class, 'edit'])->name('edit');
        Route::post('/{artwork}/preview', [ArtworkController::class, 'storePreview'])->name('preview.store');
        Route::delete('/{artwork}/preview', [ArtworkController::class, 'deletePreview'])->name('preview.delete');
        Route::patch('/{artwork}/status', [ArtworkController::class, 'updateStatus'])->name('status.update');
        Route::post('/{artwork}/production-image', [ArtworkController::class, 'storeProductionImage'])->name('production-image.store');
        Route::delete('/{artwork}/production-image/{index}', [ArtworkController::class, 'deleteProductionImage'])->name('production-image.delete');
        Route::patch('/{artwork}/production-status', [ArtworkController::class, 'updateProductionStatus'])->name('production-status.update');
    });

    // Categories Management
    Route::prefix('categories')->name('categories.')->group(function () {
        Route::get('/', [CategoryController::class, 'index'])->name('index');
        Route::get('/create', [CategoryController::class, 'create'])->name('create');
        Route::post('/', [CategoryController::class, 'store'])->name('store');
        Route::get('/{category}', [CategoryController::class, 'show'])->name('show');
        Route::get('/{category}/edit', [CategoryController::class, 'edit'])->name('edit');
        Route::put('/{category}', [CategoryController::class, 'update'])->name('update');
        Route::delete('/{category}', [CategoryController::class, 'destroy'])->name('destroy');
    });

    // Tags Management
    Route::prefix('tags')->name('tags.')->group(function () {
        Route::get('/', [TagController::class, 'index'])->name('index');
        Route::get('/create', [TagController::class, 'create'])->name('create');
        Route::post('/', [TagController::class, 'store'])->name('store');
        Route::get('/{tag}', [TagController::class, 'show'])->name('show');
        Route::get('/{tag}/edit', [TagController::class, 'edit'])->name('edit');
        Route::put('/{tag}', [TagController::class, 'update'])->name('update');
        Route::delete('/{tag}', [TagController::class, 'destroy'])->name('destroy');
    });

    // Papers Management
    Route::prefix('papers')->name('papers.')->group(function () {
        Route::get('/', [PaperController::class, 'index'])->name('index');
        Route::get('/create', [PaperController::class, 'create'])->name('create');
        Route::post('/', [PaperController::class, 'store'])->name('store');
        Route::get('/{paper}', [PaperController::class, 'show'])->name('show');
        Route::get('/{paper}/edit', [PaperController::class, 'edit'])->name('edit');
        Route::put('/{paper}', [PaperController::class, 'update'])->name('update');
        Route::delete('/{paper}', [PaperController::class, 'destroy'])->name('destroy');
    });

    // Users Management
    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\UserController::class, 'index'])->name('index');
        Route::get('/create', [App\Http\Controllers\Admin\UserController::class, 'create'])->name('create');
        Route::post('/', [App\Http\Controllers\Admin\UserController::class, 'store'])->name('store');
        Route::get('/{user}', [App\Http\Controllers\Admin\UserController::class, 'show'])->name('show');
        Route::get('/{user}/edit', [App\Http\Controllers\Admin\UserController::class, 'edit'])->name('edit');
        Route::put('/{user}', [App\Http\Controllers\Admin\UserController::class, 'update'])->name('update');
        Route::delete('/{user}', [App\Http\Controllers\Admin\UserController::class, 'destroy'])->name('destroy');
        Route::patch('/{user}/status', [App\Http\Controllers\Admin\UserController::class, 'updateStatus'])->name('update-status');
        Route::post('/bulk-action', [App\Http\Controllers\Admin\UserController::class, 'bulkAction'])->name('bulk-action');
    });

    // Orders Management
    Route::prefix('orders')->name('orders.')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\OrderController::class, 'index'])->name('index');
        Route::get('/{order}', [App\Http\Controllers\Admin\OrderController::class, 'show'])->name('show');
        Route::put('/{order}/status', [App\Http\Controllers\Admin\OrderController::class, 'updateStatus'])->name('update-status');
        Route::get('/filter', [App\Http\Controllers\Admin\OrderController::class, 'filter']);
    });

    // Designs Management
    Route::prefix('designs')->name('designs.')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\DesignController::class, 'index'])->name('index');
        Route::get('/{design}', [App\Http\Controllers\Admin\DesignController::class, 'show'])->name('show');
        Route::post('/update-status', [App\Http\Controllers\Admin\DesignController::class, 'updateStatus'])->name('update-status');
    });

    // Chart data
    Route::get('/sales-chart-data', [AdminDashboardController::class, 'getSalesChartData']);
    Route::get('/filter-users', [AdminDashboardController::class, 'filterUsers']);
});


