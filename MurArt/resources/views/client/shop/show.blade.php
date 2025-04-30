@extends('layouts.app')

@section('title', $wallpaper->title)

@push('styles')
<style>
    .wallpaper-gallery {
        position: relative;
        overflow: hidden;
        border-radius: 0.75rem;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    }
    
    .wallpaper-gallery img {
        transition: transform 0.5s ease;
    }
    
    .wallpaper-gallery:hover img {
        transform: scale(1.05);
    }
    
    .specs-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
    }
    
    .review-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    .review-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    }

    .thumbnail-gallery {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(80px, 1fr));
        gap: 0.5rem;
        margin-top: 1rem;
    }

    .thumbnail {
        position: relative;
        aspect-ratio: 1;
        border-radius: 0.5rem;
        overflow: hidden;
        cursor: pointer;
        border: 2px solid transparent;
        transition: all 0.3s ease;
    }

    .thumbnail.active {
        border-color: #D4AF37;
    }

    .thumbnail:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    }

    .thumbnail img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .rating-stars {
        display: flex;
        gap: 0.5rem;
        font-size: 1.5rem;
        color: #D4AF37;
    }

    .rating-stars i {
        cursor: pointer;
        transition: transform 0.2s ease;
    }

    .rating-stars i:hover {
        transform: scale(1.2);
    }

    .review-form {
        background: linear-gradient(to right bottom, rgba(255, 255, 255, 0.9), rgba(255, 255, 255, 0.95));
        backdrop-filter: blur(10px);
    }

    .product-section {
        margin-bottom: 2rem;
        padding-bottom: 2rem;
        border-bottom: 1px solid rgba(0, 0, 0, 0.1);
    }
    
    .product-section:last-child {
        border-bottom: none;
    }
    
    .add-to-cart-container {
        background: linear-gradient(to right bottom, rgba(255, 255, 255, 0.8), rgba(255, 255, 255, 0.9));
        padding: 1.5rem;
        border-radius: 0.75rem;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        margin-top: 1.5rem;
        border: 1px solid rgba(0, 0, 0, 0.08);
    }
    
    .quantity-selector {
        display: flex;
        align-items: center;
        max-width: 150px;
        margin-bottom: 1rem;
    }
    
    .quantity-selector button {
        width: 36px;
        height: 36px;
        border: 1px solid rgba(0, 0, 0, 0.1);
        background: white;
        border-radius: 4px;
        font-size: 1.25rem;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    
    .quantity-selector input {
        width: 50px;
        text-align: center;
        margin: 0 8px;
        border: 1px solid rgba(0, 0, 0, 0.1);
        border-radius: 4px;
        padding: 0.25rem 0;
    }
    
    .add-to-cart-btn {
        width: 100%;
        padding: 0.875rem;
        font-weight: 600;
        font-size: 1.1rem;
        letter-spacing: 0.02em;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
        box-shadow: 0 4px 10px rgba(28, 55, 90, 0.16);
    }
    
    .add-to-cart-btn:hover:not(:disabled) {
        transform: translateY(-2px);
        box-shadow: 0 6px 12px rgba(28, 55, 90, 0.25);
    }

    .review-form {
        background: linear-gradient(to right bottom, rgba(255, 255, 255, 0.9), rgba(255, 255, 255, 0.95));
        backdrop-filter: blur(10px);
        border-radius: 1rem;
        padding: 2rem;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
        border: 1px solid rgba(0, 0, 0, 0.05);
    }
    
    .product-info-pill {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 1rem;
        border-radius: 9999px;
        font-size: 0.875rem;
        font-weight: 500;
        background-color: rgba(212, 175, 55, 0.1);
        color: rgb(212, 175, 55);
        margin-right: 0.5rem;
        margin-bottom: 0.5rem;
    }
    
    .product-info-pill i {
        font-size: 0.75rem;
    }

    /* Enhanced Related Products Section */
    .related-product-card {
        height: 100%;
        display: flex;
        flex-direction: column;
        transition: all 0.3s ease;
        background: white;
        border-radius: 0.75rem;
        overflow: hidden;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        border: 1px solid rgba(0, 0, 0, 0.04);
    }
    
    .related-product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 20px rgba(0, 0, 0, 0.1);
    }
    
    .related-product-image {
        aspect-ratio: 4/5;
        width: 100%;
        position: relative;
    }
    
    .related-product-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease-in-out;
    }
    
    .related-product-card:hover .related-product-image img {
        transform: scale(1.08);
    }
    
    .related-product-info {
        padding: 1.25rem;
        flex: 1;
        display: flex;
        flex-direction: column;
    }
    
    .related-product-title {
        font-weight: 600;
        margin-bottom: 0.5rem;
        font-size: 1.1rem;
        line-height: 1.4;
        color: #333;
    }
    
    .related-product-category {
        font-size: 0.85rem;
        color: rgba(0, 0, 0, 0.6);
        margin-bottom: 0.75rem;
    }
    
    .related-product-price {
        font-weight: 700;
        color: #1c375a;
        font-size: 1.25rem;
        margin-top: auto;
    }

    /* Enhanced star rating */
    .star-rating {
        display: inline-flex;
        font-size: 1rem;
    }
    
    .star-filled {
        color: #D4AF37;
    }
    
    .star-empty {
        color: rgba(0, 0, 0, 0.2);
    }
</style>
@endpush

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
                <div class="wallpaper-gallery">
                    <div id="wallpaperGallery" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img src="{{ $wallpaper->getImageUrlAttribute() }}" 
                                    class="w-full h-[600px] object-cover" 
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
                <div class="thumbnail-gallery">
                    <div class="thumbnail active" onclick="changeImage('{{ $wallpaper->getImageUrlAttribute() }}')">
                        <img src="{{ $wallpaper->getImageUrlAttribute() }}" alt="Main Image">
                    </div>
                    @foreach($wallpaper->images as $image)
                        <div class="thumbnail" onclick="changeImage('{{ $image->getImageUrlAttribute() }}')">
                            <img src="{{ $image->getImageUrlAttribute() }}" alt="Thumbnail">
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Product Details -->
            <div class="flex flex-col">
                <div class="product-section">
                    <h1 class="text-4xl font-heading font-bold text-charcoal mb-4">{{ $wallpaper->title }}</h1>
                
                    <div class="flex flex-wrap mb-6">
                        <span class="product-info-pill">
                            <i class="fas fa-tag"></i>
                            {{ $wallpaper->category->name ?? 'Unknown' }}
                        </span>
                        <span class="product-info-pill">
                            <i class="fas fa-layer-group"></i>
                            {{ $wallpaper->style }}
                        </span>
                        <span class="product-info-pill">
                            <i class="fas fa-boxes"></i>
                            {{ $wallpaper->stock > 0 ? 'In Stock' : 'Out of Stock' }}
                        </span>
                    </div>

                    <div class="mb-6">
                        <h2 class="text-3xl font-heading font-bold text-navy mb-2">${{ number_format($wallpaper->price, 2) }}</h2>
                        <p class="text-charcoal/70">{{ $wallpaper->stock }} units available</p>
                    </div>
                </div>

                <div class="product-section">
                    <h3 class="text-xl font-heading font-semibold text-charcoal mb-4">Description</h3>
                    <p class="text-charcoal/80 leading-relaxed">{{ $wallpaper->description }}</p>
                </div>

                <!-- Add to Cart Form -->
                <div class="product-section">
                    <form action="{{ route('shop.cart.add', $wallpaper) }}" method="POST">
                        @csrf
                        <div class="add-to-cart-container">
                            <h3 class="text-lg font-heading font-semibold text-charcoal mb-4">Purchase Options</h3>
                            
                            <div class="mb-4">
                                <label for="quantity" class="block text-sm font-medium text-charcoal/70 mb-2">Quantity</label>
                                <div class="quantity-selector">
                                    <button type="button" onclick="decrementQuantity()" {{ $wallpaper->stock <= 0 ? 'disabled' : '' }}>-</button>
                                    <input type="number" 
                                        id="quantity" 
                                        name="quantity" 
                                        value="1" 
                                        min="1" 
                                        max="{{ $wallpaper->stock }}"
                                        {{ $wallpaper->stock <= 0 ? 'disabled' : '' }}>
                                    <button type="button" onclick="incrementQuantity({{ $wallpaper->stock }})" {{ $wallpaper->stock <= 0 ? 'disabled' : '' }}>+</button>
                                </div>
                            </div>
                            
                            <button type="submit" 
                                class="add-to-cart-btn bg-navy text-ivory rounded-md hover:bg-navy/90 transition-colors flex items-center justify-center gap-2 {{ $wallpaper->stock <= 0 ? 'opacity-50 cursor-not-allowed' : '' }}"
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
                    <div class="specs-grid">
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
                    <div class="review-card bg-white rounded-xl shadow-sm p-6">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h4 class="font-heading font-semibold text-charcoal">{{ $review->user->name }}</h4>
                                <p class="text-sm text-charcoal/60">{{ $review->created_at->diffForHumans() }}</p>
                            </div>
                            <div class="star-rating">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= $review->rating)
                                        <i class="fas fa-star star-filled"></i>
                                    @else
                                        <i class="fas fa-star star-empty"></i>
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
                <div id="writeReview" class="review-form mb-12 block bg-white rounded-xl shadow-md">
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
                                <div class="rating-stars" id="ratingStars">
                                    @for($i = 5; $i >= 1; $i--)
                                        <i class="fas fa-star text-charcoal/20" data-rating="{{ $i }}"></i>
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
                            <div class="related-product-card h-full">
                                <div class="related-product-image overflow-hidden">
                                    <img src="{{ $related->getImageUrlAttribute() }}" alt="{{ $related->title }}">
                                </div>
                                <div class="related-product-info">
                                    <h3 class="related-product-title truncate">{{ $related->title }}</h3>
                                    <p class="related-product-category">{{ $related->category->name ?? 'Uncategorized' }}</p>
                                    
                                    @if($related->reviews->where('is_approved', true)->count() > 0)
                                        <div class="star-rating mb-2">
                                            @php
                                                $avgRating = $related->reviews->where('is_approved', true)->avg('rating');
                                                $roundedRating = round($avgRating);
                                            @endphp
                                            
                                            @for($i = 1; $i <= 5; $i++)
                                                @if($i <= $roundedRating)
                                                    <i class="fas fa-star star-filled"></i>
                                                @else
                                                    <i class="fas fa-star star-empty"></i>
                                                @endif
                                            @endfor
                                            <span class="text-xs text-charcoal/60 ml-1">({{ $related->reviews->where('is_approved', true)->count() }})</span>
                                        </div>
                                    @endif
                                    
                                    <p class="related-product-price">${{ number_format($related->price, 2) }}</p>
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
            thumb.classList.remove('active');
            if (thumb.querySelector('img').src === src) {
                thumb.classList.add('active');
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
                        s.classList.remove('text-gold', 'text-charcoal/20');
                        if (s.dataset.rating <= hoverRating) {
                            s.classList.add('text-gold');
                        } else {
                            s.classList.add('text-charcoal/20');
                        }
                    });
                });
                
                star.addEventListener('mouseout', function() {
                    // Restore original state
                    if (selectedRating.value) {
                        highlightStars(selectedRating.value);
                    } else {
                        ratingStars.querySelectorAll('i').forEach(s => {
                            s.classList.remove('text-gold');
                            s.classList.add('text-charcoal/20');
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
                star.classList.remove('text-gold', 'text-charcoal/20');
                if (star.dataset.rating <= rating) {
                    star.classList.add('text-gold');
                } else {
                    star.classList.add('text-charcoal/20');
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