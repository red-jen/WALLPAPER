<script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
@extends('layouts.app')

@section('content')
    <!-- Hero Section -->
    <section class="py-16 md:py-24">
        <div class="container mx-auto px-4">
            <div class="flex flex-col md:flex-row items-center gap-12">
                <div class="md:w-1/2">
                    <h1 class="font-heading text-4xl md:text-5xl font-bold leading-tight mb-6">Créez le Papier Peint de vos Rêves</h1>
                    <p class="text-gray-600 text-lg mb-8">Découvrez notre plateforme de personnalisation avancée pour concevoir des papiers peints uniques qui reflètent votre style et votre personnalité.</p>
                    <div class="flex flex-wrap gap-4">
                        <a href="#" class="px-6 py-3 rounded-full font-semibold bg-primary text-white hover:bg-primary/90 transition-all transform hover:-translate-y-0.5">Explorer le Catalogue</a>
                        <a href="#" class="px-6 py-3 rounded-full font-semibold border-2 border-primary text-primary hover:bg-primary hover:text-white transition-all transform hover:-translate-y-0.5">Personnaliser</a>
                    </div>
                </div>
                <div class="md:w-1/2 relative">
                    <img src="{{ asset('images/hero-wallpaper.jpg') }}" alt="Intérieur avec papier peint design" class="w-full rounded-lg shadow-custom">
                    <div class="absolute top-0 right-0 transform translate-x-1/4 -translate-y-1/4 bg-secondary text-white p-4 rounded-full w-20 h-20 flex flex-col items-center justify-center font-bold leading-tight text-sm rotate-12 shadow-custom">
                        <span>NOUVEAU</span>
                        <span>Collection</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features -->
    <section class="py-16 md:py-24 bg-white">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16">
                <h2 class="font-heading text-3xl md:text-4xl font-bold mb-4">Pourquoi Choisir WallArt</h2>
                <p class="text-gray-600 max-w-3xl mx-auto">Notre plateforme offre une expérience unique pour créer et acheter des papiers peints personnalisés.</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-light p-8 rounded-lg shadow-custom transform transition-transform hover:-translate-y-2">
                    <div class="w-16 h-16 bg-primary text-white rounded-full flex items-center justify-center mb-6 text-2xl">
                        <i class="fas fa-paint-brush"></i>
                    </div>
                    <h3 class="font-heading text-xl font-semibold mb-4">Personnalisation Avancée</h3>
                    <p class="text-gray-600">Modifiez les couleurs, les motifs et ajoutez votre touche personnelle à n'importe quel design.</p>
                </div>
                
                <div class="bg-light p-8 rounded-lg shadow-custom transform transition-transform hover:-translate-y-2">
                    <div class="w-16 h-16 bg-primary text-white rounded-full flex items-center justify-center mb-6 text-2xl">
                        <i class="fas fa-users"></i>
                    </div>
                    <h3 class="font-heading text-xl font-semibold mb-4">Communauté Active</h3>
                    <p class="text-gray-600">Échangez avec des designers et d'autres clients pour trouver l'inspiration parfaite.</p>
                </div>
                
                <div class="bg-light p-8 rounded-lg shadow-custom transform transition-transform hover:-translate-y-2">
                    <div class="w-16 h-16 bg-primary text-white rounded-full flex items-center justify-center mb-6 text-2xl">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <h3 class="font-heading text-xl font-semibold mb-4">Suivi Personnalisé</h3>
                    <p class="text-gray-600">Suivez vos commandes et vos ventes depuis votre tableau de bord interactif.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Collections -->
    <section class="py-16 md:py-24">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center mb-8">
                <h2 class="font-heading text-3xl font-bold">Nos Collections</h2>
                <a href="#" class="px-6 py-2 rounded-full font-semibold bg-secondary text-white hover:bg-secondary/90 transition-all transform hover:-translate-y-0.5">Voir Tout</a>
            </div>
            
            <div class="flex flex-wrap gap-4 mb-8">
                <button class="px-6 py-2 rounded-full font-medium bg-primary text-white shadow-custom">Tous</button>
                <button class="px-6 py-2 rounded-full font-medium bg-white shadow-custom hover:bg-gray-50">Moderne</button>
                <button class="px-6 py-2 rounded-full font-medium bg-white shadow-custom hover:bg-gray-50">Classique</button>
                <button class="px-6 py-2 rounded-full font-medium bg-white shadow-custom hover:bg-gray-50">Nature</button>
                <button class="px-6 py-2 rounded-full font-medium bg-white shadow-custom hover:bg-gray-50">Géométrique</button>
            </div>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                @foreach ([
                    [
                        'image' => 'vagues-abstraites.jpg',
                        'title' => 'Vagues Abstraites',
                        'description' => 'Design moderne avec motif ondulé',
                        'price' => '39,99 €'
                    ],
                    [
                        'image' => 'floral-vintage.jpg',
                        'title' => 'Floral Vintage',
                        'description' => 'Motifs floraux classiques et élégants',
                        'price' => '45,99 €'
                    ],
                    [
                        'image' => 'jungle-tropicale.jpg',
                        'title' => 'Jungle Tropicale',
                        'description' => 'Immersion dans une nature luxuriante',
                        'price' => '49,99 €'
                    ],
                    [
                        'image' => 'geometrie-urbaine.jpg',
                        'title' => 'Géométrie Urbaine',
                        'description' => 'Formes géométriques contemporaines',
                        'price' => '42,99 €'
                    ]
                ] as $collection)
                <div class="bg-white rounded-lg overflow-hidden shadow-custom transform transition-all hover:-translate-y-1 hover:shadow-lg">
                    <img src="{{ asset('images/collections/' . $collection['image']) }}" alt="{{ $collection['title'] }}" class="w-full h-56 object-cover">
                    <div class="p-6">
                        <h3 class="font-heading text-xl font-semibold mb-2">{{ $collection['title'] }}</h3>
                        <p class="text-gray-600 mb-4">{{ $collection['description'] }}</p>
                        <div class="flex justify-between items-center">
                            <div class="text-primary font-bold text-lg">{{ $collection['price'] }}</div>
                            <div class="flex gap-2">
                                <button class="w-10 h-10 bg-light rounded-full flex items-center justify-center hover:bg-primary hover:text-white transition-colors">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="w-10 h-10 bg-light rounded-full flex items-center justify-center hover:bg-primary hover:text-white transition-colors">
                                    <i class="fas fa-heart"></i>
                                </button>
                                <button class="w-10 h-10 bg-light rounded-full flex items-center justify-center hover:bg-primary hover:text-white transition-colors">
                                    <i class="fas fa-shopping-cart"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Customization -->
    <section class="py-16 md:py-24 bg-white">
        <div class="container mx-auto px-4">
            <div class="flex flex-col md:flex-row items-center gap-12">
                <div class="md:w-1/2 relative">
                    <img src="{{ asset('images/customization-tool.jpg') }}" alt="Outil de personnalisation" class="w-full rounded-lg shadow-custom">
                    <div class="absolute top-5 right-5 flex flex-col gap-4">
                        <button class="w-12 h-12 bg-white rounded-full flex items-center justify-center shadow-custom hover:bg-primary hover:text-white transform hover:scale-110 transition-all">
                            <i class="fas fa-palette"></i>
                        </button>
                        <button class="w-12 h-12 bg-white rounded-full flex items-center justify-center shadow-custom hover:bg-primary hover:text-white transform hover:scale-110 transition-all">
                            <i class="fas fa-crop"></i>
                        </button>
                        <button class="w-12 h-12 bg-white rounded-full flex items-center justify-center shadow-custom hover:bg-primary hover:text-white transform hover:scale-110 transition-all">
                            <i class="fas fa-adjust"></i>
                        </button>
                        <button class="w-12 h-12 bg-white rounded-full flex items-center justify-center shadow-custom hover:bg-primary hover:text-white transform hover:scale-110 transition-all">
                            <i class="fas fa-magic"></i>
                        </button>
                    </div>
                </div>
                
                <div class="md:w-1/2">
                    <h2 class="font-heading text-3xl md:text-4xl font-bold mb-6">Personnalisez à l'Infini</h2>
                    <p class="text-gray-600 mb-8">Notre outil de personnalisation avancé vous permet de modifier chaque aspect de votre papier peint pour créer un design qui vous ressemble vraiment.</p>
                    
                    <div class="flex flex-col gap-6 mb-8">
                        <div class="flex gap-4">
                            <div class="w-9 h-9 bg-primary text-white rounded-full flex items-center justify-center font-bold flex-shrink-0">1</div>
                            <div>
                                <h4 class="font-heading text-lg font-semibold mb-2">Choisissez un Design</h4>
                                <p class="text-gray-600">Parcourez notre catalogue et sélectionnez le design qui vous inspire.</p>
                            </div>
                        </div>
                        
                        <div class="flex gap-4">
                            <div class="w-9 h-9 bg-primary text-white rounded-full flex items-center justify-center font-bold flex-shrink-0">2</div>
                            <div>
                                <h4 class="font-heading text-lg font-semibold mb-2">Personnalisez-le</h4>
                                <p class="text-gray-600">Modifiez les couleurs, les motifs et ajoutez des éléments personnels.</p>
                            </div>
                        </div>
                        
                        <div class="flex gap-4">
                            <div class="w-9 h-9 bg-primary text-white rounded-full flex items-center justify-center font-bold flex-shrink-0">3</div>
                            <div>
                                <h4 class="font-heading text-lg font-semibold mb-2">Visualisez le Résultat</h4>
                                <p class="text-gray-600">Utilisez notre aperçu en temps réel pour voir votre création dans un intérieur.</p>
                            </div>
                        </div>
                    </div>
                    
                    <a href="#" class="inline-block px-6 py-3 rounded-full font-semibold bg-secondary text-white hover:bg-secondary/90 transition-all transform hover:-translate-y-0.5">Essayer Maintenant</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Community -->
    <section class="py-16 md:py-24">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16">
                <h2 class="font-heading text-3xl md:text-4xl font-bold mb-4">Notre Communauté</h2>
                <p class="text-gray-600 max-w-3xl mx-auto">Rejoignez des milliers de designers et de clients qui partagent leur passion pour les beaux intérieurs.</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white p-8 rounded-lg shadow-custom">
                    <p class="text-gray-600 italic mb-6">"J'ai trouvé exactement ce que je cherchais pour ma chambre. La possibilité de personnaliser les couleurs a fait toute la différence !"</p>
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-full overflow-hidden">
                            <img src="{{ asset('images/testimonials/sophie.jpg') }}" alt="Sophie Martin" class="w-full h-full object-cover">
                        </div>
                        <div>
                            <h4 class="font-heading font-semibold">Sophie Martin</h4>
                            <p class="text-gray-600 text-sm">Cliente</p>
                            <div class="text-secondary mt-1">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white p-8 rounded-lg shadow-custom">
                    <p class="text-gray-600 italic mb-6">"En tant que designer, cette plateforme m'a permis de toucher un public plus large et de vendre mes créations de manière simple et efficace."</p>
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-full overflow-hidden">
                            <img src="{{ asset('images/testimonials/thomas.jpg') }}" alt="Thomas Durand" class="w-full h-full object-cover">
                        </div>
                        <div>
                            <h4 class="font-heading font-semibold">Thomas Durand</h4>
                            <p class="text-gray-600 text-sm">Designer</p>
                            <div class="text-secondary mt-1">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star-half-alt"></i>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white p-8 rounded-lg shadow-custom">
                    <p class="text-gray-600 italic mb-6">"La qualité des papiers peints est impressionnante et le service client est exceptionnel. Je recommande vivement !"</p>
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-full overflow-hidden">
                            <img src="{{ asset('images/testimonials/julie.jpg') }}" alt="Julie Lefevre" class="w-full h-full object-cover">
                        </div>
                        <div>
                            <h4 class="font-heading font-semibold">Julie Lefevre</h4>
                            <p class="text-gray-600 text-sm">Décoratrice d'intérieur</p>
                            <div class="text-secondary mt-1">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Newsletter -->
    <section class="py-12 md:py-16 bg-primary text-white">
        <div class="container mx-auto px-4">
            <div class="flex flex-col md:flex-row justify-between items-center gap-8">
                <div class="md:w-1/2">
                    <h2 class="font-heading text-3xl font-bold mb-4">Restez Informé</h2>
                    <p class="text-white/90 max-w-lg">Inscrivez-vous à notre newsletter pour recevoir les dernières tendances et offres exclusives.</p>
                </div>
                <div class="md:w-1/2">
                    <form class="flex flex-col sm:flex-row gap-4 w-full max-w-md">
                        <input type="email" class="flex-1 px-5 py-3 rounded-full border-none focus:outline-none text-dark" placeholder="Votre email">
                        <button type="submit" class="px-6 py-3 rounded-full font-semibold bg-secondary text-white hover:bg-secondary/90 transition-all">S'inscrire</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection