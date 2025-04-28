<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Artwork;
use App\Models\Review;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    /**
     * Display a listing of approved wallpapers available in the shop.
     */
    public function index()
    {
        $wallpapers = Artwork::where('preview_status', 'approved')
            ->with(['user', 'design'])
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        return view('client.shop.index', compact('wallpapers'));
    }

    /**
     * Display the specified wallpaper.
     */
    public function show(Artwork $wallpaper)
    {
        // Check if the wallpaper has approved status
        if ($wallpaper->preview_status !== 'approved') {
            return redirect()->route('shop.index')
                ->with('error', 'This wallpaper is not available for purchase.');
        }

        // Load related data
        $wallpaper->load(['user', 'design', 'paper', 'reviews']);
        
        // Get reviews for this wallpaper
        $reviews = Review::where('artwork_id', $wallpaper->id)
            ->orderBy('created_at', 'desc')
            ->get();
            
        // Get related wallpapers (same design or by same artist)
        $relatedWallpapers = Artwork::where('preview_status', 'approved')
            ->where('id', '!=', $wallpaper->id)
            ->where(function($query) use ($wallpaper) {
                $query->where('design_id', $wallpaper->design_id)
                      ->orWhere('user_id', $wallpaper->user_id);
            })
            ->with(['user', 'design'])
            ->limit(4)
            ->get();
            
        return view('client.shop.show', compact('wallpaper', 'reviews', 'relatedWallpapers'));
    }
    
    /**
     * Store a review for a wallpaper.
     */
    public function storeReview(Request $request, Artwork $wallpaper)
    {
        // Validate the review data
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|min:10',
        ]);
        
        // Create the review
        $review = new Review();
        $review->artwork_id = $wallpaper->id;
        $review->name = $validated['name'];
        $review->email = $validated['email'];
        $review->rating = $validated['rating'];
        $review->comment = $validated['comment'];
        $review->save();
        
        return redirect()->route('shop.show', $wallpaper)
            ->with('success', 'Your review has been submitted. Thank you for your feedback!');
    }
    
    /**
     * Add a wallpaper to cart.
     */
    public function addToCart(Artwork $artwork)
    {
        // Check if wallpaper is approved
        if ($artwork->preview_status !== 'approved') {
            return redirect()->route('shop.index')
                ->with('error', 'This wallpaper is not available for purchase.');
        }
        
        // Get current cart from session or initialize empty array
        $cart = session()->get('cart', []);
        
        // Add artwork to cart
        $cart[$artwork->id] = [
            'id' => $artwork->id,
            'title' => $artwork->title,
            'price' => 149.99, // Placeholder price, should be fetched from a products table
            'image' => $artwork->preview_image_path,
            'width' => $artwork->width,
            'height' => $artwork->height,
            'quantity' => 1
        ];
        
        // Save cart in session
        session()->put('cart', $cart);
        
        return redirect()->back()
            ->with('success', 'Wallpaper added to cart successfully!');
    }
} 