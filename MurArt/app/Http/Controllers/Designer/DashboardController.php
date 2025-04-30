<?php

namespace App\Http\Controllers\Designer;

use App\Http\Controllers\Controller;
use App\Models\Design;
use App\Models\Artwork;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Show the designer dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $user = Auth::user();
        
        // Get designer's statistics
        $stats = [
            'designs_count' => $user->designs()->count(),
            'in_review_count' => $user->designs()->where('status', 'pending')->count(),
            'favorite_count' => $user->designs()->where('is_featured', true)->count(),
            'total_artwork_usage' => $user->designs()->withCount('artworks')->get()->sum('artworks_count'),
        ];
        
        // Get recent designs
        $recentDesigns = $user->designs()
            ->latest()
            ->take(3)
            ->get();
        
        return view('designer.dashboard', compact('stats', 'recentDesigns'));
    }
} 