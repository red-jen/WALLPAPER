@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>My Designs</span>
                    <a href="{{ route('designer.designs.create') }}" class="btn btn-primary btn-sm">Add New Design</a>
                </div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (count($designs) > 0)
                        <div class="row">
                            @foreach ($designs as $design)
                                <div class="col-md-4 mb-4">
                                    <div class="card h-100">
                                        <img src="{{ asset('storage/' . $design->image_path) }}" class="card-img-top" alt="{{ $design->title }}">
                                        <div class="card-body">
                                            <h5 class="card-title">{{ $design->title }}</h5>
                                            <p class="card-text text-muted">
                                                Status: <span class="badge {{ $design->status === 'published' ? 'bg-success' : 'bg-secondary' }}">{{ ucfirst($design->status) }}</span>
                                            </p>
                                            <p class="card-text">{{ Str::limit($design->description, 100) }}</p>
                                        </div>
                                        <div class="card-footer bg-transparent">
                                            <div class="btn-group w-100">
                                                <a href="{{ route('designer.designs.show', $design) }}" class="btn btn-sm btn-outline-primary">View</a>
                                                <a href="{{ route('designer.designs.edit', $design) }}" class="btn btn-sm btn-outline-secondary">Edit</a>
                                                <form action="{{ route('designer.designs.destroy', $design) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete this design?')">Delete</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="alert alert-info">
                            You haven't posted any designs yet. <a href="{{ route('designer.designs.create') }}">Create your first design</a>!
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection