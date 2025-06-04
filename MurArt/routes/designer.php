<?php
use App\Http\Controllers\Designer\{
    DashboardController,
    DesignController
};
use Illuminate\Support\Facades\Route;

Route::prefix('designer')->name('designer.')->middleware(['auth', 'designer'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('designs', DesignController::class);
});



Route::prefix('designer')->name('designer.')->middleware(['auth', 'designer'])->group(function () {
    // Designs Management
    Route::prefix('designs')->name('designs.')->group(function () {
        Route::get('/', [DesignController::class, 'index'])->name('index');
        Route::get('/create', [DesignController::class, 'create'])->name('create');
        Route::post('/', [DesignController::class, 'store'])->name('store');
        Route::get('/{design}', [DesignController::class, 'show'])->name('show');
        Route::get('/{design}/edit', [DesignController::class, 'edit'])->name('edit');
        Route::put('/{design}', [DesignController::class, 'update'])->name('update');
        Route::delete('/{design}', [DesignController::class, 'destroy'])->name('destroy');
    });

    // Dashboard - assuming we'll need one for designers too
    Route::get('/dashboard', [App\Http\Controllers\Designer\DashboardController::class, 'index'])
        ->name('dashboard');
});
