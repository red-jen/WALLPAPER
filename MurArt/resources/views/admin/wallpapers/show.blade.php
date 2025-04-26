@extends('layouts.admin')

@section('styles')
<style>
    .carousel-item img {
        max-height: 400px;
        object-fit: contain;
    }
    .thumbnail-image {
        width: 80px;
        height: 80px;
        object-fit: cover;
        cursor: pointer;
        border: 2px solid transparent;
    }
    .thumbnail-image.active {
        border-color: #4e73df;
    }
</style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ $wallpaper->title }}</h1>
        <div>
            <a href="{{ route('admin.wallpapers.edit', $wallpaper) }}" class="btn btn-sm btn-primary shadow-sm">
                <i class="fas fa-edit fa-sm text-white-50"></i> Edit
            </a>
            <a href="{{ route('admin.wallpapers.index') }}" class="btn btn-sm btn-secondary shadow-sm ml-2">
                <i class="fas fa-arrow-left fa-sm text-white-50"></i> Back to Wallpapers
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="row">
        <!-- Left Column (Images) -->
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Wallpaper Images</h6>
                </div>
                <div class="card-body">
                    @if($wallpaper->images->count() > 0)
                        <!-- Main Image Carousel -->
                        <div id="wallpaperCarousel" class="carousel slide mb-4" data-ride="carousel">
                            <div class="carousel-inner">
                                @foreach($wallpaper->images as $index => $image)
                                    <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                        <img src="{{ asset('storage/' . $image->image_path) }}" class="d-block w-100" alt="{{ $image->title ?? $wallpaper->title }}">
                                        @if($image->title)
                                            <div class="carousel-caption d-none d-md-block">
                                                <h5>{{ $image->title }}</h5>
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                            <a class="carousel-control-prev" href="#wallpaperCarousel" role="button" data-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="sr-only">Previous</span>
                            </a>
                            <a class="carousel-control-next" href="#wallpaperCarousel" role="button" data-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="sr-only">Next</span>
                            </a>
                        </div>
                        
                        <!-- Thumbnail Navigation -->
                        <div class="d-flex flex-wrap justify-content-center">
                            @foreach($wallpaper->images as $index => $image)
                                <div class="m-1">
                                    <img 
                                        src="{{ asset('storage/' . $image->image_path) }}" 
                                        class="thumbnail-image {{ $index === 0 ? 'active' : '' }}" 
                                        data-target="#wallpaperCarousel" 
                                        data-slide-to="{{ $index }}"
                                        alt="{{ $image->title ?? 'Image ' . ($index + 1) }}"
                                    >
                                    @if($image->is_primary)
                                        <div class="text-center">
                                            <span class="badge badge-primary">Primary</span>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-5">
                            <p class="text-muted">No images available</p>
                        </div>
                    @endif
                </div>
            </div>
            
            <!-- Reviews Section -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Reviews</h6>
                </div>
                <div class="card-body">
                    @if($wallpaper->reviews->count() > 0)
                        @foreach($wallpaper->reviews as $review)
                            <div class="card mb-3">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h6 class="font-weight-bold">{{ $review->user->name }}</h6>
                                            <div class="text-warning mb-2">
                                                @for($i = 1; $i <= 5; $i++)
                                                    @if($i <= $review->rating)
                                                        <i class="fas fa-star"></i>
                                                    @else
                                                        <i class="far fa-star"></i>
                                                    @endif
                                                @endfor
                                                <span class="text-muted ml-2">{{ $review->created_at->format('M d, Y') }}</span>
                                            </div>
                                        </div>
                                        <div>
                                            <form action="{{ route('admin.reviews.destroy', $review) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this review?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                    <p class="card-text">{{ $review->comment }}</p>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <p class="text-center text-muted">No reviews yet</p>
                    @endif
                </div>
            </div>
        </div>
        
        <!-- Right Column (Details) -->
        <div class="col-lg-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Wallpaper Details</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <th style="width: 40%;">Category</th>
                                    <td>{{ $wallpaper->category->name ?? 'None' }}</td>
                                </tr>
                                <tr>
                                    <th>Price</th>
                                    <td>${{ number_format($wallpaper->price, 2) }}</td>
                                </tr>
                                <tr>
                                    <th>Dimensions</th>
                                    <td>{{ $wallpaper->dimensions }}</td>
                                </tr>
                                <tr>
                                    <th>Stock</th>
                                    <td>
                                        <span class="badge {{ $wallpaper->stock > 0 ? 'badge-success' : 'badge-danger' }}">
                                            {{ $wallpaper->stock }}
                                        </span>
                                        <button type="button" class="btn btn-sm btn-warning ml-2" data-toggle="modal" data-target="#updateStockModal">
                                            <i class="fas fa-edit"></i> Update
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Downloads</th>
                                    <td>{{ $wallpaper->downloads }}</td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td>
                                        @if($wallpaper->status == 'draft')
                                            <span class="badge badge-secondary">Draft</span>
                                        @elseif($wallpaper->status == 'published')
                                            <span class="badge badge-success">Published</span>
                                        @elseif($wallpaper->status == 'featured')
                                            <span class="badge badge-primary">Featured</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Created</th>
                                    <td>{{ $wallpaper->created_at->format('M d, Y') }}</td>
                                </tr>
                                <tr>
                                    <th>Last Updated</th>
                                    <td>{{ $wallpaper->updated_at->format('M d, Y') }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    
                    @if($wallpaper->description)
                        <div class="mt-3">
                            <h6 class="font-weight-bold">Description</h6>
                            <p>{{ $wallpaper->description }}</p>
                        </div>
                    @endif
                </div>
            </div>
            
            <!-- Compatible Papers -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Compatible Papers</h6>
                </div>
                <div class="card-body">
                    @if($wallpaper->papers->count() > 0)
                        <ul class="list-group">
                            @foreach($wallpaper->papers as $paper)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    {{ $paper->name }}
                                    @if($paper->pivot->is_recommended)
                                        <span class="badge badge-primary badge-pill">Recommended</span>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-center text-muted">No compatible papers specified</p>
                    @endif
                </div>
            </div>
            
            <!-- Danger Zone -->
            <div class="card border-danger mb-4">
                <div class="card-header bg-danger text-white py-3">
                    <h6 class="m-0 font-weight-bold">Danger Zone</h6>
                </div>
                <div class="card-body">
                    <button type="button" class="btn btn-danger btn-block" data-toggle="modal" data-target="#deleteWallpaperModal">
                        <i class="fas fa-trash"></i> Delete Wallpaper
                    </button>
                </div>
            </div>
        </div>