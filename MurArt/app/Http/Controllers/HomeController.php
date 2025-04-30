<?php

namespace App\Http\Controllers;

use App\Models\Wallpaper;
use App\Models\Design;
use App\Models\Paper;
use App\Models\Artwork;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class HomeController extends Controller
{
    /**
     * Show the application landing page.
     *
     */
    public function index()
    {
        // Get latest wallpapers
        $wallpapers = Wallpaper::with('category')
            ->latest()
            ->take(8)
            ->get();
            
        // Get categories with at least one wallpaper
        $categories = Category::has('wallpapers')
            ->withCount('wallpapers')
            ->orderByDesc('wallpapers_count')
            ->take(4)
            ->get();
            
        // Get featured des
        $designs = Design::with('designer')
            ->latest()
            ->take(6)
            ->get();
            
            $designers = \App\Models\User::where('role', 'designer')
            ->take(4)
            ->get();
            return view('home', compact('wallpapers', 'categories', 'designs', 'designers'));
    }
    
    /**
     * Show the about page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function about()
    {
        return view('public.about');
    }
    
    /**
     * Show the contact page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function contact()
    {
        return view('public.contact');
    }
} 