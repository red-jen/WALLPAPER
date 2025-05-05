<?php

namespace App\Http\Controllers\Designer;

use App\Http\Controllers\Controller;
use App\Models\Design;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Display the designer dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();

        // Get designs created by this designer
        $designs = Design::where('designer_id', $user->id)
            ->latest()
            ->get();

        // Get reviews for designs by this designer
        // Adjust this based on your actual Review model structure
        $reviews = Review::whereHas('design', function($query) use ($user) {
                $query->where('designer_id', $user->id);
            })
            ->with(['user', 'design'])
            ->latest()
            ->get();

        // If your reviews are stored differently, you might need to adapt this query
        // For example, if reviews are directly linked to designs without a polymorphic relationship:
        // $reviews = Review::whereIn('design_id', $designs->pluck('id'))->with(['user', 'design'])->latest()->get();

        // Get recent designs
        $recentDesigns = $designs->take(5);

        // Count statistics
        $totalDesigns = $designs->count();
        $pendingDesigns = $designs->where('status', 'pending')->count();
        $approvedDesigns = $designs->where('status', 'approved')->count();
        $totalReviews = $reviews->count();

        return view('designer.dashboard', compact(
            'designs',
            'reviews',
            'recentDesigns',
            'totalDesigns',
            'pendingDesigns',
            'approvedDesigns',
            'totalReviews'
        ));
    }
}
