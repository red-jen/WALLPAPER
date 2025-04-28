@extends('layouts.client')

@section('title', 'Shop Wallpapers')

@section('content')
<div class="container py-5">
    <!-- Alerts -->
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    
    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('client.home') }}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Shop</li>
        </ol>
    </nav>

    <h1 class="mb-4">Shop Wallpapers</h1>
    
    <!-- Filters (optional) -->
    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('shop.index') }}" method="GET" class="row g-3">
                <div class="col-md-3">
                    <label for="design" class="form-label">Design</label>
                    <select name="design" id="design" class="form-select">
                        <option value="">All Designs</option>
                        <!-- Loop through designs -->
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="artist" class="form-label">Artist</label>
                    <select name="artist" id="artist" class="form-select">
                        <option value="">All Artists</option>
                        <!-- Loop through artists -->
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="sort" class="form-label">Sort By</label>
                    <select name="sort" id="sort" class="form-select">
                        <option value="newest">Newest First</option>
                        <option value="price_low">Price: Low to High</option>
                        <option value="price_high">Price: High to Low</option>
                        <option value="popular">Most Popular</option>
                    </select>
                </div>
                <div class="col-md-3 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">Apply Filters</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Wallpapers Grid -->
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
        @forelse($wallpapers as $wallpaper)
            <div class="col">
                <div class="card h-100 wallpaper-card">
                    <a href="{{ route('shop.show', $wallpaper) }}" class="text-decoration-none">
                        <div class="wallpaper-thumbnail">
                            <img src="{{ asset('storage/'.$wallpaper->preview_image) }}" 
                                class="card-img-top" 
                                alt="{{ $wallpaper->title }}">
                        </div>
                    </a>
                    <div class="card-body">
                        <h5 class="card-title">
                            <a href="{{ route('shop.show', $wallpaper) }}" class="text-decoration-none text-dark">
                                {{ $wallpaper->title }}
                            </a>
                        </h5>
                        <p class="card-text text-muted mb-1">{{ $wallpaper->user->name }}</p>
                        <p class="card-text mb-1">
                            <span class="badge bg-secondary">{{ $wallpaper->design->name }}</span>
                        </p>
                        
                        <!-- Rating display -->
                        <div class="mb-2">
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
                            
                            <small class="text-muted">({{ $wallpaper->reviews->count() }})</small>
                        </div>
                        
                        <p class="card-text fs-5 fw-bold">${{ number_format($wallpaper->price, 2) }}</p>
                    </div>
                    <div class="card-footer">
                        <form action="{{ route('cart.add', $wallpaper) }}" method="POST">
                            @csrf
                            <input type="hidden" name="quantity" value="1">
                            <button type="submit" class="btn btn-primary w-100">
                                Add to Cart
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info">
                    No wallpapers available at the moment. Please check back later.
                </div>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="mt-4 d-flex justify-content-center">
        {{ $wallpapers->links() }}
    </div>
</div>

<!-- Custom styles for wallpaper cards -->
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
        height: 250px;
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
</style>
@endsection 