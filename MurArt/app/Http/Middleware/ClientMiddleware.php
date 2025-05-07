<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ClientMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Check if user is logged in and has client role
        if (auth()->check() && auth()->user()->role === 'client') {
            return $next($request);
        }

        return redirect()->route('login')->with('error', 'You must be a Client to access this page.');
    }
}