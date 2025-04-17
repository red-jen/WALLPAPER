<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Designer\DashboardController as DesignerDashboardController;
use App\Http\Controllers\Designer\DesignController;
use App\Http\Controllers\Client\DashboardController as ClientDashboardController;

// Home route
Route::get('/', function () {
    return view('welcome');
});

// Authentication Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// Dashboard Routes for Different User Roles
// Route::middleware(['auth'])->group(function () {
//     // Admin routes
//     // Route::middleware(['role:admin'])->prefix('admin')->group(function () {
//     //     Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
//     // });
    
//     // Designer routes
//     // Route::middleware(['role:designer'])->prefix('designer')->group(function () {
//     //     Route::get('/dashboard', [DesignerDashboardController::class, 'index'])->name('designer.dashboard');
        
//     //     // Design management routes
//     //     Route::resource('designs', DesignController::class)->names([
//     //         'index' => 'designer.designs.index',
//     //         'create' => 'designer.designs.create',
//     //         'store' => 'designer.designs.store',
//     //         'show' => 'designer.designs.show',
//     //         'edit' => 'designer.designs.edit',
//     //         'update' => 'designer.designs.update',
//     //         'destroy' => 'designer.designs.destroy',
//     //     ]);
//     // });
    
//     // Client routes
//     // Route::middleware(['role:client'])->prefix('client')->group(function () {
//     //     Route::get('/dashboard', [ClientDashboardController::class, 'index'])->name('client.dashboard');
//     // });
// });