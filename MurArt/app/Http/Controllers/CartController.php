<?php

namespace App\Http\Controllers;

use App\Models\Artwork;
use App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\Wallpaper;
use App\Models\User;
use App\Models\Paper;
use Illuminate\Http\Controller as BaseController;
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
    


    
public function processCheckout(Request $request)
{
    $userId = auth()->id();
    $cartItems = $this->getCartItems($request);
    
    if ($cartItems->isEmpty()) {
        return redirect()->route('cart.index')->with('error', 'Your cart is empty');
    }
    
    // Calculate totals
    $subtotal = $this->calculateSubtotal($cartItems);
    $tax = round($subtotal * 0.1, 2); // 10% tax
    $shipping = 15.00; // Flat shipping rate
    $total = $subtotal + $tax + $shipping;
    
    // Validate shipping info
    $validatedData = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'phone' => 'required|string|max:20',
        'address' => 'required|string|max:255',
        'city' => 'required|string|max:255',
        'postal_code' => 'required|string|max:20',
        'state' => 'required|string|max:255',
        'country' => 'required|string|max:2',
        'notes' => 'nullable|string',
    ]);
    
    // Format shipping address
    $shippingAddress = json_encode([
        'name' => $validatedData['name'],
        'address' => $validatedData['address'],
        'city' => $validatedData['city'],
        'postal_code' => $validatedData['postal_code'],
        'state' => $validatedData['state'],
        'country' => $validatedData['country'],
        'phone' => $validatedData['phone'],
    ]);
    
    // Use billing address or shipping address based on checkbox
    $billingAddress = $shippingAddress;
    if (!$request->has('same_billing')) {
        $billingAddress = json_encode([
            'name' => $request->billing_name,
            'address' => $request->billing_address,
            'city' => $request->billing_city,
            'postal_code' => $request->billing_postal_code,
            'state' => $request->billing_state,
            'country' => $request->billing_country,
        ]);
    }
    
    // Create pending order
    $order = Order::create([
        'user_id' => $userId,
        'order_number' => 'ORD-' . strtoupper(uniqid()),
        'subtotal' => $subtotal,
        'tax' => $tax,
        'shipping' => $shipping,
        'total' => $total,
        'status' => 'pending',
        'payment_status' => 'pending',
        'shipping_address' => $shippingAddress,
        'billing_address' => $billingAddress,
        'notes' => $validatedData['notes'] ?? null,
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
        // Make sure Stripe API key is set
        if (!config('services.stripe.secret')) {
            throw new \Exception('Stripe API key is not configured');
        }

        // Set up Stripe
        \Stripe\Stripe::setApiKey(config('services.stripe.secret'));
        
        // Create line items for Stripe
        $lineItems = [];
        foreach ($cartItems as $item) {
            $product = $item->artwork ?? $item->wallpaper;
            $imageUrl = $product->getImageUrlAttribute() ?? 'https://via.placeholder.com/150';
            
            $lineItems[] = [
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => $product->title,
                        'description' => $item->artwork ? "Custom Artwork" : "Wallpaper",
                        'images' => [$imageUrl],
                    ],
                    'unit_amount' => intval($item->price * 100), // Convert to cents
                ],
                'quantity' => $item->quantity,
            ];
        }
        
        // Add tax and shipping
        $lineItems[] = [
            'price_data' => [
                'currency' => 'usd',
                'product_data' => [
                    'name' => 'Tax',
                    'description' => '10% Sales Tax',
                ],
                'unit_amount' => intval($tax * 100),
            ],
            'quantity' => 1,
        ];
        
        $lineItems[] = [
            'price_data' => [
                'currency' => 'usd',
                'product_data' => [
                    'name' => 'Shipping',
                    'description' => 'Standard Shipping',
                ],
                'unit_amount' => intval($shipping * 100),
            ],
            'quantity' => 1,
        ];
        
        // Create Stripe checkout session
        $checkoutSession = \Stripe\Checkout\Session::create([
            'payment_method_types' => ['card'],
            'line_items' => $lineItems,
            'mode' => 'payment',
            'success_url' => route('checkout.success') . '?order_id=' . $order->id . '&session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('checkout.cancel') . '?order_id=' . $order->id,
            'customer_email' => $validatedData['email'],
            'metadata' => [
                'order_id' => $order->id,
                'user_id' => $userId,
            ],
        ]);
        
        // Save Stripe session ID to order
        $order->update([
            'payment_id' => $checkoutSession->id,
        ]);
        
        // Direct redirect to Stripe for traditional form submission
        return redirect($checkoutSession->url);
        
    } catch (\Exception $e) {
        // Log the error for debugging
        \Log::error('Stripe checkout error: ' . $e->getMessage());
        
        return redirect()->back()->with('error', 'Payment processing failed: ' . $e->getMessage());
    }
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