@extends('layouts.app')

@section('title', 'MurArt - Papiers Peints Personnalisés')

@push('styles')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700;800&family=Poppins:wght@300;400;500;600;700&display=swap');
    
    .hero-wallpaper-bg {
        background-image: linear-gradient(135deg, rgba(74, 108, 139, 0.95) 0%, rgba(217, 165, 102, 0.85) 100%), 
                          url('{{ asset('imgs/floral-wallpaper-empty-room-with-wooden-floor_53876-74596.jpg') }}');
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
    }
    
    .creative-heading {
        font-family: 'Playfair Display', serif;
        font-weight: 700;
        letter-spacing: -0.02em;
        line-height: 1.1;
    }
    
    .elegant-text {
        font-family: 'Poppins', sans-serif;
        font-weight: 300;
        letter-spacing: 0.02em;
    }
    
    .wallpaper-card {
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        overflow: hidden;
    }
    
    .wallpaper-card:hover {
        transform: translateY(-12px);
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
    }
    
    .wallpaper-card img {
        transition: transform 0.6s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .wallpaper-card:hover img {
        transform: scale(1.08);
    }
    
    .feature-icon-circle {
        width: 80px;
        height: 80px;
        background: linear-gradient(135deg, #4A6C8B 0%, #6D8BA6 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        font-size: 2rem;
        color: white;
        margin: 0 auto 1.5rem;
        box-shadow: 0 10px 25px rgba(74, 108, 139, 0.3);
    }
    
    .stats-number {
        font-family: 'Playfair Display', serif;
        font-size: 3.5rem;
        font-weight: 700;
        color: #D9A566;
        line-height: 1;
    }
    
    .pattern-overlay {
        background-image: url('{{ asset('imgs/falsterbo-stripe.jpg') }}');
        background-size: 400px;
        opacity: 0.03;
        position: absolute;
        inset: 0;
    }
    
    .gradient-text {
        background: linear-gradient(135deg, #4A6C8B 0%, #D9A566 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
    
    .designer-avatar {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        border: 4px solid #D9A566;
        object-fit: cover;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
    }
    
    .btn-primary-custom {
        background: linear-gradient(135deg, #4A6C8B 0%, #6D8BA6 100%);
        color: white;
        padding: 1rem 2.5rem;
        border-radius: 50px;
        font-weight: 600;
        font-size: 1.1rem;
        transition: all 0.3s ease;
        box-shadow: 0 10px 25px rgba(74, 108, 139, 0.3);
    }
    
    .btn-primary-custom:hover {
        transform: translateY(-2px);
        box-shadow: 0 15px 35px rgba(74, 108, 139, 0.4);
        color: white;
    }
    
    .btn-secondary-custom {
        background: linear-gradient(135deg, #D9A566 0%, #E6C393 100%);
        color: white;
        padding: 1rem 2.5rem;
        border-radius: 50px;
        font-weight: 600;
        font-size: 1.1rem;
        transition: all 0.3s ease;
        box-shadow: 0 10px 25px rgba(217, 165, 102, 0.3);
    }
    
    .btn-secondary-custom:hover {
        transform: translateY(-2px);
        box-shadow: 0 15px 35px rgba(217, 165, 102, 0.4);
        color: white;
    }
</style>
@endpush

@section('content')
<!-- Hero Section with Real Wallpaper Background -->
<section class="hero-wallpaper-bg relative min-h-screen flex items-center justify-center overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-b from-transparent via-transparent to-black opacity-20"></div>
    
    <div class="container mx-auto px-4 lg:px-8 relative z-10">
        <div class="max-w-5xl mx-auto text-center text-white">
            <!-- Main Heading with Creative Typography -->
            <h1 class="creative-heading text-5xl md:text-6xl lg:text-7xl mb-6 animate-fade-in">
                Créez le Papier Peint <br>
                <span class="gradient-text">de vos Rêves</span>
            </h1>
            
            <p class="elegant-text text-xl md:text-2xl mb-8 text-white/90 max-w-3xl mx-auto leading-relaxed">
                Découvrez notre collection exclusive de papiers peints artistiques personnalisables qui transformeront votre intérieur en une œuvre d'art unique
            </p>
            
            <!-- Stats Bar -->
            <div class="grid grid-cols-3 gap-8 max-w-2xl mx-auto mb-12 py-8">
                <div>
                    <div class="stats-number">{{ $wallpapers->count() }}+</div>
                    <p class="elegant-text text-white/80 uppercase tracking-widest text-sm">Motifs Exclusifs</p>
                </div>
                <div>
                    <div class="stats-number">{{ $designers->count() }}+</div>
                    <p class="elegant-text text-white/80 uppercase tracking-widest text-sm">Designers</p>
                </div>
                <div>
                    <div class="stats-number">{{ $categories->count() }}</div>
                    <p class="elegant-text text-white/80 uppercase tracking-widest text-sm">Collections</p>
                </div>
            </div>
            
            <!-- CTA Buttons -->
            <div class="flex flex-col sm:flex-row justify-center gap-4 sm:gap-6">
                <a href="{{ route('designs.index') }}" class="btn-primary-custom inline-block">
                    <i class="fas fa-compass mr-2"></i> Explorer le Catalogue
                </a>
                <a href="{{ route('shop.index') }}" class="btn-secondary-custom inline-block">
                    <i class="fas fa-palette mr-2"></i> Personnaliser
                </a>
            </div>
        </div>
    </div>
    
    <!-- Scroll Indicator -->
    <div class="absolute bottom-10 left-1/2 transform -translate-x-1/2 text-white/70 animate-bounce">
        <i class="fas fa-chevron-down text-2xl"></i>
    </div>
</section>

<!-- Featured Wallpapers Gallery with Real Images -->
<section class="relative py-20 bg-white">
    <div class="pattern-overlay"></div>
    
    <div class="container mx-auto px-4 lg:px-8 relative z-10">
        <div class="text-center mb-16">
            <h2 class="creative-heading text-4xl md:text-5xl mb-4 text-gray-900">
                Collections <span class="gradient-text">Populaires</span>
            </h2>
            <div class="w-24 h-1 bg-gradient-to-r from-transparent via-[#D9A566] to-transparent mx-auto mb-6"></div>
            <p class="elegant-text text-gray-600 text-lg max-w-2xl mx-auto">
                Nos papiers peints les plus appréciés, créés par des designers talentueux
            </p>
        </div>
        
        <!-- Wallpaper Grid with Real Product Images -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 lg:gap-8">
            @forelse($wallpapers->take(8) as $wallpaper)
            <div class="wallpaper-card bg-white rounded-xl shadow-lg">
                <div class="aspect-w-3 aspect-h-4 overflow-hidden rounded-t-xl">
                    @if($wallpaper->primaryImage)
                        <img src="{{ asset('storage/' . $wallpaper->primaryImage->image_path) }}" 
                             alt="{{ $wallpaper->title }}" 
                             class="w-full h-64 object-cover">
                    @else
                        <img src="{{ asset('imgs/nocturne.jpg') }}" 
                             alt="Wallpaper Design" 
                             class="w-full h-64 object-cover">
                    @endif
                </div>
                <div class="p-5">
                    <h3 class="font-semibold text-gray-900 mb-2 truncate">{{ $wallpaper->title ?? 'Design Exclusif' }}</h3>
                    <p class="text-sm text-gray-600 mb-3">{{ $wallpaper->category->name ?? 'Collection Premium' }}</p>
                    <a href="{{ route('shop.show', $wallpaper->id) }}" class="text-[#4A6C8B] hover:text-[#D9A566] font-medium text-sm inline-flex items-center transition">
                        Découvrir <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
            </div>
            @empty
            <!-- Fallback with Actual Images -->
            @foreach(['nocturne.jpg', 'hummingbirds-100-14070.jpg', 'woods-pears.jpg', 'falsterbo-stripe.jpg', 'charlie.jpg', 'green-lake.jpg', 'venice (1).jpg', 'pine-green.jpg'] as $image)
            <div class="wallpaper-card bg-white rounded-xl shadow-lg">
                <div class="aspect-w-3 aspect-h-4 overflow-hidden rounded-t-xl">
                    <img src="{{ asset('imgs/' . $image) }}" 
                         alt="Wallpaper Design" 
                         class="w-full h-64 object-cover">
                </div>
                <div class="p-5">
                    <h3 class="font-semibold text-gray-900 mb-2">Design Exclusif {{ $loop->iteration }}</h3>
                    <p class="text-sm text-gray-600 mb-3">Collection Premium</p>
                    <a href="{{ route('shop.index') }}" class="text-[#4A6C8B] hover:text-[#D9A566] font-medium text-sm inline-flex items-center transition">
                        Découvrir <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
            </div>
            @endforeach
            @endforelse
        </div>
        
        <div class="text-center mt-12">
            <a href="{{ route('shop.index') }}" class="btn-primary-custom inline-block">
                Voir Toute la Collection <i class="fas fa-arrow-right ml-2"></i>
            </a>
        </div>
    </div>
</section>

<!-- How It Works Section -->
<section class="relative py-20 bg-gradient-to-br from-gray-50 to-white">
    <div class="container mx-auto px-4 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="creative-heading text-4xl md:text-5xl mb-4 text-gray-900">
                Comment <span class="gradient-text">Ça Marche</span>
            </h2>
            <div class="w-24 h-1 bg-gradient-to-r from-transparent via-[#D9A566] to-transparent mx-auto mb-6"></div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-12 max-w-5xl mx-auto">
            <!-- Step 1 -->
            <div class="text-center">
                <div class="feature-icon-circle">
                    <i class="fas fa-search"></i>
                </div>
                <h3 class="creative-heading text-2xl mb-4">1. Explorez</h3>
                <p class="elegant-text text-gray-600 leading-relaxed">
                    Parcourez notre collection de motifs créés par des designers talentueux ou téléchargez votre propre design
                </p>
            </div>
            
            <!-- Step 2 -->
            <div class="text-center">
                <div class="feature-icon-circle">
                    <i class="fas fa-palette"></i>
                </div>
                <h3 class="creative-heading text-2xl mb-4">2. Personnalisez</h3>
                <p class="elegant-text text-gray-600 leading-relaxed">
                    Ajustez les couleurs, dimensions et choisissez parmi nos différentes qualités de papier
                </p>
            </div>
            
            <!-- Step 3 -->
            <div class="text-center">
                <div class="feature-icon-circle">
                    <i class="fas fa-shipping-fast"></i>
                </div>
                <h3 class="creative-heading text-2xl mb-4">3. Recevez</h3>
                <p class="elegant-text text-gray-600 leading-relaxed">
                    Nous imprimons et livrons votre papier peint personnalisé directement chez vous
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Featured Designs Section -->
@if($designs->count() > 0)
<section class="relative py-20" style="background-image: linear-gradient(135deg, rgba(248, 247, 245, 0.95) 0%, rgba(255, 255, 255, 0.95) 100%), url('{{ asset('imgs/wall-paper-1024x683.jpg') }}'); background-size: cover; background-position: center;">
    <div class="container mx-auto px-4 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="creative-heading text-4xl md:text-5xl mb-4 text-gray-900">
                Designs <span class="gradient-text">des Créateurs</span>
            </h2>
            <div class="w-24 h-1 bg-gradient-to-r from-transparent via-[#D9A566] to-transparent mx-auto mb-6"></div>
            <p class="elegant-text text-gray-600 text-lg max-w-2xl mx-auto">
                Découvrez les créations uniques de nos designers
            </p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($designs->take(6) as $design)
            <div class="wallpaper-card bg-white rounded-xl shadow-lg">
                <div class="aspect-w-4 aspect-h-3 overflow-hidden rounded-t-xl">
                    <img src="{{ asset('storage/' . ($design->image_path ?? 'default.jpg')) }}" 
                         alt="{{ $design->name }}" 
                         class="w-full h-48 object-cover">
                </div>
                <div class="p-6">
                    <h3 class="font-semibold text-gray-900 text-lg mb-2">{{ $design->name }}</h3>
                    <p class="text-sm text-gray-600 mb-4">Par {{ $design->designer->name ?? 'Designer' }}</p>
                    <a href="{{ route('designs.show', $design->id) }}" class="text-[#4A6C8B] hover:text-[#D9A566] font-medium inline-flex items-center transition">
                        Voir le design <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
            </div>
            @endforeach
        </div>
        
        <div class="text-center mt-12">
            <a href="{{ route('designs.index') }}" class="btn-secondary-custom inline-block">
                Tous les Designs <i class="fas fa-arrow-right ml-2"></i>
            </a>
        </div>
    </div>
</section>
@endif

<!-- Designers Section -->
@if($designers->count() > 0)
<section class="relative py-20 bg-gradient-to-br from-[#4A6C8B] to-[#6D8BA6]">
    <div class="container mx-auto px-4 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="creative-heading text-4xl md:text-5xl mb-4 text-white">
                Nos Designers Talentueux
            </h2>
            <div class="w-24 h-1 bg-[#D9A566] mx-auto mb-6"></div>
            <p class="elegant-text text-white/90 text-lg max-w-2xl mx-auto">
                Rencontrez les artistes qui créent des papiers peints exceptionnels
            </p>
        </div>
        
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8 max-w-4xl mx-auto">
            @foreach($designers as $designer)
            <div class="text-center">
                @if($designer->profile_image)
                    <img src="{{ asset('storage/' . $designer->profile_image) }}" 
                         alt="{{ $designer->name }}" 
                         class="designer-avatar mx-auto mb-4">
                @else
                    <div class="designer-avatar mx-auto mb-4 bg-[#D9A566] flex items-center justify-center text-white text-3xl font-bold">
                        {{ substr($designer->name, 0, 1) }}
                    </div>
                @endif
                <h4 class="creative-heading text-white text-lg mb-1">{{ $designer->name }}</h4>
                <p class="elegant-text text-white/70 text-sm">Designer</p>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- CTA Section -->
<section class="relative py-24" style="background-image: linear-gradient(135deg, rgba(217, 165, 102, 0.9) 0%, rgba(74, 108, 139, 0.9) 100%), url('{{ asset('imgs/floral-wallpaper-empty-room-with-wooden-floor_53876-74596.jpg') }}'); background-size: cover; background-position: center; background-attachment: fixed;">
    <div class="container mx-auto px-4 lg:px-8">
        <div class="max-w-4xl mx-auto text-center text-white">
            <h2 class="creative-heading text-4xl md:text-5xl lg:text-6xl mb-6">
                Prêt à Transformer Votre Intérieur ?
            </h2>
            <p class="elegant-text text-xl md:text-2xl mb-10 text-white/90 leading-relaxed">
                Créez dès maintenant votre papier peint unique qui reflète parfaitement votre style et votre personnalité
            </p>
            <div class="flex flex-col sm:flex-row justify-center gap-4 sm:gap-6">
                <a href="{{ route('designs.index') }}" class="bg-white text-[#4A6C8B] hover:bg-gray-100 px-10 py-4 rounded-full font-semibold text-lg transition inline-block shadow-xl">
                    <i class="fas fa-rocket mr-2"></i> Commencer Maintenant
                </a>
                <a href="{{ route('about') }}" class="bg-white/10 backdrop-blur-sm text-white hover:bg-white/20 px-10 py-4 rounded-full font-semibold text-lg transition inline-block border-2 border-white/30">
                    <i class="fas fa-info-circle mr-2"></i> En Savoir Plus
                </a>
            </div>
        </div>
    </div>
</section>
@endsection
