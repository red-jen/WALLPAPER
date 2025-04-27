@extends('layouts.app')

@section('content')
<div class="bg-neutral min-h-screen py-12">
    <div class="container mx-auto px-4">
        <!-- Header -->
        <div class="text-center mb-12">
            <h1 class="font-serif text-4xl md:text-5xl text-charcoal font-bold mb-4">Explore Our Designs</h1>
            <p class="text-charcoal/80 max-w-2xl mx-auto">Browse our collection of beautiful wallpaper designs created by our talented designers. Find the perfect pattern for your space.</p>
        </div>

        <!-- Category Filter -->
        <div class="max-w-5xl mx-auto mb-10">
            <div class="bg-white rounded-xl shadow-subtle p-4 flex flex-wrap items-center gap-2">
                <span class="font-medium text-charcoal mr-2">Filter by:</span>
                <a href="{{ route('designs.index') }}" class="px-3 py-1 rounded-full {{ !request('category') ? 'bg-gold text-white' : 'bg-neutral text-charcoal/70 hover:bg-neutral/50' }}">
                    All Designs
                </a>
                @foreach($categories as $category)
                <a href="{{ route('designs.index', ['category' => $category->id]) }}" class="px-3 py-1 rounded-full {{ request('category') == $category->id ? 'bg-gold text-white' : 'bg-neutral text-charcoal/70 hover:bg-neutral/50' }}">
                    {{ $category->name }}
                </a>
                @endforeach
            </div>
        </div>

        <!-- Designs Grid -->
        <div class="max-w-7xl mx-auto">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @forelse($designs as $design)
                <div class="bg-white rounded-xl shadow-subtle overflow-hidden transition-transform hover:shadow-md hover:-translate-y-1">
                    <div class="aspect-square overflow-hidden">
                        <img src="{{ asset('storage/' . $design->image_path) }}" alt="{{ $design->title }}" class="w-full h-full object-cover">
                    </div>
                    <div class="p-4">
                        <h3 class="font-serif text-xl text-navy mb-1">{{ $design->title }}</h3>
                        <p class="text-sm text-charcoal/70 mb-2">By {{ $design->designer->name ?? 'Unknown Designer' }}</p>
                        <div class="flex justify-between items-end">
                            <span class="inline-block px-2 py-1 bg-neutral/20 text-xs rounded-full text-charcoal/70">
                                {{ $design->category->name ?? 'Uncategorized' }}
                            </span>
                            <a href="{{ route('designs.show', $design) }}" class="text-navy hover:text-navy-light text-sm">
                                View Details
                            </a>
                        </div>

                        <div class="mt-4 pt-4 border-t border-neutral/30">
                            <a href="{{ route('designs.create-artwork', $design) }}" class="w-full block text-center bg-gold hover:bg-gold-light text-charcoal font-medium py-2 px-4 rounded-lg transition duration-300">
                                Use This Design
                            </a>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-span-full text-center py-12">
                    <div class="bg-white rounded-xl shadow-subtle p-8 max-w-xl mx-auto">
                        <svg class="w-16 h-16 text-neutral-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <h3 class="text-xl font-medium text-charcoal mb-2">No Designs Found</h3>
                        <p class="text-charcoal/70 mb-4">We couldn't find any designs matching your criteria. Try changing your filter or check back later.</p>
                    </div>
                </div>
                @endforelse
            </div>

            <!-- Pagination -->
            <div class="mt-12">
                {{ $designs->links() }}
            </div>
        </div>
    </div>
</div>
@endsection 