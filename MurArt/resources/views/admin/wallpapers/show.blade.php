@extends('layouts.admin')

@section('title', $wallpaper->title)

@section('styles')
<style>
    .carousel-container {
        position: relative;
        max-height: 400px;
        overflow: hidden;
    }
    .carousel-image {
        width: 100%;
        height: 400px;
        object-fit: contain;
    }
    .thumbnail {
        width: 80px;
        height: 80px;
        object-fit: cover;
        cursor: pointer;
        border: 2px solid transparent;
        transition: all 0.2s;
    }
    .thumbnail.active {
        border-color: #D4AF37;
    }
</style>
@endsection

@section('content')
<!-- Breadcrumbs -->
<div class="mb-6">
    <div class="flex items-center text-sm text-charcoal/70">
        <a href="{{ route('admin.dashboard') }}" class="hover:text-navy">Dashboard</a>
        <span class="mx-2">/</span>
        <a href="{{ route('admin.wallpapers.index') }}" class="hover:text-navy">Wallpapers</a>
        <span class="mx-2">/</span>
        <span class="text-charcoal">{{ $wallpaper->title }}</span>
    </div>
</div>

<!-- Header -->
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8">
    <h1 class="text-3xl font-heading font-bold text-navy mb-4 sm:mb-0">{{ $wallpaper->title }}</h1>
    <div class="flex gap-3">
        <a href="{{ route('admin.wallpapers.edit', $wallpaper) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors duration-150">
            <i class="fas fa-edit mr-2"></i> Edit
        </a>
        <a href="{{ route('admin.wallpapers.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-lg transition-colors duration-150">
            <i class="fas fa-arrow-left mr-2"></i> Back
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

<!-- Main Content -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Left Column (Images) - 2/3 width on large screens -->
    <div class="lg:col-span-2">
        <!-- Wallpaper Images -->
        <div class="bg-white rounded-xl shadow-sm overflow-hidden mb-6">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="font-heading font-semibold text-lg text-navy">Wallpaper Images</h2>
            </div>
            <div class="p-4">
                @if($wallpaper->images->count() > 0)
                    <!-- Main Image Display -->
                    <div id="mainCarousel" class="carousel-container mb-4 rounded-lg overflow-hidden bg-gray-100">
                        @foreach($wallpaper->images as $index => $image)
                            <div class="carousel-item {{ $index === 0 ? 'block' : 'hidden' }}" data-index="{{ $index }}">
                                <img src="{{ asset('storage/' . $image->image_path) }}" 
                                     alt="{{ $image->title ?? $wallpaper->title }}" 
                                     class="carousel-image mx-auto">
                                @if($image->title)
                                    <div class="absolute bottom-0 left-0 right-0 bg-black bg-opacity-50 text-white p-2">
                                        <h5 class="text-center">{{ $image->title }}</h5>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                        
                        <!-- Carousel Controls -->
                        @if($wallpaper->images->count() > 1)
                        <button type="button" class="absolute top-1/2 left-2 transform -translate-y-1/2 bg-black bg-opacity-50 text-white rounded-full p-2 hover:bg-opacity-75 focus:outline-none" id="prevButton">
                            <i class="fas fa-chevron-left"></i>
                        </button>
                        <button type="button" class="absolute top-1/2 right-2 transform -translate-y-1/2 bg-black bg-opacity-50 text-white rounded-full p-2 hover:bg-opacity-75 focus:outline-none" id="nextButton">
                            <i class="fas fa-chevron-right"></i>
                        </button>
                        @endif
                    </div>
                    
                    <!-- Thumbnail Navigation -->
                    @if($wallpaper->images->count() > 1)
                    <div class="flex flex-wrap justify-center gap-2">
                        @foreach($wallpaper->images as $index => $image)
                            <div class="relative">
                                <img src="{{ asset('storage/' . $image->image_path) }}" 
                                     class="thumbnail {{ $index === 0 ? 'active' : '' }}" 
                                     alt="{{ $image->title ?? 'Image ' . ($index + 1) }}"
                                     data-index="{{ $index }}">
                                @if($image->is_primary)
                                    <span class="absolute -top-1 -right-1 bg-gold text-white text-xs px-1.5 py-0.5 rounded-full">Primary</span>
                                @endif
                            </div>
                        @endforeach
                    </div>
                    @endif
                @else
                    <div class="text-center py-12">
                        <i class="fas fa-images text-5xl text-gray-300 mb-3"></i>
                        <p class="text-gray-500">No images available</p>
                    </div>
                @endif
            </div>
        </div>
        
        <!-- Reviews Section -->
        <div class="bg-white rounded-xl shadow-sm overflow-hidden mb-6">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="font-heading font-semibold text-lg text-navy">Customer Reviews</h2>
            </div>
            <div class="p-4">
                @if($wallpaper->reviews->count() > 0)
                    <div class="space-y-4">
                        @foreach($wallpaper->reviews as $review)
                            <div class="border border-gray-200 rounded-lg p-4">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <div class="font-medium text-gray-800">{{ $review->user->name }}</div>
                                        <div class="flex items-center mt-1">
                                            <div class="flex text-yellow-400">
                                                @for($i = 1; $i <= 5; $i++)
                                                    @if($i <= $review->rating)
                                                        <i class="fas fa-star"></i>
                                                    @else
                                                        <i class="far fa-star"></i>
                                                    @endif
                                                @endfor
                                            </div>
                                            <span class="text-xs text-gray-500 ml-2">{{ $review->created_at->format('M d, Y') }}</span>
                                        </div>
                                    </div>
                                    <form action="{{ route('admin.reviews.destroy', $review) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700" 
                                                onclick="return confirm('Are you sure you want to delete this review?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                                <p class="mt-3 text-gray-600">{{ $review->comment }}</p>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <p class="text-gray-500">No reviews yet</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
    
    <!-- Right Column (Details) -->
    <div class="lg:col-span-1">
        <!-- Wallpaper Details -->
        <div class="bg-white rounded-xl shadow-sm overflow-hidden mb-6">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="font-heading font-semibold text-lg text-navy">Wallpaper Details</h2>
            </div>
            <div class="p-4">
                <div class="divide-y divide-gray-200">
                    <div class="py-3 grid grid-cols-2">
                        <div class="text-sm font-medium text-gray-500">Category</div>
                        <div class="text-sm text-gray-900">{{ $wallpaper->category->name ?? 'None' }}</div>
                    </div>
                    <div class="py-3 grid grid-cols-2">
                        <div class="text-sm font-medium text-gray-500">Price</div>
                        <div class="text-sm text-gray-900 font-medium">${{ number_format($wallpaper->price, 2) }}</div>
                    </div>
                    <div class="py-3 grid grid-cols-2">
                        <div class="text-sm font-medium text-gray-500">Dimensions</div>
                        <div class="text-sm text-gray-900">{{ $wallpaper->width ?? '0' }} × {{ $wallpaper->height ?? '0' }}</div>
                    </div>
                    <div class="py-3 grid grid-cols-2">
                        <div class="text-sm font-medium text-gray-500">Stock</div>
                        <div class="text-sm text-gray-900">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $wallpaper->stock > 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $wallpaper->stock }}
                            </span>
                            <button type="button" 
                                    onclick="openStockModal('{{ $wallpaper->id }}', {{ $wallpaper->stock }})"
                                    class="ml-2 text-xs bg-gray-200 hover:bg-gray-300 text-gray-700 py-1 px-2 rounded">
                                <i class="fas fa-edit"></i> Update
                            </button>
                        </div>
                    </div>
                    <div class="py-3 grid grid-cols-2">
                        <div class="text-sm font-medium text-gray-500">Downloads</div>
                        <div class="text-sm text-gray-900">{{ $wallpaper->downloads ?? '0' }}</div>
                    </div>
                    <div class="py-3 grid grid-cols-2">
                        <div class="text-sm font-medium text-gray-500">Status</div>
                        <div class="text-sm text-gray-900">
                            @if($wallpaper->status == 'draft')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                    Draft
                                </span>
                            @elseif($wallpaper->status == 'published')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    Published
                                </span>
                            @elseif($wallpaper->status == 'featured')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    Featured
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="py-3 grid grid-cols-2">
                        <div class="text-sm font-medium text-gray-500">Created</div>
                        <div class="text-sm text-gray-900">{{ $wallpaper->created_at->format('M d, Y') }}</div>
                    </div>
                    <div class="py-3 grid grid-cols-2">
                        <div class="text-sm font-medium text-gray-500">Last Updated</div>
                        <div class="text-sm text-gray-900">{{ $wallpaper->updated_at->format('M d, Y') }}</div>
                    </div>
                </div>
                
                @if($wallpaper->description)
                    <div class="mt-4">
                        <h3 class="text-sm font-medium text-gray-700 mb-2">Description</h3>
                        <p class="text-sm text-gray-600">{{ $wallpaper->description }}</p>
                    </div>
                @endif
            </div>
        </div>
        
        <!-- Compatible Papers -->
        <div class="bg-white rounded-xl shadow-sm overflow-hidden mb-6">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="font-heading font-semibold text-lg text-navy">Compatible Papers</h2>
            </div>
            <div class="p-4">
                @if($wallpaper->papers->count() > 0)
                    <ul class="divide-y divide-gray-200">
                        @foreach($wallpaper->papers as $paper)
                            <li class="py-3 flex justify-between items-center">
                                <span class="text-sm text-gray-800">{{ $paper->name }}</span>
                                @if($paper->pivot->is_recommended)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        Recommended
                                    </span>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                @else
                    <div class="text-center py-6">
                        <p class="text-gray-500">No compatible papers specified</p>
                    </div>
                @endif
            </div>
        </div>
        
        <!-- Danger Zone -->
        <div class="border border-red-300 rounded-xl overflow-hidden mb-6">
            <div class="px-6 py-4 bg-red-500 border-b border-red-300">
                <h2 class="font-heading font-semibold text-lg text-white">Danger Zone</h2>
            </div>
            <div class="p-4 bg-red-50">
                <button type="button" 
                        onclick="if(confirm('Are you sure you want to delete this wallpaper? This action cannot be undone.')) document.getElementById('delete-wallpaper-form').submit();"
                        class="w-full py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition-colors flex items-center justify-center">
                    <i class="fas fa-trash mr-2"></i> Delete Wallpaper
                </button>
                <form id="delete-wallpaper-form" action="{{ route('admin.wallpapers.destroy', $wallpaper) }}" method="POST" class="hidden">
                    @csrf
                    @method('DELETE')
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Stock Update Modal -->
<div id="stockModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center hidden">
    <div class="bg-white rounded-lg shadow-xl max-w-md w-full p-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-medium text-gray-900">Update Stock</h3>
            <button type="button" onclick="closeStockModal()" class="text-gray-400 hover:text-gray-500">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <form id="stockUpdateForm" action="{{ route('admin.wallpapers.updateStock', $wallpaper) }}" method="POST">
            @csrf
            @method('PATCH')
            <div class="mb-4">
                <label for="stock" class="block text-sm font-medium text-gray-700 mb-1">Stock Quantity</label>
                <input type="number" id="stockInput" name="stock" min="0" value="{{ $wallpaper->stock }}" 
                       class="w-full border border-gray-300 rounded-md focus:ring-2 focus:ring-gold focus:border-transparent p-2">
            </div>
            <div class="flex justify-end space-x-3">
                <button type="button" onclick="closeStockModal()" 
                        class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 transition-colors">
                    Cancel
                </button>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors">
                    Update
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    // Carousel functionality
    document.addEventListener('DOMContentLoaded', function() {
        const items = document.querySelectorAll('.carousel-item');
        const thumbnails = document.querySelectorAll('.thumbnail');
        const prevButton = document.getElementById('prevButton');
        const nextButton = document.getElementById('nextButton');
        let currentIndex = 0;
        
        function showSlide(index) {
            // Hide all slides
            items.forEach(item => item.classList.add('hidden'));
            thumbnails.forEach(thumb => thumb.classList.remove('active'));
            
            // Show the selected slide
            items[index].classList.remove('hidden');
            thumbnails[index].classList.add('active');
            currentIndex = index;
        }
        
        // Thumbnail click handler
        thumbnails.forEach(thumbnail => {
            thumbnail.addEventListener('click', function() {
                const index = parseInt(this.getAttribute('data-index'));
                showSlide(index);
            });
        });
        
        // Previous button handler
        if (prevButton) {
            prevButton.addEventListener('click', function() {
                let index = currentIndex - 1;
                if (index < 0) index = items.length - 1;
                showSlide(index);
            });
        }
        
        // Next button handler
        if (nextButton) {
            nextButton.addEventListener('click', function() {
                let index = currentIndex + 1;
                if (index >= items.length) index = 0;
                showSlide(index);
            });
        }
    });
    
    // Stock modal functionality
    function openStockModal() {
        document.getElementById('stockModal').classList.remove('hidden');
    }
    
    function closeStockModal() {
        document.getElementById('stockModal').classList.add('hidden');
    }
    
    // Close modal on Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeStockModal();
        }
    });
    
    // Close modal on outside click
    document.getElementById('stockModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeStockModal();
        }
    });
</script>
@endpush
@endsection