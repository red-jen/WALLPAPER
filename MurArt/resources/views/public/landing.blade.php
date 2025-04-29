@extends('layouts.app')

@section('content')
<!-- Hero Section -->
<section class="relative h-screen">
    <!-- Background Image with Overlay -->
    <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('/images/hero-wallpaper.jpg');">
        <div class="absolute inset-0 bg-navy/50"></div>
    </div>
    
    <!-- Hero Content -->
    <div class="relative container mx-auto px-6 h-full flex flex-col justify-center" style="background-image: url(./images/hero-pattern.svg);">
        <div class="max-w-3xl">
            <h1 class="font-serif text-5xl md:text-7xl text-ivory mb-4 leading-tight">
                <span class="block">Exquisite Wallpaper</span>
                <span class="text-gold">Timeless Elegance</span>
            </h1>
            <p class="text-ivory/90 text-lg md:text-xl font-light mb-8 max-w-xl">
                Discover our exclusive collection of heritage wallpapers inspired by French and British artisanal tradition.
            </p>
            <div class="flex flex-col sm:flex-row gap-4">
                <a href="{{ route('designs.index') }}" class="inline-block bg-gold hover:bg-gold-light text-navy uppercase tracking-wider text-sm font-medium px-8 py-3 transition duration-300">
                    Explore Collection
                </a>
                <a href="{{ route('about') }}" class="inline-block border border-ivory text-ivory hover:bg-ivory hover:text-navy uppercase tracking-wider text-sm font-medium px-8 py-3 transition duration-300">
                    Our Heritage
                </a>
            </div>
        </div>
    </div>
    
    <!-- Decorative Scroll -->
    <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 text-ivory/70 animate-bounce">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
        </svg>
    </div>
</section>

<!-- Featured Collections -->
<section class="py-24 bg-ivory">
    <div class="container mx-auto px-6">
        <div class="text-center max-w-3xl mx-auto mb-16">
            <h2 class="font-serif text-4xl text-charcoal mb-4">Our <span class="text-navy">Featured</span> Collections</h2>
            <div class="w-24 h-px bg-gold mx-auto my-6"></div>
            <p class="text-charcoal/70 font-light">
                Discover our finest wallpaper collections, each capturing centuries of design heritage with meticulous attention to detail and authentic craftsmanship.
            </p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
            <!-- Collection 1 -->
            <div class="group overflow-hidden">
                <div class="relative h-96 overflow-hidden">
                    <img src="/images/collection-french.jpg" alt="French Classical Collection" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                    <div class="absolute inset-0 bg-gradient-to-t from-navy/80 to-transparent"></div>
                    <div class="absolute bottom-0 left-0 right-0 p-6">
                        <h3 class="font-serif text-2xl text-ivory mb-2">French Classical</h3>
                        <p class="text-ivory/80 font-light mb-6">Inspired by the ornate detailing of French palaces and châteaux.</p>
                        <a href="#" class="inline-block text-gold text-sm uppercase tracking-wider group-hover:translate-x-2 transition-transform duration-300">
                            View Collection
                            <span class="ml-2">→</span>
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Collection 2 -->
            <div class="group overflow-hidden">
                <div class="relative h-96 overflow-hidden">
                    <img src="/images/collection-british.jpg" alt="British Heritage Collection" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                    <div class="absolute inset-0 bg-gradient-to-t from-navy/80 to-transparent"></div>
                    <div class="absolute bottom-0 left-0 right-0 p-6">
                        <h3 class="font-serif text-2xl text-ivory mb-2">British Heritage</h3>
                        <p class="text-ivory/80 font-light mb-6">Elegant patterns reminiscent of Victorian and Georgian eras.</p>
                        <a href="#" class="inline-block text-gold text-sm uppercase tracking-wider group-hover:translate-x-2 transition-transform duration-300">
                            View Collection
                            <span class="ml-2">→</span>
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Collection 3 -->
            <div class="group overflow-hidden">
                <div class="relative h-96 overflow-hidden">
                    <img src="/images/collection-botanical.jpg" alt="Botanical Studies Collection" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                    <div class="absolute inset-0 bg-gradient-to-t from-navy/80 to-transparent"></div>
                    <div class="absolute bottom-0 left-0 right-0 p-6">
                        <h3 class="font-serif text-2xl text-ivory mb-2">Botanical Studies</h3>
                        <p class="text-ivory/80 font-light mb-6">Detailed flora and fauna inspired by 18th-century naturalist illustrations.</p>
                        <a href="#" class="inline-block text-gold text-sm uppercase tracking-wider group-hover:translate-x-2 transition-transform duration-300">
                            View Collection
                            <span class="ml-2">→</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Craftmanship Section -->
<section class="py-24 bg-navy relative overflow-hidden">
    <!-- Decorative Element -->
    <div class="absolute top-0 left-0 w-64 h-64 opacity-5">
        <svg viewBox="0 0 100 100" fill="currentColor" class="text-gold">
            <path d="M50 0C22.4 0 0 22.4 0 50s22.4 50 50 50 50-22.4 50-50S77.6 0 50 0zm0 90C28.4 90 10 71.6 10 50S28.4 10 50 10s40 18.4 40 40-18.4 40-40 40z"/>
            <path d="M54 26H46v48h8V26z"/>
            <path d="M26 54v-8h48v8H26z"/>
        </svg>
    </div>
    
    <div class="container mx-auto px-6 relative">
        <div class="flex flex-col lg:flex-row items-center">
            <div class="lg:w-1/2 mb-12 lg:mb-0">
                <img src="/images/craftmanship.jpg" alt="Our Craftmanship" class="w-full h-auto rounded">
            </div>
            
            <div class="lg:w-1/2 lg:pl-16">
                <h2 class="font-serif text-4xl text-ivory mb-4">Artisanal <span class="text-gold">Craftsmanship</span></h2>
                <div class="w-24 h-px bg-gold my-6"></div>
                <p class="text-ivory/80 font-light mb-6">
                    Every design in our collection represents centuries of wallpaper artistry, meticulously recreated with traditional techniques and the finest materials.
                </p>
                <p class="text-ivory/80 font-light mb-8">
                    Our master craftsmen draw on both French and British heritage to create wallpapers of exceptional quality and authenticity, bringing historic patterns into contemporary spaces with unmatched elegance.
                </p>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="flex items-center">
                        <div class="text-gold mr-3">
                            <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        <span class="text-ivory/90 font-light">Hand-drawn designs</span>
                    </div>
                    <div class="flex items-center">
                        <div class="text-gold mr-3">
                            <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        <span class="text-ivory/90 font-light">Premium materials</span>
                    </div>
                    <div class="flex items-center">
                        <div class="text-gold mr-3">
                            <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        <span class="text-ivory/90 font-light">Historical accuracy</span>
                    </div>
                    <div class="flex items-center">
                        <div class="text-gold mr-3">
                            <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        <span class="text-ivory/90 font-light">Sustainable production</span>
                    </div>
                </div>
                
                <div class="mt-10">
                    <a href="{{ route('about') }}" class="inline-block border border-gold text-gold hover:bg-gold hover:text-navy uppercase tracking-wider text-sm font-medium px-8 py-3 transition duration-300">
                        Our Process
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Testimonials Section -->
<section class="py-24 bg-neutral">
    <div class="container mx-auto px-6">
        <div class="text-center max-w-3xl mx-auto mb-16">
            <h2 class="font-serif text-4xl text-charcoal mb-4">Client <span class="text-navy">Testimonials</span></h2>
            <div class="w-24 h-px bg-gold mx-auto my-6"></div>
            <p class="text-charcoal/70 font-light">
                Discover what our clients say about their experience with our wallpapers.
            </p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
            <!-- Testimonial 1 -->
            <div class="bg-white p-8 rounded">
                <div class="flex text-gold mb-6">
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
                <p class="text-charcoal/80 font-light italic mb-6">
                    "The French Classical collection transformed our dining room into a space of remarkable beauty. The detail and craftsmanship is truly exceptional."
                </p>
                <div class="flex items-center">
                    <div class="w-10 h-10 rounded-full bg-navy/10 flex items-center justify-center mr-3">
                        <span class="text-navy font-serif">M</span>
                    </div>
                    <div>
                        <h4 class="font-medium text-navy">Madame Dubois</h4>
                        <p class="text-charcoal/60 text-sm">Paris, France</p>
                    </div>
                </div>
            </div>
            
            <!-- Testimonial 2 -->
            <div class="bg-white p-8 rounded">
                <div class="flex text-gold mb-6">
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
                <p class="text-charcoal/80 font-light italic mb-6">
                    "As an interior designer, I'm consistently impressed by the quality and authenticity of these papers. My clients are always delighted with the results."
                </p>
                <div class="flex items-center">
                    <div class="w-10 h-10 rounded-full bg-navy/10 flex items-center justify-center mr-3">
                        <span class="text-navy font-serif">J</span>
                    </div>
                    <div>
                        <h4 class="font-medium text-navy">Jonathan Harrington</h4>
                        <p class="text-charcoal/60 text-sm">London, UK</p>
                    </div>
                </div>
            </div>
            
            <!-- Testimonial 3 -->
            <div class="bg-white p-8 rounded">
                <div class="flex text-gold mb-6">
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
                <p class="text-charcoal/80 font-light italic mb-6">
                    "We were restoring a historic château and needed wallpaper that honored the original 18th-century design. The Maison Royale collection perfectly captured the period's essence with exquisite quality."</p>
                <div class="flex items-center">
                    <div class="w-10 h-10 rounded-full bg-navy/10 flex items-center justify-center mr-3">
                        <span class="text-navy font-serif">C</span>
                    </div>
                    <div>
                        <h4 class="font-medium text-navy">Comtesse de Beaumont</h4>
                        <p class="text-charcoal/60 text-sm">Loire Valley, France</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Featured Wallpaper -->
<section class="py-24 bg-ivory">
    <div class="container mx-auto px-6">
        <div class="flex flex-col lg:flex-row items-center">
            <div class="lg:w-1/2 pr-0 lg:pr-12 mb-12 lg:mb-0">
                <h2 class="font-serif text-4xl text-charcoal mb-4">Featured <span class="text-navy">Design</span></h2>
                <div class="w-24 h-px bg-gold my-6"></div>
                
                <h3 class="font-serif text-2xl text-navy-dark mb-6">Château de Versailles Collection</h3>
                
                <p class="text-charcoal/80 font-light mb-6">
                    Inspired by the opulent interiors of Versailles, this collection recreates the splendor of the French royal palace with meticulous attention to detail and historical accuracy.
                </p>
                
                <p class="text-charcoal/80 font-light mb-8">
                    Each pattern has been researched in collaboration with historians to ensure authentic representation of the era's most prestigious designs, bringing the elegance of 18th-century France into contemporary interiors.
                </p>
                
                <ul class="space-y-3 mb-10">
                    <li class="flex items-center">
                        <div class="text-gold mr-3">
                            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        <span class="text-charcoal/80 font-light">Gold foil accents</span>
                    </li>
                    <li class="flex items-center">
                        <div class="text-gold mr-3">
                            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        <span class="text-charcoal/80 font-light">Premium textured paper</span>
                    </li>
                    <li class="flex items-center">
                        <div class="text-gold mr-3">
                            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        <span class="text-charcoal/80 font-light">Historical color palette</span>
                    </li>
                </ul>
                
                <a href="{{ route('designs.index') }}" class="inline-block bg-navy hover:bg-navy-light text-ivory uppercase tracking-wider text-sm font-medium px-8 py-3 transition duration-300">
                    View Collection
                </a>
            </div>
            
            <div class="lg:w-1/2">
                <div class="grid grid-cols-2 gap-4">
                    <div class="overflow-hidden rounded">
                        <img src="/images/versailles-1.jpg" alt="Versailles Collection" class="w-full h-64 object-cover hover:scale-105 transition duration-700">
                    </div>
                    <div class="overflow-hidden rounded">
                        <img src="/images/versailles-2.jpg" alt="Versailles Collection" class="w-full h-64 object-cover hover:scale-105 transition duration-700">
                    </div>
                    <div class="overflow-hidden rounded col-span-2">
                        <img src="/images/versailles-3.jpg" alt="Versailles Collection" class="w-full h-64 object-cover hover:scale-105 transition duration-700">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Process Section -->
<section class="py-24 bg-white relative">
    <div class="absolute inset-0 bg-texture opacity-30"></div>
    
    <div class="container mx-auto px-6 relative">
        <div class="text-center max-w-3xl mx-auto mb-16">
            <h2 class="font-serif text-4xl text-charcoal mb-4">Our <span class="text-navy">Process</span></h2>
            <div class="w-24 h-px bg-gold mx-auto my-6"></div>
            <p class="text-charcoal/70 font-light">
                From historical research to meticulous craftsmanship, discover how we create our exceptional wallpapers.
            </p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10">
            <!-- Step 1 -->
            <div class="text-center">
                <div class="relative inline-flex items-center justify-center w-16 h-16 bg-navy text-ivory rounded-full mb-6 mx-auto">
                    <span class="font-serif text-xl">1</span>
                </div>
                <h3 class="font-serif text-xl text-navy mb-4">Historical Research</h3>
                <p class="text-charcoal/70 font-light">
                    Our historians study original designs from museum archives and historic properties.
                </p>
            </div>
            
            <!-- Step 2 -->
            <div class="text-center">
                <div class="relative inline-flex items-center justify-center w-16 h-16 bg-navy text-ivory rounded-full mb-6 mx-auto">
                    <span class="font-serif text-xl">2</span>
                </div>
                <h3 class="font-serif text-xl text-navy mb-4">Artistic Interpretation</h3>
                <p class="text-charcoal/70 font-light">
                    Our master artists redraw each pattern by hand, preserving historical accuracy.
                </p>
            </div>
            
            <!-- Step 3 -->
            <div class="text-center">
                <div class="relative inline-flex items-center justify-center w-16 h-16 bg-navy text-ivory rounded-full mb-6 mx-auto">
                    <span class="font-serif text-xl">3</span>
                </div>
                <h3 class="font-serif text-xl text-navy mb-4">Material Selection</h3>
                <p class="text-charcoal/70 font-light">
                    We source the finest sustainable papers and traditional pigments for authenticity.
                </p>
            </div>
            
            <!-- Step 4 -->
            <div class="text-center">
                <div class="relative inline-flex items-center justify-center w-16 h-16 bg-navy text-ivory rounded-full mb-6 mx-auto">
                    <span class="font-serif text-xl">4</span>
                </div>
                <h3 class="font-serif text-xl text-navy mb-4">Artisanal Production</h3>
                <p class="text-charcoal/70 font-light">
                    Each wallpaper is carefully printed using time-honored techniques with modern precision.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Newsletter Section -->
<section class="py-20 bg-navy">
    <div class="container mx-auto px-6">
        <div class="max-w-3xl mx-auto text-center">
            <h2 class="font-serif text-3xl text-ivory mb-4">Join Our Exclusive Circle</h2>
            <div class="w-24 h-px bg-gold mx-auto my-6"></div>
            <p class="text-ivory/80 font-light mb-10">
                Subscribe to receive our catalogue, exclusive offers, and invitations to private collection previews.
            </p>
            
            <form class="max-w-md mx-auto">
                <div class="flex flex-col sm:flex-row gap-4">
                    <input type="email" placeholder="Your email address" class="px-4 py-3 w-full focus:outline-none bg-navy-dark border border-navy-light text-ivory placeholder:text-ivory/50 focus:border-gold">
                    <button type="submit" class="bg-gold hover:bg-gold-light text-navy uppercase tracking-wider text-sm font-medium px-6 py-3 transition duration-300 whitespace-nowrap">
                        Subscribe
                    </button>
                </div>
                <p class="text-ivory/60 text-xs mt-4 font-light">
                    By subscribing, you agree to our Privacy Policy. We respect your privacy and will never share your information.
                </p>
            </form>
        </div>
    </div>
</section>

<!-- Instagram Gallery -->
<section class="py-16 bg-ivory">
    <div class="container mx-auto px-6">
        <div class="text-center mb-12">
            <h2 class="font-serif text-2xl text-charcoal">Follow Our Inspiration <span class="text-navy">@MaisonRoyale</span></h2>
        </div>
        
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-3">
            <a href="#" class="block overflow-hidden group">
                <div class="aspect-square bg-neutral relative">
                    <img src="/images/insta-1.jpg" alt="Instagram" class="w-full h-full object-cover group-hover:scale-105 transition duration-700">
                    <div class="absolute inset-0 bg-navy/20 opacity-0 group-hover:opacity-100 transition duration-300 flex items-center justify-center">
                        <svg class="w-8 h-8 text-ivory" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                        </svg>
                    </div>
                </div>
            </a>
            
            <a href="#" class="block overflow-hidden group">
                <div class="aspect-square bg-neutral relative">
                    <img src="/images/insta-2.jpg" alt="Instagram" class="w-full h-full object-cover group-hover:scale-105 transition duration-700">
                    <div class="absolute inset-0 bg-navy/20 opacity-0 group-hover:opacity-100 transition duration-300 flex items-center justify-center">
                        <svg class="w-8 h-8 text-ivory" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                        </svg>
                    </div>
                </div>
            </a>
            
            <a href="#" class="block overflow-hidden group">
                <div class="aspect-square bg-neutral relative">
                    <img src="/images/insta-3.jpg" alt="Instagram" class="w-full h-full object-cover group-hover:scale-105 transition duration-700">
                    <div class="absolute inset-0 bg-navy/20 opacity-0 group-hover:opacity-100 transition duration-300 flex items-center justify-center">
                        <svg class="w-8 h-8 text-ivory" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                        </svg>
                    </div>
                </div>
            </a>
            
            <a href="#" class="block overflow-hidden group">
                <div class="aspect-square bg-neutral relative">
                    <img src="/images/insta-4.jpg" alt="Instagram" class="w-full h-full object-cover group-hover:scale-105 transition duration-700">
                    <div class="absolute inset-0 bg-navy/20 opacity-0 group-hover:opacity-100 transition duration-300 flex items-center justify-center">
                        <svg class="w-8 h-8 text-ivory" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                        </svg>
                    </div>
                </div>
            </a>
            
            <a href="#" class="block overflow-hidden group">
                <div class="aspect-square bg-neutral relative">
                    <img src="/images/insta-5.jpg" alt="Instagram" class="w-full h-full object-cover group-hover:scale-105 transition duration-700">
                    <div class="absolute inset-0 bg-navy/20 opacity-0 group-hover:opacity-100 transition duration-300 flex items-center justify-center">
                        <svg class="w-8 h-8 text-ivory" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                        </svg>
                    </div>
                </div>
            </a>
            
            <a href="#" class="block overflow-hidden group">
                <div class="aspect-square bg-neutral relative">
                    <img src="/images/insta-6.jpg" alt="Instagram" class="w-full h-full object-cover group-hover:scale-105 transition duration-700">
                    <div class="absolute inset-0 bg-navy/20 opacity-0 group-hover:opacity-100 transition duration-300 flex items-center justify-center">
                        <svg class="w-8 h-8 text-ivory" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                        </svg>
                    </div>
                </div>
            </a>
        </div>
    </div>
</section>
@endsection