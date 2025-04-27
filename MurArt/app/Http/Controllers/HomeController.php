<?php

namespace App\Http\Controllers;

use App\Models\Wallpaper;
use App\Models\Design;
use App\Models\Paper;
use App\Models\Artwork;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Show the application landing page.
     *
     */
    public function index()
    {
        // Get featured wallpapers
        $wallpapers = Wallpaper::with(['primaryImage', 'category'])
            ->where('status', 'published')
            ->take(6)
            ->latest()
            ->get();
            
        // Get designs
        $designs = Design::with(['category', 'designer'])
            ->latest()
            ->take(6)
            ->get();
            
        // Get papers
        $papers = Paper::where('is_active', true)
            ->take(4)
            ->get();
        
        // Get featured artworks for the home page
        $featuredArtworks = Artwork::with(['paper', 'design'])
            ->latest()
            ->take(4)
            ->get();
            
        return view('home', compact('wallpapers', 'designs', 'papers', 'featuredArtworks'));
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