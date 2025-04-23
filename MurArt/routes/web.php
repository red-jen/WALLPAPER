<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
// use App\Http\Controllers\Designer\DashboardController as DesignerDashboardController;
use App\Http\Controllers\DesignController;
use Illuminate\Console\View\Components\Warn;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\TagController;

use App\Http\Controllers\Admin\PaperController;
// use App\Http\Controllers\Client\DashboardController as ClientDashboardController;

// Home route
Route::get('/', function () {
    return view('welcome');
});

// Authentication Routes

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::get('designer.designs.create', function (){
    return view('designer/designs/create');})->name('designer.designs.create');

//     // Route::get('designer.designs.store', function (){
//     //     return view('designer/designs/store');})->name('designer.designs.store');

// Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('registerform');

// Route::post('/register', [RegisterController::class, 'register'])->name('register');
// Route::get('admin.category.create', function (){
//     return view('admin/categories/create');})->name('admin.category.create');
//         // Route::post('designer.designs.create', function (){
//         //     return view('designer/designs/create');})->name('designer.designs.create');

//         //     Route::post('/designer/store', [DesignController::class, 'store'])->name('designer.designs.store');

//             Route::get('/designs/create', [DesignController::class, 'create'])->name('designs.create');
//             Route::post('/designs', [DesignController::class, 'store'])->name('designs.store');
//             Route::get('/designs', [DesignController::class, 'index'])->name('designs.index');
//             Route::get('/designs/{design}', [DesignController::class, 'show'])->name('designs.show');
//             Route::get('/designs/{design}/edit', [DesignController::class, 'edit'])->name('designs.edit');
//             Route::put('/designs/{design}', [DesignController::class, 'update'])->name('designs.update');
//             Route::delete('/designs/{design}', [DesignController::class, 'destroy'])->name('designs.destroy');

            
//             // Categories routes - expanded from Route::resource
//             Route::get('/categories', [CategoryController::class, 'index'])->name('admin.categories.index');
//             Route::get('/categories/create', [CategoryController::class, 'create'])->name('admin.categories.create');
//             Route::post('/categories', [CategoryController::class, 'store'])->name('admin.categories.store');
//             Route::get('/categories/{category}', [CategoryController::class, 'show'])->name('admin.categories.show');
//             Route::get('/categories/{category}/edit', [CategoryController::class, 'edit'])->name('admin.categories.edit');
//             Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('admin.categories.update');
//             Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('admin.categories.destroy');


//             Route::get('/tags', [TagController::class, 'index'])->name('admin.tags.index');
//             Route::get('/tags/create', [TagController::class, 'create'])->name('admin.tags.create');
//             Route::post('/tags', [TagController::class, 'store'])->name('admin.tags.store');
//             Route::get('/tags/{tag}', [TagController::class, 'show'])->name('admin.tags.show');
//             Route::get('/tags/{tag}/edit', [TagController::class, 'edit'])->name('admin.tags.edit');
//             Route::put('/tags/{tag}', [TagController::class, 'update'])->name('admin.tags.update');
//             Route::delete('/tags/{tag}', [TagController::class, 'destroy'])->name('admin.tags.destroy');




//             Route::get('/papers', [PaperController::class, 'index'])->name('admin.papers.index');
// Route::get('/papers/create', [PaperController::class, 'create'])->name('admin.papers.create');
// Route::post('/papers', [PaperController::class, 'store'])->name('admin.papers.store');
// Route::get('/papers/{paper}', [PaperController::class, 'show'])->name('admin.papers.show');
// Route::get('/papers/{paper}/edit', [PaperController::class, 'edit'])->name('admin.papers.edit');
// Route::put('/papers/{paper}', [PaperController::class, 'update'])->name('admin.papers.update');
// Route::delete('/papers/{paper}', [PaperController::class, 'destroy'])->name('admin.papers.destroy');


            
            
            // Instead of:
            // Route::resource('categories', CategoryController::class);
    // Route::resource('designs', DesignController::class)->names([
    //                 'index' => 'designer.designs.index',
    //                 'create' => 'designer.designs.create',
    //                 'store' => 'designer.designs.store',
    //                 'show' => 'designer.designs.show',
    //                 'edit' => 'designer.designs.edit',
    //                 'update' => 'designer.designs.update',
    //                 'destroy' => 'designer.designs.destroy',
    //             ]);
// return redirect()->route('designer.designs.create');
// Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
// Route::post('/register', [RegisterController::class, 'register']);

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