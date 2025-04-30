@extends('layouts.app')

@section('title', 'Designs - MurArt')

@section('content')
<div class="bg-neutral min-h-screen py-12">
    <div class="container mx-auto px-4">
        <!-- Breadcrumbs -->
        <div class="mb-6">
            <div class="flex items-center text-sm text-charcoal/70">
                <a href="{{ route('home') }}" class="hover:text-navy">Home</a>
                <span class="mx-2">/</span>
                <span class="text-charcoal">Designs</span>
            </div>
        </div>

        <!-- Header -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8">
            <div>
                <h1 class="text-4xl font-heading font-bold text-charcoal mb-2">Explore Our Designs</h1>
                <p class="text-charcoal/70">Browse our curated collection of premium wallpaper designs</p>
            </div>
            <div class="mt-4 md:mt-0">
                <form method="GET" action="{{ route('designs.index') }}" class="flex">
                    <select name="sort" onchange="this.form.submit()" class="px-4 py-2 border border-gray-200 rounded-l-md text-sm bg-white focus:outline-none focus:ring-2 focus:ring-gold focus:border-transparent">
                        <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest First</option>
                        <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>Most Popular</option>
                        <option value="featured" {{ request('sort') == 'featured' ? 'selected' : '' }}>Featured</option>
                    </select>
                    <button type="submit" class="px-4 py-2 bg-navy text-white rounded-r-md hover:bg-navy/90">
                        <i class="fas fa-sort"></i>
                    </button>
                </form>
            </div>
        </div>

        <!-- Main Content Area -->
        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Sidebar / Filters -->
            <div class="w-full lg:w-1/4">
                <div class="bg-white rounded-xl shadow-sm p-6 sticky top-24">
                    <h2 class="text-xl font-heading font-semibold text-charcoal mb-6">Filters</h2>
                    
                    <form method="GET" action="{{ route('designs.index') }}" class="space-y-6">
                        <!-- Preserve sort parameter if it exists -->
                        @if(request('sort'))
                            <input type="hidden" name="sort" value="{{ request('sort') }}">
                        @endif
                        
                        <!-- Categories -->
                        <div>
                            <h3 class="font-medium text-charcoal mb-3">Categories</h3>
                            <div class="space-y-2">
                                @foreach($categories as $category)
                                    <div class="flex items-center">
                                        <input 
                                            type="checkbox" 
                                            id="category-{{ $category->id }}" 
                                            name="categories[]" 
                                            value="{{ $category->id }}" 
                                            class="rounded border-gray-300 text-gold focus:ring-gold"
                                            {{ in_array($category->id, request('categories', [])) ? 'checked' : '' }}
                                        >
                                        <label for="category-{{ $category->id }}" class="ml-2 text-sm text-charcoal/80">
                                            {{ $category->name }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Filter Actions -->
                        <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                            <button type="reset" class="text-sm text-charcoal/60 hover:text-charcoal">
                                Reset Filters
                            </button>
                            <button 
                                type="submit" 
                                class="px-6 py-2 bg-gold text-navy rounded-md font-medium hover:bg-gold/90 transition-colors"
                            >
                                Apply
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            
            <!-- Designs Grid -->
            <div class="w-full lg:w-3/4">
                @if($designs->isEmpty())
                    <div class="bg-white p-8 rounded-xl text-center">
                        <div class="text-charcoal/40 mb-4">
                            <i class="fas fa-palette text-4xl"></i>
                        </div>
                        <h3 class="text-xl font-heading font-semibold text-charcoal mb-2">No Designs Found</h3>
                        <p class="text-charcoal/60 mb-4">Try adjusting your filters or check back later for new designs</p>
                        <a href="{{ route('designs.index') }}" class="inline-block px-6 py-2 bg-navy text-ivory rounded-md font-medium hover:bg-navy/90 transition-colors">
                            Clear Filters
                        </a>
                    </div>
                @else
                    <!-- Results count and search term if applicable -->
                    @if(request('search'))
                        <div class="mb-6">
                            <p class="text-charcoal/70">
                                {{ $designs->total() }} results for "<span class="font-medium text-charcoal">{{ request('search') }}</span>"
                            </p>
                        </div>
                    @endif
                    
                    <!-- Designs Grid -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-6">
                        @foreach($designs as $design)
                            <a href="{{ route('designs.show', $design) }}" class="block h-full group">
                                <div class="h-full bg-white rounded-xl shadow-sm overflow-hidden border border-gray-50 transition duration-300 ease-in-out hover:-translate-y-1 hover:shadow-lg flex flex-col">
                                    <div class="aspect-[4/5] w-full relative overflow-hidden">
                                        <img src="{{ asset('storage/' . $design->image_path) }}" 
                                            class="w-full h-full object-cover transition duration-500 ease-in-out group-hover:scale-105" 
                                            alt="{{ $design->title }}">
                                        
                                        @if($design->featured)
                                            <div class="absolute top-0 right-0 bg-gold text-navy text-xs font-bold px-3 py-1 m-2 rounded">
                                                Featured
                                            </div>
                                        @endif
                                    </div>
                                    <div class="p-5 flex-1 flex flex-col">
                                        <h3 class="font-semibold text-base leading-tight text-gray-800 mb-2 truncate">
                                            {{ $design->title }}
                                        </h3>
                                        <p class="text-sm text-gray-500 mb-3">
                                            By {{ $design->designer->name ?? 'Unknown Designer' }}
                                        </p>
                                        
                                        <div class="mt-auto flex items-center justify-between">
                                            <span class="inline-flex items-center gap-2 px-3 py-1 bg-neutral-100 text-charcoal/70 rounded-full text-xs">
                                                <i class="fas fa-tag"></i>
                                                {{ $design->category->name ?? 'Uncategorized' }}
                                            </span>
                                            <span class="inline-flex items-center gap-1 text-xs text-charcoal/60">
                                                <i class="fas fa-eye"></i>
                                                {{ $design->views ?? 0 }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="mt-10">
                        {{ $designs->withQueryString()->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Reset filters when reset button is clicked
        const resetButton = document.querySelector('button[type="reset"]');
        if (resetButton) {
            resetButton.addEventListener('click', function(e) {
                e.preventDefault();
                window.location.href = '{{ route('designs.index') }}';
            });
        }
    });
</script>
@endpush 