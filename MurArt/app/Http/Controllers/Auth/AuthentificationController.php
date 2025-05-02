<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class AuthentificationController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.auth');
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['required', 'string', 'in:designer,client'],
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        auth()->login($user);

        if ($user->isDesigner()) {
            return redirect()->route('designer.dashboard');
        } else {
            return redirect()->route('client.dashboard');
        }
    }






    public function showLoginForm()
    {
        return view('auth.auth');
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