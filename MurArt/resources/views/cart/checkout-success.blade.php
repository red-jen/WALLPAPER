{{-- resources/views/cart/checkout-success.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container py-10">
    <div class="max-w-2xl mx-auto text-center">
        <div class="bg-white rounded-lg shadow-md p-8">
            <div class="flex justify-center mb-6">
                <div class="bg-green-100 rounded-full p-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
            </div>
            
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Thank You for Your Order!</h1>
            <p class="text-lg text-gray-600 mb-6">Your order has been successfully placed.</p>
            
            <div class="text-left bg-gray-50 rounded-lg p-6 mb-6">
                <h2 class="text-lg font-medium mb-3">Order Details</h2>
                <div class="space-y-2 text-gray-700">
                    <p><span class="font-medium">Order Number:</span> {{ $order->order_number }}</p>
                    <p><span class="font-medium">Date:</span> {{ $order->created_at->format('M d, Y') }}</p>
                    <p><span class="font-medium">Total:</span> ${{ number_format($order->total, 2) }}</p>
                    <p><span class="font-medium">Status:</span> {{ ucfirst($order->status) }}</p>
                </div>
            </div>
            
            <div class="mb-6">
                <p class="text-gray-600">We'll send you a confirmation email with your order details and updates on your shipping status.</p>
            </div>
            
            <div class="flex justify-center space-x-4">
                <a href="{{ route('home') }}" class="px-6 py-3 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition duration-200">
                    Continue Shopping
                </a>
                <a href="{{ url('/account/orders') }}" class="px-6 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition duration-200">
                    View My Orders
                </a>
            </div>
        </div>
    </div>
</div>
@endsection