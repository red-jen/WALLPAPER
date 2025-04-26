<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt([
            'email' => $request->email,
            'password' => $request->password
        ], $request->filled('remember'))) {
            
            $request->session()->regenerate();
            
            // Get current authenticated user
            $user = Auth::user();
            
            // Redirect based on role
            switch ($user->role) {
                case 'admin':
                    return view('welcome');
                    // return redirect()->route('admin.categories.create');
                case 'designer':
                    return view('welcome');
                    // return redirect()->route('designer.designs.create');
                case 'client':
                default:
                    return redirect()->route('client.dashboard');
            }
        }
        
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}