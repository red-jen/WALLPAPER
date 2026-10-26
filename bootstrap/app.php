<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        then: function () {
            Route::middleware('web')->group(base_path('routes/public.php'));
            Route::middleware('web')->group(base_path('routes/auth.php'));
            Route::middleware('web')->group(base_path('routes/admin.php'));
            Route::middleware('web')->group(base_path('routes/client.php'));
            Route::middleware('web')->group(base_path('routes/designer.php'));
        },
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->web(append: [
            \App\Http\Middleware\HandleInertiaRequests::class,
        ]);
        
        $middleware->alias([
            'client' => \App\Http\Middleware\ClientMiddleware::class,
          //  'auth' => \App\Http\Middleware\CheckRole::class,
            'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
            // other middleware...
            'admin' => \App\Http\Middleware\AdminMiddleware::class,
    'designer' => \App\Http\Middleware\DesignerMiddleware::class,
     // Add this line
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
