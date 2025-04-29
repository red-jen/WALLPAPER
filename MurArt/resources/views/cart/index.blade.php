{{-- resources/views/cart/index.blade.php --}}
@extends('layouts.app')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
<div class="container py-6">
    <div class="max-w-5xl mx-auto">
        <h1 class="text-3xl font-bold mb-6">Your Shopping Cart</h1>
        
        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded">
                {{ session('success') }}
            </div>
        @endif
        
        @if(count($cartItems) > 0)
            <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Product
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Details
                            </th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Quantity
                            </th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Price
                            </th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Total
                            </th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($cartItems as $item)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        @if($item->artwork)
                                            <img src="{{ asset('storage/' . ($item->artwork->preview_image_path ?? $item->artwork->image_path)) }}" 
                                                alt="{{ $item->artwork->title }}" 
                                                class="w-16 h-16 object-cover rounded">
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">
                                                    {{ $item->artwork->title }}
                                                </div>
                                                <div class="text-sm text-gray-500">
                                                    Custom Artwork
                                                </div>
                                            </div>
                                        @elseif($item->wallpaper)
                                            <img src="{{ asset('storage/' . $item->wallpaper->getImageUrlAttribute()) }}" 
                                                alt="{{ $item->wallpaper->title }}" 
                                                class="w-16 h-16 object-cover rounded">
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">
                                                    {{ $item->wallpaper->title }}
                                                </div>
                                                <div class="text-sm text-gray-500">
                                                    Wallpaper
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-500">
                                        @if($item->artwork)
                                            <div>Size: {{ $item->options['width'] ?? $item->artwork->width }}cm × {{ $item->options['height'] ?? $item->artwork->height }}cm</div>
                                            <div>Paper: {{ $item->options['paper'] ?? $item->artwork->paper->name }}</div>
                                        @elseif($item->wallpaper)
                                            <div>{{ $item->wallpaper->category->name }}</div>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <form action="{{ route('cart.updateItem', $item) }}" method="POST" class="flex justify-center">
                                        @csrf
                                        @method('PUT')
                                        <select name="quantity" onchange="this.form.submit()" class="rounded border-gray-300 text-center w-16">
                                            @for($i = 1; $i <= 10; $i++)
                                                <option value="{{ $i }}" {{ $item->quantity == $i ? 'selected' : '' }}>
                                                    {{ $i }}
                                                </option>
                                            @endfor
                                        </select>
                                    </form>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm text-gray-500">
                                    ${{ number_format($item->price, 2) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    ${{ number_format($item->price * $item->quantity, 2) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                    <form action="{{ route('cart.removeItem', $item) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900">
                                            Remove
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="bg-gray-50">
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-right font-medium">
                                Subtotal:
                            </td>
                            <td class="px-6 py-4 text-right font-medium">
                                ${{ number_format($subtotal, 2) }}
                            </td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            
            <div class="flex justify-between items-center">
                <a href="{{ url('/') }}" class="px-6 py-3 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300">
                    Continue Shopping
                </a>
                
                <a href="{{ route('cart.checkout') }}" class="px-6 py-3 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                    Proceed to Checkout
                </a>
            </div>
        @else
            <div class="bg-white rounded-lg shadow-md p-6 text-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                <h2 class="mt-4 text-lg font-medium">Your cart is empty</h2>
                <p class="mt-2 text-gray-500">Start by adding some custom artworks or wallpapers to your cart.</p>
                <div class="mt-6">
                    <a href="{{ url('/') }}" class="px-6 py-3 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                        Browse Products
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection