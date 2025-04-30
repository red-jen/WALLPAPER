<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
// use App\Http\Controllers\Designer\DashboardController as DesignerDashboardController;
use App\Http\Controllers\Designer\DesignController;
use Illuminate\Console\View\Components\Warn;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\TagController;

use App\Http\Controllers\Admin\PaperController;
// use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ReviewController;
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
Route::get('/admin/dashboard', [ShopController::class, 'index'])->name('admin.dashboard');
// Basic pages
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [PageController::class, 'about'])->name('about');
// Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::get('/faq', [PageController::class, 'faq'])->name('faq');
Route::get('/returns', [PageController::class, 'returns'])->name('returns');

Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/artworks/{artwork}/cart', [CartController::class, 'addArtwork'])->name('artworks.addToCart');
Route::delete('/cart/{item}', [CartController::class, 'removeItem'])->name('cart.removeItem');
Route::put('/cart/{item}', [CartController::class, 'updateItem'])->name('cart.updateItem');
Route::get('/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
Route::get('/shop', [CartController::class, 'check'])->name('shop.index');
Route::get('/dasshop', [CartController::class, 'check'])->name('client.dashboard');
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
Route::get('/designs/{design}/create-artwork', [ClientDesignController::class, 'createWithDesign'])
    ->name('designs.create-artwork');


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
Route::post('/newsletter/subscribe', [NewsletterController::class, 'subscribe'])->name('newsletter.subscribe');

Route::get('/n', [HomeController::class, 'iondex'])->name('client.home');

Route::get('/aabout', [HomeController::class, 'abaout'])->name('profile.show');

Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
// Route::get('/contact', [HomeController::class, 'contact'])->name('dashboard');

Route::post('/contact', [HomeController::class, 'contact'])->name('dashboard');
Route::get('/nav', function (){
    return view('layouts.navbar');})->name('navbar');

// Authentication Routes
  
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
Route::post('/login', [LoginController::class, 'login']);
Route::get('designer.designs.create', function (){
    return view('designer/designs/create');})->name('designer.designs.create');

    // Route::get('designer.designs.store', function (){
    //     return view('designer/designs/store');})->name('designer.designs.store');

Route::get('/register', [LoginController::class, 'showLoginForm'])->name('login');

Route::post('/register', [RegisterController::class, 'register'])->name('register');
Route::get('admin.category.create', function (){
    return view('admin/categories/create');})->name('admin.category.create');
        // Route::post('designer.designs.create', function (){
        //     return view('designer/designs/create');})->name('designer.designs.create');

        //     Route::post('/designer/store', [DesignController::class, 'store'])->name('designer.designs.store');

            Route::get('/designer/designs/create', [DesignController::class, 'create'])->name('designer.designs.create');
            Route::post('/designer/designs', [DesignController::class, 'store'])->name('designer.designs.store');
            Route::get('/designer/designs', [DesignController::class, 'index'])->name('designer.designs.index');
            Route::get('/designer/designs/{design}', [DesignController::class, 'show'])->name('designer.designs.show');
            Route::get('/designer/designs/{design}/edit', [DesignController::class, 'edit'])->name('designer.designs.edit');
            Route::put('/designer/designs/{design}', [DesignController::class, 'update'])->name('designer.designs.update');
            Route::delete('/designer/designs/{design}', [DesignController::class, 'destroy'])->name('designer.designs.destroy');

            
   

   
// Route::get('/gallery', [App\Http\Controllers\Client\DesignGalleryController::class, 'index'])->name('designs.gallery');
// Route::get('/gallery/{design}', [App\Http\Controllers\Client\DesignGalleryController::class, 'show'])->name('designs.gallery.show');

// Review routes - require authentication
Route::post('/designs/{design}/review', [ReviewController::class, 'store'])->name('reviews.store');
    Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');
// Admin review management
Route::get('/reviews', [ReviewController::class, 'index'])->name('admin.reviews.index');
Route::put('/reviews/{review}/approve', [ReviewController::class, 'approve'])->name('admin.reviews.approve');
Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('admin.reviews.destroy');






                      //admin



                      Route::get('admin/wallpapers', [WallpaperController::class, 'index'])->name('admin.wallpapers.index');
                      Route::get('admin/wallpapers/create', [WallpaperController::class, 'create'])->name('admin.wallpapers.create');
                      Route::post('admin/wallpapers', [WallpaperController::class, 'store'])->name('admin.wallpapers.store');
                      Route::get('admin/wallpapers/{wallpaper}', [WallpaperController::class, 'show'])->name('admin.wallpapers.show');
                      Route::get('admin/wallpapers/{wallpaper}/edit', [WallpaperController::class, 'edit'])->name('admin.wallpapers.edit');
                      Route::put('admin/wallpapers/{wallpaper}', [WallpaperController::class, 'update'])->name('admin.wallpapers.update');
                      Route::delete('admin/wallpapers/{wallpaper}', [WallpaperController::class, 'destroy'])->name('admin.wallpapers.destroy');
                      
                      // Add these lines after your existing wallpaper routes
                      Route::put('/wallpapers/{wallpaper}/stock', [WallpaperController::class, 'updateStock'])
                          ->name('admin.wallpapers.updateStock');
                      Route::post('/wallpapers/{wallpaper}/reorder', [WallpaperController::class, 'reorderImages'])
                          ->name('admin.wallpapers.reorderImages');
                      
                      
                      
                      
                      
                      
                          // Replace the incorrect line with these:
                          Route::get('/admin/artworks', [ArtworkController::class, 'index'])->name('admin.artworks.index');
                          Route::get('/admin/artworks/{artwork}/edit', [ArtworkController::class, 'edit'])->name('admin.artworks.edit');
                          Route::post('artworks/{artwork}/preview', [ArtworkController::class, 'storePreview'])->name('admin.artworks.preview.store');
                          Route::delete('artworks/{artwork}/preview', [ArtworkController::class, 'deletePreview'])->name('admin.artworks.preview.delete');
                          Route::patch('artworks/{artwork}/status', [ArtworkController::class, 'updateStatus'])->name('admin.artworks.status.update');
                          Route::post('artworks/{artwork}/production-image', [ArtworkController::class, 'storeProductionImage'])->name('admin.artworks.production-image.store');
                          Route::delete('artworks/{artwork}/production-image/{index}', [ArtworkController::class, 'deleteProductionImage'])->name('admin.artworks.production-image.delete');
                          Route::patch('artworks/{artwork}/production-status', [ArtworkController::class, 'updateProductionStatus'])->name('admin.artworks.production-status.update');
                      
                      
                               // Categories routes - expanded from Route::resource
                               Route::get('/categories', [CategoryController::class, 'index'])->name('admin.categories.index');
                               Route::get('/categories/create', [CategoryController::class, 'create'])->name('admin.categories.create');
                               Route::post('/categories', [CategoryController::class, 'store'])->name('admin.categories.store');
                               Route::get('/categories/{category}', [CategoryController::class, 'show'])->name('admin.categories.show');
                               Route::get('/categories/{category}/edit', [CategoryController::class, 'edit'])->name('admin.categories.edit');
                               Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('admin.categories.update');
                               Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('admin.categories.destroy');
                      
                      
                               Route::get('/tags', [TagController::class, 'index'])->name('admin.tags.index');
                               Route::get('/tags/create', [TagController::class, 'create'])->name('admin.tags.create');
                               Route::post('/tags', [TagController::class, 'store'])->name('admin.tags.store');
                               Route::get('/tags/{tag}', [TagController::class, 'show'])->name('admin.tags.show');
                               Route::get('/tags/{tag}/edit', [TagController::class, 'edit'])->name('admin.tags.edit');
                               Route::put('/tags/{tag}', [TagController::class, 'update'])->name('admin.tags.update');
                               Route::delete('/tags/{tag}', [TagController::class, 'destroy'])->name('admin.tags.destroy');
                      
                      
                      
                      
                               Route::get('/papers', [PaperController::class, 'index'])->name('admin.papers.index');
                               Route::get('/papers/create', [PaperController::class, 'create'])->name('admin.papers.create');
                               Route::post('/papers', [PaperController::class, 'store'])->name('admin.papers.store');
                               Route::get('/papers/{paper}', [PaperController::class, 'show'])->name('admin.papers.show');
                               Route::get('/papers/{paper}/edit', [PaperController::class, 'edit'])->name('admin.papers.edit');
                               Route::put('/papers/{paper}', [PaperController::class, 'update'])->name('admin.papers.update');
                               Route::delete('/papers/{paper}', [PaperController::class, 'destroy'])->name('admin.papers.destroy');
                               

