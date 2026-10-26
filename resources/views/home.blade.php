@extends('layouts.app')

@section('title', 'MurArt - Créez le Papier Peint de vos Rêves')

@push('styles')
<style>
    /* Butterfly-inspired palette override for home */
    :root {
        --transition: all 0.3s ease-in-out;
    }

    /* Hero with wallpaper background + frosted overlay */
    .hero-section {
        position: relative;
        padding: 6rem 0 5rem;
        overflow: hidden;
        background: 
            linear-gradient(135deg, rgba(75, 124, 157, 0.92) 0%, rgba(212, 160, 79, 0.88) 100%),
            url('/imgs/floral-wallpaper-empty-room-with-wooden-floor_53876-74596.jpg') center/cover fixed;
    }

    .hero-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(250, 249, 247, 0.05);
        backdrop-filter: blur(0.5px);
        z-index: 0;
    }

    .hero-container {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 4rem;
        position: relative;
        z-index: 1;
    }

    .hero-content {
        flex: 1;
        max-width: 600px;
    }

    .hero-tagline {
        color: rgba(255, 255, 255, 0.9);
        font-weight: 600;
        font-size: 0.9rem;
        letter-spacing: 2px;
        text-transform: uppercase;
        display: block;
        margin-bottom: 1.5rem;
        text-shadow: 0 1px 6px rgba(0, 0, 0, 0.1);
    }

    .hero-content h1 {
        font-family: 'Playfair Display', serif;
        font-size: 3.5rem;
        font-weight: 700;
        color: white;
        margin-bottom: 1.5rem;
        line-height: 1.2;
        text-shadow: 0 2px 12px rgba(0, 0, 0, 0.15);
    }

    .hero-content p {
        font-size: 1.15rem;
        color: rgba(255, 255, 255, 0.95);
        margin-bottom: 2.5rem;
        line-height: 1.8;
        text-shadow: 0 1px 8px rgba(0, 0, 0, 0.1);
    }

    .hero-buttons {
        display: flex;
        gap: 1rem;
        margin-bottom: 3rem;
    }

    .btn-primary-clean {
        background-color: white;
        color: var(--primary);
        padding: 1rem 2.5rem;
        border-radius: 30px;
        font-weight: 600;
        text-decoration: none;
        display: inline-block;
        transition: var(--transition);
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
    }

    .btn-primary-clean:hover {
        background-color: rgba(255, 255, 255, 0.95);
        transform: translateY(-2px);
        box-shadow: 0 6px 30px rgba(0, 0, 0, 0.25);
        color: var(--primary-dark);
    }

    .btn-outline-clean {
        background-color: transparent;
        color: white;
        border: 2px solid rgba(255, 255, 255, 0.8);
        padding: 1rem 2.5rem;
        border-radius: 30px;
        font-weight: 600;
        text-decoration: none;
        display: inline-block;
        transition: var(--transition);
    }

    .btn-outline-clean:hover {
        background-color: rgba(255, 255, 255, 0.15);
        border-color: white;
        color: white;
        transform: translateY(-2px);
    }

    .hero-stats {
        display: flex;
        gap: 3rem;
    }

    .hero-stat {
        text-align: center;
    }

    .hero-stat-number {
        font-family: 'Playfair Display', serif;
        font-size: 2.5rem;
        font-weight: 700;
        color: white;
        margin-bottom: 0.5rem;
        text-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
    }

    .hero-stat-text {
        color: rgba(255, 255, 255, 0.85);
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .hero-image-container {
        flex: 1;
        position: relative;
        max-width: 550px;
    }

    .hero-image {
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 12px 40px rgba(0, 0, 0, 0.25), inset 0 2px 6px rgba(0, 0, 0, 0.08);
        position: relative;
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .hero-image img {
        width: 100%;
        height: auto;
        display: block;
    }

    .hero-badge {
        position: absolute;
        top: 20px;
        right: 20px;
        background-color: var(--secondary);
        color: white;
        padding: 0.75rem 1.5rem;
        border-radius: 30px;
        font-weight: 600;
        font-size: 0.85rem;
        box-shadow: 0 4px 15px rgba(217, 165, 102, 0.3);
    }

    .hero-image-accent {
        position: absolute;
        width: 150px;
        height: 150px;
        background-color: var(--secondary);
        opacity: 0.1;
        border-radius: 50%;
        bottom: -30px;
        right: -30px;
        z-index: -1;
    }

    /* Section Styles */
    .section-clean {
        padding: 5rem 0;
    }

    .section-title-clean {
        text-align: center;
        margin-bottom: 3rem;
    }

    .section-title-clean h2 {
        font-family: 'Playfair Display', serif;
        font-size: 2.5rem;
        font-weight: 700;
        color: var(--dark);
        margin-bottom: 1rem;
        position: relative;
        display: inline-block;
    }

    .section-title-clean h2::after {
        content: '';
        position: absolute;
        width: 60px;
        height: 3px;
        background-color: var(--secondary);
        left: 50%;
        transform: translateX(-50%);
        bottom: -10px;
    }

    .section-title-clean p {
        color: var(--text-light);
        font-size: 1.05rem;
        max-width: 600px;
        margin: 1.5rem auto 0;
    }

    /* Collection Grid with Depth */
    .collection-grid-clean {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 2rem;
        margin-top: 3rem;
    }

    .collection-card-clean {
        background-color: white;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: var(--shadow-soft), inset 0 1px 0 rgba(255, 255, 255, 0.5);
        transition: var(--transition);
        cursor: pointer;
        border: 1px solid rgba(0, 0, 0, 0.03);
    }

    .collection-card-clean:hover {
        transform: translateY(-10px);
        box-shadow: 0 16px 45px rgba(0, 0, 0, 0.14), inset 0 1px 0 rgba(255, 255, 255, 0.6);
    }

    .collection-card-image {
        width: 100%;
        height: 320px;
        overflow: hidden;
        position: relative;
    }

    .collection-card-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }

    .collection-card-clean:hover .collection-card-image img {
        transform: scale(1.05);
    }

    .collection-card-overlay {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background: linear-gradient(to top, rgba(42, 50, 64, 0.92), transparent);
        padding: 1.5rem;
        color: white;
        box-shadow: inset 0 -2px 8px rgba(0, 0, 0, 0.15);
    }

    .collection-card-body {
        padding: 1.5rem;
    }

    .collection-card-body h3 {
        font-family: 'Playfair Display', serif;
        font-size: 1.3rem;
        font-weight: 600;
        color: var(--dark);
        margin-bottom: 0.5rem;
    }

    .collection-card-body p {
        color: var(--text-light);
        font-size: 0.9rem;
        margin-bottom: 1rem;
    }

    .collection-card-price {
        color: var(--secondary);
        font-weight: 700;
        font-size: 1.2rem;
    }

    /* Features Section with Background Texture */
    .features-clean {
        background: 
            linear-gradient(rgba(250, 249, 247, 0.96), rgba(250, 249, 247, 0.96)),
            url('/imgs/wall-paper-1024x683.jpg') center/cover;
        box-shadow: inset 0 2px 12px rgba(0, 0, 0, 0.04);
    }

    .features-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 3rem;
        margin-top: 3rem;
    }

    .feature-item {
        text-align: center;
        background: white;
        padding: 2rem;
        border-radius: 12px;
        box-shadow: var(--shadow-soft), inset 0 1px 0 rgba(255, 255, 255, 0.8);
        transition: var(--transition);
    }

    .feature-item:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 35px rgba(0, 0, 0, 0.1);
    }

    .feature-icon {
        width: 70px;
        height: 70px;
        background: linear-gradient(135deg, var(--primary), var(--primary-light));
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem;
        color: white;
        font-size: 1.8rem;
        box-shadow: 0 8px 24px rgba(75, 124, 157, 0.25), inset 0 -2px 4px rgba(0, 0, 0, 0.1);
    }

    .feature-item h3 {
        font-family: 'Playfair Display', serif;
        font-size: 1.3rem;
        color: var(--dark);
        margin-bottom: 1rem;
    }

    .feature-item p {
        color: var(--text);
        line-height: 1.7;
    }

    /* CTA Section with Wallpaper Background + Depth */
    .cta-section {
        background: 
            linear-gradient(135deg, rgba(75, 124, 157, 0.94), rgba(212, 160, 79, 0.90)),
            url('/imgs/nocturne.jpg') center/cover fixed;
        padding: 5rem 0;
        text-align: center;
        color: white;
        position: relative;
        overflow: hidden;
        box-shadow: inset 0 3px 15px rgba(0, 0, 0, 0.12);
    }

    .cta-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(42, 50, 64, 0.08);
        backdrop-filter: blur(0.5px);
    }

    .cta-content {
        position: relative;
        z-index: 1;
        max-width: 800px;
        margin: 0 auto;
    }

    .cta-content h2 {
        font-family: 'Playfair Display', serif;
        font-size: 3rem;
        font-weight: 700;
        margin-bottom: 1.5rem;
    }

    .cta-content p {
        font-size: 1.2rem;
        margin-bottom: 2.5rem;
        opacity: 0.95;
    }

    @media (max-width: 992px) {
        .hero-container {
            flex-direction: column;
            text-align: center;
        }

        .hero-content {
            max-width: 100%;
        }

        .hero-buttons {
            justify-content: center;
        }

        .hero-stats {
            justify-content: center;
        }

        .features-grid {
            grid-template-columns: 1fr;
            gap: 2.5rem;
        }
    }

    @media (max-width: 768px) {
        .hero-content h1 {
            font-size: 2.5rem;
        }

        .hero-buttons {
            flex-direction: column;
        }

        .hero-stats {
            flex-direction: column;
            gap: 2rem;
        }

        .collection-grid-clean {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush

@section('content')
<!-- Hero Section -->
<section class="hero-section">
    <div class="container mx-auto px-4 lg:px-8">
        <div class="hero-container">
            <!-- Left: Content -->
            <div class="hero-content">
                <span class="hero-tagline">Papiers Peints Premium</span>
                <h1>Créez le Papier Peint de vos Rêves</h1>
                <p>Découvrez notre plateforme de personnalisation avancée pour concevoir des papiers peints uniques qui reflètent votre style et votre personnalité.</p>
                
                <div class="hero-buttons">
                    <a href="{{ route('shop.index') }}" class="btn-primary-clean">
                        Explorer le Catalogue
                    </a>
                    <a href="{{ route('designs.index') }}" class="btn-outline-clean">
                        Personnaliser
                    </a>
                </div>
                
                <div class="hero-stats">
                    <div class="hero-stat">
                        <div class="hero-stat-number">{{ $wallpapers->count() }}+</div>
                        <div class="hero-stat-text">Designs</div>
                    </div>
                    <div class="hero-stat">
                        <div class="hero-stat-number">{{ $categories->count() }}</div>
                        <div class="hero-stat-text">Collections</div>
                    </div>
                    <div class="hero-stat">
                        <div class="hero-stat-number">{{ $designers->count() }}+</div>
                        <div class="hero-stat-text">Designers</div>
                    </div>
                </div>
            </div>
            
            <!-- Right: Featured Image -->
            <div class="hero-image-container">
                <div class="hero-image">
                    @if($wallpapers->first() && $wallpapers->first()->primaryImage)
                        <img src="{{ asset('storage/' . $wallpapers->first()->primaryImage->image_path) }}" 
                             alt="{{ $wallpapers->first()->title }}">
                    @else
                        <img src="{{ asset('imgs/floral-wallpaper-empty-room-with-wooden-floor_53876-74596.jpg') }}" 
                             alt="Intérieur avec papier peint design élégant">
                    @endif
                    <div class="hero-badge">NOUVEAU 2025</div>
                    <div class="hero-image-accent"></div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Featured Collections Section -->
<section class="section-clean" style="background-color: var(--light);">
    <div class="container mx-auto px-4 lg:px-8">
        <div class="section-title-clean">
            <h2>Collections Populaires</h2>
            <p>Découvrez nos papiers peints les plus appréciés, créés par des designers talentueux</p>
        </div>
        
        <div class="collection-grid-clean">
            @forelse($wallpapers->take(8) as $wallpaper)
                <a href="{{ route('shop.show', $wallpaper->id) }}" class="collection-card-clean">
                    <div class="collection-card-image">
                        @if($wallpaper->primaryImage)
                            <img src="{{ asset('storage/' . $wallpaper->primaryImage->image_path) }}" 
                                 alt="{{ $wallpaper->title }}">
                        @else
                            <img src="{{ asset('imgs/nocturne.jpg') }}" 
                                 alt="{{ $wallpaper->title }}">
                        @endif
                        <div class="collection-card-overlay">
                            <span style="font-size: 0.85rem; text-transform: uppercase; letter-spacing: 1px;">
                                {{ $wallpaper->category->name ?? 'Design' }}
                            </span>
                        </div>
                    </div>
                    <div class="collection-card-body">
                        <h3>{{ $wallpaper->title }}</h3>
                        <p>{{ Str::limit($wallpaper->description, 80) }}</p>
                        <span class="collection-card-price">{{ number_format($wallpaper->price, 2) }} €</span>
                    </div>
                </a>
            @empty
                @foreach(['nocturne.jpg', 'hummingbirds-100-14070.jpg', 'woods-pears.jpg', 'falsterbo-stripe.jpg', 'charlie.jpg', 'green-lake.jpg', 'venice (1).jpg', 'pine-green.jpg'] as $index => $image)
                    <a href="{{ route('shop.index') }}" class="collection-card-clean">
                        <div class="collection-card-image">
                            <img src="{{ asset('imgs/' . $image) }}" alt="Design Exclusif">
                            <div class="collection-card-overlay">
                                <span style="font-size: 0.85rem; text-transform: uppercase; letter-spacing: 1px;">
                                    Collection Premium
                                </span>
                            </div>
                        </div>
                        <div class="collection-card-body">
                            <h3>Design Exclusif {{ $index + 1 }}</h3>
                            <p>Papier peint de haute qualité pour transformer votre intérieur</p>
                            <span class="collection-card-price">29.99 €</span>
                        </div>
                    </a>
                @endforeach
            @endforelse
        </div>
        
        <div style="text-align: center; margin-top: 3rem;">
            <a href="{{ route('shop.index') }}" class="btn-primary-clean">
                Voir Toute la Collection
            </a>
        </div>
    </div>
</section>

<!-- How It Works Section -->
<section class="section-clean features-clean">
    <div class="container mx-auto px-4 lg:px-8">
        <div class="section-title-clean">
            <h2>Comment Ça Marche</h2>
            <p>Notre processus simple en trois étapes pour créer votre papier peint parfait</p>
        </div>
        
        <div class="features-grid">
            <div class="feature-item">
                <div class="feature-icon">
                    <i class="fas fa-search"></i>
                </div>
                <h3>1. Explorez</h3>
                <p>Parcourez notre collection de motifs créés par des designers talentueux ou téléchargez votre propre design</p>
            </div>
            
            <div class="feature-item">
                <div class="feature-icon">
                    <i class="fas fa-palette"></i>
                </div>
                <h3>2. Personnalisez</h3>
                <p>Ajustez les couleurs, dimensions et choisissez parmi nos différentes qualités de papier</p>
            </div>
            
            <div class="feature-item">
                <div class="feature-icon">
                    <i class="fas fa-shipping-fast"></i>
                </div>
                <h3>3. Recevez</h3>
                <p>Nous imprimons et livrons votre papier peint personnalisé directement chez vous</p>
            </div>
        </div>
    </div>
</section>

@if($designs->count() > 0)
<!-- Featured Designs Section -->
<section class="section-clean" style="background-color: var(--light);">
    <div class="container mx-auto px-4 lg:px-8">
        <div class="section-title-clean">
            <h2>Designs des Créateurs</h2>
            <p>Découvrez les créations uniques de nos designers</p>
        </div>
        
        <div class="collection-grid-clean">
            @foreach($designs->take(6) as $design)
                <a href="{{ route('designs.show', $design->id) }}" class="collection-card-clean">
                    <div class="collection-card-image">
                        @if($design->image_path)
                            <img src="{{ asset('storage/' . $design->image_path) }}" 
                                 alt="{{ $design->name }}">
                        @else
                            <img src="{{ asset('imgs/nocturne.jpg') }}" 
                                 alt="{{ $design->name }}">
                        @endif
                        <div class="collection-card-overlay">
                            <span style="font-size: 0.85rem;">
                                Par {{ $design->designer->name ?? 'Designer' }}
                            </span>
                        </div>
                    </div>
                    <div class="collection-card-body">
                        <h3>{{ $design->name }}</h3>
                        <p>Design créé par {{ $design->designer->name ?? 'notre équipe' }}</p>
                    </div>
                </a>
            @endforeach
        </div>
        
        <div style="text-align: center; margin-top: 3rem;">
            <a href="{{ route('designs.index') }}" class="btn-outline-clean" style="border-color: var(--secondary); color: var(--secondary);">
                Tous les Designs
            </a>
        </div>
    </div>
</section>
@endif

<!-- Call to Action Section -->
<section class="cta-section">
    <div class="container mx-auto px-4 lg:px-8">
        <div class="cta-content">
            <h2>Prêt à Transformer Votre Intérieur ?</h2>
            <p>Créez dès maintenant votre papier peint unique qui reflète parfaitement votre style et votre personnalité</p>
            <div style="display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap;">
                <a href="{{ route('shop.index') }}" class="btn-primary-clean" style="background-color: white; color: var(--primary);">
                    <i class="fas fa-rocket"></i> Commencer Maintenant
                </a>
                <a href="{{ route('about') }}" class="btn-outline-clean" style="border-color: white; color: white;">
                    <i class="fas fa-info-circle"></i> En Savoir Plus
                </a>
            </div>
        </div>
    </div>
</section>
@endsection
