@extends('layouts.app')

@section('title', 'Order Details - MurArt')

@section('content')
<div class="container py-8">
    <div class="max-w-5xl mx-auto">
        <div class="mb-6 flex justify-between items-center">
            <h1 class="text-3xl font-bold">Order Details</h1>
            <a href="{{ route('client.orders.index') }}" class="text-primary hover:text-primary-dark">
                <i class="fas fa-arrow-left mr-2"></i> Back to Orders
            </a>
        </div>
        
        <!-- Order Summary -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
            <div class="p-4 border-b border-gray-200 bg-gray-50">
                <h2 class="font-medium">Order Summary</h2>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <div class="mb-4">
                            <h3 class="text-sm font-medium text-gray-500 mb-1">Order Number</h3>
                            <p class="text-lg">{{ $order->order_number }}</p>
                        </div>
                        <div class="mb-4">
                            <h3 class="text-sm font-medium text-gray-500 mb-1">Date Placed</h3>
                            <p>{{ $order->created_at->format('F j, Y g:i A') }}</p>
                        </div>
                        <div>
                            <h3 class="text-sm font-medium text-gray-500 mb-1">Order Status</h3>
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                @if($order->status == 'completed')
                                    bg-green-100 text-green-800
                                @elseif($order->status == 'processing')
                                    bg-blue-100 text-blue-800
                                @elseif($order->status == 'cancelled')
                                    bg-red-100 text-red-800
                                @else
                                    bg-yellow-100 text-yellow-800
                                @endif
                            ">
                                {{ ucfirst($order->status) }}
                            </span>
                        </div>
                    </div>
                    <div>
                        <div class="mb-4">
                            <h3 class="text-sm font-medium text-gray-500 mb-1">Payment Status</h3>
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                @if($order->payment_status == 'paid')
                                    bg-green-100 text-green-800
                                @elseif($order->payment_status == 'pending')
                                    bg-yellow-100 text-yellow-800
                                @else
                                    bg-red-100 text-red-800
                                @endif
                            ">
                                {{ ucfirst($order->payment_status) }}
                            </span>
                        </div>
                        <div class="mb-4">
                            <h3 class="text-sm font-medium text-gray-500 mb-1">Payment Method</h3>
                            <p>Credit Card</p>
                        </div>
                        @if($order->notes)
                        <div>
                            <h3 class="text-sm font-medium text-gray-500 mb-1">Order Notes</h3>
                            <p class="text-sm text-gray-700">{{ $order->notes }}</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Shipping Information -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="p-4 border-b border-gray-200 bg-gray-50">
                    <h2 class="font-medium">Shipping Address</h2>
                </div>
                <div class="p-6">
                    @php $shippingAddress = json_decode($order->shipping_address, true); @endphp
                    <p class="mb-1">{{ $shippingAddress['name'] }}</p>
                    <p class="mb-1">{{ $shippingAddress['address'] }}</p>
                    <p class="mb-1">{{ $shippingAddress['city'] }}, {{ $shippingAddress['state'] }} {{ $shippingAddress['postal_code'] }}</p>
                    <p class="mb-1">{{ $shippingAddress['country'] }}</p>
                    <p>{{ $shippingAddress['phone'] ?? '' }}</p>
                </div>
            </div>
            
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="p-4 border-b border-gray-200 bg-gray-50">
                    <h2 class="font-medium">Billing Address</h2>
                </div>
                <div class="p-6">
                    @php $billingAddress = json_decode($order->billing_address, true); @endphp
                    <p class="mb-1">{{ $billingAddress['name'] }}</p>
                    <p class="mb-1">{{ $billingAddress['address'] }}</p>
                    <p class="mb-1">{{ $billingAddress['city'] }}, {{ $billingAddress['state'] }} {{ $billingAddress['postal_code'] }}</p>
                    <p>{{ $billingAddress['country'] }}</p>
                </div>
            </div>
        </div>
        
        <!-- Order Items -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
            <div class="p-4 border-b border-gray-200 bg-gray-50">
                <h2 class="font-medium">Order Items</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Product
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Options
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Price
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Quantity
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Total
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($order->items as $item)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10">
                                            @if($item->artwork)
                                                <img class="h-10 w-10 rounded-md object-cover" src="{{ $item->artwork->preview_url ?? asset('images/placeholder.jpg') }}" alt="{{ $item->name }}">
                                            @elseif($item->wallpaper)
                                                <img class="h-10 w-10 rounded-md object-cover" src="{{ $item->wallpaper->primary_image ?? asset('images/placeholder.jpg') }}" alt="{{ $item->name }}">
                                            @else
                                                <img class="h-10 w-10 rounded-md bg-gray-100" src="{{ asset('images/placeholder.jpg') }}" alt="Product">
                                            @endif
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ $item->name }}
                                            </div>
                                            <div class="text-sm text-gray-500">
                                                {{ $item->artwork_id ? 'Custom Artwork' : 'Wallpaper' }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    @if($item->options)
                                        <div class="text-sm text-gray-900">
                                            @php $options = is_array($item->options) ? $item->options : json_decode($item->options, true); @endphp
                                            @if(is_array($options))
                                                @foreach($options as $key => $value)
                                                    <div>{{ ucfirst($key) }}: {{ $value }}</div>
                                                @endforeach
                                            @endif
                                        </div>
                                    @else
                                        <span class="text-sm text-gray-500">Standard</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    ${{ number_format($item->price, 2) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $item->quantity }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-medium">
                                    ${{ number_format($item->price * $item->quantity, 2) }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="bg-gray-50">
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-right text-sm font-medium text-gray-500">Subtotal</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-medium">${{ number_format($order->subtotal, 2) }}</td>
                        </tr>
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-right text-sm font-medium text-gray-500">Tax</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-medium">${{ number_format($order->tax, 2) }}</td>
                        </tr>
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-right text-sm font-medium text-gray-500">Shipping</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-medium">${{ number_format($order->shipping, 2) }}</td>
                        </tr>
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-right text-sm font-medium text-gray-700">Total</td>
                            <td class="px-6 py-4 whitespace-nowrap text-base text-gray-900 font-bold">${{ number_format($order->total, 2) }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        
        <!-- Action buttons -->
        <div class="flex justify-between">
            <a href="{{ route('client.orders.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                <i class="fas fa-arrow-left mr-2"></i>
                Back to Orders
            </a>
            
            @if($order->status !== 'cancelled' && $order->status !== 'completed')
            <div class="flex space-x-3">
                <a href="{{ route('contact') }}?subject=Order%20{{$order->order_number}}" class="inline-flex items-center px-4 py-2 border border-primary rounded-md shadow-sm text-sm font-medium text-primary bg-white hover:bg-primary hover:text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                    <i class="fas fa-envelope mr-2"></i>
                    Contact Support
                </a>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
