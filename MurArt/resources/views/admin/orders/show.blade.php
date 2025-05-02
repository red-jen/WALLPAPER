@extends('layouts.admin')

@section('title', 'Order #' . $order->order_number)

@section('content')
<!-- Breadcrumbs -->
<div class="mb-6">
    <div class="flex items-center text-sm text-charcoal/70">
        <a href="{{ route('admin.dashboard') }}" class="hover:text-navy">Dashboard</a>
        <span class="mx-2">/</span>
        <a href="{{ route('admin.orders.index') }}" class="hover:text-navy">Orders</a>
        <span class="mx-2">/</span>
        <span class="text-charcoal">Order #{{ $order->order_number }}</span>
    </div>
</div>

<!-- Header -->
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8">
    <h1 class="text-3xl font-heading font-bold text-navy mb-4 sm:mb-0">
        Order #{{ $order->order_number }}
    </h1>
    <a href="{{ route('admin.orders.index') }}" 
        class="px-4 py-2 bg-gray-200 text-charcoal rounded-md font-medium hover:bg-gray-300 transition-colors flex items-center gap-2">
        <i class="fas fa-arrow-left"></i> Back to Orders
    </a>
</div>

@if(session('success'))
<div class="bg-green-100 border border-green-400 text-green-800 px-4 py-3 rounded-md mb-6 flex justify-between items-center">
    <div>{{ session('success') }}</div>
    <button type="button" class="text-green-800" onclick="this.parentElement.remove()">
        <i class="fas fa-times"></i>
    </button>
</div>
@endif

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Order Details - Left Column -->
    <div class="lg:col-span-2 space-y-6">
        <!-- Order Summary Card -->
        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <div class="border-b border-gray-200 px-6 py-4">
                <h2 class="text-lg font-heading font-semibold text-navy">Order Summary</h2>
            </div>
            
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 mb-2">Order Information</h3>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <div class="grid grid-cols-2 gap-3 text-sm">
                                <div class="text-gray-500">Date:</div>
                                <div class="font-medium text-navy">{{ $order->created_at->format('M d, Y H:i') }}</div>
                                
                                <div class="text-gray-500">Payment Method:</div>
                                <div class="font-medium text-navy">{{ $order->payment_method ?? 'Credit Card' }}</div>
                                
                                <div class="text-gray-500">Payment Status:</div>
                                <div class="font-medium">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        {{ $order->payment_status === 'paid' ? 'bg-green-100 text-green-800' : 'bg-amber-100 text-amber-800' }}">
                                        {{ ucfirst($order->payment_status ?? 'Paid') }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 mb-2">Customer Information</h3>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <div class="flex items-center mb-3">
                                <div class="h-10 w-10 rounded-full bg-navy/10 flex items-center justify-center text-navy mr-3">
                                    <i class="fas fa-user"></i>
                                </div>
                                <div>
                                    <div class="font-medium text-navy">{{ $order->user->name }}</div>
                                    <div class="text-sm text-gray-500">{{ $order->user->email }}</div>
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-3 text-sm mt-3">
                                <div class="text-gray-500">Phone:</div>
                                <div class="font-medium text-navy">{{ $order->billing_phone ?? 'N/A' }}</div>
                                
                                <div class="text-gray-500">Customer ID:</div>
                                <div class="font-medium text-navy">{{ $order->user->id }}</div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Shipping Address -->
                <div class="mb-6">
                    <h3 class="text-sm font-medium text-gray-500 mb-2">Shipping Address</h3>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-navy">
                            {{ $order->shipping_name ?? $order->user->name }}<br>
                            {{ $order->shipping_address ?? 'No address provided' }}<br>
                            @if($order->shipping_city)
                                {{ $order->shipping_city }}, 
                            @endif
                            @if($order->shipping_state)
                                {{ $order->shipping_state }} 
                            @endif
                            @if($order->shipping_zip)
                                {{ $order->shipping_zip }}<br>
                            @endif
                            {{ $order->shipping_country ?? '' }}
                        </p>
                    </div>
                </div>
                
                <!-- Order Items -->
                <div>
                    <h3 class="text-sm font-medium text-gray-500 mb-2">Order Items</h3>
                    <div class="bg-gray-50 rounded-lg overflow-hidden">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Item</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach($order->orderItems as $item)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="h-16 w-16 flex-shrink-0 overflow-hidden rounded-md border border-gray-200 mr-4">
                                                    <img src="{{ asset('storage/' . ($item->wallpaper->image_path ?? 'no-image.jpg')) }}" 
                                                         alt="{{ $item->wallpaper->title ?? 'Product' }}" 
                                                         class="h-full w-full object-cover object-center">
                                                </div>
                                                <div>
                                                    <div class="font-medium text-navy">
                                                        {{ $item->wallpaper->title ?? 'Product #' . $item->wallpaper_id }}
                                                    </div>
                                                    <div class="text-xs text-gray-500">SKU: {{ $item->wallpaper->sku ?? 'N/A' }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            ${{ number_format($item->price, 2) }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $item->quantity }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-navy">
                                            ${{ number_format($item->price * $item->quantity, 2) }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="bg-gray-50">
                                <tr>
                                    <td colspan="3" class="px-6 py-4 text-sm font-medium text-gray-500 text-right">Subtotal:</td>
                                    <td class="px-6 py-4 text-sm font-medium text-navy">${{ number_format($order->subtotal ?? $order->total, 2) }}</td>
                                </tr>
                                @if($order->tax_amount)
                                <tr>
                                    <td colspan="3" class="px-6 py-4 text-sm font-medium text-gray-500 text-right">Tax:</td>
                                    <td class="px-6 py-4 text-sm font-medium text-navy">${{ number_format($order->tax_amount, 2) }}</td>
                                </tr>
                                @endif
                                @if($order->shipping_amount)
                                <tr>
                                    <td colspan="3" class="px-6 py-4 text-sm font-medium text-gray-500 text-right">Shipping:</td>
                                    <td class="px-6 py-4 text-sm font-medium text-navy">${{ number_format($order->shipping_amount, 2) }}</td>
                                </tr>
                                @endif
                                <tr class="bg-gray-100">
                                    <td colspan="3" class="px-6 py-4 text-sm font-bold text-gray-700 text-right">Total:</td>
                                    <td class="px-6 py-4 text-sm font-bold text-navy">${{ number_format($order->total, 2) }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Order Actions - Right Column -->
    <div class="lg:col-span-1 space-y-6">
        <!-- Status Card -->
        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <div class="border-b border-gray-200 px-6 py-4">
                <h2 class="text-lg font-heading font-semibold text-navy">Order Status</h2>
            </div>
            
            <div class="p-6 space-y-6">
                <div class="mb-4">
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-sm text-gray-500">Current Status:</span>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                            @if($order->status === 'completed') bg-green-100 text-green-800
                            @elseif($order->status === 'processing') bg-blue-100 text-blue-800
                            @elseif($order->status === 'pending') bg-amber-100 text-amber-800
                            @elseif($order->status === 'cancelled') bg-red-100 text-red-800
                            @else bg-gray-100 text-gray-800
                            @endif">
                            {{ ucfirst($order->status) }}
                        </span>
                    </div>
                    
                    <!-- Status Update Form -->
                    <form action="{{ route('admin.orders.update-status', $order) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="status" class="block text-sm font-medium text-gray-700 mb-1">
                                Update Status
                            </label>
                            <select id="status" name="status" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-gold focus:border-transparent">
                                <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>Processing</option>
                                <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }}>Completed</option>
                                <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                        </div>
                        
                        <button type="submit" class="w-full py-2 bg-navy text-white rounded-md font-medium hover:bg-navy/90 transition-colors">
                            Update Status
                        </button>
                    </form>
                </div>
                
                <div class="border-t border-gray-200 pt-4">
                    <h3 class="text-sm font-medium text-gray-500 mb-2">Timeline</h3>
                    <div class="space-y-3">
                        <div class="flex">
                            <div class="flex flex-col items-center mr-4">
                                <div class="h-3 w-3 rounded-full bg-green-500"></div>
                                <div class="flex-grow w-0.5 bg-gray-200"></div>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-navy">Order Created</p>
                                <p class="text-xs text-gray-500">{{ $order->created_at->format('M d, Y h:i A') }}</p>
                            </div>
                        </div>
                        
                        <!-- Add more timeline steps based on order history if available -->
                        <div class="flex">
                            <div class="flex flex-col items-center mr-4">
                                <div class="h-3 w-3 rounded-full {{ $order->status !== 'pending' ? 'bg-green-500' : 'bg-gray-300' }}"></div>
                                <div class="flex-grow w-0.5 bg-gray-200"></div>
                            </div>
                            <div>
                                <p class="text-sm font-medium {{ $order->status !== 'pending' ? 'text-navy' : 'text-gray-400' }}">Processing</p>
                                <p class="text-xs text-gray-500">{{ $order->processing_date ? $order->processing_date->format('M d, Y h:i A') : 'Pending' }}</p>
                            </div>
                        </div>
                        
                        <div class="flex">
                            <div class="flex flex-col items-center mr-4">
                                <div class="h-3 w-3 rounded-full {{ $order->status === 'completed' ? 'bg-green-500' : 'bg-gray-300' }}"></div>
                            </div>
                            <div>
                                <p class="text-sm font-medium {{ $order->status === 'completed' ? 'text-navy' : 'text-gray-400' }}">Completed</p>
                                <p class="text-xs text-gray-500">{{ $order->completed_date ? $order->completed_date->format('M d, Y h:i A') : 'Pending' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Actions Card -->
        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <div class="border-b border-gray-200 px-6 py-4">
                <h2 class="text-lg font-heading font-semibold text-navy">Order Actions</h2>
            </div>
            
            <div class="p-6 space-y-3">
                <a href="#" class="block w-full py-2 text-center bg-white border border-gray-300 text-navy rounded-md font-medium hover:bg-gray-50 transition-colors">
                    <i class="fas fa-print mr-2"></i> Print Invoice
                </a>
                
                <a href="mailto:{{ $order->user->email }}" class="block w-full py-2 text-center bg-white border border-gray-300 text-navy rounded-md font-medium hover:bg-gray-50 transition-colors">
                    <i class="fas fa-envelope mr-2"></i> Email Customer
                </a>
                
                <button type="button" class="block w-full py-2 text-center bg-red-50 border border-red-200 text-red-600 rounded-md font-medium hover:bg-red-100 transition-colors" onclick="document.getElementById('refundModal').classList.remove('hidden')">
                    <i class="fas fa-undo mr-2"></i> Process Refund
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Refund Modal -->
<div id="refundModal" class="fixed inset-0 z-50 overflow-y-auto hidden" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" onclick="document.getElementById('refundModal').classList.add('hidden')"></div>

        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                        <i class="fas fa-exclamation-triangle text-red-600"></i>
                    </div>
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">Process Refund</h3>
                        <div class="mt-2">
                            <p class="text-sm text-gray-500">
                                Are you sure you want to process a refund for this order? This action cannot be undone.
                            </p>
                            
                            <div class="mt-4">
                                <label for="refundAmount" class="block text-sm font-medium text-gray-700 mb-1">
                                    Refund Amount
                                </label>
                                <div class="mt-1 relative rounded-md shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 sm:text-sm">$</span>
                                    </div>
                                    <input type="number" name="refundAmount" id="refundAmount" 
                                        class="focus:ring-gold focus:border-gold block w-full pl-7 pr-12 sm:text-sm border-gray-300 rounded-md" 
                                        placeholder="0.00" 
                                        aria-describedby="price-currency"
                                        max="{{ $order->total }}"
                                        value="{{ $order->total }}">
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 sm:text-sm" id="price-currency">USD</span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mt-4">
                                <label for="refundReason" class="block text-sm font-medium text-gray-700 mb-1">
                                    Reason for Refund
                                </label>
                                <textarea id="refundReason" name="refundReason" rows="3" 
                                    class="focus:ring-gold focus:border-gold block w-full sm:text-sm border-gray-300 rounded-md"
                                    placeholder="Enter reason for refund"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <button type="button" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">
                    Process Refund
                </button>
                <button type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm" onclick="document.getElementById('refundModal').classList.add('hidden')">
                    Cancel
                </button>
            </div>
        </div>
    </div>
</div>
@endsection
