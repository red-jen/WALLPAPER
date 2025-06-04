@extends('layouts.app')

@section('title', 'About Us - MurArt')

@push('styles')
<style>
    .diagonal-slice {
        position: absolute;
        width: 100%;
        height: 100%;
        clip-path: polygon(0 0, 100% 20%, 100% 100%, 0 80%);
    }
    
    .pattern-bg {
        background-image: url('{{ asset('storage/wallpapers/1745908565_cafe-wallpaper_3.jpg') }}');
        background-size: cover;
        background-position: center;
        opacity: 0.1;
    }
    
    .grid-pattern {
        background-image: url('{{ asset('storage/wallpapers/1745908565_cafe-wallpaper_1.jpg') }}');
        background-size: 400px;
        opacity: 0.05;
    }
    
    .team-card:hover .team-image {
        transform: scale(1.05);
    }
    
    .team-image {
        transition: transform 0.3s ease;
    }

    .pfp{
        background-color: rgb(156, 142, 51)
    }
    
</style>
 <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
@endpush

@section('content')
<!-- Hero Section with Background Pattern -->
<section class="relative py-24 overflow-hidden">
    <!-- Background Pattern -->
    <div class="absolute inset-0 pattern-bg"></div>
    
    <div class="container mx-auto px-4 relative z-10">
        <div class="max-w-4xl mx-auto text-center">
            <h1 class="text-5xl md:text-6xl font-heading font-bold mb-6 tracking-tight text-dark">About MurArt</h1>
            <p class="text-xl text-gray-600 mb-10">Transforming spaces with artistic wallpapers since 2020</p>
        </div>
    </div>
</section>

<!-- Our Story Section -->
<section class="relative py-20 overflow-hidden">
    <!-- Diagonal Background -->
    <div class="diagonal-slice bg-secondary bg-opacity-5"></div>
    
    <div class="container mx-auto px-4 relative z-10">
        <div class="max-w-5xl mx-auto bg-white rounded-lg shadow-xl p-8 mb-12">
            <h2 class="text-3xl font-heading font-bold mb-4 text-dark">Our Story</h2>
            <p class="text-lg text-gray-600 mb-6">MurArt was founded with a simple mission: to bring high-quality, artistic wallpapers to homes and businesses around the world. We believe that walls are more than just boundaries—they're canvases waiting to be transformed into expressions of your unique style and personality.</p>
            <p class="text-gray-600">Our team of designers and artists work tirelessly to create stunning, durable wallpapers that not only look beautiful but are also easy to install and maintain. We source the finest materials and use cutting-edge printing technology to ensure that every wallpaper meets our exacting standards.</p>
        </div>
    </div>
</section>

<!-- Mission and Values Section -->
<section class="py-20">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-5xl mx-auto">
            <div class="bg-white rounded-lg shadow-lg p-8 h-full">
                <h2 class="text-2xl font-heading font-bold mb-6 text-dark">Our Mission</h2>
                <p class="text-gray-600">To provide premium quality wallpapers that inspire creativity and transform living spaces into beautiful, personalized environments. We aim to make artistic wallpapers accessible to everyone, offering a wide range of designs at competitive prices.</p>
            </div>
            
            <div class="bg-white rounded-lg shadow-lg p-8 h-full">
                <h2 class="text-2xl font-heading font-bold mb-6 text-dark">Our Values</h2>
                <ul class="space-y-4">
                    <li class="flex items-start">
                        <div class="flex-shrink-0 h-6 w-6 rounded-full bg-primary bg-opacity-20 flex items-center justify-center mt-0.5 mr-3">
                            <i class="fas fa-check text-primary text-sm"></i>
                        </div>
                        <div>
                            <span class="font-medium text-gray-800">Quality:</span> 
                            <span class="text-gray-600">We never compromise on the materials or printing process.</span>
                        </div>
                    </li>
                    <li class="flex items-start">
                        <div class="flex-shrink-0 h-6 w-6 rounded-full bg-primary bg-opacity-20 flex items-center justify-center mt-0.5 mr-3">
                            <i class="fas fa-check text-primary text-sm"></i>
                        </div>
                        <div>
                            <span class="font-medium text-gray-800">Sustainability:</span> 
                            <span class="text-gray-600">Our products are eco-friendly and responsibly sourced.</span>
                        </div>
                    </li>
                    <li class="flex items-start">
                        <div class="flex-shrink-0 h-6 w-6 rounded-full bg-primary bg-opacity-20 flex items-center justify-center mt-0.5 mr-3">
                            <i class="fas fa-check text-primary text-sm"></i>
                        </div>
                        <div>
                            <span class="font-medium text-gray-800">Innovation:</span> 
                            <span class="text-gray-600">We continuously explore new designs and technologies.</span>
                        </div>
                    </li>
                    <li class="flex items-start">
                        <div class="flex-shrink-0 h-6 w-6 rounded-full bg-primary bg-opacity-20 flex items-center justify-center mt-0.5 mr-3">
                            <i class="fas fa-check text-primary text-sm"></i>
                        </div>
                        <div>
                            <span class="font-medium text-gray-800">Customer Satisfaction:</span> 
                            <span class="text-gray-600">Your happiness is our top priority.</span>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>

<!-- Products Section with Background Pattern -->
<section class="relative py-20 overflow-hidden">
    <!-- Background Pattern -->
    <div class="absolute inset-0 grid-pattern"></div>
    
    <div class="container mx-auto px-4 relative z-10">
        <div class="max-w-5xl mx-auto bg-white bg-opacity-90 rounded-lg shadow-xl p-8">
            <h2 class="text-3xl font-heading font-bold mb-8 text-dark text-center">Our Products</h2>
            <p class="text-center text-lg text-gray-600 mb-12">At MurArt, we offer a diverse collection of wallpapers to suit every style and space:</p>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white rounded-lg shadow-md p-8 text-center transform transition-transform hover:scale-105">
                    <div class="inline-flex items-center justify-center h-16 w-16 rounded-full bg-primary bg-opacity-10 mb-6">
                        <i class="fas fa-paint-brush text-primary text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-heading font-bold mb-4 text-gray-800">Artistic Designs</h3>
                    <p class="text-gray-600">Unique patterns and illustrations created by our talented artists.</p>
                </div>
                
                <div class="bg-white rounded-lg shadow-md p-8 text-center transform transition-transform hover:scale-105">
                    <div class="inline-flex items-center justify-center h-16 w-16 rounded-full bg-primary bg-opacity-10 mb-6">
                        <i class="fas fa-leaf text-primary text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-heading font-bold mb-4 text-gray-800">Nature-Inspired</h3>
                    <p class="text-gray-600">Bring the beauty of nature into your space with our botanical and landscape designs.</p>
                </div>
                
                <div class="bg-white rounded-lg shadow-md p-8 text-center transform transition-transform hover:scale-105">
                    <div class="inline-flex items-center justify-center h-16 w-16 rounded-full bg-primary bg-opacity-10 mb-6">
                        <i class="fas fa-building text-primary text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-heading font-bold mb-4 text-gray-800">Modern & Minimalist</h3>
                    <p class="text-gray-600">Clean lines and contemporary patterns for a sophisticated look.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Our Team Section -->
<section class="py-20">
    <div class="container mx-auto px-4 ">
        <div class="max-w-5xl mx-auto">
            <h2 class="text-3xl font-heading font-bold mb-8 text-dark text-center">Our Team</h2>
            <p class="text-center text-lg text-gray-600 mb-12">Behind every beautiful wallpaper is a team of passionate individuals dedicated to bringing art to your walls.</p>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                <div class="bg-white rounded-lg shadow-md overflow-hidden team-card">
                    <div class="h-48 overflow-hidden">
                        <div class=" h-full w-full flex items-center justify-center team-image" style="background-color: #B56917;">
                            <img src="../imgs/fake profiloes/8.jpg" class="rounded-full text-5xl"  alt="">
                            {{-- <i class="fas fa-user-circle text-gray-400 text-5xl"></i> --}}
                        </div>
                    </div>
                    <div class="p-6 text-center">
                        <h4 class="text-xl font-heading font-bold mb-1 text-gray-800">Sarah Johnson</h4>
                        <p class="text-gray-500 mb-3">Founder & Creative Director</p>
                        <div class="flex justify-center space-x-3">
                            <a href="#" class="text-gray-400 hover:text-primary transition">
                                <i class="fab fa-linkedin"></i>
                            </a>
                            <a href="#" class="text-gray-400 hover:text-primary transition">
                                <i class="fab fa-twitter"></i>
                            </a>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white rounded-lg shadow-md overflow-hidden team-card">
                    <div class="h-48 overflow-hidden">
                         <div class=" h-full w-full flex items-center justify-center team-image" style="background-color: #B56917;">
                            <img src="../imgs/fake profiloes/22.jpg" class="rounded-full text-5xl"  alt="">
                           
                        </div>
                    </div>
                    <div class="p-6 text-center">
                        <h4 class="text-xl font-heading font-bold mb-1 text-gray-800">Michael Chen</h4>
                        <p class="text-gray-500 mb-3">Lead Designer</p>
                        <div class="flex justify-center space-x-3">
                            <a href="#" class="text-gray-400 hover:text-primary transition">
                                <i class="fab fa-linkedin"></i>
                            </a>
                            <a href="#" class="text-gray-400 hover:text-primary transition">
                                <i class="fab fa-behance"></i>
                            </a>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white rounded-lg shadow-md overflow-hidden team-card">
                    <div class="h-48 overflow-hidden">
                        <div class=" h-full w-full flex items-center justify-center team-image" style="background-color: #B56917;">
                            <img src="../imgs/fake profiloes/8.jpg" class="rounded-full text-5xl"  alt="">
                           
                        </div>
                    </div>
                    <div class="p-6 text-center">
                        <h4 class="text-xl font-heading font-bold mb-1 text-gray-800">Emma Rodriguez</h4>
                        <p class="text-gray-500 mb-3">Customer Experience Manager</p>
                        <div class="flex justify-center space-x-3">
                            <a href="#" class="text-gray-400 hover:text-primary transition">
                                <i class="fab fa-linkedin"></i>
                            </a>
                            <a href="#" class="text-gray-400 hover:text-primary transition">
                                <i class="fab fa-instagram"></i>
                            </a>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white rounded-lg shadow-md overflow-hidden team-card">
                    <div class="h-48 overflow-hidden">
                      <div class=" h-full w-full flex items-center justify-center team-image" style="background-color: #B56917;">
                            <img src="../imgs/fake profiloes/8.jpg" class="rounded-full text-5xl"  alt="">
                           
                        </div>
                    </div>
                    <div class="p-6 text-center">
                        <h4 class="text-xl font-heading font-bold mb-1 text-gray-800">David Kim</h4>
                        <p class="text-gray-500 mb-3">Production Manager</p>
                        <div class="flex justify-center space-x-3">
                            <a href="#" class="text-gray-400 hover:text-primary transition">
                                <i class="fab fa-linkedin"></i>
                            </a>
                            <a href="#" class="text-gray-400 hover:text-primary transition">
                                <i class="fab fa-twitter"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="relative py-16 bg-secondary bg-opacity-10 overflow-hidden">
    <div class="container mx-auto px-4 relative z-10">
        <div class="max-w-4xl mx-auto text-center">
            <h2 class="text-3xl font-heading font-bold mb-6 text-dark">Ready to Transform Your Space?</h2>
            <p class="text-gray-600 text-lg mb-8">Discover our collection of wallpapers or create your own custom design today.</p>
            <div class="flex flex-col sm:flex-row justify-center space-y-4 sm:space-y-0 sm:space-x-6">
                <a href="{{ route('shop.index') }}" class="bg-primary hover:bg-opacity-90 text-white py-4 px-10 rounded-md font-heading font-medium text-center transition duration-300 transform hover:scale-105 shadow-lg">Shop Wallpapers</a>
                <a href="{{ route('artworks.create') }}" class="bg-secondary hover:bg-opacity-90 text-white py-4 px-10 rounded-md font-heading font-medium text-center transition duration-300 transform hover:scale-105">Create Custom Design</a>
            </div>
        </div>
    </div>
</section>
@endsection