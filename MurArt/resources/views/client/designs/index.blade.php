@extends('layouts.app')

@section('content')
<div class="bg-neutral min-h-screen py-12">
    <div class="container mx-auto px-4">
        <!-- Header -->
        <div class="text-center mb-12">
            <h1 class="font-serif text-4xl md:text-5xl text-charcoal font-bold mb-4">Explore Our Designs</h1>
            <p class="text-charcoal/80 max-w-2xl mx-auto">Browse our curated collection of premium wallpaper designs created by talented artists from around the world.</p>
        </div>

        <!-- Category Filters -->
        <div class="mb-10">
            <div class="flex flex-wrap items-center justify-center gap-3">
                <a href="{{ route('designs.index') }}" class="px-4 py-2 rounded-full {{ !request('category') ? 'bg-gold text-charcoal' : 'bg-neutral-200 text-charcoal/70 hover:bg-neutral-300' }} transition">
                    All Designs
                </a>
                @foreach($categories as $category)
                    <a href="{{ route('designs.index', ['category' => $category->id]) }}" class="px-4 py-2 rounded-full {{ request('category') == $category->id ? 'bg-gold text-charcoal' : 'bg-neutral-200 text-charcoal/70 hover:bg-neutral-300' }} transition">
                        {{ $category->name }}
                    </a>
                @endforeach
            </div>
        </div>

        <!-- Designs Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @forelse($designs as $design)
                <div class="bg-white rounded-xl overflow-hidden shadow-subtle transition-transform hover:shadow-md hover:-translate-y-1">
                    <!-- Design Image -->
                    <div class="aspect-square overflow-hidden">
                        <img src="{{ asset('storage/' . $design->image_path) }}" alt="{{ $design->title }}" class="w-full h-full object-cover">
                    </div>
                    
                    <!-- Design Info -->
                    <div class="p-4">
                        <h3 class="font-serif text-lg text-navy font-medium mb-1">{{ $design->title }}</h3>
                        <p class="text-sm text-charcoal/70 mb-2">By {{ $design->designer->name ?? 'Unknown Designer' }}</p>
                        <div class="flex justify-between items-center">
                            <span class="inline-block px-3 py-1 bg-neutral-100 text-charcoal/70 rounded-full text-xs">
                                {{ $design->category->name ?? 'Uncategorized' }}
                            </span>
                            @if($design->featured)
                                <span class="inline-block px-2 py-1 bg-gold/10 text-gold-dark rounded-full text-xs">
                                    Featured
                                </span>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Actions -->
                    <div class="p-4 pt-0 flex gap-2">
                        <a href="{{ route('designs.show', $design) }}" class="flex-1 text-center px-3 py-2 border border-navy text-navy rounded-lg text-sm hover:bg-navy hover:text-white transition">
                            View Details
                        </a>
                        <a href="{{ route('designs.create-artwork', $design) }}" class="flex-1 text-center px-3 py-2 bg-gold text-charcoal rounded-lg text-sm hover:bg-gold-light transition">
                            Use This Design
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-12 text-center">
                    <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                    </svg>
                    <h3 class="text-lg font-medium text-charcoal mb-1">No designs found</h3>
                    <p class="text-charcoal/70">Please try another category or check back later for new designs.</p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="mt-12">
            {{ $designs->links() }}
        </div>
    </div>
</div>
@endsection 