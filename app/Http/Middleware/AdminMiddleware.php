<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Check if user is logged in and has admin role
        if (!$request->user() || $request->user()->role !== 'admin') {
            
            abort(403, 'You do not have permission to access this page.');
        }

        return $next($request);
    }
}