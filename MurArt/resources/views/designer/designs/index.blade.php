@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">My Designs</h1>
        <a href="{{ route('designs.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-plus fa-sm text-white-50"></i> Create New Design
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="row">
        @if($designs->count() > 0)
            @foreach($designs as $design)
                <div class="col-md-4 col-lg-3 mb-4">
                    <div class="card shadow h-100">
                        <img src="{{ asset('storage/' . $design->image_path) }}" class="card-img-top" alt="{{ $design->title }}" style="height: 200px; object-fit: cover;">
                        <div class="card-body">
                            <h5 class="card-title font-weight-bold text-primary">{{ $design->title }}</h5>
                            <p class="card-text small">
                                <span class="badge badge-secondary">{{ $design->category->name ?? 'No Category' }}</span>
                            </p>
                            <p class="card-text small text-muted">
                                Created: {{ $design->created_at->format('M d, Y') }}
                            </p>
                        </div>
                        <div class="card-footer bg-transparent">
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('designs.show', $design) }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-eye"></i> View
                                </a>
                                <a href="{{ route('designs.edit', $design) }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <div class="col-12">
                <div class="card shadow mb-4">
                    <div class="card-body text-center py-5">
                        <h5 class="text-gray-500 mb-4">You haven't created any designs yet</h5>
                        <a href="{{ route('designs.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus fa-sm"></i> Create Your First Design
                        </a>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <!-- Pagination -->
    <div class="row">
        <div class="col-12">
            {{ $designs->links() }}
        </div>
    </div>
</div>
@endsection