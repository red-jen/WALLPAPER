@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <span>Design Details</span>
                        <div>
                            <a href="{{ route('designer.designs.edit', $design) }}" class="btn btn-sm btn-primary me-2">Edit</a>
                            <a href="{{ route('designer.designs.index') }}" class="btn btn-sm btn-secondary">Back to Designs</a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <img src="{{ asset('storage/' . $design->image_path) }}" alt="{{ $design->title }}" class="img-fluid rounded">
                        </div>
                        <div class="col-md-6">
                            <h2>{{ $design->title }}</h2>
                            <p class="text-muted">
                                <span class="badge {{ $design->status === 'published' ? 'bg-success' : ($design->status === 'archived' ? 'bg-danger' : 'bg-secondary') }}">
                                    {{ ucfirst($design->status) }}
                                </span>
                            </p>
                            <p class="text-muted">Posted: {{ $design->created_at->format('F j, Y, g:i a') }}</p>
                            @if($design->updated_at != $design->created_at)
                                <p class="text-muted">Last updated: {{ $design->updated_at->format('F j, Y, g:i a') }}</p>
                            @endif
                            
                            <h5 class="mt-4">Description</h5>
                            <p>{{ $design->description ?: 'No description provided.' }}</p>
                            
                            <div class="mt-4">
                                <form action="{{ route('designer.designs.destroy', $design) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this design?')">Delete Design</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection