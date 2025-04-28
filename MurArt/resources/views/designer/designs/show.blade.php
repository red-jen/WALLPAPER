@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ $design->title }}</h1>
        <div>
            <a href="{{ route('designer.designs.edit', $design) }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                <i class="fas fa-edit fa-sm text-white-50"></i> Edit Design
            </a>
            <a href="{{ route('designer.designs.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm ml-2">
                <i class="fas fa-arrow-left fa-sm text-white-50"></i> Back to Designs
            </a>
        </div>
    </div>

    <div class="row">
        <!-- Design Details -->
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Design Details</h6>
                </div>
                <div class="card-body">
                    <div class="text-center mb-4">
                        <img src="{{ asset('storage/' . $design->image_path) }}" alt="{{ $design->title }}" class="img-fluid" style="max-height: 400px;">
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <p><strong>Category:</strong> {{ $design->category->name ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Designer:</strong> {{ $design->designer->name ?? 'N/A' }}</p>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <p><strong>Created:</strong> {{ $design->created_at->format('M d, Y') }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Last Updated:</strong> {{ $design->updated_at->format('M d, Y') }}</p>
                        </div>
                    </div>
                    
                    <!-- Design Actions -->
                    <div class="mt-4 d-flex justify-content-between">
                        <div>
                            <form action="{{ route('designer.designs.destroy', $design) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this design? This action cannot be undone.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">
                                    <i class="fas fa-trash fa-sm"></i> Delete Design
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Reviews Section -->
          <!-- Add this section to your existing design show page -->

<div class="card shadow mb-4 mt-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Reviews</h6>
    </div>
    <div class="card-body">
        @auth
            <!-- Review Form -->
            <form action="{{ route('reviews.store', $design) }}" method="POST" class="mb-4">
                @csrf
                <div class="form-group">
                    <label for="rating">Rating</label>
                    <select class="form-control @error('rating') is-invalid @enderror" id="rating" name="rating" required>
                        <option value="">Select a rating</option>
                        <option value="5">5 - Excellent</option>
                        <option value="4">4 - Very Good</option>
                        <option value="3">3 - Good</option>
                        <option value="2">2 - Fair</option>
                        <option value="1">1 - Poor</option>
                    </select>
                    @error('rating')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="comment">Your Review (Optional)</label>
                    <textarea class="form-control @error('comment') is-invalid @enderror" id="comment" name="comment" rows="3">{{ old('comment') }}</textarea>
                    @error('comment')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary">Submit Review</button>
            </form>
        @else
            <div class="alert alert-info">
                Please <a href="{{ route('login') }}">log in</a> to leave a review.
            </div>
        @endauth

        <!-- Display Reviews -->
        <h5>Customer Reviews</h5>
        
        @if($design->reviews()->where('is_approved', true)->count() > 0)
            @foreach($design->reviews()->where('is_approved', true)->with('user')->latest()->get() as $review)
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6 class="card-title font-weight-bold">{{ $review->user->name }}</h6>
                                <p class="card-subtitle mb-2 text-muted small">{{ $review->created_at->format('M d, Y') }}</p>
                            </div>
                            <div>
                                <span class="badge badge-primary">Rating: {{ $review->rating }}/5</span>
                                
                                @if(Auth::id() == $review->user_id)
                                    <form action="{{ route('reviews.destroy', $review) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete your review?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                        
                        @if($review->comment)
                            <p class="card-text mt-2">{{ $review->comment }}</p>
                        @endif
                    </div>
                </div>
            @endforeach
        @else
            <p class="text-muted">No reviews yet. Be the first to leave a review!</p>
        @endif
    </div>
</div>
        
        <!-- Recommended Papers -->
        <div class="col-lg-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Recommended Papers</h6>
                </div>
                <div class="card-body">
                    @if($recommendedPapers->count() > 0)
                        @foreach($recommendedPapers as $paper)
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h6 class="font-weight-bold">{{ $paper->name }}</h6>
                                    <p class="small mb-1"><strong>Type:</strong> {{ $paper->type }}</p>
                                    @if($paper->thickness)
                                        <p class="small mb-1"><strong>Thickness:</strong> {{ $paper->thickness }} GSM</p>
                                    @endif
                                    @if($paper->size)
                                        <p class="small mb-1"><strong>Size:</strong> {{ $paper->size }}</p>
                                    @endif
                                    @if($paper->price)
                                        <p class="small mb-1"><strong>Price:</strong> ${{ number_format($paper->price, 2) }}</p>
                                    @endif
                                    <a href="{{ route('admin.papers.show', $paper) }}" class="btn btn-sm btn-info mt-2">
                                        <i class="fas fa-info-circle"></i> View Details
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <p class="text-center mb-0">No recommended papers found.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection