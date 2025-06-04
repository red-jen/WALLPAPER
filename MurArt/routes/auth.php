<?php
use App\Http\Controllers\Auth\AuthentificationController;
use Illuminate\Support\Facades\Route;

Route::get('/login', [AuthentificationController::class, 'showLoginForm'])->name('login');
Route::get('/logout', [AuthentificationController::class, 'logout'])->name('logout');
Route::post('/logout', [AuthentificationController::class, 'logout'])->name('logout'); 
Route::post('/login', [AuthentificationController::class, 'login']);


Route::get('/register', [AuthentificationController::class, 'showRegistrationForm'])->name('registerform');

Route::post('/register', [AuthentificationController::class, 'register'])->name('register');