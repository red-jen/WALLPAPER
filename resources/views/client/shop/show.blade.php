@extends('layouts.app')

@section('title', $wallpaper->title)
<script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

@section('content')
<div class="bg-neutral min-h-screen py-12">
    <div class="container mx-auto px-4">
        <!-- Breadcrumbs -->
        <div class="mb-8">
            <div class="flex items-center text-sm text-charcoal/70">
                <a href="{{ route('home') }}" class="hover:text-navy">Home</a>
                <span class="mx-2">/</span>
                <a href="{{ route('shop.index') }}" class="hover:text-navy">Shop</a>
                <span class="mx-2">/</span>
                <span class="text-charcoal">{{ $wallpaper->title }}</span>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
            <!-- Image Gallery -->
            <div class="space-y-4">
                <div class="relative overflow-hidden rounded-3xl shadow-md">
                    <div id="wallpaperGallery" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img src="{{ $wallpaper->getImageUrlAttribute() }}" 
                                    class="w-full h-[600px] object-cover transition-transform duration-500 ease-in-out group-hover:scale-105" 
                                    alt="{{ $wallpaper->title }}"
                                    id="mainImage">
                            </div>
                       
                        </div>
                        @if($wallpaper->images->count() > 0)
                            <button class="carousel-control-prev" type="button" data-bs-target="#wallpaperGallery" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#wallpaperGallery" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        @endif
                    </div>
                </div>

                <!-- Thumbnail Gallery -->
                <div class="grid grid-cols-4 sm:grid-cols-6 gap-2 mt-4">
                    <div class="relative aspect-square rounded-lg overflow-hidden cursor-pointer border-2 border-[#D4AF37] transition-all duration-300 ease-in-out hover:-translate-y-0.5 hover:shadow-md" 
                         onclick="changeImage('{{ $wallpaper->getImageUrlAttribute() }}')">
                        <img src="{{ $wallpaper->getImageUrlAttribute() }}" class="w-full h-full object-cover" alt="Main Image">
                    </div>
                    @foreach($wallpaper->images as $image)
                        <div class="relative aspect-square rounded-lg overflow-hidden cursor-pointer border-2 border-transparent transition-all duration-300 ease-in-out hover:-translate-y-0.5 hover:shadow-md" 
                             onclick="changeImage('{{ $image->getImageUrlAttribute() }}')">
                            <img src="{{ $image->getImageUrlAttribute() }}" class="w-full h-full object-cover" alt="Thumbnail">
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Product Details -->
            <div class="flex flex-col">
                <div class="mb-8 pb-8 border-b border-gray-200 border-opacity-50">
                    <h1 class="text-4xl font-heading font-bold text-charcoal mb-4">{{ $wallpaper->title }}</h1>
                
                    <div class="flex flex-wrap mb-6">
                        <span class="inline-flex items-center gap-2 px-4 py-2 bg-[#D4AF37]/10 text-[#D4AF37] rounded-full text-sm font-medium mr-2 mb-2">
                            <i class="fas fa-tag text-xs"></i>
                            {{ $wallpaper->category->name ?? 'Unknown' }}
                        </span>
                        <span class="inline-flex items-center gap-2 px-4 py-2 bg-[#D4AF37]/10 text-[#D4AF37] rounded-full text-sm font-medium mr-2 mb-2">
                            <i class="fas fa-layer-group text-xs"></i>
                            {{ $wallpaper->style }}
                        </span>
                        <span class="inline-flex items-center gap-2 px-4 py-2 bg-[#D4AF37]/10 text-[#D4AF37] rounded-full text-sm font-medium mr-2 mb-2">
                            <i class="fas fa-boxes text-xs"></i>
                            {{ $wallpaper->stock > 0 ? 'In Stock' : 'Out of Stock' }}
                        </span>
                    </div>

                    <div class="mb-6">
                        <h2 class="text-3xl font-heading font-bold text-navy mb-2">${{ number_format($wallpaper->price, 2) }}</h2>
                        <p class="text-charcoal/70">{{ $wallpaper->stock }} units available</p>
                    </div>
                </div>

                <div class="mb-8 pb-8 border-b border-gray-200 border-opacity-50">
                    <h3 class="text-xl font-heading font-semibold text-charcoal mb-4">Description</h3>
                    <p class="text-charcoal/80 leading-relaxed">{{ $wallpaper->description }}</p>
                </div>

                <!-- Add to Cart Form -->
                <div class="mb-8 pb-8 border-b border-gray-200 border-opacity-50">
                    <form action="{{ route('shop.cart.add', $wallpaper) }}" method="POST">
                        @csrf
                        <div class="bg-gradient-to-br from-white/80 to-white/90 p-6 rounded-xl shadow-sm border border-gray-100 mt-6">
                            <h3 class="text-lg font-heading font-semibold text-charcoal mb-4">Purchase Options</h3>
                            
                            <div class="mb-4">
                                <label for="quantity" class="block text-sm font-medium text-charcoal/70 mb-2">Quantity</label>
                                <div class="flex items-center max-w-[150px] mb-4">
                                    <button type="button" 
                                        class="w-9 h-9 border border-gray-200 bg-white rounded flex items-center justify-center text-xl transition duration-200 ease-in-out" 
                                        onclick="decrementQuantity()" 
                                        {{ $wallpaper->stock <= 0 ? 'disabled' : '' }}>-</button>
                                    <input type="number" 
                                        class="w-[50px] text-center mx-2 border border-gray-200 rounded p-1"
                                        id="quantity" 
                                        name="quantity" 
                                        value="1" 
                                        min="1" 
                                        max="{{ $wallpaper->stock }}"
                                        {{ $wallpaper->stock <= 0 ? 'disabled' : '' }}>
                                    <button type="button" 
                                        class="w-9 h-9 border border-gray-200 bg-white rounded flex items-center justify-center text-xl transition duration-200 ease-in-out" 
                                        onclick="incrementQuantity({{ $wallpaper->stock }})" 
                                        {{ $wallpaper->stock <= 0 ? 'disabled' : '' }}>+</button>
                                </div>
                            </div>
                            
                            <button type="submit" 
                                class="w-full py-3.5 font-semibold text-lg tracking-wide bg-navy text-ivory rounded-md transition-all duration-300 ease-in-out flex items-center justify-center gap-2 shadow-md hover:-translate-y-0.5 hover:shadow-lg disabled:opacity-50 disabled:cursor-not-allowed"
                                {{ $wallpaper->stock <= 0 ? 'disabled' : '' }}>
                                <i class="fas fa-shopping-cart"></i>
                                {{ $wallpaper->stock > 0 ? 'Add to Cart' : 'Out of Stock' }}
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Specifications -->
                <div>
                    <h3 class="text-xl font-heading font-semibold text-charcoal mb-6">Specifications</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 gap-4">
                        <div class="p-4 bg-neutral-100 rounded-lg shadow-sm">
                            <div class="flex items-center gap-3 mb-1">
                                <i class="fas fa-scroll text-navy"></i>
                                <p class="text-sm text-charcoal/60">Material</p>
                            </div>
                            <p class="font-medium text-charcoal">{{ $wallpaper->material }}</p>
                        </div>
                        <div class="p-4 bg-neutral-100 rounded-lg shadow-sm">
                            <div class="flex items-center gap-3 mb-1">
                                <i class="fas fa-expand-arrows-alt text-navy"></i>
                                <p class="text-sm text-charcoal/60">Size</p>
                            </div>
                            <p class="font-medium text-charcoal">{{ $wallpaper->width }}m x {{ $wallpaper->height }}m</p>
                        </div>
                        <div class="p-4 bg-neutral-100 rounded-lg shadow-sm">
                            <div class="flex items-center gap-3 mb-1">
                                <i class="fas fa-th text-navy"></i>
                                <p class="text-sm text-charcoal/60">Pattern</p>
                            </div>
                            <p class="font-medium text-charcoal">{{ $wallpaper->pattern }}</p>
                        </div>
                        <div class="p-4 bg-neutral-100 rounded-lg shadow-sm">
                            <div class="flex items-center gap-3 mb-1">
                                <i class="fas fa-paint-brush text-navy"></i>
                                <p class="text-sm text-charcoal/60">Style</p>
                            </div>
                            <p class="font-medium text-charcoal">{{ $wallpaper->style }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Reviews Section -->
        <div class="mt-16">
            <div class="flex items-center justify-between mb-8">
                <h2 class="text-3xl font-heading font-bold text-charcoal">Customer Reviews</h2>
                @auth
                    <a href="#writeReview" class="px-4 py-2 bg-gold text-navy rounded-md font-medium hover:bg-gold/90 transition-colors">
                        <i class="fas fa-pen-alt mr-2"></i>Write a Review
                    </a>
                @endauth
            </div>
            
            <!-- Reviews List -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-12">
                @forelse($reviews as $review)
                    <div class="bg-white rounded-xl shadow-sm p-6 transition duration-300 ease-in-out hover:-translate-y-1.5 hover:shadow-lg">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h4 class="font-heading font-semibold text-charcoal">{{ $review->user->name }}</h4>
                                <p class="text-sm text-charcoal/60">{{ $review->created_at->diffForHumans() }}</p>
                            </div>
                            <div class="inline-flex text-base">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= $review->rating)
                                        <i class="fas fa-star text-[#D4AF37]"></i>
                                    @else
                                        <i class="fas fa-star text-gray-200"></i>
                                    @endif
                                @endfor
                            </div>
                        </div>
                        <p class="text-charcoal/80">{{ $review->comment }}</p>
                    </div>
                @empty
                    <div class="col-span-2 text-center py-12 bg-white rounded-xl shadow-sm">
                        <div class="text-charcoal/40 mb-4">
                            <i class="fas fa-star text-4xl"></i>
                        </div>
                        <h3 class="text-xl font-heading font-semibold text-charcoal mb-2">No Reviews Yet</h3>
                        <p class="text-charcoal/60">Be the first to review this wallpaper!</p>
                    </div>
                @endforelse
            </div>

            <!-- Show Authentication Status -->
            @guest
                <div class="bg-white/80 p-8 rounded-xl shadow-sm text-center mb-12">
                    <div class="text-charcoal/60 mb-4">
                        <i class="fas fa-user-lock text-3xl"></i>
                    </div>
                    <h3 class="text-xl font-heading font-semibold text-charcoal mb-2">Login to Write a Review</h3>
                    <p class="text-charcoal/70 mb-4">You need to be logged in to share your experience with this product.</p>
                    <a href="{{ route('login') }}" class="inline-block px-6 py-2 bg-navy text-ivory rounded-md font-medium hover:bg-navy/90 transition-colors">
                        Login Now
                    </a>
                </div>
            @else
                <!-- Review Form - Fixed Visibility -->
                <div id="writeReview" class="bg-gradient-to-br from-white/90 to-white/95 backdrop-blur-md rounded-xl p-8 shadow-lg mb-12 border border-white/5">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-xl font-heading font-semibold text-charcoal">Write a Review</h3>
                        <div class="bg-gold/10 px-3 py-1 rounded-full">
                            <i class="fas fa-user text-gold mr-2"></i>
                            <span class="text-sm text-gold font-medium">{{ auth()->user()->name }}</span>
                        </div>
                    </div>
                    
                    <!-- Updated Form with only required fields from the model -->
                    <form action="{{ route('wallpapers.review.store', $wallpaper) }}" method="POST" class="space-y-6">
                        @csrf
                        
                        <!-- Rating Selection -->
                        <div class="bg-white/60 p-4 rounded-lg border border-charcoal/10">
                            <label class="block text-sm font-medium text-charcoal/70 mb-2">Your Rating</label>
                            <div class="flex flex-col sm:flex-row sm:items-center gap-4">
                                <div class="flex gap-2 text-2xl" id="ratingStars">
                                    @for($i = 5; $i >= 1; $i--)
                                        <i class="fas fa-star text-gray-200 cursor-pointer hover:scale-110 transition duration-200" data-rating="{{ $i }}"></i>
                                    @endfor
                                </div>
                                <span id="ratingText" class="text-sm text-charcoal/70 italic">Select a rating</span>
                            </div>
                            <input type="hidden" name="rating" id="selectedRating" value="" required>
                            @error('rating')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <!-- Review Comment -->
                        <div>
                            <label for="comment" class="block text-sm font-medium text-charcoal/70 mb-2">
                                Your Review 
                                <span class="text-charcoal/50 text-xs ml-1">(required)</span>
                            </label>
                            <textarea 
                                class="w-full px-4 py-3 border border-charcoal/20 rounded-md focus:ring-2 focus:ring-gold focus:border-transparent min-h-[120px]" 
                                id="comment" 
                                name="comment" 
                                placeholder="Share your experience with this wallpaper..."
                                required
                                maxlength="1000"></textarea>
                            <div class="flex justify-between mt-2">
                                <span class="text-xs text-charcoal/50">Max 1000 characters</span>
                                <span id="commentCounter" class="text-xs text-charcoal/50">0/1000</span>
                            </div>
                            @error('comment')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <!-- Add hidden wallpaper_id field to ensure proper association -->
                        <input type="hidden" name="wallpaper_id" value="{{ $wallpaper->id }}">
                        
                        <!-- Submit Button -->
                        <div class="flex justify-end pt-4">
                            <button type="submit" class="px-8 py-3 bg-gold text-navy rounded-md font-medium hover:bg-gold/90 transition-colors flex items-center gap-2">
                                <i class="fas fa-paper-plane"></i>
                                Submit Review
                            </button>
                        </div>
                    </form>
                </div>
            @endguest
        </div>

        <!-- Related Wallpapers -->
        @if($relatedWallpapers->count() > 0)
            <div class="mt-16">
                <h2 class="text-3xl font-heading font-bold text-charcoal mb-8">You May Also Like</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach($relatedWallpapers as $related)
                        <a href="{{ route('shop.show', $related) }}" class="block h-full">
                            <div class="h-full bg-white rounded-xl shadow-sm overflow-hidden border border-gray-50 transition duration-300 ease-in-out hover:-translate-y-1 hover:shadow-lg flex flex-col">
                                <div class="aspect-[4/5] w-full relative overflow-hidden">
                                    <img src="{{ $related->getImageUrlAttribute() }}" 
                                        class="w-full h-full object-cover transition duration-500 ease-in-out group-hover:scale-105" 
                                        alt="{{ $related->title }}">
                                </div>
                                <div class="p-5 flex-1 flex flex-col">
                                    <h3 class="font-semibold text-base leading-tight text-gray-800 mb-2 truncate">{{ $related->title }}</h3>
                                    <p class="text-sm text-gray-500 mb-3">{{ $related->category->name ?? 'Uncategorized' }}</p>
                                    
                                    @if($related->reviews->where('is_approved', true)->count() > 0)
                                        <div class="flex text-sm mb-2">
                                            @php
                                                $avgRating = $related->reviews->where('is_approved', true)->avg('rating');
                                                $roundedRating = round($avgRating);
                                            @endphp
                                            
                                            @for($i = 1; $i <= 5; $i++)
                                                @if($i <= $roundedRating)
                                                    <i class="fas fa-star text-[#D4AF37]"></i>
                                                @else
                                                    <i class="fas fa-star text-gray-200"></i>
                                                @endif
                                            @endfor
                                            <span class="text-xs text-gray-500 ml-1">({{ $related->reviews->where('is_approved', true)->count() }})</span>
                                        </div>
                                    @endif
                                    
                                    <p class="text-lg font-bold text-navy mt-auto">${{ number_format($related->price, 2) }}</p>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
    // Image gallery functionality
    function changeImage(src) {
        document.getElementById('mainImage').src = src;
        document.querySelectorAll('.thumbnail').forEach(thumb => {
            thumb.classList.remove('border-[#D4AF37]');
            thumb.classList.add('border-transparent');
            if (thumb.querySelector('img').src === src) {
                thumb.classList.remove('border-transparent');
                thumb.classList.add('border-[#D4AF37]');
            }
        });
    }

    // Quantity buttons functionality
    function decrementQuantity() {
        const input = document.getElementById('quantity');
        const currentValue = parseInt(input.value);
        if (currentValue > 1) {
            input.value = currentValue - 1;
        }
    }

    function incrementQuantity(maxStock) {
        const input = document.getElementById('quantity');
        const currentValue = parseInt(input.value);
        if (currentValue < maxStock) {
            input.value = currentValue + 1;
        }
    }

    // Fixed script to avoid duplication
    document.addEventListener('DOMContentLoaded', function() {
        // Rating stars functionality
        const ratingStars = document.getElementById('ratingStars');
        const selectedRating = document.getElementById('selectedRating');
        const ratingText = document.getElementById('ratingText');
        
        const ratingDescriptions = {
            5: 'Excellent',
            4: 'Very Good',
            3: 'Good',
            2: 'Fair',
            1: 'Poor'
        };
        
        if (ratingStars) {
            // Pre-highlight stars if there's a value
            if (selectedRating.value) {
                highlightStars(selectedRating.value);
            }
            
            // Star rating hover effect
            ratingStars.querySelectorAll('i').forEach(star => {
                star.addEventListener('mouseover', function() {
                    const hoverRating = this.dataset.rating;
                    
                    // Temporarily highlight stars
                    ratingStars.querySelectorAll('i').forEach(s => {
                        s.classList.remove('text-[#D4AF37]', 'text-gray-200');
                        if (s.dataset.rating <= hoverRating) {
                            s.classList.add('text-[#D4AF37]');
                        } else {
                            s.classList.add('text-gray-200');
                        }
                    });
                });
                
                star.addEventListener('mouseout', function() {
                    // Restore original state
                    if (selectedRating.value) {
                        highlightStars(selectedRating.value);
                    } else {
                        ratingStars.querySelectorAll('i').forEach(s => {
                            s.classList.remove('text-[#D4AF37]');
                            s.classList.add('text-gray-200');
                        });
                    }
                });
            });
            
            ratingStars.addEventListener('click', function(e) {
                if (e.target.tagName === 'I') {
                    const rating = e.target.dataset.rating;
                    selectedRating.value = rating;
                    
                    if (ratingText) {
                        ratingText.textContent = ratingDescriptions[rating] || 'Select a rating';
                    }
                    
                    highlightStars(rating);
                }
            });
        }
        
        function highlightStars(rating) {
            document.querySelectorAll('#ratingStars i').forEach(star => {
                star.classList.remove('text-[#D4AF37]', 'text-gray-200');
                if (star.dataset.rating <= rating) {
                    star.classList.add('text-[#D4AF37]');
                } else {
                    star.classList.add('text-gray-200');
                }
            });
        }
        
        // Character counter for review
        const commentTextarea = document.getElementById('comment');
        const commentCounter = document.getElementById('commentCounter');
        
        if (commentTextarea && commentCounter) {
            // Initialize counter
            commentCounter.textContent = '0/1000';
            
            commentTextarea.addEventListener('input', function() {
                const currentLength = this.value.length;
                commentCounter.textContent = `${currentLength}/1000`;
                
                if (currentLength >= 900) {
                    commentCounter.classList.add('text-amber-600');
                } else {
                    commentCounter.classList.remove('text-amber-600');
                }
                
                if (currentLength >= 1000) {
                    commentCounter.classList.add('text-red-600');
                } else {
                    commentCounter.classList.remove('text-red-600');
                }
            });
        }
    });
</script>
@endpush
@endsection