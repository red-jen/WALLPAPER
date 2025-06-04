@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ $paper->name }}</h1>
        <div>
            <a href="{{ route('admin.papers.edit', $paper) }}" class="btn btn-sm btn-warning shadow-sm">
                <i class="fas fa-edit fa-sm text-white-50"></i> Edit
            </a>
            <a href="{{ route('admin.papers.index') }}" class="btn btn-sm btn-secondary shadow-sm ml-2">
                <i class="fas fa-arrow-left fa-sm text-white-50"></i> Back to Papers
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-4 col-md-5 mb-4">
            <div class="card shadow h-100">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Paper Image</h6>
                </div>
                <div class="card-body text-center">
                    @if($paper->image_path)
                        <img src="{{ asset('storage/' . $paper->image_path) }}" 
                             alt="{{ $paper->name }}" 
                             class="img-fluid rounded">
                    @else
                        <div class="text-center p-5 bg-light rounded">
                            <i class="fas fa-file-image fa-5x text-gray-300"></i>
                            <p class="mt-3 text-muted">No image available</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        
        <div class="col-xl-8 col-md-7 mb-4">
            <div class="card shadow h-100">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Paper Details</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Paper Type:</strong> {{ $paper->type }}</p>
                            <p><strong>Thickness:</strong> {{ $paper->thickness ? $paper->thickness . ' GSM' : 'N/A' }}</p>
                            <p><strong>Size:</strong> {{ $paper->size ?? 'N/A' }}</p>
                            <p><strong>Color:</strong> {{ $paper->color ?? 'N/A' }}</p>
                            <p><strong>Finish:</strong> {{ $paper->finish ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Price:</strong> {{ $paper->price ? $paper->formatted_price : 'N/A' }}</p>
                            <p><strong>Status:</strong> 
                                <span class="badge badge-{{ $paper->is_active ? 'success' : 'danger' }}">
                                    {{ $paper->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </p>
                            <p><strong>Created:</strong> {{ $paper->created_at->format('M d, Y') }}</p>
                            <p><strong>Last Updated:</strong> {{ $paper->updated_at->format('M d, Y') }}</p>
                        </div>
                    </div>
                    
                    @if($paper->description)
                        <div class="mt-4">
                            <h6 class="font-weight-bold">Description</h6>
                            <p>{{ $paper->description }}</p>
                        </div>
                    @endif
                    
                    @if($paper->usage)
                        <div class="mt-4">
                            <h6 class="font-weight-bold">Recommended Usage</h6>
                            <p>{{ $paper->usage }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection