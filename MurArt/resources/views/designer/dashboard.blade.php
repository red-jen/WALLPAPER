@extends('layouts.designer')

@section('title', 'Designer Dashboard')

@section('content')
    <!-- Hero Section with Parallax -->
    <section class="relative h-96 sm:h-128 overflow-hidden">
        <div class="absolute inset-0 bg-navy/40 z-10"></div>
        <div class="js-parallax absolute inset-0 w-full h-full" data-parallax-speed="-0.2">
            <img src="{{ asset('images/designer/luxury-wallpaper-hero.jpg') }}" alt="Luxury Wallpaper" class="w-full h-full object-cover">
        </div>
        <div class="absolute inset-0 flex items-center justify-center z-20">
            <div class="text-center px-4">
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-heading font-semibold text-ivory mb-4 animate-fade-in">Designer Studio</h1>
                <p class="text-xl text-ivory/90 max-w-2xl mx-auto animate-slide-up">Craft exquisite wall coverings that transform spaces into works of art.</p>
                <div class="mt-8 flex flex-wrap justify-center gap-4">
                    <a href="{{ route('designs.create') }}" class="bg-gold hover:bg-gold/90 text-navy font-medium py-3 px-8 rounded-md transition-colors">
                        Create New Design
                    </a>
                    <a href="#featured" class="bg-transparent border border-ivory hover:bg-ivory/10 text-ivory font-medium py-3 px-8 rounded-md transition-colors">
                        View Your Designs
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Designer Stats -->
    <section class="py-12 bg-ivory">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white rounded-lg shadow-md p-6 border-t-4 border-gold transition-transform hover:transform hover:-translate-y-1">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-charcoal/60 font-medium text-sm">Total Designs</p>
                            <h3 class="text-3xl font-heading font-semibold text-navy mt-1">{{ $totalDesigns ?? 12 }}</h3>
                        </div>
                        <div class="bg-gold/10 p-3 rounded-full">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gold" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                    </div>
                    <div class="mt-4">
                        <a href="{{ route('designs.index') }}" class="text-navy hover:text-gold text-sm font-medium inline-flex items-center transition-colors">
                            View all designs
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                    </div>
                </div>
                
                <div class="bg-white rounded-lg shadow-md p-6 border-t-4 border-sage transition-transform hover:transform hover:-translate-y-1">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-charcoal/60 font-medium text-sm">Featured Designs</p>
                            <h3 class="text-3xl font-heading font-semibold text-navy mt-1">{{ $featuredDesigns ?? 4 }}</h3>
                        </div>
                        <div class="bg-sage/10 p-3 rounded-full">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-sage" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                            </svg>
                        </div>
                    </div>
                    <div class="mt-4">
                        <a href="#" class="text-navy hover:text-sage text-sm font-medium inline-flex items-center transition-colors">
                            Manage featured
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                    </div>
                </div>
                
                <div class="bg-white rounded-lg shadow-md p-6 border-t-4 border-navy transition-transform hover:transform hover:-translate-y-1">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-charcoal/60 font-medium text-sm">Client Artworks</p>
                            <h3 class="text-3xl font-heading font-semibold text-navy mt-1">{{ $clientArtworks ?? 18 }}</h3>
                        </div>
                        <div class="bg-navy/10 p-3 rounded-full">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-navy" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                    </div>
                    <div class="mt-4">
                        <a href="#" class="text-navy hover:text-navy/70 text-sm font-medium inline-flex items-center transition-colors">
                            View client gallery
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Designs -->
    <section id="featured" class="py-16 bg-ivory/50">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-heading font-semibold text-navy mb-2">Your Designs</h2>
            <p class="text-charcoal/70 mb-8 max-w-3xl">Browse your collection of exquisite wallpaper designs or create something new to inspire our clients.</p>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($designs ?? [] as $design)
                    <div class="group bg-white rounded-lg shadow-md overflow-hidden transition-transform hover:-translate-y-1">
                        <div class="relative aspect-w-4 aspect-h-3 overflow-hidden">
                            <img src="{{ asset('storage/' . $design->image_path) }}" alt="{{ $design->title }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                            <div class="absolute inset-0 bg-gradient-to-t from-charcoal/70 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity flex items-end justify-between p-4">
                                <h3 class="text-xl font-heading font-semibold text-ivory">{{ $design->title }}</h3>
                                <div class="flex space-x-2">
                                    <a href="{{ route('designs.edit', $design) }}" class="bg-ivory/20 hover:bg-ivory/40 p-2 rounded-full transition-colors">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-ivory" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="p-4">
                            <div class="flex justify-between items-center mb-2">
                                <p class="text-sm text-charcoal/60">{{ $design->category->name ?? 'Uncategorized' }}</p>
                                <span class="text-xs py-1 px-2 bg-gold/10 text-gold rounded-full">{{ $design->featured ? 'Featured' : 'Standard' }}</span>
                            </div>
                            <h3 class="text-lg font-medium text-navy mb-2">{{ $design->title }}</h3>
                            <p class="text-sm text-charcoal/70 line-clamp-2">{{ $design->description ?? 'No description available' }}</p>
                            
                            <div class="flex justify-between items-center mt-4 pt-4 border-t border-gray-100">
                                <div class="flex items-center">
                                    <span class="text-xs text-charcoal/60">Created: {{ $design->created_at->format('M d, Y') }}</span>
                                </div>
                                <a href="{{ route('designs.show', $design) }}" class="text-navy hover:text-gold text-sm font-medium inline-flex items-center transition-colors">
                                    View design
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <!-- No designs yet - Create new design card -->
                    <div class="bg-white rounded-lg shadow-md p-8 border border-dashed border-charcoal/20 flex flex-col items-center justify-center text-center">
                        <div class="bg-gold/10 p-4 rounded-full mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-gold" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-heading font-semibold text-navy mb-2">Create Your First Design</h3>
                        <p class="text-charcoal/70 mb-6">Start your creative journey by adding your first design to the collection.</p>
                        <a href="{{ route('designs.create') }}" class="bg-gold hover:bg-gold/90 text-navy font-medium py-2 px-6 rounded-md transition-colors">
                            Create Design
                        </a>
                    </div>
                    
                    <!-- Placeholder designs for visual reference -->
                    <div class="group bg-white rounded-lg shadow-md overflow-hidden transition-transform hover:-translate-y-1">
                        <div class="relative aspect-w-4 aspect-h-3 overflow-hidden bg-sage/10">
                            <div class="absolute inset-0 bg-gradient-to-t from-charcoal/30 via-transparent to-transparent flex items-end p-4">
                                <h3 class="text-xl font-heading font-semibold text-navy/50">Example Design</h3>
                            </div>
                        </div>
                        <div class="p-4">
                            <div class="flex justify-between items-center mb-2">
                                <p class="text-sm text-charcoal/40">Floral</p>
                                <span class="text-xs py-1 px-2 bg-gray-100 text-charcoal/50 rounded-full">Sample</span>
                            </div>
                            <h3 class="text-lg font-medium text-navy/50 mb-2">Botanical Garden</h3>
                            <p class="text-sm text-charcoal/40 line-clamp-2">This is an example of how your designs will appear in the dashboard.</p>
                            
                            <div class="flex justify-between items-center mt-4 pt-4 border-t border-gray-100">
                                <div class="flex items-center">
                                    <span class="text-xs text-charcoal/40">Example Only</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="group bg-white rounded-lg shadow-md overflow-hidden transition-transform hover:-translate-y-1">
                        <div class="relative aspect-w-4 aspect-h-3 overflow-hidden bg-navy/10">
                            <div class="absolute inset-0 bg-gradient-to-t from-charcoal/30 via-transparent to-transparent flex items-end p-4">
                                <h3 class="text-xl font-heading font-semibold text-navy/50">Example Design</h3>
                            </div>
                        </div>
                        <div class="p-4">
                            <div class="flex justify-between items-center mb-2">
                                <p class="text-sm text-charcoal/40">Geometric</p>
                                <span class="text-xs py-1 px-2 bg-gray-100 text-charcoal/50 rounded-full">Sample</span>
                            </div>
                            <h3 class="text-lg font-medium text-navy/50 mb-2">Modern Shapes</h3>
                            <p class="text-sm text-charcoal/40 line-clamp-2">This is an example of how your designs will appear in the dashboard.</p>
                            
                            <div class="flex justify-between items-center mt-4 pt-4 border-t border-gray-100">
                                <div class="flex items-center">
                                    <span class="text-xs text-charcoal/40">Example Only</span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforelse
            </div>
            
            @if(!empty($designs ?? []))
                <div class="mt-8 text-center">
                    <a href="{{ route('designs.create') }}" class="bg-navy hover:bg-navy/90 text-ivory font-medium py-3 px-8 rounded-md transition-colors">
                        Create New Design
                    </a>
                </div>
            @endif
        </div>
    </section>

    <!-- Room Visualizer Preview -->
    <section class="py-16 bg-charcoal text-ivory">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div>
                    <h2 class="text-3xl font-heading font-semibold mb-4">Room Visualizer</h2>
                    <p class="text-ivory/80 mb-6">Help your clients visualize your designs in real-world settings with our room visualizer tool. Create stunning presentations that showcase your designs in context.</p>
                    
                    <ul class="space-y-4 mb-8">
                        <li class="flex items-start">
                            <svg class="h-6 w-6 text-gold mr-2 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span>Upload interior room scenes</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="h-6 w-6 text-gold mr-2 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span>Apply your designs to walls with realistic perspective</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="h-6 w-6 text-gold mr-2 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span>Share visualizations with clients to help them make decisions</span>
                        </li>
                    </ul>
                    
                    <a href="#" class="inline-flex items-center bg-gold hover:bg-gold/90 text-navy font-medium py-3 px-8 rounded-md transition-colors">
                        Try Room Visualizer
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                        </svg>
                    </a>
                </div>
                
                <div class="relative">
                    <div class="rounded-lg overflow-hidden shadow-2xl">
                        <img src="{{ asset('images/designer/room-visualizer-preview.jpg') }}" alt="Room Visualizer" class="w-full h-auto">
                        <div class="absolute inset-0 bg-gradient-to-t from-charcoal/70 via-transparent to-transparent opacity-60"></div>
                    </div>
                    
                    <!-- Play button for video -->
                    <button class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-gold/90 hover:bg-gold text-navy p-4 rounded-full transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
<script>
    // Add any additional JavaScript needed for the designer dashboard
    document.addEventListener('DOMContentLoaded', function() {
        // Example: Initialize image comparison slider for the room visualizer
        // This would be expanded in a real implementation
        const roomVisualizer = {
            init: function() {
                console.log('Room visualizer initialized');
                // Add room visualizer functionality here
            }
        };
        
        // Initialize components
        roomVisualizer.init();
    });
</script>
@endpush 