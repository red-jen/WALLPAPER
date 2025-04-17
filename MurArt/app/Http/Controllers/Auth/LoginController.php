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
        // $request->validate([
        //     'email' => ['required', 'string', 'email'],
        //     'password' => ['required', 'string'],
        // ]);
        return redirect()->route('designer.designs.create');
        // if (Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
        //     $request->session()->regenerate();

        //     $user = new User;
        //     // Check roles using a safer approach
        //     if ($user->role === 'admin' || $user->isAdmin() === "admin") {
        //         return redirect()->route('admin.dashboard');
        //     } elseif ($user->role === 'designer' || $user->isDesigner() === "designer") {
        //         return redirect()->route('designer.designs.create');
        //     } else {
        //         return redirect()->route('client.dashboard');
        //     }
        // }

        // throw ValidationException::withMessages([
        //     'email' => trans('auth.failed'),
        // ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}