<?php

namespace App\Http\Controllers;

use App\Models\Artwork;
use App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CartController extends Controller
{
    /**
     * Display the shopping cart
     */
    public function index(Request $request)
    {
        $cartItems = $this->getCartItems($request);
        $subtotal = $this->calculateSubtotal($cartItems);
        
        return view('cart.index', compact('cartItems', 'subtotal'));
    }
    
    /**
     * Add an artwork to cart
     */
    public function addArtwork(Request $request, Artwork $artwork)
    {
        // Check if artwork preview is approved
        if ($artwork->preview_status !== 'approved') {
            return redirect()->route('artworks.show', $artwork)
                ->with('error', 'This artwork preview must be approved before adding to cart.');
        }
        
        // Get user or session ID
        $userId = auth()->id();
        $sessionId = $this->getSessionId($request);
        
        // Check if item is already in cart
        $existingItem = CartItem::where(function ($query) use ($userId, $sessionId) {
            if ($userId) {
                $query->where('user_id', $userId);
            } else {
                $query->where('session_id', $sessionId);
            }
        })->where('artwork_id', $artwork->id)->first();
        
        if ($existingItem) {
            // Update quantity
            $existingItem->update([
                'quantity' => $existingItem->quantity + 1
            ]);
        } else {
            // Create new cart item
            CartItem::create([
                'user_id' => $userId,
                'session_id' => $userId ? null : $sessionId,
                'artwork_id' => $artwork->id,
                'quantity' => 1,
                'price' => $artwork->calculatePrice(),
                'options' => [
                    'width' => $artwork->width,
                    'height' => $artwork->height,
                    'paper' => $artwork->paper->name,
                ]
            ]);
        }
        
        return redirect()->route('cart.index')
            ->with('success', "{$artwork->title} added to your cart.");
    }
    
    /**
     * Remove an item from cart
     */
    public function removeItem(Request $request, CartItem $item)
    {
        // Security check
        if (!$this->canAccessCartItem($request, $item)) {
            abort(403, 'Unauthorized action.');
        }
        
        $item->delete();
        
        return redirect()->route('cart.index')
            ->with('success', 'Item removed from cart.');
    }
    
    /**
     * Update cart item quantity
     */
    public function updateItem(Request $request, CartItem $item)
    {
        // Security check
        if (!$this->canAccessCartItem($request, $item)) {
            abort(403, 'Unauthorized action.');
        }
        
        $request->validate([
            'quantity' => 'required|integer|min:1|max:10'
        ]);
        
        $item->update([
            'quantity' => $request->quantity
        ]);
        
        return redirect()->route('cart.index')
            ->with('success', 'Cart updated successfully.');
    }
    
    /**
     * Show checkout page
     */
    public function checkout(Request $request)
    {
        $cartItems = $this->getCartItems($request);
        
        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')
                ->with('error', 'Your cart is empty.');
        }
        
        $subtotal = $this->calculateSubtotal($cartItems);
        $tax = $subtotal * 0.1; // 10% tax example
        $shipping = 15.00; // Flat shipping rate
        $total = $subtotal + $tax + $shipping;
        
        return view('cart.checkout', compact('cartItems', 'subtotal', 'tax', 'shipping', 'total'));
    }
    
    /**
     * Get cart items for current user or session
     */
    private function getCartItems(Request $request)
    {
        $userId = auth()->id();
        $sessionId = $this->getSessionId($request);
        
        return CartItem::where(function ($query) use ($userId, $sessionId) {
            if ($userId) {
                $query->where('user_id', $userId);
            } else {
                $query->where('session_id', $sessionId);
            }
        })->with(['artwork.paper', 'artwork.design', 'wallpaper'])->get();
    }
    
    /**
     * Get or create session ID for guest carts
     */
    private function getSessionId(Request $request)
    {
        if (!$request->session()->has('cart_session_id')) {
            $request->session()->put('cart_session_id', Str::uuid()->toString());
        }
        
        return $request->session()->get('cart_session_id');
    }
    
    /**
     * Check if user can access cart item
     */
    private function canAccessCartItem(Request $request, CartItem $item)
    {
        $userId = auth()->id();
        $sessionId = $this->getSessionId($request);
        
        // Check if cart item belongs to current user or session
        return ($userId && $item->user_id === $userId) || 
               (!$userId && $item->session_id === $sessionId);
    }
    
    /**
     * Calculate subtotal for cart items
     */
    private function calculateSubtotal($cartItems)
    {
        return $cartItems->sum(function ($item) {
            return $item->price * $item->quantity;
        });
    }
}