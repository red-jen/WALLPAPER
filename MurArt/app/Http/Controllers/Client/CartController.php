<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Artwork;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
class CartController extends Controller
{
    /**
     * Display the cart contents
     */
    public function checkout(Request $request)
{
    // Get cart items
    $cartItems = $this->getCartItems($request);
    
    if ($cartItems->isEmpty()) {
        return redirect()->route('cart.index')->with('error', 'Your cart is empty');
    }
    
    // Calculate totals
    $subtotal = $this->calculateSubtotal($cartItems);
    $tax = round($subtotal * 0.1, 2); // 10% tax
    $shipping = 15.00; // Flat shipping rate
    $total = $subtotal + $tax + $shipping;
    
    return view('cart.checkout', compact('cartItems', 'subtotal', 'tax', 'shipping', 'total'));
}

/**
 * Get cart items for the current user or session
 */
private function getCartItems(Request $request)
{
    $userId = auth()->id();
    $sessionId = $this->getSessionId($request);
    
    $query = CartItem::with(['artwork', 'wallpaper']);
    
    if ($userId) {
        $query->where('user_id', $userId);
    } else {
        $query->where('session_id', $sessionId);
    }
    
    return $query->get();
}

/**
 * Calculate subtotal for cart items
 */
private function calculateSubtotal($cartItems)
{
    $subtotal = 0;
    
    foreach ($cartItems as $item) {
        $subtotal += $item->price * $item->quantity;
    }
    
    return $subtotal;
}

/**
 * Get or create a session ID for guest users
 */
private function getSessionId(Request $request)
{
    if (!$request->session()->has('cart_session_id')) {
        $request->session()->put('cart_session_id', uniqid());
    }
    
    return $request->session()->get('cart_session_id');
}
    public function index()
    {
        $cartItems = Session::get('cart', []);
        $wallpapers = [];
        $total = 0;
        
        // Load the artwork data for each cart item
        foreach ($cartItems as $id => $quantity) {
            $artwork = Artwork::with(['design', 'paper', 'user'])
                ->where('preview_status', 'approved')
                ->find($id);
                
            if ($artwork) {
                $wallpapers[$id] = [
                    'artwork' => $artwork,
                    'quantity' => $quantity,
                    'subtotal' => $artwork->price * $quantity
                ];
                $total += $wallpapers[$id]['subtotal'];
            }
        }
        
        return view('client.cart.index', compact('wallpapers', 'total'));
    }
    
    /**
     * Add an artwork to the cart
     */
    public function add(Artwork $artwork)
    {
        // Make sure the artwork is approved
        if ($artwork->preview_status !== 'approved') {
            return redirect()->back()->with('error', 'Sorry, this wallpaper is not available.');
        }
        
        // Get current cart
        $cart = Session::get('cart', []);
        
        // Add or increment
        if (isset($cart[$artwork->id])) {
            $cart[$artwork->id]++;
        } else {
            $cart[$artwork->id] = 1;
        }
        
        // Update cart
        Session::put('cart', $cart);
        
        return redirect()->back()->with('success', 'Wallpaper added to cart!');
    }
    
    /**
     * Update cart quantity
     */
    public function update(Request $request)
    {
        $request->validate([
            'quantities' => 'required|array',
            'quantities.*' => 'required|integer|min:0'
        ]);
        
        $cart = Session::get('cart', []);
        $quantities = $request->input('quantities');
        
        foreach ($quantities as $id => $quantity) {
            if ($quantity > 0) {
                $cart[$id] = $quantity;
            } else {
                unset($cart[$id]);
            }
        }
        
        Session::put('cart', $cart);
        
        return redirect()->route('cart.index')->with('success', 'Cart updated successfully!');
    }
    
    /**
     * Remove an item from the cart
     */
    public function remove($id)
    {
        $cart = Session::get('cart', []);
        
        if (isset($cart[$id])) {
            unset($cart[$id]);
            Session::put('cart', $cart);
        }
        
        return redirect()->route('cart.index')->with('success', 'Item removed from cart!');
    }
    
    /**
     * Checkout process
     */
 /**
 * Show the checkout page
 */

} 