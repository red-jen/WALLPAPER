<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DesignController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PaperController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register admin routes for your application.
|
*/

// Admin authentication middleware
Route::prefix('admin')->middleware(['auth', 'admin'])->name('admin.')->group(function () {
    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    
    // Categories management
    Route::resource('categories', CategoryController::class);
    
    // Tags management
    Route::resource('tags', TagController::class);
    
    // Paper types management
    Route::resource('papers', PaperController::class);
    
    // Designs management
    Route::resource('designs', DesignController::class);
    Route::patch('designs/{design}/approve', [DesignController::class, 'approve'])->name('designs.approve');
    Route::patch('designs/{design}/reject', [DesignController::class, 'reject'])->name('designs.reject');
    Route::patch('designs/{design}/feature', [DesignController::class, 'feature'])->name('designs.feature');
    
    // Users management
    Route::resource('users', UserController::class)->except(['show']);
});