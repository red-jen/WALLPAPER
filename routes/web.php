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

// Health check endpoint for Railway
Route::get('/health', function () {
    return response('OK', 200);
});

// Debug endpoint for manual demo seeding (Wasmer frozen start command workaround)
Route::match(['GET', 'POST'], '/__seed-demo', function () {
    // Only works when SEED_DEMO is enabled
    $seedDemo = config('app.seed_demo');
    if (!in_array($seedDemo, ['true', '1', 'yes', true, 1], true)) {
        return response()->json([
            'ok' => false,
            'error' => 'SEED_DEMO not enabled in environment',
            'hint' => 'Set SEED_DEMO=true in Wasmer environment variables',
        ], 403);
    }

    try {
        // Clear any failure backoff cache
        Cache::forget('demo_seed_completed_retry_after');
        
        // Check current catalog state
        $wallpaperCount = \App\Models\Wallpaper::count();
        $paperCount = \App\Models\Paper::count();
        
        \Log::info("/__seed-demo: Manual seed requested. Current state: {$paperCount} papers, {$wallpaperCount} wallpapers");
        
        // Run seeder
        $exitCode = Artisan::call('db:seed', ['--force' => true]);
        $output = Artisan::output();
        
        // Check new counts
        $newWallpaperCount = \App\Models\Wallpaper::count();
        $newPaperCount = \App\Models\Paper::count();
        
        if ($exitCode === 0) {
            Cache::forever('demo_seed_completed', true);
            \Log::info("/__seed-demo: Seed succeeded. New state: {$newPaperCount} papers, {$newWallpaperCount} wallpapers");
            
            return response()->json([
                'ok' => true,
                'exit_code' => $exitCode,
                'output' => $output,
                'before' => ['papers' => $paperCount, 'wallpapers' => $wallpaperCount],
                'after' => ['papers' => $newPaperCount, 'wallpapers' => $newWallpaperCount],
                'message' => 'Demo data seeded successfully',
            ]);
        } else {
            \Log::error("/__seed-demo: Seed failed with exit code {$exitCode}");
            
            return response()->json([
                'ok' => false,
                'exit_code' => $exitCode,
                'output' => $output,
                'before' => ['papers' => $paperCount, 'wallpapers' => $wallpapers],
                'after' => ['papers' => $newPaperCount, 'wallpapers' => $newWallpaperCount],
                'error' => 'Seeder returned non-zero exit code',
            ], 500);
        }
    } catch (\Exception $e) {
        \Log::error("/__seed-demo: Exception: " . $e->getMessage());
        \Log::error("/__seed-demo: Trace: " . $e->getTraceAsString());
        
        return response()->json([
            'ok' => false,
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString(),
        ], 500);
    }
});

// Home route
Route::get('/', [HomeController::class, 'index'])->name('home');


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
