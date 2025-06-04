<?php

use App\Http\Controllers\Admin\ArtworkController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DesignController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PaperController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\WallpaperController;
use App\Http\Controllers\Admin\ReviewController as AdminReviewController;

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
        Route::put('/{order}/shipping', [App\Http\Controllers\Admin\OrderController::class, 'updateShipping'])->name('update-shipping');
        Route::put('/{order}/notes', [App\Http\Controllers\Admin\OrderController::class, 'updateNotes'])->name('update-notes');
        Route::post('/{order}/upload-image', [App\Http\Controllers\Admin\OrderController::class, 'uploadImage'])->name('upload-image');
        Route::delete('/{order}/delete-image/{index}', [App\Http\Controllers\Admin\OrderController::class, 'deleteImage'])->name('delete-image');
        Route::get('/{order}/invoice', [App\Http\Controllers\Admin\OrderController::class, 'generateInvoice'])->name('invoice');
        Route::get('/filter', [App\Http\Controllers\Admin\OrderController::class, 'filter'])->name('filter');
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

Route::get('admin.category.create', function () {
    return view('admin/categories/create');
})->name('admin.category.create');