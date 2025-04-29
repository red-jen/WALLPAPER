<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Wallpaper;
use App\Models\Review;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\CartItem;

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
    
  
     public function addToCart(Wallpaper $wallpaper, Request $request)
     {
         // Validate quantity
         $request->validate([
             'quantity' => 'required|integer|min:1',
         ]);
         
         // Get quantity from request
         $quantity = $request->quantity;
         
         // Check if wallpaper is in stock
         if ($wallpaper->stock <= 0) {
             return redirect()->back()
                 ->with('error', 'This wallpaper is currently out of stock.');
         }
         
         // Get user ID if logged in, otherwise use session ID
         $userId = auth()->id();
         $sessionId = $userId ? null : session()->getId();
         
         // Check if item already exists in cart
         $cartItem = CartItem::where('wallpaper_id', $wallpaper->id)
             ->where(function($query) use ($userId, $sessionId) {
                 if ($userId) {
                     $query->where('user_id', $userId);
                 } else {
                     $query->where('session_id', $sessionId);
                 }
             })
             ->first();
         
         if ($cartItem) {
             // Update existing cart item
             $cartItem->quantity += $quantity;
             $cartItem->save();
         } else {
             // Create new cart item
             CartItem::create([
                 'user_id' => $userId,
                 'session_id' => $sessionId,
                 'wallpaper_id' => $wallpaper->id,
                 'quantity' => $quantity,
                 'price' => $wallpaper->price,
                 'options' => []
             ]);
         }
         
         return redirect()->back()
             ->with('success', 'Wallpaper added to cart successfully!');
     }
} 