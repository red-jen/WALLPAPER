<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Check if user is authenticated and has client role
        if (!Auth::check() || Auth::user()->role !== 'client') {
            // If trying to access JSON endpoint
            if ($request->expectsJson()) {
                return response()->json(['error' => 'Unauthorized. Client access required.'], 403);
            }

            // Redirect to login with message if not authenticated
            if (!Auth::check()) {
                return redirect()->route('login')
                    ->with('error', 'You must be logged in to access this area.');
            }

            // Redirect to home with message if wrong role
            return redirect()->route('home')
                ->with('error', 'You do not have permission to access this area.');
        }

        return $next($request);
    }
}
