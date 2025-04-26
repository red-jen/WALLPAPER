<?php

namespace App\Http\Controllers;

use App\Models\Design;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    /**
     * Store a new review.
     */
    public function store(Request $request, Design $design)
    {
        // Validate request
        $validatedData = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:500',
        ]);
        
        // Check if user already reviewed this design
        $existingReview = Review::where('user_id', Auth::id())
            ->where('design_id', $design->id)
            ->first();
            
        if ($existingReview) {
            // Update existing review
            $existingReview->rating = $validatedData['rating'];
            $existingReview->comment = $validatedData['comment'];
            $existingReview->is_approved = false; // Reset for moderation
            $existingReview->save();
            
            $message = 'Your review has been updated and will be visible after approval.';
        } else {
            // Create a new review
            Review::create([
                'user_id' => Auth::id(),
                'design_id' => $design->id,
                'rating' => $validatedData['rating'],
                'comment' => $validatedData['comment'],
                'is_approved' => false, // Needs approval
            ]);
            
            $message = 'Your review has been submitted and will be visible after approval.';
        }
        
        return redirect()->back()->with('success', $message);
    }
    
    /**
     * Delete a review.
     */
    public function destroy(Review $review)
    {
        // Verify ownership
        if ($review->user_id !== Auth::id()) {
            return redirect()->back()->with('error', 'You are not authorized to delete this review.');
        }
        
        $review->delete();
        
        return redirect()->back()->with('success', 'Review deleted successfully.');
    }
}