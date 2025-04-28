@extends('layouts.client')

@section('title', $wallpaper->title)

@section('content')
<div class="container py-5">
    <!-- Alerts -->
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('client.home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('shop.index') }}">Shop</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $wallpaper->title }}</li>
        </ol>
    </nav>

    <!-- Wallpaper Information Section -->
    <div class="row mb-5">
        <!-- Preview Image -->
        <div class="col-md-7 mb-4 mb-md-0">
            <div class="card">
                <img src="{{ asset('storage/' . $wallpaper->preview_image) }}" 
                    class="img-fluid rounded" 
                    alt="{{ $wallpaper->title }}">
            </div>
        </div>

        <!-- Wallpaper Details -->
        <div class="col-md-5">
            <h1 class="mb-2">{{ $wallpaper->title }}</h1>
            <p class="mb-2">
                <strong>Artist:</strong> {{ $wallpaper->user->name }}
            </p>
            <p class="mb-2">
                <span class="badge bg-secondary">{{ $wallpaper->design->name }}</span>
            </p>
            <p class="mb-2">
                <strong>Dimensions:</strong> {{ $wallpaper->width }}x{{ $wallpaper->height }} pixels
            </p>
            
            <!-- Rating display -->
            <div class="mb-3">
                @php
                    $rating = $wallpaper->reviews->avg('rating') ?? 0;
                    $fullStars = floor($rating);
                    $halfStar = $rating - $fullStars >= 0.5;
                    $emptyStars = 5 - $fullStars - ($halfStar ? 1 : 0);
                @endphp
                
                @for($i = 0; $i < $fullStars; $i++)
                    <i class="fas fa-star text-warning"></i>
                @endfor
                
                @if($halfStar)
                    <i class="fas fa-star-half-alt text-warning"></i>
                @endif
                
                @for($i = 0; $i < $emptyStars; $i++)
                    <i class="far fa-star text-warning"></i>
                @endfor
                
                <span class="ms-1">{{ number_format($rating, 1) }}</span>
                <span class="text-muted">({{ $wallpaper->reviews->count() }} {{ Str::plural('review', $wallpaper->reviews->count()) }})</span>
            </div>
            
            <h3 class="h2 text-primary mb-4">${{ number_format($wallpaper->price, 2) }}</h3>

            <!-- Add to Cart Form -->
            <form action="{{ route('cart.add', $wallpaper) }}" method="POST" class="mb-4">
                @csrf
                <div class="row g-3">
                    <div class="col-md-4">
                        <label for="quantity" class="form-label">Quantity</label>
                        <input type="number" class="form-control" id="quantity" name="quantity" value="1" min="1" max="10">
                    </div>
                    <div class="col-md-8 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary btn-lg w-100">
                            <i class="fas fa-shopping-cart me-2"></i>Add to Cart
                        </button>
                    </div>
                </div>
            </form>

            <!-- Description -->
            <div class="card mt-4">
                <div class="card-header">
                    <h4 class="mb-0">Description</h4>
                </div>
                <div class="card-body">
                    <p class="card-text">{{ $wallpaper->description }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Reviews Section -->
    <div class="card mb-5">
        <div class="card-header bg-light">
            <h3 class="mb-0">Customer Reviews</h3>
        </div>
        <div class="card-body">
            @forelse($wallpaper->reviews as $review)
                <div class="review border-bottom pb-4 mb-4">
                    <div class="d-flex justify-content-between mb-2">
                        <h5 class="mb-0">{{ $review->name }}</h5>
                        <small class="text-muted">{{ $review->created_at->format('M d, Y') }}</small>
                    </div>
                    <div class="mb-2">
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= $review->rating)
                                <i class="fas fa-star text-warning"></i>
                            @else
                                <i class="far fa-star text-warning"></i>
                            @endif
                        @endfor
                    </div>
                    <p>{{ $review->comment }}</p>
                </div>
            @empty
                <div class="text-center py-4">
                    <p class="mb-0">No reviews yet. Be the first to review this wallpaper!</p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Review Form -->
    <div class="card mb-5">
        <div class="card-header bg-light">
            <h3 class="mb-0">Write a Review</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('shop.review', $wallpaper) }}" method="POST">
                @csrf
                
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                        @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required>
                        @error('email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Rating</label>
                    <div class="star-rating">
                        @for($i = 5; $i >= 1; $i--)
                            <input type="radio" id="star{{$i}}" name="rating" value="{{$i}}" {{ old('rating') == $i ? 'checked' : '' }} required>
                            <label for="star{{$i}}"><i class="far fa-star"></i></label>
                        @endfor
                    </div>
                    @error('rating')
                        <div class="text-danger">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                
                <div class="mb-3">
                    <label for="comment" class="form-label">Comment</label>
                    <textarea class="form-control @error('comment') is-invalid @enderror" id="comment" name="comment" rows="4" required>{{ old('comment') }}</textarea>
                    @error('comment')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                
                <button type="submit" class="btn btn-primary">Submit Review</button>
            </form>
        </div>
    </div>

    <!-- Related Wallpapers -->
    <div class="related-wallpapers mb-5">
        <h3 class="mb-4">Related Wallpapers</h3>
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
            @foreach($relatedWallpapers as $related)
                <div class="col">
                    <div class="card h-100 wallpaper-card">
                        <a href="{{ route('shop.show', $related) }}" class="text-decoration-none">
                            <div class="wallpaper-thumbnail">
                                <img src="{{ asset('storage/'.$related->preview_image) }}" 
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
                            <p class="card-text text-muted mb-1">{{ $related->user->name }}</p>
                            <p class="card-text fs-5 fw-bold">${{ number_format($related->price, 2) }}</p>
                        </div>
                        <div class="card-footer">
                            <form action="{{ route('cart.add', $related) }}" method="POST">
                                @csrf
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" class="btn btn-primary w-100">
                                    Add to Cart
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

<!-- Custom styles -->
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
    
    /* Star Rating styles */
    .star-rating {
        display: flex;
        flex-direction: row-reverse;
        justify-content: flex-end;
    }
    
    .star-rating input {
        display: none;
    }
    
    .star-rating label {
        cursor: pointer;
        font-size: 1.5rem;
        color: #ccc;
        margin-right: 5px;
    }
    
    .star-rating label:hover,
    .star-rating label:hover ~ label,
    .star-rating input:checked ~ label {
        color: #f8ce0b;
    }
    
    .star-rating label:hover i,
    .star-rating label:hover ~ label i,
    .star-rating input:checked ~ label i {
        content: '\f005';
        font-weight: 900;
    }
</style>

@section('scripts')
<script>
    // Change star icons when selected
    document.addEventListener('DOMContentLoaded', function() {
        const starLabels = document.querySelectorAll('.star-rating label');
        
        starLabels.forEach(label => {
            label.addEventListener('click', function() {
                // Change the icon for this label and all previous ones
                let icon = this.querySelector('i');
                icon.classList.remove('far');
                icon.classList.add('fas');
                
                // Get the previousSibling elements and change them too
                let prev = this;
                while (prev = prev.nextElementSibling) {
                    if (prev.tagName === 'LABEL') {
                        let prevIcon = prev.querySelector('i');
                        prevIcon.classList.remove('far');
                        prevIcon.classList.add('fas');
                    }
                }
                
                // Reset the following siblings
                let next = this;
                while (next = next.previousElementSibling) {
                    if (next.tagName === 'LABEL') {
                        let nextIcon = next.querySelector('i');
                        nextIcon.classList.remove('fas');
                        nextIcon.classList.add('far');
                    }
                }
            });
        });
    });
</script>
@endsection 