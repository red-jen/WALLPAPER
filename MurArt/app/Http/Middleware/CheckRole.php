<?php

namespace App\Http\Middleware;

use App\Services\UserService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserRole
{


public function handle(Request $request, Closure $next, ...$roles): Response{
    if (!Auth::check()) {
        return redirect()->route('login');}
    $user = UserService::getCurrentUser();
    // Get the string value of the user's role$userRoleValue = $user->role->value;
    // Direct string comparison with the passed roles
    if (!in_array($userRoleValue, $roles)) {// Determine appropriate redirect based on user's role
        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard')->with('error', 'You do not have permission to access this area.');} elseif ($user->isDoctor()) {
            return redirect()->route('doctor.dashboard')->with('error', 'You do not have permission to access this area.');} else {
            return redirect()->route('client.dashboard')->with('error', 'You do not have permission to access this area.');}}
    return $next($request);}
}