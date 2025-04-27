@extends('layouts.app')

@section('content')
<div class="relative">
    <!-- Hero section with background image -->
    <div class="relative h-screen">
        <div class="absolute inset-0 bg-gradient-to-r from-navy-dark/80 to-navy/50 z-10"></div>
        <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('/images/hero-bg.jpg')"></div>
        
        <div class="relative z-20 container mx-auto px-6 flex flex-col items-center justify-center h-full text-center">
            <h1 class="font-serif text-5xl md:text-7xl text-ivory animate-fade-in font-bold leading-tight">
                Elegant<span class="text-gold"> Wallpaper</span> Design
            </h1>
            <p class="font-sans text-lg md:text-xl text-ivory/90 mt-6 max-w-2xl animate-slide-up">
                Discover our curated collection of sophisticated wallpapers with timeless appeal and exquisite craftsmanship.
            </p>
            <div class="mt-10 animate-slide-up">
                <a href="{{ route('designs.index') }}" class="bg-gold hover:bg-gold-light text-charcoal font-medium px-8 py-3 rounded transition duration-300 mr-4">
                    Browse Collection
                </a>
                <a href="{{ route('artworks.create') }}" class="bg-navy hover:bg-navy-light text-ivory font-medium px-8 py-3 rounded transition duration-300 mr-4">
                    Make
                </a>
                <a href="{{ route('about') }}" class="border-2 border-ivory text-ivory hover:bg-ivory hover:text-navy font-medium px-8 py-3 rounded transition duration-300">
                    About Us
                </a>
            </div>
        </div>
        
        <!-- Scroll indicator -->
        <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 z-20 animate-bounce">
            <svg class="w-8 h-8 text-ivory" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
            </svg>
        </div>
    </div>
    
    <!-- Dynamic Wallpaper Showcase -->
    <div class="bg-neutral py-24">
        <div class="container mx-auto px-6">
            <h2 class="font-serif text-4xl text-charcoal text-center mb-6">Featured <span class="text-navy">Wallpapers</span></h2>
            <p class="text-charcoal/80 text-center max-w-3xl mx-auto mb-16">Our most popular and trending wallpaper designs that transform spaces into works of art.</p>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                @foreach($featuredArtworks ?? [] as $artwork)
                <div class="bg-white rounded-lg shadow-subtle overflow-hidden group">
                    <div class="relative h-80 overflow-hidden">
                        <img src="{{ asset('storage/' . ($artwork->image_path ?? 'designs/default.jpg')) }}" alt="{{ $artwork->title ?? 'Featured Wallpaper' }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                        <div class="absolute inset-0 bg-gradient-to-t from-navy/80 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end">
                            <div class="p-4 w-full">
                                <h3 class="text-ivory font-serif text-xl">{{ $artwork->title ?? 'Elegant Design' }}</h3>
                                <p class="text-ivory/90 text-sm mt-1">{{ $artwork->description ?? 'Premium quality wallpaper with elegant design patterns.' }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="p-4">
                        <div class="flex justify-between items-center">
                            <span class="text-navy font-medium">{{ $artwork->price ?? '€49.99' }}</span>
                            <a href="{{ $artwork->id ? route('artworks.show', $artwork->id) : '#' }}" class="text-gold hover:text-gold-light">View Details</a>
                        </div>
                    </div>
                </div>
                @endforeach
                
                <!-- Fallback items if no dynamic content -->
                @if(empty($featuredArtworks))
                <div class="bg-white rounded-lg shadow-subtle overflow-hidden group">
                    <div class="relative h-80 overflow-hidden">
                        <img src="/images/featured-1.jpg" alt="Vintage Floral" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                        <div class="absolute inset-0 bg-gradient-to-t from-navy/80 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end">
                            <div class="p-4 w-full">
                                <h3 class="text-ivory font-serif text-xl">Vintage Floral</h3>
                                <p class="text-ivory/90 text-sm mt-1">Classic floral patterns with contemporary color schemes.</p>
                            </div>
                        </div>
                    </div>
                    <div class="p-4">
                        <div class="flex justify-between items-center">
                            <span class="text-navy font-medium">€49.99</span>
                            <a href="#" class="text-gold hover:text-gold-light">View Details</a>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white rounded-lg shadow-subtle overflow-hidden group">
                    <div class="relative h-80 overflow-hidden">
                        <img src="/images/featured-2.jpg" alt="Geometric Patterns" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                        <div class="absolute inset-0 bg-gradient-to-t from-navy/80 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end">
                            <div class="p-4 w-full">
                                <h3 class="text-ivory font-serif text-xl">Geometric Patterns</h3>
                                <p class="text-ivory/90 text-sm mt-1">Modern geometric designs for contemporary spaces.</p>
                            </div>
                        </div>
                    </div>
                    <div class="p-4">
                        <div class="flex justify-between items-center">
                            <span class="text-navy font-medium">€39.99</span>
                            <a href="#" class="text-gold hover:text-gold-light">View Details</a>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white rounded-lg shadow-subtle overflow-hidden group">
                    <div class="relative h-80 overflow-hidden">
                        <img src="/images/featured-3.jpg" alt="Art Nouveau" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                        <div class="absolute inset-0 bg-gradient-to-t from-navy/80 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end">
                            <div class="p-4 w-full">
                                <h3 class="text-ivory font-serif text-xl">Art Nouveau</h3>
                                <p class="text-ivory/90 text-sm mt-1">Elegant Art Nouveau inspired wallpaper designs.</p>
                            </div>
                        </div>
                    </div>
                    <div class="p-4">
                        <div class="flex justify-between items-center">
                            <span class="text-navy font-medium">€59.99</span>
                            <a href="#" class="text-gold hover:text-gold-light">View Details</a>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white rounded-lg shadow-subtle overflow-hidden group">
                    <div class="relative h-80 overflow-hidden">
                        <img src="/images/cat-botanical.jpg" alt="Botanical Collection" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                        <div class="absolute inset-0 bg-gradient-to-t from-navy/80 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end">
                            <div class="p-4 w-full">
                                <h3 class="text-ivory font-serif text-xl">Botanical Collection</h3>
                                <p class="text-ivory/90 text-sm mt-1">Nature-inspired designs for a refreshing ambiance.</p>
                            </div>
                        </div>
                    </div>
                    <div class="p-4">
                        <div class="flex justify-between items-center">
                            <span class="text-navy font-medium">€44.99</span>
                            <a href="#" class="text-gold hover:text-gold-light">View Details</a>
                        </div>
                    </div>
                </div>
                @endif
            </div>
            
            <div class="text-center mt-12">
                <a href="{{ route('designs.index') }}" class="bg-navy hover:bg-navy-light text-ivory font-medium px-8 py-3 rounded transition duration-300 inline-flex items-center">
                    View All Designs
                    <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                    </svg>
                </a>
            </div>
        </div>
    </div>
    
    <!-- How to Create Your Wallpaper -->
    <div class="bg-ivory py-24">
        <div class="container mx-auto px-6">
            <h2 class="font-serif text-4xl text-charcoal text-center mb-6">Create Your <span class="text-navy">Custom Wallpaper</span></h2>
            <p class="text-charcoal/80 text-center max-w-3xl mx-auto mb-16">Design your own unique wallpaper in just a few simple steps. Express your style with our easy-to-use customization tools.</p>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
                <div class="text-center">
                    <div class="w-20 h-20 bg-gold rounded-full flex items-center justify-center mx-auto mb-6">
                        <span class="text-3xl font-serif font-bold text-charcoal">1</span>
                    </div>
                    <h3 class="font-serif text-2xl text-navy mb-4">Choose Your Paper</h3>
                    <p class="text-charcoal/80">Select from our premium quality paper options with different textures and finishes to match your interior design.</p>
                </div>
                
                <div class="text-center">
                    <div class="w-20 h-20 bg-gold rounded-full flex items-center justify-center mx-auto mb-6">
                        <span class="text-3xl font-serif font-bold text-charcoal">2</span>
                    </div>
                    <h3 class="font-serif text-2xl text-navy mb-4">Select or Upload Design</h3>
                    <p class="text-charcoal/80">Browse our extensive collection of designs or upload your own artwork to create a truly personalized wallpaper.</p>
                </div>
                
                <div class="text-center">
                    <div class="w-20 h-20 bg-gold rounded-full flex items-center justify-center mx-auto mb-6">
                        <span class="text-3xl font-serif font-bold text-charcoal">3</span>
                    </div>
                    <h3 class="font-serif text-2xl text-navy mb-4">Customize & Order</h3>
                    <p class="text-charcoal/80">Specify your dimensions, preview your creation, and place your order. We'll handle the production and delivery.</p>
                </div>
            </div>
            
            <div class="mt-16 text-center">
                <a href="{{ route('artworks.create') }}" class="bg-gold hover:bg-gold-light text-charcoal font-medium px-10 py-4 rounded-lg text-lg transition duration-300 inline-flex items-center">
                    Start Creating Now
                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                    </svg>
                </a>
            </div>
        </div>
    </div>
    
    <!-- Featured Categories -->
    <div class="bg-ivory py-24">
        <div class="container mx-auto px-6">
            <h2 class="font-serif text-4xl text-charcoal text-center mb-16">Our <span class="text-navy">Collection</span></h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
                <div class="bg-white rounded shadow-subtle overflow-hidden group transition duration-300 hover:shadow-elevated">
                    <div class="h-64 bg-cover bg-center" style="background-image: url('/images/cat-vintage.jpg')">
                        <div class="h-full w-full bg-navy/30 flex items-end p-6 transition-opacity duration-300 group-hover:opacity-100 opacity-90">
                            <h3 class="font-serif text-2xl text-ivory">Vintage Collection</h3>
                        </div>
                    </div>
                    <div class="p-6">
                        <p class="text-charcoal/80 mb-4">Classic designs inspired by historical patterns and motifs.</p>
                        <a href="#" class="text-navy hover:text-navy-light font-medium inline-flex items-center">
                            Explore Collection
                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                            </svg>
                        </a>
                    </div>
                </div>
                
                <div class="bg-white rounded shadow-subtle overflow-hidden group transition duration-300 hover:shadow-elevated">
                    <div class="h-64 bg-cover bg-center" style="background-image: url('/images/cat-contemporary.jpg')">
                        <div class="h-full w-full bg-navy/30 flex items-end p-6 transition-opacity duration-300 group-hover:opacity-100 opacity-90">
                            <h3 class="font-serif text-2xl text-ivory">Contemporary</h3>
                        </div>
                    </div>
                    <div class="p-6">
                        <p class="text-charcoal/80 mb-4">Modern designs with clean lines and sophisticated color palettes.</p>
                        <a href="#" class="text-navy hover:text-navy-light font-medium inline-flex items-center">
                            Explore Collection
                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                            </svg>
                        </a>
                    </div>
                </div>
                
                <div class="bg-white rounded shadow-subtle overflow-hidden group transition duration-300 hover:shadow-elevated">
                    <div class="h-64 bg-cover bg-center" style="background-image: url('/images/cat-botanical.jpg')">
                        <div class="h-full w-full bg-navy/30 flex items-end p-6 transition-opacity duration-300 group-hover:opacity-100 opacity-90">
                            <h3 class="font-serif text-2xl text-ivory">Botanical</h3>
                        </div>
                    </div>
                    <div class="p-6">
                        <p class="text-charcoal/80 mb-4">Nature-inspired patterns featuring elegant flora and fauna.</p>
                        <a href="#" class="text-navy hover:text-navy-light font-medium inline-flex items-center">
                            Explore Collection
                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Testimonials -->
    <div class="bg-neutral py-24">
        <div class="container mx-auto px-6">
            <h2 class="font-serif text-4xl text-charcoal text-center mb-16">Client <span class="text-navy">Testimonials</span></h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
                <div class="bg-white p-8 rounded shadow-subtle">
                    <div class="flex items-center mb-4">
                        <div class="flex text-gold">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                        </div>
                    </div>
                    <p class="text-charcoal/80 italic mb-6">"The wallpaper quality exceeded my expectations. The design has transformed my dining room into an elegant space that everyone compliments."</p>
                    <div class="font-medium text-navy">— Catherine Dubois, Paris</div>
                </div>
                
                <div class="bg-white p-8 rounded shadow-subtle">
                    <div class="flex items-center mb-4">
                        <div class="flex text-gold">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                        </div>
                    </div>
                    <p class="text-charcoal/80 italic mb-6">"The customer service was exceptional. They helped me select the perfect pattern for my Georgian home and the installation advice was spot on."</p>
                    <div class="font-medium text-navy">— William Harrington, London</div>
                </div>
                
                <div class="bg-white p-8 rounded shadow-subtle">
                    <div class="flex items-center mb-4">
                        <div class="flex text-gold">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                        </div>
                    </div>
                    <p class="text-charcoal/80 italic mb-6">"I've ordered multiple times for my interior design projects. The quality is consistently excellent and my clients are always impressed with the final look."</p>
                    <div class="font-medium text-navy">— Sophie Laurent, Lyon</div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Featured Design -->
    <div class="bg-ivory py-24">
        <div class="container mx-auto px-6">
            <div class="flex flex-col md:flex-row items-center">
                <div class="md:w-1/2 mb-10 md:mb-0 md:pr-12">
                    <h2 class="font-serif text-4xl text-charcoal mb-6">Featured <span class="text-navy">Design</span></h2>
                    <h3 class="font-serif text-2xl text-charcoal/80 mb-4">Château Floral Collection</h3>
                    <p class="text-charcoal/80 mb-6">
                        Inspired by the elegant gardens of French châteaux, this collection combines classic floral motifs with contemporary color palettes. Perfect for creating a sophisticated ambiance in dining rooms and formal living spaces.
                    </p>
                    <ul class="mb-8 space-y-2">
                        <li class="flex items-center text-charcoal/80">
                            <svg class="w-5 h-5 text-gold mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            Premium quality materials
                        </li>
                        <li class="flex items-center text-charcoal/80">
                            <svg class="w-5 h-5 text-gold mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            Eco-friendly production
                        </li>
                        <li class="flex items-center text-charcoal/80">
                            <svg class="w-5 h-5 text-gold mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            Easy to install and maintain
                        </li>
                    </ul>
                    <a href="#" class="bg-navy hover:bg-navy-light text-ivory font-medium px-8 py-3 rounded transition duration-300 inline-flex items-center">
                        View Collection
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                        </svg>
                    </a>
                </div>
                <div class="md:w-1/2">
                    <div class="grid grid-cols-2 gap-4">
                        <div class="overflow-hidden rounded">
                            <img src="/images/featured-1.jpg" alt="Château Floral Design" class="w-full h-64 object-cover transform hover:scale-105 transition duration-500">
                        </div>
                        <div class="overflow-hidden rounded">
                            <img src="/images/featured-2.jpg" alt="Château Floral Design" class="w-full h-64 object-cover transform hover:scale-105 transition duration-500">
                        </div>
                        <div class="overflow-hidden rounded col-span-2">
                            <img src="/images/featured-3.jpg" alt="Château Floral Design" class="w-full h-64 object-cover transform hover:scale-105 transition duration-500">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Newsletter -->
    <div class="bg-navy py-16">
        <div class="container mx-auto px-6 text-center">
            <h2 class="font-serif text-3xl text-ivory mb-4">Stay Inspired</h2>
            <p class="text-ivory/80 max-w-lg mx-auto mb-8">
                Subscribe to our newsletter for exclusive design inspirations, new collection announcements, and special offers.
            </p>
            <form class="max-w-md mx-auto flex flex-col sm:flex-row gap-2">
                <input type="email" placeholder="Your email address" class="px-4 py-3 w-full rounded focus:outline-none focus:ring-2 focus:ring-gold">
                <button type="submit" class="bg-gold hover:bg-gold-light text-charcoal font-medium px-6 py-3 rounded transition duration-300 mt-2 sm:mt-0">
                    Subscribe
                </button>
            </form>
        </div>
    </div>
</div>
@endsection