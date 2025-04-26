@extends('layouts.public')

@section('title', 'About Us')

@push('styles')
<link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
<style>
    .bg-navy { background-color: #0F3057; }
    .bg-sage { background-color: #8DAA9D; }
    .bg-gold { background-color: #D4B483; }
</style>
@endpush

@section('content')
    <!-- Hero Section -->
    <section class="bg-navy py-16 text-white">
        <div class="container mx-auto px-4">
            <div class="flex flex-col items-center text-center">
                <h1 class="text-5xl font-bold mb-6 font-heading">About MurArt</h1>
                <p class="text-xl mb-10 max-w-3xl">Learn more about our passion for quality wallpapers and interior design</p>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section class="py-16">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto">
                <div class="mb-12">
                    <h2 class="text-3xl font-bold font-heading mb-6 text-center">Our Story</h2>
                    <p class="text-lg mb-6">MurArt was founded in 2020 with a simple mission: to transform living spaces with exceptional wallpapers and design elements that inspire and delight.</p>
                    <p class="text-lg mb-6">What began as a small studio with a handful of designs has grown into a curated marketplace of premium wallpapers and custom designs created by talented artists from around the world.</p>
                    <p class="text-lg">We believe that walls should never be boring. Every space deserves character, personality, and artistic expression that reflects the people who live or work within it.</p>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-12">
                    <div>
                        <h3 class="text-2xl font-bold font-heading mb-4 text-navy">Our Values</h3>
                        <ul class="space-y-3">
                            <li class="flex">
                                <svg class="h-6 w-6 text-gold flex-shrink-0 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="text-lg">Quality craftsmanship in every product</span>
                            </li>
                            <li class="flex">
                                <svg class="h-6 w-6 text-gold flex-shrink-0 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="text-lg">Sustainable materials and practices</span>
                            </li>
                            <li class="flex">
                                <svg class="h-6 w-6 text-gold flex-shrink-0 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="text-lg">Supporting independent artists</span>
                            </li>
                            <li class="flex">
                                <svg class="h-6 w-6 text-gold flex-shrink-0 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="text-lg">Exceptional customer service</span>
                            </li>
                        </ul>
                    </div>
                    <div>
                        <h3 class="text-2xl font-bold font-heading mb-4 text-navy">Our Process</h3>
                        <ol class="space-y-3">
                            <li class="flex">
                                <span class="bg-gold text-navy rounded-full h-6 w-6 flex items-center justify-center font-bold flex-shrink-0 mr-3">1</span>
                                <span class="text-lg">We carefully select designs from talented artists</span>
                            </li>
                            <li class="flex">
                                <span class="bg-gold text-navy rounded-full h-6 w-6 flex items-center justify-center font-bold flex-shrink-0 mr-3">2</span>
                                <span class="text-lg">Materials are sourced with quality and sustainability in mind</span>
                            </li>
                            <li class="flex">
                                <span class="bg-gold text-navy rounded-full h-6 w-6 flex items-center justify-center font-bold flex-shrink-0 mr-3">3</span>
                                <span class="text-lg">Each item is printed with state-of-the-art technology</span>
                            </li>
                            <li class="flex">
                                <span class="bg-gold text-navy rounded-full h-6 w-6 flex items-center justify-center font-bold flex-shrink-0 mr-3">4</span>
                                <span class="text-lg">Products undergo rigorous quality control</span>
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Team Section -->
    <section class="py-16 bg-sage bg-opacity-10">
        <div class="container mx-auto px-4">
            <div class="mb-12 text-center">
                <h2 class="text-3xl font-bold font-heading mb-2">Our Team</h2>
                <p class="text-gray-600">Meet the passionate people behind MurArt</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 max-w-5xl mx-auto">
                <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                    <div class="p-6 text-center">
                        <div class="w-32 h-32 rounded-full bg-gray-200 mx-auto mb-4 overflow-hidden">
                            <!-- Replace with actual image -->
                            <div class="w-full h-full bg-navy text-white flex items-center justify-center text-2xl font-bold">JD</div>
                        </div>
                        <h3 class="text-xl font-bold mb-2">Jane Doe</h3>
                        <p class="text-navy font-semibold mb-2">Founder & Creative Director</p>
                        <p class="text-gray-600 mb-4">Jane brings over 15 years of experience in interior design and a passion for transforming spaces.</p>
                    </div>
                </div>
                
                <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                    <div class="p-6 text-center">
                        <div class="w-32 h-32 rounded-full bg-gray-200 mx-auto mb-4 overflow-hidden">
                            <!-- Replace with actual image -->
                            <div class="w-full h-full bg-sage text-white flex items-center justify-center text-2xl font-bold">JS</div>
                        </div>
                        <h3 class="text-xl font-bold mb-2">John Smith</h3>
                        <p class="text-navy font-semibold mb-2">Head of Design</p>
                        <p class="text-gray-600 mb-4">John curates our collection and works directly with our talented designers to create exclusive patterns.</p>
                    </div>
                </div>
                
                <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                    <div class="p-6 text-center">
                        <div class="w-32 h-32 rounded-full bg-gray-200 mx-auto mb-4 overflow-hidden">
                            <!-- Replace with actual image -->
                            <div class="w-full h-full bg-gold text-navy flex items-center justify-center text-2xl font-bold">EJ</div>
                        </div>
                        <h3 class="text-xl font-bold mb-2">Emily Johnson</h3>
                        <p class="text-navy font-semibold mb-2">Customer Experience</p>
                        <p class="text-gray-600 mb-4">Emily ensures every customer has an exceptional experience from browsing to installation.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-16 bg-navy text-white">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-3xl font-bold font-heading mb-6">Ready to transform your space?</h2>
            <p class="text-xl mb-8 max-w-3xl mx-auto">Explore our collection of premium wallpapers and designs, or contact us for custom solutions.</p>
            <div class="flex flex-col sm:flex-row justify-center gap-4">
                <a href="{{ route('home') }}" class="bg-gold hover:bg-opacity-90 text-navy font-bold py-3 px-8 rounded-full transition duration-300">Browse Collection</a>
                {{-- <a href="{{ route('contact') }}" class="bg-transparent border-2 border-white hover:bg-white hover:text-navy text-white font-bold py-3 px-8 rounded-full transition duration-300">Contact Us</a> --}}
            </div>
        </div>
    </section>
@endsection 