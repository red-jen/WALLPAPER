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


// Authentication Routes


// Route::get('designer.designs.create', function () {
//     return view('designer/designs/create');
// })->name('designer.designs.create');



    // Cart
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');





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

// Designer routes with middleware protection
Route::get('/papers', [App\Http\Controllers\PaperController::class, 'index'])->name('papers.index');
Route::get('/papers/{paper}', [App\Http\Controllers\PaperController::class, 'show'])->name('papers.show');

// Review routes - require authentication
Route::post('/designs/{design}/review', [ReviewController::class, 'store'])->name('reviews.store');
Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');

// Artworks
Route::middleware(['auth'])->group(function () {
    // ...existing artwork routes...
    
    // Add this new route for adding artworks to cart
    Route::post('/artworks/{artwork}/add-to-cart', [App\Http\Controllers\Client\CartController::class, 'addArtwork'])
        ->name('artworks.addToCart');
});
