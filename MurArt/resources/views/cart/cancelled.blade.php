@extends('layouts.app')

@section('title', 'Order Cancelled - MurArt')

@section('content')
<div class="container py-8">
    <div class="max-w-3xl mx-auto bg-white rounded-lg shadow-md overflow-hidden">
        <div class="p-6 bg-yellow-50 border-b border-yellow-100">
            <div class="flex items-center">
                <div class="mr-4 bg-yellow-100 rounded-full p-2">
                    <svg class="w-8 h-8 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                </div>
                <h1 class="text-2xl font-bold text-gray-800">Order Cancelled</h1>
            </div>
        </div>
        
        <div class="p-6">
            <p class="text-lg mb-6">{{ $message ?? 'Your order has been cancelled and no payment has been processed.' }}</p>
            
            <p class="mb-6">
                If you experienced any issues during checkout or have questions about our products, 
                please don't hesitate to <a href="{{ route('contact') }}" class="text-indigo-600 hover:text-indigo-800">contact us</a>.
            </p>
            
            <div class="flex flex-col md:flex-row space-y-3 md:space-y-0 md:space-x-3">
                <a href="{{ route('cart.index') }}" class="inline-block bg-primary text-white py-2 px-4 rounded-md hover:bg-primary-dark transition">
                    Return to Cart
                </a>
                <a href="{{ route('shop.index') }}" class="inline-block bg-gray-200 text-gray-800 py-2 px-4 rounded-md hover:bg-gray-300 transition">
                    Continue Shopping
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
