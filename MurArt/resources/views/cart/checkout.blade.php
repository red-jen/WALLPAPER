@extends('layouts.app')

@section('content')
<div class="container py-6">
    <div class="max-w-5xl mx-auto">
        <h1 class="text-3xl font-bold mb-6">Checkout</h1>
        
        @if(session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded">
                {{ session('error') }}
            </div>
        @endif
        
        <form id="checkout-form" action="{{ route('checkout.process') }}" method="POST">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Left Column: Shipping Form -->
                <div class="md:col-span-2">
                    <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
                        <div class="p-4 border-b border-gray-200 bg-gray-50">
                            <h2 class="font-medium">Shipping Information</h2>
                        </div>
                        
                        <div class="p-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                                    <input type="text" name="name" id="name" value="{{ old('name', auth()->user()->name) }}" class="w-full rounded-md border-gray-300" required>
                                    @error('name')
                                        <span class="text-red-600 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>
                                
                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                                    <input type="email" name="email" id="email" value="{{ old('email', auth()->user()->email) }}" class="w-full rounded-md border-gray-300" required>
                                    @error('email')
                                        <span class="text-red-600 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>
                                
                                <div>
                                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                                    <input type="tel" name="phone" id="phone" value="{{ old('phone', auth()->user()->phone ?? '') }}" class="w-full rounded-md border-gray-300" required>
                                    @error('phone')
                                        <span class="text-red-600 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>
                                
                                <div>
                                    <label for="address" class="block text-sm font-medium text-gray-700 mb-1">Address</label>
                                    <input type="text" name="address" id="address" value="{{ old('address') }}" class="w-full rounded-md border-gray-300" required>
                                    @error('address')
                                        <span class="text-red-600 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>
                                
                                <div>
                                    <label for="city" class="block text-sm font-medium text-gray-700 mb-1">City</label>
                                    <input type="text" name="city" id="city" value="{{ old('city') }}" class="w-full rounded-md border-gray-300" required>
                                    @error('city')
                                        <span class="text-red-600 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>
                                
                                <div>
                                    <label for="postal_code" class="block text-sm font-medium text-gray-700 mb-1">Postal Code</label>
                                    <input type="text" name="postal_code" id="postal_code" value="{{ old('postal_code') }}" class="w-full rounded-md border-gray-300" required>
                                    @error('postal_code')
                                        <span class="text-red-600 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>
                                
                                <div>
                                    <label for="state" class="block text-sm font-medium text-gray-700 mb-1">State/Province</label>
                                    <input type="text" name="state" id="state" value="{{ old('state') }}" class="w-full rounded-md border-gray-300" required>
                                    @error('state')
                                        <span class="text-red-600 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>
                                
                                <div>
                                    <label for="country" class="block text-sm font-medium text-gray-700 mb-1">Country</label>
                                    <select name="country" id="country" class="w-full rounded-md border-gray-300" required>
                                        <option value="">Select Country</option>
                                        <option value="US" {{ old('country') == 'US' ? 'selected' : '' }}>United States</option>
                                        <option value="CA" {{ old('country') == 'CA' ? 'selected' : '' }}>Canada</option>
                                        <option value="GB" {{ old('country') == 'GB' ? 'selected' : '' }}>United Kingdom</option>
                                        <option value="FR" {{ old('country') == 'FR' ? 'selected' : '' }}>France</option>
                                        <option value="DE" {{ old('country') == 'DE' ? 'selected' : '' }}>Germany</option>
                                        <option value="AU" {{ old('country') == 'AU' ? 'selected' : '' }}>Australia</option>
                                        <option value="JP" {{ old('country') == 'JP' ? 'selected' : '' }}>Japan</option>
                                    </select>
                                    @error('country')
                                        <span class="text-red-600 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="mt-6">
                                <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">Order Notes (Optional)</label>
                                <textarea name="notes" id="notes" rows="3" class="w-full rounded-md border-gray-300">{{ old('notes') }}</textarea>
                                @error('notes')
                                    <span class="text-red-600 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                            
                            <!-- Use same address for billing -->
                            <div class="mt-6 flex items-center">
                                <input type="checkbox" name="same_billing" id="same_billing" class="rounded border-gray-300 text-indigo-600" value="1" checked>
                                <label for="same_billing" class="ml-2 text-sm text-gray-700">Use same address for billing</label>
                            </div>
                            
                            <!-- Billing address fields (shown when checkbox is unchecked) -->
                            <div id="billing-fields" class="mt-6 hidden">
                                <h3 class="text-lg font-medium mb-4 border-t pt-4">Billing Address</h3>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label for="billing_name" class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                                        <input type="text" name="billing_name" id="billing_name" value="{{ old('billing_name') }}" class="w-full rounded-md border-gray-300">
                                    </div>
                                    
                                    <div>
                                        <label for="billing_address" class="block text-sm font-medium text-gray-700 mb-1">Address</label>
                                        <input type="text" name="billing_address" id="billing_address" value="{{ old('billing_address') }}" class="w-full rounded-md border-gray-300">
                                    </div>
                                    
                                    <div>
                                        <label for="billing_city" class="block text-sm font-medium text-gray-700 mb-1">City</label>
                                        <input type="text" name="billing_city" id="billing_city" value="{{ old('billing_city') }}" class="w-full rounded-md border-gray-300">
                                    </div>
                                    
                                    <div>
                                        <label for="billing_postal_code" class="block text-sm font-medium text-gray-700 mb-1">Postal Code</label>
                                        <input type="text" name="billing_postal_code" id="billing_postal_code" value="{{ old('billing_postal_code') }}" class="w-full rounded-md border-gray-300">
                                    </div>
                                    
                                    <div>
                                        <label for="billing_state" class="block text-sm font-medium text-gray-700 mb-1">State/Province</label>
                                        <input type="text" name="billing_state" id="billing_state" value="{{ old('billing_state') }}" class="w-full rounded-md border-gray-300">
                                    </div>
                                    
                                    <div>
                                        <label for="billing_country" class="block text-sm font-medium text-gray-700 mb-1">Country</label>
                                        <select name="billing_country" id="billing_country" class="w-full rounded-md border-gray-300">
                                            <option value="">Select Country</option>
                                            <option value="US" {{ old('billing_country') == 'US' ? 'selected' : '' }}>United States</option>
                                            <option value="CA" {{ old('billing_country') == 'CA' ? 'selected' : '' }}>Canada</option>
                                            <option value="GB" {{ old('billing_country') == 'GB' ? 'selected' : '' }}>United Kingdom</option>
                                            <option value="FR" {{ old('billing_country') == 'FR' ? 'selected' : '' }}>France</option>
                                            <option value="DE" {{ old('billing_country') == 'DE' ? 'selected' : '' }}>Germany</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Right Column: Order Summary -->
                <div class="md:col-span-1">
                    <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
                        <div class="p-4 border-b border-gray-200 bg-gray-50">
                            <h2 class="font-medium">Order Summary</h2>
                        </div>
                        
                        <div class="p-6">
                            <div class="mb-6">
                                @foreach($cartItems as $item)
                                    <div class="flex justify-between py-2 border-b">
                                        <div class="flex items-center">
                                            <div>
                                                <p class="font-medium">
                                                    {{ $item->artwork ? $item->artwork->title : $item->wallpaper->title }} 
                                                    <span class="text-gray-500">x {{ $item->quantity }}</span>
                                                </p>
                                                <p class="text-sm text-gray-500">
                                                    @if($item->artwork && isset($item->options) && is_array($item->options))
                                                        {{ $item->options['width'] ?? $item->artwork->width }}cm × 
                                                        {{ $item->options['height'] ?? $item->artwork->height }}cm, 
                                                        {{ $item->options['paper'] ?? ($item->artwork->paper->name ?? 'Standard Paper') }}
                                                    @endif
                                                </p>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <p>${{ number_format($item->price * $item->quantity, 2) }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            
                            <div class="mb-6 space-y-2">
                                <div class="flex justify-between">
                                    <p class="text-gray-600">Subtotal</p>
                                    <p class="font-medium">${{ number_format($subtotal, 2) }}</p>
                                </div>
                                <div class="flex justify-between">
                                    <p class="text-gray-600">Tax</p>
                                    <p class="font-medium">${{ number_format($tax, 2) }}</p>
                                </div>
                                <div class="flex justify-between">
                                    <p class="text-gray-600">Shipping</p>
                                    <p class="font-medium">${{ number_format($shipping, 2) }}</p>
                                </div>
                                <div class="flex justify-between border-t pt-2 mt-2">
                                    <p class="font-bold">Total</p>
                                    <p class="font-bold">${{ number_format($total, 2) }}</p>
                                </div>
                            </div>
                            
                            <!-- Payment method selection -->
                            <div class="mb-6">
                                <h3 class="text-sm font-medium text-gray-700 mb-3">Payment Method</h3>
                                <div class="space-y-3">
                                    <div class="flex items-center">
                                        <input id="payment-card" name="payment_method" type="radio" checked value="card" class="h-4 w-4 text-indigo-600 border-gray-300 focus:ring-indigo-500">
                                        <label for="payment-card" class="ml-3 block text-sm font-medium text-gray-700">
                                            Credit / Debit Card
                                        </label>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mb-6">
                                <button type="submit" id="payment-button" class="w-full bg-indigo-600 text-white py-3 px-4 rounded-md hover:bg-indigo-700">
                                    Complete Order
                                </button>
                            </div>
                            
                            <p class="text-sm text-gray-500 text-center">
                                Your payment information is processed securely by Stripe. We do not store your payment details.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const sameBillingCheckbox = document.getElementById('same_billing');
        const billingFields = document.getElementById('billing-fields');
        const paymentButton = document.getElementById('payment-button');
        
        // Toggle billing address fields visibility
        if (sameBillingCheckbox) {
            sameBillingCheckbox.addEventListener('change', function() {
                billingFields.classList.toggle('hidden', this.checked);
            });
        }
        
        if (paymentButton) {
            paymentButton.addEventListener('click', function() {
                paymentButton.disabled = true;
                paymentButton.textContent = 'Processing...';
            });
        }
    });
</script>
@endpush
@endsection