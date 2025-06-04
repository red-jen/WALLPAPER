@extends('layouts.app')

@section('title', 'Shop - MurArt Wallpapers')

@section('content')
<div class="bg-neutral min-h-screen py-12">
    <div class="container mx-auto px-4">
        <!-- Breadcrumbs -->
        <div class="mb-6">
            <div class="flex items-center text-sm text-charcoal/70">
                <a href="{{ route('home') }}" class="hover:text-navy">Home</a>
                <span class="mx-2">/</span>
                <span class="text-charcoal">Shop</span>
            </div>
        </div>

        <!-- Shop Header -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8">
            <div>
                <h1 class="text-4xl font-heading font-bold text-charcoal mb-2">Our Wallpapers</h1>
                <p class="text-charcoal/70">Discover our premium wallpaper collection</p>
            </div>
            <div class="mt-4 md:mt-0">
                <form method="GET" action="{{ route('shop.index') }}" class="flex">
                    <select name="sort" onchange="this.form.submit()" class="px-4 py-2 border border-gray-200 rounded-l-md text-sm bg-white focus:outline-none focus:ring-2 focus:ring-gold focus:border-transparent">
                        <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest First</option>
                        <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                        <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                        <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>Most Popular</option>
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
                    
                    <form method="GET" action="{{ route('shop.index') }}" class="space-y-6">
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
                        
                        <!-- Price Range -->
                        <div>
                            <h3 class="font-medium text-charcoal mb-3">Price Range</h3>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label for="min_price" class="block text-xs text-charcoal/60 mb-1">Min</label>
                                    <input 
                                        type="number" 
                                        id="min_price" 
                                        name="min_price" 
                                        value="{{ request('min_price', '') }}" 
                                        class="w-full px-3 py-2 border border-gray-200 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-gold focus:border-transparent"
                                        placeholder="$"
                                        min="0"
                                    >
                                </div>
                                <div>
                                    <label for="max_price" class="block text-xs text-charcoal/60 mb-1">Max</label>
                                    <input 
                                        type="number" 
                                        id="max_price" 
                                        name="max_price" 
                                        value="{{ request('max_price', '') }}" 
                                        class="w-full px-3 py-2 border border-gray-200 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-gold focus:border-transparent"
                                        placeholder="$"
                                        min="0"
                                    >
                                </div>
                            </div>
                        </div>
                        
                        <!-- Styles -->
                        {{-- <div>
                            <h3 class="font-medium text-charcoal mb-3">Styles</h3>
                            <div class="space-y-2 max-h-[180px] overflow-y-auto pr-2">
                                @foreach($styles as $style)
                                    <div class="flex items-center">
                                        <input 
                                            type="checkbox" 
                                            id="style-{{ $loop->index }}" 
                                            name="styles[]" 
                                            value="{{ $style }}" 
                                            class="rounded border-gray-300 text-gold focus:ring-gold"
                                            {{ in_array($style, request('styles', [])) ? 'checked' : '' }}
                                        >
                                        <label for="style-{{ $loop->index }}" class="ml-2 text-sm text-charcoal/80">
                                            {{ $style }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div> --}}
                        
                        <!-- Materials -->
                        {{-- <div>
                            <h3 class="font-medium text-charcoal mb-3">Materials</h3>
                            <div class="space-y-2 max-h-[180px] overflow-y-auto pr-2">
                                @foreach($materials as $material)
                                    <div class="flex items-center">
                                        <input 
                                            type="checkbox" 
                                            id="material-{{ $loop->index }}" 
                                            name="materials[]" 
                                            value="{{ $material }}" 
                                            class="rounded border-gray-300 text-gold focus:ring-gold"
                                            {{ in_array($material, request('materials', [])) ? 'checked' : '' }}
                                        >
                                        <label for="material-{{ $loop->index }}" class="ml-2 text-sm text-charcoal/80">
                                            {{ $material }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        
                        <!-- Availability -->
                        <div>
                            <h3 class="font-medium text-charcoal mb-3">Availability</h3>
                            <div class="flex items-center">
                                <input 
                                    type="checkbox" 
                                    id="in_stock" 
                                    name="in_stock" 
                                    value="1" 
                                    class="rounded border-gray-300 text-gold focus:ring-gold"
                                    {{ request('in_stock') ? 'checked' : '' }}
                                >
                                <label for="in_stock" class="ml-2 text-sm text-charcoal/80">
                                    In Stock Only
                                </label>
                            </div>
                        </div>
                         --}}
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
            
            <!-- Product Grid -->
            <div class="w-full lg:w-3/4">
                @if($wallpapers->isEmpty())
                    <div class="bg-white p-8 rounded-xl text-center">
                        <div class="text-charcoal/40 mb-4">
                            <i class="fas fa-search text-4xl"></i>
                        </div>
                        <h3 class="text-xl font-heading font-semibold text-charcoal mb-2">No Wallpapers Found</h3>
                        <p class="text-charcoal/60 mb-4">Try adjusting your filters or search criteria</p>
                        <a href="{{ route('shop.index') }}" class="inline-block px-6 py-2 bg-navy text-ivory rounded-md font-medium hover:bg-navy/90 transition-colors">
                            Clear Filters
                        </a>
                    </div>
                @else
                    <!-- Results count and search term if applicable -->
                    @if(request('search'))
                        <div class="mb-6">
                            <p class="text-charcoal/70">
                                {{ $wallpapers->total() }} results for "<span class="font-medium text-charcoal">{{ request('search') }}</span>"
                            </p>
                        </div>
                    @endif
                    
                    <!-- Products Grid -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-6">
                        @foreach($wallpapers as $wallpaper)
                            <a href="{{ route('shop.show', $wallpaper) }}" class="block h-full">
                                <div class="h-full bg-white rounded-xl shadow-sm overflow-hidden border border-gray-50 transition duration-300 ease-in-out hover:-translate-y-1 hover:shadow-lg flex flex-col">
                                    <div class="aspect-[4/5] w-full relative overflow-hidden">
                                        <img src="{{ $wallpaper->getImageUrlAttribute() }}" 
                                            class="w-full h-full object-cover transition duration-500 ease-in-out group-hover:scale-105" 
                                            alt="{{ $wallpaper->title }}">
                                        
                                        @if($wallpaper->stock <= 0)
                                            <div class="absolute top-0 right-0 bg-red-500 text-white text-xs font-bold px-3 py-1 m-2 rounded">
                                                Out of Stock
                                            </div>
                                        @endif
                                    </div>
                                    <div class="p-5 flex-1 flex flex-col">
                                        <h3 class="font-semibold text-base leading-tight text-gray-800 mb-2 truncate">{{ $wallpaper->title }}</h3>
                                        <p class="text-sm text-gray-500 mb-3">{{ $wallpaper->category->name ?? 'Uncategorized' }}</p>
                                        
                                        @if($wallpaper->reviews->where('is_approved', true)->count() > 0)
                                            <div class="flex text-sm mb-2">
                                                @php
                                                    $avgRating = $wallpaper->reviews->where('is_approved', true)->avg('rating');

                                                    $roundedRating = round($avgRating);
                                                    
                                                @endphp
                                                
                                                @for($i = 1; $i <= 5; $i++)
                                                    @if($i <= $roundedRating)
                                                        <i class="fas fa-star text-[#D4AF37]"></i>
                                                    @else
                                                        <i class="fas fa-star text-gray-200"></i>
                                                    @endif
                                                @endfor
                                                <span class="text-xs text-gray-500 ml-1">({{ $wallpaper->reviews->where('is_approved', true)->count() }})</span>
                                            </div>
                                        @endif
                                        
                                        <div class="mt-auto flex items-center justify-between">
                                            <p class="text-lg font-bold text-navy">${{ number_format($wallpaper->price, 2) }}</p>
                                            <span class="inline-flex items-center gap-1 text-xs text-charcoal/60">
                                                <i class="fas fa-eye"></i>
                                                {{ $wallpaper->views ?? 0 }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                    
                    <!-- Pagination -->
                    <div class="mt-10">
                        {{ $wallpapers->withQueryString()->links() }}
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
                window.location.href = '{{ route('shop.index') }}';
            });
        }
    });
</script>
@endpush