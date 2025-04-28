<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CartController extends Controller
{
    // ... other methods ...

    /**
     * Process checkout with Stripe
     */

     /**
 * Show the checkout page
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
    public function processCheckout(Request $request)
    {
        // Get cart items
        $cartItems = $this->getCartItems($request);
        
        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty');
        }
        
        // Calculate totals
        $subtotal = $this->calculateSubtotal($cartItems);
        $tax = round($subtotal * 0.1, 2);
        $shipping = 15.00;
        $total = $subtotal + $tax + $shipping;
        
        // Create order
        $order = Order::create([
            'user_id' => auth()->id(),
            'order_number' => 'ORD-' . strtoupper(uniqid()),
            'subtotal' => $subtotal,
            'tax' => $tax,
            'shipping' => $shipping,
            'total' => $total,
            'status' => 'pending',
            'payment_status' => 'pending',
            'shipping_address' => json_encode([
                'name' => $request->name,
                'address' => $request->address,
                'city' => $request->city,
                'state' => $request->state,
                'postal_code' => $request->postal_code,
                'country' => $request->country,
            ]),
            'notes' => $request->notes,
        ]);
        
        // Add order items
        foreach ($cartItems as $item) {
            $order->items()->create([
                'artwork_id' => $item->artwork_id,
                'wallpaper_id' => $item->wallpaper_id,
                'name' => $item->artwork ? $item->artwork->title : $item->wallpaper->title,
                'quantity' => $item->quantity,
                'price' => $item->price,
                'options' => $item->options,
            ]);
        }
        
        try {
            if (!config('services.stripe.secret')) {
                return redirect()->back()->with('error', 'Stripe API key is not configured.');
            }
        
            // Set the API key
            \Stripe\Stripe::setApiKey(config('services.stripe.secret'));
            
            // Create Stripe checkout session
            $session = \Stripe\Checkout\Session::create([
                'payment_method_types' => ['card'],
                'line_items' => [[
                    'price_data' => [
                        'currency' => 'usd',
                        'unit_amount' => intval($total * 100), // in cents
                        'product_data' => [
                            'name' => 'Order #' . $order->order_number,
                            'description' => 'Purchase from MurArt',
                        ],
                    ],
                    'quantity' => 1,
                ]],
                'mode' => 'payment',
                'success_url' => route('checkout.success') . '?order_id=' . $order->id,
                'cancel_url' => route('checkout.cancel') . '?order_id=' . $order->id,
                'client_reference_id' => $order->id,
            ]);
            
            // Update order with session ID
            $order->update(['payment_id' => $session->id]);
            
            // Redirect to Stripe checkout
            return redirect($session->url);
            
        } catch (\Exception $e) {
            Log::error('Stripe checkout error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Payment processing failed: ' . $e->getMessage());
        }
    }
    
    /**
     * Handle successful checkout
     */
    public function checkoutSuccess(Request $request)
    {
        $orderId = $request->order_id;
        $order = Order::findOrFail($orderId);
        
        // Update order status
        $order->update([
            'status' => 'processing',
            'payment_status' => 'paid',
            'payment_method' => 'stripe',
        ]);
        
        // Clear cart
        $this->clearCart($request);
        
        return view('cart.checkout-success', compact('order'));
    }
    
    /**
     * Handle cancelled checkout
     */
    public function checkoutCancel(Request $request)
    {
        $orderId = $request->order_id;
        $order = Order::findOrFail($orderId);
        
        // Update order status
        $order->update([
            'status' => 'cancelled',
            'payment_status' => 'cancelled',
        ]);
        
        return redirect()->route('cart.index')->with('error', 'Payment was cancelled');
    }
    
    /**
     * Clear cart after checkout
     */
    private function clearCart(Request $request)
    {
        $userId = auth()->id();
        $sessionId = $this->getSessionId($request);
        
        if ($userId) {
            CartItem::where('user_id', $userId)->delete();
        } else {
            CartItem::where('session_id', $sessionId)->delete();
        }
    }
}