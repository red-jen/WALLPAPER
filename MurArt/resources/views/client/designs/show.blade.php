@extends('layouts.app')

@section('content')
<div class="bg-neutral min-h-screen py-12">
    <div class="container mx-auto px-4">
        <!-- Breadcrumbs -->
        <div class="mb-8">
            <div class="flex items-center text-sm text-charcoal/70">
                <a href="{{ route('home') }}" class="hover:text-navy">Home</a>
                <span class="mx-2">/</span>
                <a href="{{ route('designs.index') }}" class="hover:text-navy">Designs</a>
                <span class="mx-2">/</span>
                <span class="text-charcoal">{{ $design->title }}</span>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
            <!-- Design Image -->
            <div>
                <div class="bg-white rounded-xl shadow-subtle overflow-hidden">
                    <div class="aspect-square">
                        <img src="{{ asset('storage/' . $design->image_path) }}" alt="{{ $design->title }}" class="w-full h-full object-cover">
                    </div>
                </div>
            </div>

            <!-- Design Details -->
            <div>
                <div class="mb-8">
                    <h1 class="font-serif text-3xl md:text-4xl text-charcoal font-bold mb-3">{{ $design->title }}</h1>
                    
                    <div class="flex items-center mb-6">
                        <span class="inline-block px-3 py-1 bg-neutral-100 text-charcoal/70 rounded-full text-sm mr-3">
                            {{ $design->category->name ?? 'Uncategorized' }}
                        </span>
                        @if($design->featured)
                            <span class="inline-block px-3 py-1 bg-gold/10 text-gold-dark rounded-full text-sm">
                                Featured
                            </span>
                        @endif
                    </div>
                    
                    <div class="flex items-center mb-6">
                        <div class="w-12 h-12 bg-neutral-200 rounded-full flex items-center justify-center mr-3">
                            <span class="text-lg font-medium text-navy">
                                {{ substr($design->designer->name ?? 'U', 0, 1) }}
                            </span>
                        </div>
                        <div>
                            <p class="font-medium text-navy">{{ $design->designer->name ?? 'Unknown Designer' }}</p>
                            <p class="text-sm text-charcoal/70">Designer</p>
                        </div>
                    </div>
                    
                    @if($design->description)
                        <div class="mb-8">
                            <h3 class="font-medium text-navy mb-2">About this design</h3>
                            <p class="text-charcoal/80">{{ $design->description }}</p>
                        </div>
                    @endif

                    <!-- Call to Action -->
                    <div class="bg-neutral-100 rounded-xl p-6 mb-8">
                        <h3 class="font-medium text-navy mb-4">Create a custom wallpaper with this design</h3>
                        <p class="text-charcoal/80 mb-6">Select this design to create your personalized wallpaper. You'll be able to customize the dimensions, paper type, and more.</p>
                        
                        <a href="{{ route('designs.create-artwork', $design) }}" class="block w-full bg-gold hover:bg-gold-light text-charcoal font-medium py-3 px-6 rounded-lg text-center transition duration-300">
                            Use This Design
                        </a>
                    </div>
                    
                    <!-- Info Box -->
                    <div class="border border-neutral-200 rounded-xl p-6">
                        <div class="flex items-center space-x-3 mb-4 text-charcoal">
                            <svg class="w-6 h-6 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span class="font-medium">How it works</span>
                        </div>
                        <ol class="space-y-2 text-sm text-charcoal/80 list-decimal list-inside mb-0">
                            <li>Select this design to start your wallpaper project</li>
                            <li>Choose your preferred paper type</li>
                            <li>Enter your desired dimensions</li>
                            <li>Submit your request for a preview</li>
                            <li>Approve the preview and place your order</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <!-- Similar Designs -->
        @if(count($similarDesigns) > 0)
            <div class="mt-16">
                <h2 class="font-serif text-2xl text-charcoal font-bold mb-8">You might also like</h2>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    @foreach($similarDesigns as $similarDesign)
                        <div class="bg-white rounded-xl overflow-hidden shadow-subtle transition-transform hover:shadow-md hover:-translate-y-1">
                            <!-- Design Image -->
                            <div class="aspect-square overflow-hidden">
                                <img src="{{ asset('storage/' . $similarDesign->image_path) }}" alt="{{ $similarDesign->title }}" class="w-full h-full object-cover">
                            </div>
                            
                            <!-- Design Info -->
                            <div class="p-4">
                                <h3 class="font-serif text-lg text-navy font-medium mb-1">{{ $similarDesign->title }}</h3>
                                <p class="text-sm text-charcoal/70 mb-2">By {{ $similarDesign->designer->name ?? 'Unknown Designer' }}</p>
                            </div>
                            
                            <!-- Actions -->
                            <div class="p-4 pt-0 flex gap-2">
                                <a href="{{ route('designs.show', $similarDesign) }}" class="flex-1 text-center px-3 py-2 border border-navy text-navy rounded-lg text-sm hover:bg-navy hover:text-white transition">
                                    View Details
                                </a>
                                <a href="{{ route('designs.create-artwork', $similarDesign) }}" class="flex-1 text-center px-3 py-2 bg-gold text-charcoal rounded-lg text-sm hover:bg-gold-light transition">
                                    Use This Design
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>
@endsection 