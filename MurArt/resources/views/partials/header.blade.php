<!-- Header Component -->
<header class="bg-white shadow-sm sticky top-0 z-40">
    <div class="container mx-auto px-4 py-3">
        <div class="flex items-center justify-between">
            <!-- Logo and Brand -->
            <div class="flex items-center">
                <a href="{{ route('home') }}" class="flex items-center">
                    <div class="mr-3">
                        <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M20 0C8.954 0 0 8.954 0 20C0 31.046 8.954 40 20 40C31.046 40 40 31.046 40 20C40 8.954 31.046 0 20 0ZM20 6C25.514 6 30 10.486 30 16C30 21.514 25.514 26 20 26C14.486 26 10 21.514 10 16C10 10.486 14.486 6 20 6Z" fill="#6C9BCF"/>
                            <path d="M20 12C17.791 12 16 13.791 16 16C16 18.209 17.791 20 20 20C22.209 20 24 18.209 24 16C24 13.791 22.209 12 20 12Z" fill="#FFA500"/>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-2xl font-heading font-bold">Mur<span class="text-primary">Art</span></h1>
                        <p class="text-xs text-gray-500 -mt-1">Papiers Peints Personnalisables</p>
                    </div>
                </a>
            </div>
            
            <!-- Desktop Navigation -->
            <nav class="hidden md:flex items-center space-x-8">
                <a href="{{ route('home') }}" class="font-heading font-medium hover:text-primary transition {{ request()->routeIs('home') ? 'text-primary' : '' }}">Accueil</a>
                <a href="{{ route('shop.index') }}" class="font-heading font-medium hover:text-primary transition {{ request()->routeIs('shop.*') ? 'text-primary' : '' }}">Boutique</a>
                
                @auth
                <a href="{{ route('designs.index') }}" class="font-heading font-medium hover:text-primary transition {{ request()->routeIs('designs.*') ? 'text-primary' : '' }}">Designs</a>
                <a href="{{ route('artworks.index') }}" class="font-heading font-medium hover:text-primary transition {{ request()->routeIs('artworks.*') ? 'text-primary' : '' }}">Mes Créations</a>
                @endauth
                
                <div class="relative group">
                    <button class="font-heading font-medium hover:text-primary transition flex items-center">
                        Plus
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div class="absolute left-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-10 hidden group-hover:block">
                        <a href="{{ route('about') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">À propos</a>
                        <a href="{{ route('contact') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Contact</a>
                        @if(Route::has('faq'))
                            <a href="{{ route('faq') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">FAQ</a>
                        @endif
                    </div>
                </div>
            </nav>
            
            <!-- User Actions -->
            <div class="flex items-center space-x-5">
                <!-- Search Button -->
                <div class="hidden sm:block relative" x-data="{ open: false }">
                    <button @click="open = !open" class="text-dark hover:text-primary transition">
                        <i class="fas fa-search"></i>
                    </button>
                    <!-- Search Dropdown -->
                    <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-64 bg-white rounded-md shadow-lg p-2 z-20">
                        <form action="{{ route('shop.index') }}" method="GET" class="flex">
                            <input type="text" name="search" placeholder="Rechercher..." class="w-full px-3 py-2 border border-gray-300 rounded-l-md focus:outline-none focus:ring-2 focus:ring-secondary">
                            <button type="submit" class="px-3 py-2 bg-secondary text-white rounded-r-md hover:bg-primary transition">
                                <i class="fas fa-search"></i>
                            </button>
                        </form>
                    </div>
                </div>
                
                <!-- Cart -->
                <a href="{{ auth()->check() ? route('client.cart.index') : route('login') }}" class="text-dark hover:text-primary transition relative">
                    <i class="fas fa-shopping-cart"></i>
                    @if(session()->has('cart') && count(session('cart')) > 0)
                    <span class="absolute -top-2 -right-2 w-5 h-5 rounded-full bg-primary text-white text-xs flex items-center justify-center">
                        {{ count(session('cart')) }}
                    </span>
                    @endif
                </a>
                
                <!-- User Account -->
                @auth
                <div class="relative group">
                    <button class="text-dark hover:text-primary transition flex items-center">
                        <i class="fas fa-user-circle mr-1"></i>
                        <span class="hidden sm:inline-block">{{ Str::limit(Auth::user()->name, 10) }}</span>
                    </button>
                    <div class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-10 hidden group-hover:block">
                        @if(Auth::user()->hasRole('admin'))
                        <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            <i class="fas fa-tachometer-alt mr-2"></i>Dashboard Admin
                        </a>
                        @endif
                        @if(Auth::user()->hasRole('designer'))
                        <a href="{{ route('designer.designs.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            <i class="fas fa-palette mr-2"></i>Mes Designs
                        </a>
                        @endif
                        <a href="{{ route('client.dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            <i class="fas fa-user mr-2"></i>Mon Compte
                        </a>
                        <a href="{{ route('artworks.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            <i class="fas fa-images mr-2"></i>Mes Créations
                        </a>
                        <a href="{{ route('logout') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            <i class="fas fa-sign-out-alt mr-2"></i>Déconnexion
                        </a>
                    </div>
                </div>
                @else
                <div class="relative group">
                    <button class="text-dark hover:text-primary transition">
                        <i class="fas fa-user-circle"></i>
                    </button>
                    <div class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-10 hidden group-hover:block">
                        <a href="{{ route('login') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            <i class="fas fa-sign-in-alt mr-2"></i>Connexion
                        </a>
                        <a href="{{ route('registerform') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            <i class="fas fa-user-plus mr-2"></i>Inscription
                        </a>
                    </div>
                </div>
                @endauth
                
                <!-- Mobile Menu Button -->
                <button id="mobile-menu-button" class="md:hidden text-dark hover:text-primary focus:outline-none">
                    <i class="fas fa-bars text-xl"></i>
                </button>
            </div>
        </div>
    </div>
    
    <!-- Mobile Search (visible only on small screens) -->
    <div class="sm:hidden bg-gray-100 py-2 px-4">
        <form action="{{ route('shop.index') }}" method="GET" class="flex">
            <input type="text" name="search" placeholder="Rechercher..." class="w-full px-3 py-2 text-sm border border-gray-300 rounded-l-md focus:outline-none focus:ring-2 focus:ring-secondary">
            <button type="submit" class="px-3 py-2 bg-secondary text-white rounded-r-md hover:bg-primary transition">
                <i class="fas fa-search"></i>
            </button>
        </form>
    </div>
</header>

<!-- Sub-navigation for featured categories (optional) -->
@if(isset($featuredCategories) && count($featuredCategories) > 0)
<div class="bg-gray-100 py-2 hidden md:block">
    <div class="container mx-auto px-4">
        <div class="flex items-center justify-center space-x-6 overflow-x-auto pb-1">
            @foreach($featuredCategories as $category)
            <a href="{{ route('shop.index', ['category' => $category->id]) }}" class="text-sm hover:text-primary transition whitespace-nowrap">
                {{ $category->name }}
            </a>
            @endforeach
        </div>
    </div>
</div>
@endif