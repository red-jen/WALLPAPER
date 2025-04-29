@extends('layouts.client')

@section('title', 'Shop')

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
    
    <!-- Filters -->
    <div class="row mb-4">
        <div class="col-md-6">
            <form action="{{ route('shop.index') }}" method="GET" class="d-flex gap-2">
                <select name="category" class="form-select" onchange="this.form.submit()">
                    <option value="">All Categories</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                
                <select name="sort" class="form-select" onchange="this.form.submit()">
                    <option value="">Sort By</option>
                    <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Latest</option>
                    <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                    <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                    <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>Most Popular</option>
                </select>
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
                            <img src="{{ $wallpaper->getImageUrlAttribute() }}" 
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
                        <p class="card-text text-muted mb-1">{{ $wallpaper->category->name }}</p>
                        <p class="card-text fs-5 fw-bold">${{ number_format($wallpaper->price, 2) }}</p>
                    </div>
                    <div class="card-footer">
                        <form action="{{ route('shop.cart.add', $wallpaper) }}" method="POST">
                            @csrf
                            <input type="hidden" name="quantity" value="1">
                            <button type="submit" class="btn btn-primary w-100" {{ $wallpaper->stock <= 0 ? 'disabled' : '' }}>
                                {{ $wallpaper->stock > 0 ? 'Add to Cart' : 'Out of Stock' }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info">
                    No wallpapers found matching your criteria.
                </div>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-4">
        {{ $wallpapers->links() }}
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
</style>
@endsection 