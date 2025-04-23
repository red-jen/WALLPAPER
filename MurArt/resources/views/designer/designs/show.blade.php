@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ $design->title }}</h1>
        <div>
            <a href="{{ route('designs.edit', $design) }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                <i class="fas fa-edit fa-sm text-white-50"></i> Edit Design
            </a>
            <a href="{{ route('designs.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm ml-2">
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
                            <form action="{{ route('designs.destroy', $design) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this design? This action cannot be undone.');">
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
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Reviews</h6>
                </div>
                <div class="card-body">
                    @if($design->reviews->count() > 0)
                        @foreach($design->reviews as $review)
                            <div class="card mb-3">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <div>
                                            <h6 class="font-weight-bold mb-0">{{ $review->user->name }}</h6>
                                            <small class="text-muted">{{ $review->created_at->format('M d, Y') }}</small>
                                        </div>
                                        <div>
                                            <span class="badge badge-primary">Rating: {{ $review->rating }}/5</span>
                                        </div>
                                    </div>
                                    <p class="mb-0">{{ $review->comment }}</p>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <p class="text-center mb-0">No reviews yet.</p>
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