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
use Inertia\Inertia;

class HomeController extends Controller
{
    /**
     * Show the application landing page.
     *
     */
    public function index()
    {
        // Get latest wallpapers with their primary image
        $wallpapers = Wallpaper::with(['category', 'images'])
            ->latest()
            ->take(8)
            ->get()
            ->map(function ($wallpaper) {
                return [
                    'id' => $wallpaper->id,
                    'title' => $wallpaper->title,
                    'description' => $wallpaper->description,
                    'price' => $wallpaper->price,
                    'stock' => $wallpaper->stock ?? 10,
                    'category' => $wallpaper->category ? [
                        'id' => $wallpaper->category->id,
                        'name' => $wallpaper->category->name,
                    ] : null,
                    'primary_image' => $wallpaper->primaryImage ? [
                        'image_path' => $wallpaper->primaryImage->image_path,
                    ] : null,
                ];
            });
            
        // Get categories with at least one wallpaper
        $categories = Category::has('wallpapers')
            ->withCount('wallpapers')
            ->orderByDesc('wallpapers_count')
            ->take(4)
            ->get()
            ->map(function ($category) {
                return [
                    'id' => $category->id,
                    'name' => $category->name,
                    'wallpapers_count' => $category->wallpapers_count,
                ];
            });
            
        // Get featured designs
        $designs = Design::with('designer')
            ->latest()
            ->take(6)
            ->get()
            ->map(function ($design) {
                return [
                    'id' => $design->id,
                    'name' => $design->name,
                    'image_path' => $design->image_path,
                    'designer' => $design->designer ? [
                        'id' => $design->designer->id,
                        'name' => $design->designer->name,
                    ] : null,
                ];
            });
            
        $designers = User::where('role', 'designer')
            ->take(4)
            ->get();

        return Inertia::render('Home', [
            'wallpapers' => $wallpapers,
            'categories' => $categories,
            'designs' => $designs,
            'designers' => $designers,
        ]);
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