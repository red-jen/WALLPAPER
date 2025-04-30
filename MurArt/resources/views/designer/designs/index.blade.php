@extends('layouts.admin')

@section('title', 'My Design Collection')

@section('content')
<!-- Breadcrumbs -->
<div class="mb-6">
    <div class="flex items-center text-sm text-charcoal/70">
        <a href="{{ route('admin.dashboard') }}" class="hover:text-navy">Dashboard</a>
        <span class="mx-2">/</span>
        <span class="text-charcoal">My Designs</span>
    </div>
</div>

<!-- Header -->
<div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8">
    <div>
        <h1 class="text-3xl font-heading font-bold text-navy mb-2 border-b-2 border-gold pb-2 inline-block">My Design Collection</h1>
        <p class="italic text-terracotta font-serif">Transform spaces with your creative vision</p>
    </div>
    <a href="{{ route('designer.designs.create') }}" 
        class="mt-4 md:mt-0 px-4 py-2 bg-gold text-navy rounded-md font-medium hover:bg-gold/90 transition-colors flex items-center gap-2">
        <i class="fas fa-plus fa-sm"></i>
        Create New Design
    </a>
</div>

<!-- Alerts -->
@if(session('success'))
    <div class="bg-sage/10 border border-sage text-sage px-4 py-3 rounded-md mb-6 flex justify-between items-center" role="alert">
        <div>{{ session('success') }}</div>
        <button type="button" class="text-sage hover:text-sage/80" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

@if(session('error'))
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-md mb-6 flex justify-between items-center" role="alert">
        <div>{{ session('error') }}</div>
        <button type="button" class="text-red-700 hover:text-red-800" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

<!-- Designs Grid -->
@if($designs->count() > 0)
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @foreach($designs as $design)
            <div class="bg-white rounded-xl shadow-sm overflow-hidden transition duration-300 hover:-translate-y-1 hover:shadow-md flex flex-col h-full">
                <div class="aspect-[4/3] w-full relative overflow-hidden">
                    <img src="{{ asset('storage/' . $design->image_path) }}" 
                        class="w-full h-full object-cover transition duration-500 ease-in-out hover:scale-105"
                        alt="{{ $design->title }}">
                    
                    <!-- Status Badge -->
                    <div class="absolute top-3 right-3 px-2.5 py-1 rounded-full text-xs font-medium 
                        {{ $design->is_approved ? 'bg-green-100 text-green-800' : 'bg-amber-100 text-amber-800' }}">
                        {{ $design->is_approved ? 'Approved' : 'Pending' }}
                    </div>
                </div>
                <div class="p-4 flex-1 flex flex-col">
                    <h3 class="font-heading font-semibold text-lg text-navy mb-2 truncate">{{ $design->title }}</h3>
                    <div class="flex flex-wrap gap-2 mb-3">
                        <span class="inline-flex items-center px-2.5 py-0.5 bg-sage/10 text-sage rounded-full text-xs font-medium">
                            {{ $design->category->name ?? 'No Category' }}
                        </span>
                        @if($design->style)
                            <span class="inline-flex items-center px-2.5 py-0.5 bg-gold/10 text-gold rounded-full text-xs font-medium">
                                {{ $design->style }}
                            </span>
                        @endif
                    </div>
                    <div class="text-gray-600 text-sm">
                        <p class="flex items-center gap-2 mb-1">
                            <i class="far fa-calendar-alt text-gold"></i>
                            <span>{{ $design->created_at->format('M d, Y') }}</span>
                        </p>
                        @if(isset($design->reviews_count) && $design->reviews_count)
                            <p class="flex items-center gap-2 mb-1">
                                <i class="far fa-star text-gold"></i>
                                <span>{{ $design->reviews_count }} {{ Str::plural('review', $design->reviews_count) }}</span>
                            </p>
                        @endif
                    </div>
                    <div class="flex justify-between gap-2 mt-auto pt-4">
                        <a href="{{ route('designer.designs.show', $design) }}" 
                            class="flex-1 px-3 py-2 bg-navy text-white rounded-md text-sm font-medium hover:bg-navy/90 transition-colors text-center">
                            <i class="fas fa-eye mr-1"></i> View
                        </a>
                        <a href="{{ route('designer.designs.edit', $design) }}" 
                            class="flex-1 px-3 py-2 bg-sage text-white rounded-md text-sm font-medium hover:bg-sage/90 transition-colors text-center">
                            <i class="fas fa-edit mr-1"></i> Edit
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    
    <!-- Pagination -->
    <div class="mt-8 flex justify-center">
        {{ $designs->links() }}
    </div>
@else
    <div class="text-center py-16 px-4 bg-white rounded-xl shadow-sm">
        <div class="text-charcoal/40 mb-4">
            <i class="fas fa-paint-brush text-4xl"></i>
        </div>
        <h2 class="text-2xl font-heading font-bold text-navy mb-4">Your design collection is empty</h2>
        <p class="text-gray-600 mb-6 max-w-md mx-auto">Create stunning wall coverings to transform any space into a work of art.</p>
        <a href="{{ route('designer.designs.create') }}" 
            class="inline-block px-6 py-3 bg-gold text-navy rounded-md font-medium hover:bg-gold/90 transition-colors">
            <i class="fas fa-plus fa-sm mr-2"></i>
            Create Your First Design
        </a>
    </div>
@endif
@endsection