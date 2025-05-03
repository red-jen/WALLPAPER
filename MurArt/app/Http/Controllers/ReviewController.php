<?php

namespace App\Http\Controllers;

use App\Models\Design;
use App\Models\Wallpaper;
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
     * Store a new wallpaper review.
     */
    public function storeWallpaperReview(Request $request, Wallpaper $wallpaper)
    {
        // Validate request
        $validatedData = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:500',
        ]);

        // Check if user already reviewed this wallpaper
        $existingReview = Review::where('user_id', Auth::id())
            ->where('wallpaper_id', $wallpaper->id)
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
                'wallpaper_id' => $wallpaper->id,
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

    /**
     * Display a listing of the reviews for admin management.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $reviews = Review::with(['user', 'design', 'wallpaper'])
            ->latest()
            ->paginate(15);

        $totalReviews = Review::count();

        return view('admin.reviews.index', compact(
            'reviews',
            'totalReviews'
        ));
    }

    /**
     * Approve a review.
     *
     * @param  \App\Models\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function approve(Review $review)
    {
        $review->is_approved = true;
        $review->save();

        return redirect()->back()->with('success', 'Review has been approved.');
    }

    /**
     * Get a review's details for AJAX requests.
     *
     * @param  \App\Models\Review  $review
     * @return \Illuminate\Http\JsonResponse
     */
    public function getReviewDetails(Review $review)
    {
        $review->load(['user', 'reviewable']);
        $review->created_at_formatted = $review->created_at->format('M d, Y g:i A');

        return response()->json($review);
    }
}
