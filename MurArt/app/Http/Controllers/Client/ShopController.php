<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Wallpaper;
use App\Models\Review;
use Illuminate\Http\Request;
use App\Models\Category;

class ShopController extends Controller
{
    /**
     * Display a listing of wallpapers available in the shop.
     */
    public function index(Request $request)
    {
        $wallpapers = Wallpaper::with(['category', 'images', 'reviews'])
            ->when($request->category, function($query, $category) {
                return $query->where('category_id', $category);
            })
            ->when($request->sort, function($query, $sort) {
                switch($sort) {
                    case 'price_low':
                        return $query->orderBy('price', 'asc');
                    case 'price_high':
                        return $query->orderBy('price', 'desc');
                    case 'popular':
                        return $query->orderBy('downloads', 'desc');
                    default:
                        return $query->latest();
                }
            }, function($query) {
                return $query->latest();
            })
            ->paginate(12);
            
        // Fetch categories for the filter
        $categories = Category::all();

        return view('client.shop.index', compact('wallpapers', 'categories'));
    }

    /**
     * Display the specified wallpaper.
     */
    public function show(Wallpaper $wallpaper)
    {
        // Load related data
        $wallpaper->load(['category', 'images', 'reviews', 'papers']);
        
        // Get reviews for this wallpaper
        $reviews = Review::where('wallpaper_id', $wallpaper->id)
            ->where('is_approved', true)
            ->orderBy('created_at', 'desc')
            ->get();
            
        // Get related wallpapers (same category)
        $relatedWallpapers = Wallpaper::where('category_id', $wallpaper->category_id)
            ->where('id', '!=', $wallpaper->id)
            ->where('status', 'published')
            ->with(['category', 'images'])
            ->limit(4)
            ->get();
            
        return view('client.shop.show', compact('wallpaper', 'reviews', 'relatedWallpapers'));
    }
    
    /**
     * Store a review for a wallpaper.
     */
    public function storeReview(Request $request, Wallpaper $wallpaper)
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
        $review->wallpaper_id = $wallpaper->id;
        $review->name = $validated['name'];
        $review->email = $validated['email'];
        $review->rating = $validated['rating'];
        $review->comment = $validated['comment'];
        $review->is_approved = false; // Needs approval
        $review->save();
        
        return redirect()->route('shop.show', $wallpaper)
            ->with('success', 'Your review has been submitted and will be visible after approval. Thank you for your feedback!');
    }
    
    /**
     * Add a wallpaper to cart.
     */
    public function addToCart(Wallpaper $wallpaper, Request $request)
    {
        // Check if wallpaper is in stock - use direct property access for consistency
        if ($wallpaper->stock <= 0) {
            return redirect()->route('shop.index')
                ->with('error', 'This wallpaper is currently out of stock.');
        }
        
        // Get current cart from session or initialize empty array
        $cart = session()->get('cart', []);
        
        // Check if item already exists in cart
        if (isset($cart[$wallpaper->id])) {
            // Increment quantity if it exists
            $cart[$wallpaper->id]['quantity']++;
        } else {
            // Add new item to cart
            $cart[$wallpaper->id] = [
                'id' => $wallpaper->id,
                'title' => $wallpaper->title,
                'price' => $wallpaper->price,
                'image' => $wallpaper->getImageUrlAttribute(),
                'quantity' => 1
            ];
        }
        
        // Save cart in session
        session()->put('cart', $cart);
        
        return redirect()->back()
            ->with('success', 'Wallpaper added to cart successfully!');
    }
} 