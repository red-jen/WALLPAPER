@extends('layouts.app')

@section('title', 'Order Confirmation - MurArt')

@section('content')
<div class="container py-8">
    <div class="max-w-3xl mx-auto bg-white rounded-lg shadow-md overflow-hidden">
        <div class="p-6 bg-green-50 border-b border-green-100">
            <div class="flex items-center">
                <div class="mr-4 bg-green-100 rounded-full p-2">
                    <svg class="w-8 h-8 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <h1 class="text-2xl font-bold text-gray-800">Order Confirmed!</h1>
            </div>
        </div>
        
        <div class="p-6">
            <p class="text-lg mb-6">Thank you for your order. Your payment has been processed successfully.</p>
            
            <div class="mb-6 bg-gray-50 p-4 rounded-md">
                <h2 class="text-lg font-semibold mb-2">Order Details</h2>
                <p class="mb-1"><span class="font-medium">Order Number:</span> {{ $orderNumber }}</p>
                <p class="mb-1"><span class="font-medium">Date:</span> {{ $order->created_at->format('F j, Y') }}</p>
                <p class="mb-1"><span class="font-medium">Total:</span> ${{ number_format($order->total, 2) }}</p>
            </div>
            
            <p class="mb-6">
                We've sent a confirmation email to your inbox with all the details of your purchase. 
                You can also view your order status in your <a href="{{ route('client.dashboard') }}" class="text-indigo-600 hover:text-indigo-800">account dashboard</a>.
            </p>
            
            <div class="flex flex-col md:flex-row space-y-3 md:space-y-0 md:space-x-3">
                <a href="{{ route('client.orders.index') }}" class="inline-block bg-primary text-white py-2 px-4 rounded-md hover:bg-primary-dark transition">
                    View Your Orders
                </a>
                <a href="{{ route('shop.index') }}" class="inline-block bg-gray-200 text-gray-800 py-2 px-4 rounded-md hover:bg-gray-300 transition">
                    Continue Shopping
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
