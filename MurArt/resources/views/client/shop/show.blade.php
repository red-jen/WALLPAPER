@extends('layouts.client')

@section('title', $wallpaper->title)

@section('content')
<div class="container py-5">
    <div class="row">
        <!-- Image Gallery -->
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-body p-0">
                    <div id="wallpaperGallery" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img src="{{ $wallpaper->getImageUrlAttribute() }}" 
                                    class="d-block w-100" 
                                    alt="{{ $wallpaper->title }}">
                            </div>
                            @foreach($wallpaper->images as $image)
                                <div class="carousel-item">
                                    <img src="{{ $image->getImageUrlAttribute() }}" 
                                        class="d-block w-100" 
                                        alt="{{ $wallpaper->title }}">
                                </div>
                            @endforeach
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
            </div>
        </div>

        <!-- Add this somewhere in your view for debugging -->
@if(app()->environment('local'))
<div class="mt-4 p-3 bg-light">
    <h5>Debug Information:</h5>
    <ul>
        @foreach($wallpapers as $w)
            <li>{{ $w->title }} - Stock: {{ $w->stock }} (inStock: {{ $w->getInStockAttribute() }})</li>
        @endforeach
    </ul>
</div>
@endif

        <!-- Wallpaper Details -->
        <div class="col-md-6">
            <h1 class="mb-3">{{ $wallpaper->title }}</h1>
            
            <div class="mb-3">
                <span class="badge bg-primary">{{ $wallpaper->category->name }}</span>
            </div>

            <div class="mb-4">
                <h3 class="text-primary">${{ number_format($wallpaper->price, 2) }}</h3>
                <p class="text-muted mb-0">Stock: {{ $wallpaper->stock }} available</p>
            </div>

            <div class="mb-4">
                <h5>Description</h5>
                <p>{{ $wallpaper->description }}</p>
            </div>

            <!-- Add to Cart Form -->
            <form action="{{ route('shop.cart.add', $wallpaper) }}" method="POST" class="mb-4">
                @csrf
                <div class="row g-3 align-items-center">
                    <div class="col-auto">
                        <label for="quantity" class="form-label">Quantity</label>
                        <input type="number" 
                            class="form-control" 
                            id="quantity" 
                            name="quantity" 
                            value="1" 
                            min="1" 
                            max="{{ $wallpaper->stock }}"
                            {{ $wallpaper->stock <= 0 ? 'disabled' : '' }}>
                    </div>
                    <div class="col-auto d-flex align-items-end">
                        <button type="submit" 
                            class="btn btn-primary btn-lg" 
                            {{ $wallpaper->stock <= 0 ? 'disabled' : '' }}>
                            {{ $wallpaper->stock > 0 ? 'Add to Cart' : 'Out of Stock' }}
                        </button>
                    </div>
                </div>
            </form>

            <!-- Specifications -->
            <div class="mb-4">
                <h5>Specifications</h5>
                <ul class="list-unstyled">
                    <li><strong>Material:</strong> {{ $wallpaper->material }}</li>
                    <li><strong>Size:</strong> {{ $wallpaper->width }}m x {{ $wallpaper->height }}m</li>
                    <li><strong>Pattern:</strong> {{ $wallpaper->pattern }}</li>
                    <li><strong>Style:</strong> {{ $wallpaper->style }}</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Reviews Section -->
    <div class="row mt-5">
        <div class="col-12">
            <h3 class="mb-4">Customer Reviews</h3>
            <!-- Add this somewhere in your view for debugging -->
@if(app()->environment('local'))
    <div class="mt-4 p-3 bg-light">
        <h5>Debug Information:</h5>
        <ul>
            @foreach($wallpapers as $w)
                <li>{{ $w->title }} - Stock: {{ $w->stock }} (inStock: {{ $w->getInStockAttribute() }})</li>
            @endforeach
        </ul>
    </div>
@endif

            <!-- Review Form -->
            @auth
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Write a Review</h5>
                        <form action="{{ route('shop.reviews.store', $wallpaper) }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="rating" class="form-label">Rating</label>
                                <select class="form-select" id="rating" name="rating" required>
                                    <option value="">Select rating</option>
                                    @for($i = 5; $i >= 1; $i--)
                                        <option value="{{ $i }}">{{ $i }} stars</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="comment" class="form-label">Your Review</label>
                                <textarea class="form-control" id="comment" name="comment" rows="3" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Submit Review</button>
                        </form>
                    </div>
                </div>
            @endauth

            <!-- Reviews List -->
            <div class="reviews-list">
                @forelse($wallpaper->reviews->where('is_approved', true) as $review)
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <div>
                                    <h6 class="mb-0">{{ $review->user->name }}</h6>
                                    <small class="text-muted">{{ $review->created_at->diffForHumans() }}</small>
                                </div>
                                <div class="rating">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star {{ $i <= $review->rating ? 'text-warning' : 'text-muted' }}"></i>
                                    @endfor
                                </div>
                            </div>
                            <p class="card-text">{{ $review->comment }}</p>
                        </div>
                    </div>
                @empty
                    <div class="alert alert-info">
                        No reviews yet. Be the first to review this wallpaper!
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Related Wallpapers -->
    @if($relatedWallpapers->count() > 0)
        <div class="row mt-5">
            <div class="col-12">
                <h3 class="mb-4">You May Also Like</h3>
                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
                    @foreach($relatedWallpapers as $related)
                        <div class="col">
                            <div class="card h-100 wallpaper-card">
                                <a href="{{ route('shop.show', $related) }}" class="text-decoration-none">
                                    <div class="wallpaper-thumbnail">
                                        <img src="{{ $related->getImageUrlAttribute() }}" 
                                            class="card-img-top" 
                                            alt="{{ $related->title }}">
                                    </div>
                                </a>
                                <div class="card-body">
                                    <h5 class="card-title">
                                        <a href="{{ route('shop.show', $related) }}" class="text-decoration-none text-dark">
                                            {{ $related->title }}
                                        </a>
                                    </h5>
                                    <p class="card-text text-muted mb-1">{{ $related->category->name }}</p>
                                    <p class="card-text fs-5 fw-bold">${{ number_format($related->price, 2) }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
</div>

<style>
    .wallpaper-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    .wallpaper-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    }
    
    .wallpaper-thumbnail {
        position: relative;
        overflow: hidden;
        height: 200px;
    }
    
    .wallpaper-thumbnail img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }
    
    .wallpaper-card:hover .wallpaper-thumbnail img {
        transform: scale(1.05);
    }

    #wallpaperGallery .carousel-item img {
        height: 500px;
        object-fit: cover;
    }
</style>
@endsection 