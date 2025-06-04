<?php
use App\Http\Controllers\Client\{
    DashboardController,
    ArtworkController,
    DesignController,
    OrderController,
    ProfileController,
    ShopController
};
use App\Http\Controllers\Client\CartController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Client\DashboardController as ClientDashboardController;
use App\Http\Controllers\Client\ArtworkController as ClientArtworkController;

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
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

Route::post('/checkout/process', [CartController::class, 'processCheckout'])->name('checkout.process');
Route::get('/checkout/success', [CartController::class, 'checkoutSuccess'])->name('checkout.success');
Route::get('/checkout/cancel', [CartController::class, 'checkoutCancel'])->name('checkout.cancel');



//artwork client management



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







//     Route::prefix('client')->name('client.')->middleware(['auth', 'client'])->group(function () {
//     // Dashboard
//     Route::get('/dashboard', [App\Http\Controllers\Client\DashboardController::class, 'index'])
//         ->name('dashboard');

//     // Cart
//     Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
//     Route::post('/artworks/{artwork}/cart', [CartController::class, 'addArtwork'])->name('artworks.addToCart');
//     Route::delete('/cart/{item}', [CartController::class, 'removeItem'])->name('cart.removeItem');
//     Route::put('/cart/{item}', [CartController::class, 'updateItem'])->name('cart.updateItem');
//     Route::get('/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
//     // Route::get('/shop', [CartController::class, 'check'])->name('shop.index');

//     // Orders
//     Route::prefix('orders')->name('orders.')->group(function () {
//         Route::get('/', [App\Http\Controllers\Client\OrderController::class, 'index'])->name('index');
//         Route::get('/{order}', [App\Http\Controllers\Client\OrderController::class, 'show'])->name('show');
//     });

//     Route::get('/designs/{design}/create-artwork', [ClientDesignController::class, 'createWithDesign'])
//         ->name('designs.create-artwork');



//     // Profile
//     Route::get('/profile', [App\Http\Controllers\Client\ProfileController::class, 'edit'])->name('profile.edit');
//     Route::put('/profile', [App\Http\Controllers\Client\ProfileController::class, 'update'])->name('profile.update');
// });