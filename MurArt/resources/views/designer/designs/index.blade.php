@extends('layouts.admin')

@section('styles')
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@500;600;700&family=Montserrat:wght@300;400;500&family=Libre+Baskerville:ital@0;1&display=swap" rel="stylesheet">
<style>
    :root {
        --navy: #2C3E50;
        --gold: #D4AF37;
        --sage: #7D8E7B;
        --ivory: #F8F3E6;
        --charcoal: #2F353B;
        --terracotta: #C67D5C;
        --dusty-rose: #C99A9A;
    }
    
    body {
        background-color: var(--ivory);
        color: var(--charcoal);
        font-family: 'Montserrat', sans-serif;
        line-height: 1.8;
    }
    
    h1, h2, h3, h4, h5, h6 {
        font-family: 'Cormorant Garamond', serif;
        letter-spacing: 0.5px;
        color: var(--navy);
    }
    
    .text-gray-800 {
        color: var(--navy) !important;
    }
    
    .btn-primary {
        background-color: var(--navy);
        border-color: var(--navy);
        color: var(--ivory);
    }
    
    .btn-primary:hover {
        background-color: var(--charcoal);
        border-color: var(--charcoal);
    }
    
    .btn-info {
        background-color: var(--sage);
        border-color: var(--sage);
        color: var(--ivory);
    }
    
    .btn-info:hover {
        background-color: #6A7B68;
        border-color: #6A7B68;
    }
    
    .card {
        border: none;
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        transition: all 0.3s ease;
        background-color: white;
    }
    
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }
    
    .card-title {
        font-family: 'Cormorant Garamond', serif;
        font-weight: 600;
        color: var(--navy);
        font-size: 1.5rem;
    }
    
    .badge-secondary {
        background-color: var(--sage);
        color: white;
    }
    
    .alert-success {
        background-color: rgba(125, 142, 123, 0.2);
        color: var(--sage);
        border-color: var(--sage);
    }
    
    .pagination .page-item.active .page-link {
        background-color: var(--gold);
        border-color: var(--gold);
    }
    
    .pagination .page-link {
        color: var(--navy);
    }
    
    .luxury-header {
        border-bottom: 2px solid var(--gold);
        padding-bottom: 10px;
        margin-bottom: 30px;
        display: inline-block;
    }
    
    .card-footer {
        border-top: 1px solid rgba(0,0,0,0.05);
        background-color: white;
    }
    
    .design-meta {
        color: var(--charcoal);
        font-size: 0.9rem;
    }
    
    .design-meta i {
        color: var(--gold);
        margin-right: 5px;
    }
    
    .design-card-img {
        height: 250px;
        object-fit: cover;
        border-top-left-radius: calc(0.25rem - 1px);
        border-top-right-radius: calc(0.25rem - 1px);
    }
    
    .no-designs {
        padding: 60px 20px;
        text-align: center;
        background: linear-gradient(to right, rgba(44, 62, 80, 0.05), rgba(212, 175, 55, 0.05));
        border-radius: 8px;
    }
    
    .create-btn {
        background-color: var(--gold);
        border-color: var(--gold);
        color: var(--navy);
        font-weight: 500;
    }
    
    .create-btn:hover {
        background-color: #C29E30;
        border-color: #C29E30;
        color: var(--navy);
    }
    
    .quote {
        font-family: 'Libre Baskerville', serif;
        font-style: italic;
        color: var(--terracotta);
    }
</style>
@endsection

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-5">
        <div class="col-12">
            <h1 class="h2 luxury-header">My Design Collection</h1>
            <p class="quote">Transform spaces with your creative vision</p>
        </div>
    </div>
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <p class="text-muted">Showcasing your artistic wall coverings</p>
        </div>
        <a href="{{ route('designs.create') }}" class="btn create-btn">
            <i class="fas fa-plus fa-sm mr-2"></i> Create New Design
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
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
                    <div class="card h-100">
                        <img src="{{ asset('storage/' . $design->image_path) }}" class="design-card-img" alt="{{ $design->title }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ $design->title }}</h5>
                            <p class="card-text mb-3">
                                <span class="badge badge-secondary">{{ $design->category->name ?? 'No Category' }}</span>
                            </p>
                            <div class="design-meta">
                                <p class="mb-1"><i class="far fa-calendar-alt"></i> Created {{ $design->created_at->format('M d, Y') }}</p>
                            </div>
                        </div>
                        <div class="card-footer bg-transparent">
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('designs.show', $design) }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-eye mr-1"></i> View
                                </a>
                                <a href="{{ route('designs.edit', $design) }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-edit mr-1"></i> Edit
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <div class="col-12">
                <div class="no-designs mb-4">
                    <h5 class="mb-4" style="color: var(--navy);">Your design collection is empty</h5>
                    <p class="mb-4">Create stunning wall coverings to transform any space into a work of art.</p>
                    <a href="{{ route('designs.create') }}" class="btn create-btn btn-lg">
                        <i class="fas fa-plus fa-sm mr-2"></i> Create Your First Design
                    </a>
                </div>
            </div>
        @endif
    </div>

    <!-- Pagination -->
    <div class="row">
        <div class="col-12 d-flex justify-content-center">
            {{ $designs->links() }}
        </div>
    </div>
</div>
@endsection