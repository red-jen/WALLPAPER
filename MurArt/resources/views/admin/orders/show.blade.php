@extends('layouts.admin')

@section('title', 'Order #' . $order->order_number)

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Order #{{ $order->order_number }}</h1>
            <p class="text-gray-600">Placed on {{ $order->created_at->format('M d, Y H:i') }}</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('admin.orders.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">
                <i class="fas fa-arrow-left mr-2"></i> Back to Orders
            </a>
            <a href="{{ route('admin.orders.invoice', $order) }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                <i class="fas fa-file-invoice mr-2"></i> Generate Invoice
            </a>
        </div>
    </div>

    @if(session('success'))
    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded">
        <div class="flex">
            <div class="flex-shrink-0">
                <i class="fas fa-check-circle h-5 w-5 text-green-500"></i>
            </div>
            <div class="ml-3">
                <p>{{ session('success') }}</p>
            </div>
        </div>
    </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Order Information -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-lg shadow-sm overflow-hidden mb-6">
                <div class="p-4 border-b border-gray-200 bg-gray-50">
                    <h2 class="font-medium">Order Information</h2>
                </div>
                <div class="p-5 space-y-4">
                    <div>
                        <h3 class="text-sm font-medium text-gray-500">Customer Details</h3>
                        <div class="mt-2">
                            <p class="text-gray-800 font-medium">{{ $order->user->name }}</p>
                            <p class="text-gray-600">{{ $order->user->email }}</p>
                            <p class="text-gray-600">{{ $order->user->phone ?? 'No phone number' }}</p>
                        </div>
                    </div>

                    <div class="pt-3 border-t border-gray-200">
                        <h3 class="text-sm font-medium text-gray-500">Order Status</h3>
                        <div class="mt-2">
                            <form action="{{ route('admin.orders.update-status', $order) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="flex items-center space-x-3">
                                    <select name="status" class="flex-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                        <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>Processing</option>
                                        <option value="in_production" {{ $order->status === 'in_production' ? 'selected' : '' }}>In Production</option>
                                        <option value="ready_to_ship" {{ $order->status === 'ready_to_ship' ? 'selected' : '' }}>Ready to Ship</option>
                                        <option value="shipped" {{ $order->status === 'shipped' ? 'selected' : '' }}>Shipped</option>
                                        <option value="delivered" {{ $order->status === 'delivered' ? 'selected' : '' }}>Delivered</option>
                                        <option value="canceled" {{ $order->status === 'canceled' ? 'selected' : '' }}>Canceled</option>
                                    </select>
                                    <button type="submit" class="px-3 py-1.5 bg-indigo-600 text-white text-sm rounded-md hover:bg-indigo-700">
                                        Update
                                    </button>
                                </div>
                            </form>
                            <div class="mt-2">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                    {{ 
                                        $order->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                                        ($order->status === 'processing' ? 'bg-blue-100 text-blue-800' : 
                                        ($order->status === 'in_production' ? 'bg-purple-100 text-purple-800' : 
                                        ($order->status === 'ready_to_ship' ? 'bg-indigo-100 text-indigo-800' : 
                                        ($order->status === 'shipped' ? 'bg-green-100 text-green-800' : 
                                        ($order->status === 'delivered' ? 'bg-green-100 text-green-800' : 
                                        'bg-red-100 text-red-800')))))
                                    }}">
                                    {{ ucwords(str_replace('_', ' ', $order->status)) }}
                                </span>
                                <p class="text-xs text-gray-500 mt-1">Last updated: {{ $order->updated_at->format('M d, Y H:i') }}</p>
                            </div>
                        </div>
                    </div>

                    @if($order->status === 'shipped' || $order->status === 'delivered')
                    <div class="pt-3 border-t border-gray-200">
                        <h3 class="text-sm font-medium text-gray-500">Shipping Information</h3>
                        <div class="mt-2">
                            <form action="{{ route('admin.orders.update-shipping', $order) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="mb-3">
                                    <label for="tracking_number" class="block text-sm font-medium text-gray-700 mb-1">Tracking Number</label>
                                    <input type="text" id="tracking_number" name="tracking_number" value="{{ $order->tracking_number }}" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 w-full">
                                </div>
                                <div class="mb-3">
                                    <label for="carrier" class="block text-sm font-medium text-gray-700 mb-1">Shipping Carrier</label>
                                    <input type="text" id="carrier" name="carrier" value="{{ $order->carrier }}" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 w-full">
                                </div>
                                <button type="submit" class="w-full px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                                    Update Shipping Info
                                </button>
                            </form>
                        </div>
                    </div>
                    @endif

                    <div class="pt-3 border-t border-gray-200">
                        <h3 class="text-sm font-medium text-gray-500">Payment Information</h3>
                        <div class="mt-2">
                            <p class="text-sm">
                                <span class="text-gray-600">Payment Method:</span>
                                <span class="font-medium text-gray-800">{{ ucfirst($order->payment_method) }}</span>
                            </p>
                            <p class="text-sm">
                                <span class="text-gray-600">Transaction ID:</span>
                                <span class="font-medium text-gray-800">{{ $order->transaction_id ?? 'N/A' }}</span>
                            </p>
                            <p class="text-sm">
                                <span class="text-gray-600">Payment Status:</span>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $order->payment_status === 'paid' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ ucfirst($order->payment_status) }}
                                </span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                <div class="p-4 border-b border-gray-200 bg-gray-50">
                    <h2 class="font-medium">Shipping Address</h2>
                </div>
                <div class="p-5">
                    <address class="not-italic">
                        <p class="font-medium text-gray-800">{{ $order->shipping_name }}</p>
                        <p class="text-gray-600">{{ $order->shipping_address }}</p>
                        <p class="text-gray-600">{{ $order->shipping_city }}, {{ $order->shipping_state }} {{ $order->shipping_zip }}</p>
                        <p class="text-gray-600">{{ $order->shipping_country }}</p>
                        <p class="text-gray-600 mt-2">{{ $order->shipping_phone }}</p>
                    </address>
                </div>
            </div>
        </div>

        <!-- Order Items & Production Images -->
        <div class="lg:col-span-2">
            <!-- Order Items -->
            <div class="bg-white rounded-lg shadow-sm overflow-hidden mb-6">
                <div class="p-4 border-b border-gray-200 bg-gray-50">
                    <h2 class="font-medium">Order Items</h2>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Item</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Qty</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($order->items as $item)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10 bg-gray-100 rounded-md overflow-hidden">
                                            @if($item->artwork && $item->artwork->image_path)
                                                <img src="{{ asset('storage/' . $item->artwork->image_path) }}" alt="{{ $item->product_name }}" class="h-10 w-10 object-cover">
                                            @else
                                                <div class="h-10 w-10 flex items-center justify-center text-gray-400">
                                                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                    </svg>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $item->product_name }}</div>
                                            <div class="text-sm text-gray-500">
                                                @if($item->artwork)
                                                    <a href="{{ route('admin.artworks.edit', $item->artwork) }}" class="text-indigo-600 hover:text-indigo-900">
                                                        View Artwork
                                                    </a>
                                                @endif
                                            </div>
                                          
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $order->currency }} {{ number_format($item->price, 2) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $item->quantity }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $order->currency }} {{ number_format($item->price * $item->quantity, 2) }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="bg-gray-50">
                            <tr>
                                <td colspan="3" class="px-6 py-3 text-right text-sm font-medium text-gray-500">Subtotal:</td>
                                <td class="px-6 py-3 text-sm text-gray-900">{{ $order->currency }} {{ number_format($order->subtotal, 2) }}</td>
                            </tr>
                            <tr>
                                <td colspan="3" class="px-6 py-3 text-right text-sm font-medium text-gray-500">Tax:</td>
                                <td class="px-6 py-3 text-sm text-gray-900">{{ $order->currency }} {{ number_format($order->tax, 2) }}</td>
                            </tr>
                            <tr>
                                <td colspan="3" class="px-6 py-3 text-right text-sm font-medium text-gray-500">Shipping:</td>
                                <td class="px-6 py-3 text-sm text-gray-900">{{ $order->currency }} {{ number_format($order->shipping, 2) }}</td>
                            </tr>
                            <tr>
                                <td colspan="3" class="px-6 py-3 text-right text-sm font-medium text-gray-500">Discount:</td>
                                <td class="px-6 py-3 text-sm text-gray-900">{{ $order->currency }} {{ number_format($order->discount, 2) }}</td>
                            </tr>
                            <tr>
                                <td colspan="3" class="px-6 py-3 text-right text-sm font-bold text-gray-700">Total:</td>
                                <td class="px-6 py-3 text-sm font-bold text-gray-900">{{ $order->currency }} {{ number_format($order->total, 2) }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            <!-- Production Images & Notes -->
            <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                <div class="p-4 border-b border-gray-200 bg-gray-50">
                    <h2 class="font-medium">Production Images & Notes</h2>
                </div>
                <div class="p-5">
                    @if($order->status === 'pending')
                        <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded-md">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-yellow-700">
                                        Production images can be added once the order status is changed from pending.
                                    </p>
                                </div>
                            </div>
                        </div>
                    @else
                        <!-- Current Production Images -->
                        @if($order->production_images && count($order->production_images) > 0)
                            <div class="mb-6">
                                <h3 class="text-sm font-medium text-gray-700 mb-3">Current Production Images</h3>
                                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                                    @foreach($order->production_images as $index => $image)
                                        <div class="relative group">
                                            <div class="rounded-md overflow-hidden border border-gray-200 aspect-square">
                                                <img src="{{ asset('storage/' . $image['path']) }}" alt="Production image {{ $index + 1 }}" class="w-full h-full object-cover">
                                            </div>
                                            <div class="absolute bottom-0 left-0 right-0 bg-black bg-opacity-60 text-white text-xs px-2 py-1 truncate">
                                                {{ $image['stage'] ?? 'Unknown stage' }}
                                            </div>
                                            <form action="{{ route('admin.orders.delete-image', ['order' => $order->id, 'index' => $index]) }}" method="POST" class="absolute top-1 right-1 opacity-0 group-hover:opacity-100 transition-opacity">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="bg-red-500 text-white rounded-full p-1 hover:bg-red-600" onclick="return confirm('Delete this image?')">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @else
                            <div class="flex flex-col items-center justify-center py-8 bg-gray-50 rounded-lg mb-6">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                <p class="mt-2 text-sm text-gray-500">No production images uploaded yet</p>
                            </div>
                        @endif

                        <!-- Upload Production Image Form -->
                        <form action="{{ route('admin.orders.upload-image', $order) }}" method="POST" enctype="multipart/form-data" class="mb-6">
                            @csrf
                            <h3 class="text-sm font-medium text-gray-700 mb-3">Upload New Production Image</h3>
                            <div class="grid grid-cols-1 gap-y-4">
                                <div>
                                    <label for="production_image" class="block text-sm font-medium text-gray-700 mb-1">Image</label>
                                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md hover:bg-gray-50 transition cursor-pointer" id="dropzone">
                                        <div class="space-y-1 text-center">
                                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                            <div class="flex text-sm text-gray-600">
                                                <label for="production_image" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500">
                                                    <span>Upload a file</span>
                                                    <input id="production_image" name="production_image" type="file" class="sr-only" accept="image/*" required>
                                                </label>
                                                <p class="pl-1">or drag and drop</p>
                                            </div>
                                            <p class="text-xs text-gray-500">PNG, JPG, GIF up to 5MB</p>
                                        </div>
                                    </div>
                                    <div id="preview-container" class="mt-2 hidden">
                                        <img id="preview-image" src="#" alt="Preview" class="h-20 object-contain rounded border border-gray-300">
                                        <button type="button" id="remove-image" class="mt-1 text-xs text-red-500 hover:text-red-700">Remove</button>
                                    </div>
                                </div>

                                <div>
                                    <label for="stage" class="block text-sm font-medium text-gray-700 mb-1">Production Stage</label>
                                    <select id="stage" name="stage" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                        <option value="initial_setup">Initial Setup</option>
                                        <option value="printing">Printing</option>
                                        <option value="quality_check">Quality Check</option>
                                        <option value="finishing">Finishing</option>
                                        <option value="packaging">Packaging</option>
                                        <option value="ready_to_ship">Ready to Ship</option>
                                    </select>
                                </div>

                                <div>
                                    <label for="note" class="block text-sm font-medium text-gray-700 mb-1">Note (Optional)</label>
                                    <textarea id="note" name="note" rows="2" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" placeholder="Add a note about this production stage..."></textarea>
                                </div>

                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <input id="notify_customer" name="notify_customer" type="checkbox" class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                                        <label for="notify_customer" class="ml-2 block text-sm text-gray-700">
                                            Notify customer about this update
                                        </label>
                                    </div>
                                    <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                                        Upload Image
                                    </button>
                                </div>
                            </div>
                        </form>

                        <!-- Production Notes -->
                        <div>
                            <h3 class="text-sm font-medium text-gray-700 mb-3">Production Notes</h3>
                            <form action="{{ route('admin.orders.update-notes', $order) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="mb-4">
                                    <textarea id="production_notes" name="production_notes" rows="4" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" placeholder="Add notes about production process...">{{ $order->production_notes }}</textarea>
                                </div>
                                <div class="flex justify-end">
                                    <button type="submit" class="px-4 py-2 bg-gray-800 text-white rounded-md hover:bg-gray-700">
                                        Save Notes
                                    </button>
                                </div>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Image preview for production image upload