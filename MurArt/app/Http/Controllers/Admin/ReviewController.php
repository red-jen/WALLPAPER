<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    /**
     * Display a listing of the reviews.
     */
    public function index()
    {
        $pendingReviews = Review::where('is_approved', false)
            ->with(['user', 'design'])
            ->latest()
            ->paginate(10);
            
        $approvedReviews = Review::where('is_approved', true)
            ->with(['user', 'design'])
            ->latest()
            ->paginate(10);
            
        return view('admin.reviews.index', compact('pendingReviews', 'approvedReviews'));
    }

    /**
     * Approve a review.
     */
    public function approve(Review $review)
    {
        $review->is_approved = true;
        $review->save();
        
        return redirect()->back()->with('success', 'Review approved successfully.');
    }
    
    /**
     * Delete a review.
     */
    public function destroy(Review $review)
    {
        $review->delete();
        
        return redirect()->back()->with('success', 'Review deleted successfully.');
    }
}