<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\Router;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\DesignerMiddleware;
use App\Http\Middleware\CustomerMiddleware;

class MiddlewareServiceProvider extends ServiceProvider
{
    public function boot(Router $router)
    {
        $router->aliasMiddleware('admin', AdminMiddleware::class);
        $router->aliasMiddleware('designer', DesignerMiddleware::class);
        $router->aliasMiddleware('customer', CustomerMiddleware::class);
    }
}
