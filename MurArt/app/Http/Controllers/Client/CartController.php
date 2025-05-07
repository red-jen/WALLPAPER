<?php

namespace App\Http\Controllers\Client;

use App\Models\Artwork;
use App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Order;
use App\Models\Wallpaper;
use App\Models\User;
use App\Models\Paper;
use Illuminate\Support\Facades\Log;
use Stripe;

use App\Http\Controllers\Controller;

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
        try {
            // Add debug log at start of checkout process
            Log::info('Starting checkout process', [
                'user_id' => auth()->id(),
                'session_id' => $request->session()->getId()
            ]);

            $userId = auth()->id();
            $cartItems = $this->getCartItems($request);

            if ($cartItems->isEmpty()) {
                return redirect()->route('cart.index')->with('error', 'Your cart is empty');
            }

            // Log cart items for debugging
            Log::info('Cart items found', [
                'count' => $cartItems->count(),
                'item_ids' => $cartItems->pluck('id')->toArray()
            ]);

            // Calculate totals
            $subtotal = $this->calculateSubtotal($cartItems);
            $tax = round($subtotal * 0.1, 2); // 10% tax
            $shipping = 15.00; // Flat shipping rate
            $total = $subtotal + $tax + $shipping;

            // Validate shipping info
            try {
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

                Log::info('Shipping info validated');
            } catch (\Exception $e) {
                Log::error('Validation error', [
                    'message' => $e->getMessage(),
                    'errors' => $request->all()
                ]);
                throw new \Exception('Please fill out all required shipping information: ' . $e->getMessage());
            }

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
            try {
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

                Log::info('Order created', ['order_id' => $order->id]);
            } catch (\Exception $e) {
                Log::error('Order creation failed', ['error' => $e->getMessage()]);
                throw new \Exception('Failed to create order: ' . $e->getMessage());
            }

            // Add order items
            try {
                Log::info('Creating order items', [
                    'order_id' => $order->id,
                    'cart_items_count' => $cartItems->count()
                ]);

                foreach ($cartItems as $item) {
                    // Debug log for each cart item
                    Log::info('Processing cart item', [
                        'item_id' => $item->id,
                        'artwork_id' => $item->artwork_id,
                        'wallpaper_id' => $item->wallpaper_id,
                        'has_artwork' => $item->artwork ? 'yes' : 'no',
                        'has_wallpaper' => $item->wallpaper ? 'yes' : 'no'
                    ]);

                    // Determine product name with fallback
                    $productName = 'Unnamed Product';

                    if ($item->artwork && $item->artwork->title) {
                        $productName = $item->artwork->title;
                    } elseif ($item->wallpaper && $item->wallpaper->title) {
                        $productName = $item->wallpaper->title;
                    } elseif (isset($item->name) && !empty($item->name)) {
                        // Use item name if directly available
                        $productName = $item->name;
                    }

                    // Create the order item with required name
                    DB::table('order_items')->insert([
                        'order_id' => $order->id,
                        'artwork_id' => $item->artwork_id,
                        'wallpaper_id' => $item->wallpaper_id,
                        'name' => $productName, // Explicitly include name
                        'quantity' => $item->quantity,
                        'price' => $item->price,
                        'options' => json_encode($item->options ?? []),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);

                    Log::info('Created order item with name', ['name' => $productName]);
                }

                Log::info('Order items created successfully');
            } catch (\Exception $e) {
                Log::error('Failed to create order items', [
                    'error' => $e->getMessage(),
                    'sql' => $e->getPrevious() ? $e->getPrevious()->getMessage() : null,
                    'trace' => $e->getTraceAsString()
                ]);
                throw new \Exception('Failed to create order items: ' . $e->getMessage());
            }

            try {
                // Verify Stripe API key exists
                $stripeSecret = config('services.stripe.secret');

                if (!$stripeSecret) {
                    Log::error('Stripe API key not configured');
                    throw new \Exception('Stripe API key is not configured');
                }

                // Log masked API key for debugging
                $maskedKey = substr($stripeSecret, 0, 4) . '****' . substr($stripeSecret, -4);
                Log::info('Using Stripe API key', ['masked_key' => $maskedKey]);

                // Set up Stripe with API key - use proper namespace
                try {
                    \Stripe\Stripe::setApiKey($stripeSecret);
                    Log::info('Stripe API key set successfully');
                } catch (\Exception $e) {
                    Log::error('Error setting Stripe API key', ['error' => $e->getMessage()]);
                    throw new \Exception('Failed to initialize Stripe: ' . $e->getMessage());
                }

                // Create line items for Stripe
                $lineItems = [];
                foreach ($cartItems as $item) {
                    $product = $item->artwork ?? $item->wallpaper;
                    $imageUrl = $product->getImageUrlAttribute() ?? 'https://via.placeholder.com/150';

                    // Format line items
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

                // Add tax and shipping as separate line items
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

                Log::info('Creating Stripe checkout session', [
                    'order_id' => $order->id,
                    'line_items_count' => count($lineItems)
                ]);

                // Create Stripe checkout session
                try {
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

                    Log::info('Stripe checkout session created', [
                        'session_id' => $checkoutSession->id
                    ]);
                } catch (\Exception $e) {
                    Log::error('Failed to create Stripe checkout session', [
                        'error' => $e->getMessage(),
                        'line' => $e->getLine(),
                        'file' => $e->getFile()
                    ]);
                    throw new \Exception('Failed to create payment session: ' . $e->getMessage());
                }

                // Save Stripe session ID to order
                $order->update([
                    'payment_id' => $checkoutSession->id,
                ]);

                // Clear cart items after order creation
                foreach ($cartItems as $item) {
                    $item->delete();
                }

                // Redirect to Stripe checkout
                return redirect()->away($checkoutSession->url);
            } catch (\Exception $e) {
                // Log Stripe-specific error details
                Log::error('Stripe checkout error', [
                    'message' => $e->getMessage(),
                    'file' => $e->getFile(),
                    'line' => $e->getLine(),
                    'order_id' => $order->id ?? 'not created'
                ]);

                // Update order status if order was created
                if (isset($order)) {
                    $order->update(['status' => 'payment_failed']);
                }

                return redirect()->route('cart.checkout')
                    ->with('error', 'Payment processing failed: ' . $e->getMessage());
            }
        } catch (\Exception $e) {
            // Main error handling
            Log::error('Checkout process error', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->route('cart.checkout')
                ->with('error', $e->getMessage());
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
     * Handle successful checkout from Stripe
     */
    public function checkoutSuccess(Request $request)
    {
        try {
            $orderId = $request->order_id;
            $sessionId = $request->session_id;

            Log::info('Checkout success callback received', [
                'order_id' => $orderId,
                'session_id' => $sessionId
            ]);

            if (!$orderId) {
                throw new \Exception('Order ID is missing from the request.');
            }

            $order = Order::findOrFail($orderId);

            // Verify the session ID if provided
            if ($sessionId && $order->payment_id !== $sessionId) {
                Log::warning('Session ID mismatch', [
                    'order_payment_id' => $order->payment_id,
                    'request_session_id' => $sessionId
                ]);
                // Continue anyway since the user reached the success page
            }

            // Update order status to confirmed/paid
            $order->update([
                'status' => 'confirmed',
                'payment_status' => 'paid',
            ]);

            Log::info('Order status updated to confirmed/paid', ['order_id' => $orderId]);

            // You could send confirmation email here

            return view('cart.success', [
                'order' => $order,
                'orderNumber' => $order->order_number
            ]);
        } catch (\Exception $e) {
            Log::error('Error in checkout success', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->route('client.dashboard')
                ->with('error', 'There was an issue confirming your order. Please contact support.');
        }
    }

    /**
     * Handle cancelled checkout from Stripe
     */
    public function checkoutCancel(Request $request)
    {
        try {
            $orderId = $request->order_id;

            Log::info('Checkout cancelled', ['order_id' => $orderId]);

            if ($orderId) {
                $order = Order::find($orderId);

                if ($order) {
                    // Update order status to cancelled
                    $order->update([
                        'status' => 'cancelled',
                        'payment_status' => 'cancelled',
                    ]);

                    Log::info('Order status updated to cancelled', ['order_id' => $orderId]);
                }
            }

            return view('cart.cancelled')
                ->with('message', 'Your order has been cancelled. No payment has been processed.');
        } catch (\Exception $e) {
            Log::error('Error in checkout cancel', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->route('cart.index')
                ->with('error', 'There was an issue with your order. Please try again or contact support.');
        }
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
