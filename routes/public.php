<?php
use App\Http\Controllers\{
    HomeController,
    CartController,
    ReviewController
};
use App\Http\Controllers\Client\{
    ShopController,
    DesignController as ClientDesignController,
    ArtworkController as ClientArtworkController
};
use Illuminate\Support\Facades\Route;

Route::get('/faq', [PageController::class, 'faq'])->name('faq');
Route::get('/returns', [PageController::class, 'returns'])->name('returns');
Route::get('/order', [ShopController::class, 'index'])->name('orders.index');

Route::get('/contact/submit', [ShopController::class, 'index'])->name('contact.submit');

Route::get('/', [HomeController::class, 'index'])->name('home');



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