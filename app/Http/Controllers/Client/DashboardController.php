<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Artwork;
use App\Models\Design;
use App\Models\Paper;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Show the client dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $user = Auth::user();
        
        // Get client's statistics
        $stats = [
            'total_artworks' => $user->artworks()->count(),
            'featured_artworks' => $user->artworks()->where('is_featured', true)->count(),
            'for_sale_artworks' => $user->artworks()->where('is_for_sale', true)->count(),
        ];
        
        // Get recent artworks
        $recentArtworks = $user->artworks()->latest()->take(5)->get();
        
        // Get available papers and designs for quick creation
        $papers = Paper::where('is_active', true)->take(5)->get();
        $designs = Design::latest()->take(5)->get();
        
        return view('client.dashboard', compact('stats', 'recentArtworks', 'papers', 'designs'));
    }
} 