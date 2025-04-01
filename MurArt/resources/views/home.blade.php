@extends('layouts.app')

@section('title', 'MurArt - Papiers Peints Artistiques Personnalisables')

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
    
    .floating-image {
        animation: float 6s ease-in-out infinite;
    }
    
    @keyframes float {
        0% { transform: translateY(0px); }
        50% { transform: translateY(-20px); }
        100% { transform: translateY(0px); }
    }
    
    .parallax-section {
        background-attachment: fixed;
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;
    }
    
    .grid-pattern {
        background-image: url('{{ asset('storage/wallpapers/1745908565_cafe-wallpaper_1.jpg') }}');
        background-size: 400px;
        opacity: 0.05;
    }
    
    .decorative-corner {
        position: absolute;
        width: 200px;
        height: 200px;
        background-size: cover;
        opacity: 0.1;
        z-index: 0;
    }
    
    .corner-top-right {
        top: 0;
        right: 0;
        transform: rotate(90deg);
    }
    
    .corner-bottom-left {
        bottom: 0;
        left: 0;
        transform: rotate(-90deg);
    }
</style>
@endpush

@section('content')
<!-- Hero Section with Creative Layout -->
<section class="relative min-h-screen flex items-center justify-center overflow-hidden">
    <!-- Decorative Background Pattern -->
    <div class="absolute inset-0 pattern-bg"></div>
    
    <!-- Main Content -->
    <div class="container mx-auto px-4 relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <!-- Text Content -->
            <div class="text-center lg:text-left">
                <h1 class="text-5xl md:text-6xl font-heading font-bold mb-6 tracking-tight text-dark">Transformez vos murs en œuvres d'art</h1>
                <p class="text-xl md:text-2xl mb-10 text-gray-600">Découvrez notre collection exclusive de papiers peints artistiques qui élèvent l'ambiance de votre intérieur</p>
                <div class="flex flex-col sm:flex-row justify-center lg:justify-start space-y-4 sm:space-y-0 sm:space-x-6">
                    <a href="{{ route('artworks.create') }}" class="bg-primary hover:bg-opacity-90 text-white py-4 px-10 rounded-md font-heading font-medium text-center transition duration-300 transform hover:scale-105 shadow-lg">Créer mon papier peint</a>
                    <a href="{{ route('designs.index') }}" class="bg-secondary hover:bg-opacity-90 text-white py-4 px-10 rounded-md font-heading font-medium text-center transition duration-300 transform hover:scale-105">Explorer les designs</a>
                </div>
            </div>
            
            <!-- Featured Image -->
            <div class="relative">
                <div class="aspect-w-4 aspect-h-5 rounded-lg overflow-hidden shadow-2xl floating-image">
                    <img src="{{ asset('storage/wallpapers/1745904225_chateau-wallpaper_0.jpg') }}" alt="Featured Design" class="object-cover w-full h-full">
                </div>
                <!-- Decorative Elements -->
                <div class="absolute -bottom-10 -left-10 w-40 h-40 bg-primary bg-opacity-10 rounded-full"></div>
                <div class="absolute -top-10 -right-10 w-60 h-60 bg-secondary bg-opacity-10 rounded-full"></div>
            </div>
        </div>
    </div>
</section>

<!-- How It Works with Diagonal Sections -->
<section class="relative py-24 overflow-hidden">
    <!-- Diagonal Background -->
    <div class="diagonal-slice bg-secondary bg-opacity-5"></div>
    
    <div class="container mx-auto px-4 relative z-10">
        <div class="text-center mb-16">
            <h2 class="text-4xl font-heading font-bold mb-4 text-dark">Comment ça marche</h2>
            <div class="w-24 h-1 bg-primary mx-auto mb-6"></div>
            <p class="text-gray-600 max-w-3xl mx-auto text-lg">Notre processus unique vous permet de créer votre papier peint parfait</p>
        </div>
        
        <!-- Steps with Alternating Layout -->
        <div class="space-y-24">
            <!-- Step 1 -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div class="order-2 lg:order-1">
                    <div class="relative">
                        <img src="{{ asset('storage/wallpapers/1745908565_cafe-wallpaper_2.jpg') }}" alt="Choose Design" class="rounded-lg shadow-xl">
                        <div class="absolute inset-0 bg-gradient-to-r from-primary to-transparent opacity-20"></div>
                    </div>
                </div>
                <div class="order-1 lg:order-2">
                    <h3 class="text-3xl font-heading font-bold mb-6 text-dark">1. Choisissez votre design</h3>
                    <p class="text-gray-600 text-lg mb-6">Explorez notre collection exclusive de motifs créés par nos artistes talentueux ou téléchargez votre propre création.</p>
                    <a href="{{ route('designs.index') }}" class="text-secondary hover:text-primary font-medium transition inline-flex items-center">
                        Découvrir les designs <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
            </div>
            
            <!-- Step 2 -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div>
                    <h3 class="text-3xl font-heading font-bold mb-6 text-dark">2. Personnalisez votre papier peint</h3>
                    <p class="text-gray-600 text-lg mb-6">Ajustez les couleurs, les dimensions et choisissez parmi nos différentes qualités de papier pour un résultat parfait.</p>
                    <a href="#" class="text-secondary hover:text-primary font-medium transition inline-flex items-center">
                        Explorer les options <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
                <div class="relative">
                    <img src="{{ asset('storage/wallpapers/1745772684_chateau-wallpaper_0.jpg') }}" alt="Customize" class="rounded-lg shadow-xl">
                    <div class="absolute inset-0 bg-gradient-to-l from-secondary to-transparent opacity-20"></div>
                </div>
            </div>
            
            <!-- Step 3 -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div class="order-2 lg:order-1">
                    <div class="relative">
                        <img src="{{ asset('storage/wallpapers/1745579806_test-wallroll_2.jpg') }}" alt="Final Product" class="rounded-lg shadow-xl">
                        <div class="absolute inset-0 bg-gradient-to-r from-primary to-transparent opacity-20"></div>
                    </div>
                </div>
                <div class="order-1 lg:order-2">
                    <h3 class="text-3xl font-heading font-bold mb-6 text-dark">3. Recevez votre création</h3>
                    <p class="text-gray-600 text-lg mb-6">Nous imprimons et livrons votre papier peint personnalisé directement chez vous, prêt à transformer votre intérieur.</p>
                    <a href="{{ route('artworks.create') }}" class="text-secondary hover:text-primary font-medium transition inline-flex items-center">
                        Commander maintenant <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Featured Designs Section with Creative Grid -->
<section class="relative py-24">
    <!-- Background Pattern -->
    <div class="absolute inset-0 grid-pattern"></div>
    
    <div class="container mx-auto px-4 relative z-10">
        <div class="text-center mb-16">
            <h2 class="text-4xl font-heading font-bold mb-4 text-dark">Nos créations</h2>
            <div class="w-24 h-1 bg-primary mx-auto mb-6"></div>
            <p class="text-gray-600 max-w-3xl mx-auto text-lg">Découvrez notre sélection de designs exclusifs</p>
        </div>
        
        <!-- Creative Grid Layout -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="col-span-2 row-span-2">
                <div class="relative h-full group overflow-hidden rounded-lg">
                    <img src="{{ asset('storage/wallpapers/1745908565_cafe-wallpaper_1.jpg') }}" alt="Featured Design" class="w-full h-full object-cover transition duration-500 group-hover:scale-110">
                    <div class="absolute inset-0 bg-gradient-to-t from-dark to-transparent opacity-60 group-hover:opacity-70 transition duration-300"></div>
                    <div class="absolute bottom-0 left-0 p-6">
                        <h3 class="text-white font-heading font-bold text-xl mb-2">Collection Signature</h3>
                        <p class="text-gray-200">Designs exclusifs</p>
                    </div>
                </div>
            </div>
            @foreach(range(1, 6) as $index)
            <div class="relative group overflow-hidden rounded-lg">
                <img src="{{ asset('storage/wallpapers/1745908565_cafe-wallpaper_' . ($index % 3 + 1) . '.jpg') }}" alt="Design {{ $index }}" class="w-full h-64 object-cover transition duration-500 group-hover:scale-110">
                <div class="absolute inset-0 bg-gradient-to-t from-dark to-transparent opacity-60 group-hover:opacity-70 transition duration-300"></div>
                <div class="absolute bottom-0 left-0 p-4">
                    <h4 class="text-white font-heading font-semibold">Design {{ $index }}</h4>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Testimonials with Artistic Background -->
<section class="relative py-24 parallax-section" style="background-image: url('{{ asset('storage/wallpapers/1745908565_cafe-wallpaper_2.jpg') }}')">
    <div class="absolute inset-0 bg-dark bg-opacity-80"></div>
    
    <div class="container mx-auto px-4 relative z-10">
        <div class="text-center mb-16">
            <h2 class="text-4xl font-heading font-bold mb-4 text-white">Ce que disent nos clients</h2>
            <div class="w-24 h-1 bg-primary mx-auto mb-6"></div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach(range(1, 3) as $index)
            <div class="bg-white bg-opacity-10 backdrop-blur-lg p-8 rounded-lg">
                <div class="flex text-yellow-500 mb-6">
                    @for($i = 0; $i < 5; $i++)
                        <i class="fas fa-star"></i>
                    @endfor
                </div>
                <p class="text-gray-200 mb-8 italic text-lg">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                <div class="flex items-center">
                    <div class="w-12 h-12 rounded-full bg-primary mr-4"></div>
                    <div>
                        <h4 class="font-heading font-semibold text-white">Client {{ $index }}</h4>
                        <p class="text-gray-300 text-sm">Client depuis 2023</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- CTA Section with Artistic Elements -->
<section class="relative py-24 overflow-hidden">
    <!-- Decorative Corners -->
    <div class="decorative-corner corner-top-right" style="background-image: url('{{ asset('storage/wallpapers/1745908565_cafe-wallpaper_3.jpg') }}')"></div>
    <div class="decorative-corner corner-bottom-left" style="background-image: url('{{ asset('storage/wallpapers/1745908565_cafe-wallpaper_1.jpg') }}')"></div>
    
    <div class="container mx-auto px-4 relative z-10">
        <div class="max-w-4xl mx-auto text-center">
            <h2 class="text-4xl md:text-5xl font-heading font-bold mb-6 text-dark">Prêt à transformer votre intérieur ?</h2>
            <p class="text-gray-600 text-xl mb-10">Créez dès maintenant votre papier peint unique qui reflétera parfaitement votre style et votre personnalité.</p>
            <div class="flex flex-col sm:flex-row justify-center space-y-4 sm:space-y-0 sm:space-x-6">
                <a href="{{ route('artworks.create') }}" class="bg-primary hover:bg-opacity-90 text-white py-4 px-10 rounded-md font-heading font-medium text-center transition duration-300 transform hover:scale-105 shadow-lg">Créer mon papier peint</a>
                <a href="{{ route('about') }}" class="bg-secondary hover:bg-opacity-90 text-white py-4 px-10 rounded-md font-heading font-medium text-center transition duration-300 transform hover:scale-105">En savoir plus</a>
            </div>
        </div>
    </div>
</section>
@endsection// Updated on 2025-04-01 16:58:27 by red-jen
