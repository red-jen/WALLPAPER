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
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Design Details</h6>
                    <span class="badge badge-{{ $design->status === 'published' ? 'success' : 'warning' }}">
                        {{ ucfirst($design->status) }}
                    </span>
                </div>
                <div class="card-body">
                    <!-- Main Image -->
                    <div class="text-center mb-4">
                        <img src="{{ asset('storage/' . $design->image_path) }}" 
                             alt="{{ $design->title }}" 
                             class="img-fluid rounded-lg shadow-sm" 
                             style="max-height: 400px; object-fit: contain;">
                    </div>
                    
                    <!-- Design Information -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="info-card mb-4">
                                <h6 class="text-gray-600 mb-3">Design Information</h6>
                                <div class="info-item mb-2">
                                    <span class="text-gray-500">Category:</span>
                                    <span class="font-weight-bold">{{ $design->category->name ?? 'N/A' }}</span>
                                </div>
                                <div class="info-item mb-2">
                                    <span class="text-gray-500">Created:</span>
                                    <span class="font-weight-bold">{{ $design->created_at->format('M d, Y') }}</span>
                                </div>
                                <div class="info-item mb-2">
                                    <span class="text-gray-500">Last Updated:</span>
                                    <span class="font-weight-bold">{{ $design->updated_at->format('M d, Y') }}</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="info-card mb-4">
                                <h6 class="text-gray-600 mb-3">Usage Statistics</h6>
                                <div class="info-item mb-2">
                                    <span class="text-gray-500">Times Used:</span>
                                    <span class="font-weight-bold">{{ $design->artworkUsageCount }}</span>
                                </div>
                                <div class="info-item mb-2">
                                    <span class="text-gray-500">Designer:</span>
                                    <span class="font-weight-bold">{{ $design->designer->name ?? 'N/A' }}</span>
                                </div>
                                @if($design->is_featured)
                                <div class="info-item mb-2">
                                    <span class="badge badge-warning">
                                        <i class="fas fa-star"></i> Featured Design
                                    </span>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Description -->
                    @if($design->description)
                    <div class="description-section mb-4">
                        <h6 class="text-gray-600 mb-3">Description</h6>
                        <p class="text-gray-800">{{ $design->description }}</p>
                    </div>
                    @endif
                    
                    <!-- Design Actions -->
                    <div class="mt-4 d-flex justify-content-between align-items-center">
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
                                <div class="rating-stars">
                                    @for($i = 5; $i >= 1; $i--)
                                        <input type="radio" name="rating" id="star{{ $i }}" value="{{ $i }}" {{ old('rating') == $i ? 'checked' : '' }}>
                                        <label for="star{{ $i }}" title="{{ $i }} stars">
                                            <i class="fas fa-star"></i>
                                        </label>
                                    @endfor
                                </div>
                                @error('rating')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="comment">Your Review (Optional)</label>
                                <textarea class="form-control @error('comment') is-invalid @enderror" 
                                          id="comment" 
                                          name="comment" 
                                          rows="3"
                                          placeholder="Share your thoughts about this design...">{{ old('comment') }}</textarea>
                                @error('comment')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-paper-plane"></i> Submit Review
                            </button>
                        </form>
                    @else
                        <div class="alert alert-info">
                            Please <a href="{{ route('login') }}">log in</a> to leave a review.
                        </div>
                    @endauth

                    <!-- Display Reviews -->
                    <h5 class="mb-3">Customer Reviews</h5>
                    
                    @if($design->reviews()->where('is_approved', true)->count() > 0)
                        @foreach($design->reviews()->where('is_approved', true)->with('user')->latest()->get() as $review)
                            <div class="review-card mb-3">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <h6 class="font-weight-bold mb-1">{{ $review->user->name }}</h6>
                                        <div class="rating-stars mb-2">
                                            @for($i = 1; $i <= 5; $i++)
                                                <i class="fas fa-star {{ $i <= $review->rating ? 'text-warning' : 'text-gray-300' }}"></i>
                                            @endfor
                                        </div>
                                        <small class="text-muted">{{ $review->created_at->format('M d, Y') }}</small>
                                    </div>
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
                                
                                @if($review->comment)
                                    <p class="mt-2 text-gray-800">{{ $review->comment }}</p>
                                @endif
                            </div>
                        @endforeach
                    @else
                        <p class="text-muted">No reviews yet. Be the first to leave a review!</p>
                    @endif
                </div>
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
                            <div class="paper-card mb-3">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <h6 class="font-weight-bold mb-1">{{ $paper->name }}</h6>
                                        <div class="paper-details">
                                            <span class="badge badge-info">{{ $paper->type }}</span>
                                            @if($paper->thickness)
                                                <span class="text-muted ml-2">{{ $paper->thickness }} GSM</span>
                                            @endif
                                        </div>
                                        @if($paper->size)
                                            <small class="text-muted d-block">{{ $paper->size }}</small>
                                        @endif
                                    </div>
                                    @if($paper->price)
                                        <span class="font-weight-bold text-primary">${{ number_format($paper->price, 2) }}</span>
                                    @endif
                                </div>
                                <a href="{{ route('admin.papers.show', $paper) }}" class="btn btn-sm btn-outline-primary mt-2">
                                    <i class="fas fa-info-circle"></i> View Details
                                </a>
                            </div>
                        @endforeach
                    @else
                        <p class="text-center text-muted">No recommended papers found.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.info-card {
    background-color: #f8f9fc;
    padding: 1.25rem;
    border-radius: 0.35rem;
    border: 1px solid #e3e6f0;
}

.info-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.description-section {
    background-color: #f8f9fc;
    padding: 1.25rem;
    border-radius: 0.35rem;
    border: 1px solid #e3e6f0;
}

.review-card {
    background-color: #f8f9fc;
    padding: 1.25rem;
    border-radius: 0.35rem;
    border: 1px solid #e3e6f0;
}

.paper-card {
    background-color: #f8f9fc;
    padding: 1.25rem;
    border-radius: 0.35rem;
    border: 1px solid #e3e6f0;
}

.rating-stars {
    display: flex;
    gap: 0.25rem;
}

.rating-stars input[type="radio"] {
    display: none;
}

.rating-stars label {
    cursor: pointer;
    color: #d1d3e2;
    transition: color 0.2s;
}

.rating-stars label:hover,
.rating-stars label:hover ~ label,
.rating-stars input[type="radio"]:checked ~ label {
    color: #f6c23e;
}

.paper-details {
    display: flex;
    align-items: center;
    margin: 0.5rem 0;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Rating stars hover effect
    const stars = document.querySelectorAll('.rating-stars input[type="radio"]');
    stars.forEach(star => {
        star.addEventListener('change', function() {
            const rating = this.value;
            const labels = document.querySelectorAll('.rating-stars label');
            labels.forEach((label, index) => {
                if (index < rating) {
                    label.style.color = '#f6c23e';
                } else {
                    label.style.color = '#d1d3e2';
                }
            });
        });
    });
});
</script>
@endsection