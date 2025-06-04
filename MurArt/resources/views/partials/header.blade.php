<!-- Modern Header Component -->
<header class="bg-white/95 backdrop-blur-lg border-b border-gray-200/50 sticky top-0 z-50">
    <div class="max-w-7xl mx-auto">
        <div class="flex items-center justify-between h-20 px-4 sm:px-6 lg:px-8">
            
            <!-- Logo Section -->
            <div class="flex items-center">
                <a href="{{ route('home') }}" class="group flex items-center space-x-3">
                    <div class="relative">
                        <div class="w-12 h-12 bg-gradient-to-br from-primary via-secondary to-primary rounded-2xl flex items-center justify-center shadow-lg group-hover:shadow-xl transition-all duration-500 group-hover:scale-110">
                            <img src="{{ asset('imgs/logo.png') }}" alt="MurArt" class="w-8 h-8 object-contain filter brightness-0 invert group-hover:scale-110 transition-transform duration-300">
                        </div>
                        <div class="absolute -inset-1 bg-gradient-to-br from-primary to-secondary rounded-2xl opacity-0 group-hover:opacity-20 blur transition-opacity duration-500"></div>
                    </div>
                    <div class="hidden sm:block">
                        <h1 class="text-2xl font-bold tracking-tight text-gray-900 group-hover:text-primary transition-colors duration-300">
                            Mur<span class="text-primary">Art</span>
                        </h1>
                        <p class="text-xs text-gray-500 -mt-0.5 font-medium tracking-wide">Design & Create</p>
                    </div>
                </a>
            </div>

            <!-- Navigation Links -->
            <nav class="hidden lg:flex items-center space-x-1">
                <a href="{{ route('home') }}" 
                   class="px-4 py-2.5 text-sm font-medium rounded-xl transition-all duration-300 hover:bg-gray-100 {{ request()->routeIs('home') ? 'text-primary bg-primary/10' : 'text-gray-700 hover:text-gray-900' }}">
                    Accueil
                </a>
                <a href="{{ route('shop.index') }}" 
                   class="px-4 py-2.5 text-sm font-medium rounded-xl transition-all duration-300 hover:bg-gray-100 {{ request()->routeIs('shop.*') ? 'text-primary bg-primary/10' : 'text-gray-700 hover:text-gray-900' }}">
                    Boutique
                </a>
                @auth
                <a href="{{ route('designs.index') }}" 
                   class="px-4 py-2.5 text-sm font-medium rounded-xl transition-all duration-300 hover:bg-gray-100 {{ request()->routeIs('designs.*') ? 'text-primary bg-primary/10' : 'text-gray-700 hover:text-gray-900' }}">
                    Designs
                </a>
                <a href="{{ route('artworks.index') }}" 
                   class="px-4 py-2.5 text-sm font-medium rounded-xl transition-all duration-300 hover:bg-gray-100 {{ request()->routeIs('artworks.*') ? 'text-primary bg-primary/10' : 'text-gray-700 hover:text-gray-900' }}">
                    Créations
                </a>
                @endauth
                
                <!-- More Menu -->
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" 
                            class="flex items-center px-4 py-2.5 text-sm font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-100 rounded-xl transition-all duration-300">
                        Plus
                        <svg class="ml-1 w-4 h-4 transition-transform duration-200" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    
                    <div x-show="open" 
                         @click.away="open = false"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 scale-95"
                         x-transition:enter-end="opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="opacity-100 scale-100"
                         x-transition:leave-end="opacity-0 scale-95"
                         class="absolute left-0 mt-3 w-48 bg-white rounded-2xl shadow-lg border border-gray-200/50 py-2 z-50">
                        <a href="{{ route('about') }}" class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 hover:text-primary transition-colors duration-200">
                            <svg class="w-4 h-4 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            À propos
                        </a>
                        <a href="{{ route('contact') }}" class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 hover:text-primary transition-colors duration-200">
                            <svg class="w-4 h-4 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            Contact
                        </a>
                    </div>
                </div>
            </nav>

            <!-- Right Actions -->
            <div class="flex items-center space-x-2">
                
                <!-- Search -->
                <div class="hidden md:block relative" x-data="{ open: false }">
                    <button @click="open = !open" 
                            class="w-10 h-10 flex items-center justify-center text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded-xl transition-all duration-300">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </button>
                    
                    <div x-show="open" 
                         @click.away="open = false"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 scale-95"
                         x-transition:enter-end="opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="opacity-100 scale-100"
                         x-transition:leave-end="opacity-0 scale-95"
                         class="absolute right-0 mt-3 w-80 bg-white rounded-2xl shadow-xl border border-gray-200/50 p-4 z-50">
                        <form action="{{ route('shop.index') }}" method="GET">
                            <div class="relative">
                                <input type="text" 
                                       name="search" 
                                       placeholder="Rechercher des papiers peints..." 
                                       class="w-full pl-10 pr-4 py-3 bg-gray-50 border-0 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/20 focus:bg-white transition-all duration-300">
                                <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Cart -->
                <a href="{{ auth()->check() ? route('client.cart.index') : route('login') }}" 
                   class="relative w-10 h-10 flex items-center justify-center text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded-xl transition-all duration-300 group">
                    <svg class="w-5 h-5 group-hover:scale-110 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    @if(session()->has('cart') && count(session('cart')) > 0)
                    <span class="absolute -top-1 -right-1 w-5 h-5 bg-red-500 text-white text-xs font-bold rounded-full flex items-center justify-center animate-pulse">
                        {{ count(session('cart')) }}
                    </span>
                    @endif
                </a>

                <!-- User Menu -->
                @auth
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" 
                            class="flex items-center space-x-2 pl-3 pr-4 py-2 hover:bg-gray-100 rounded-xl transition-all duration-300 group">
                        <div class="w-8 h-8 bg-gradient-to-br from-primary to-secondary rounded-lg flex items-center justify-center text-white text-sm font-bold shadow-sm group-hover:scale-105 transition-transform duration-300">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                        <span class="hidden sm:block text-sm font-medium text-gray-700 max-w-20 truncate">{{ Auth::user()->name }}</span>
                        <svg class="w-4 h-4 text-gray-400 transition-transform duration-200" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>

                    <div x-show="open" 
                         @click.away="open = false"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 scale-95"
                         x-transition:enter-end="opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="opacity-100 scale-100"
                         x-transition:leave-end="opacity-0 scale-95"
                         class="absolute right-0 mt-3 w-64 bg-white rounded-2xl shadow-xl border border-gray-200/50 overflow-hidden z-50">
                        
                        <!-- User Info Header -->
                        <div class="p-4 bg-gradient-to-br from-primary to-secondary text-white">
                            <div class="flex items-center space-x-3">
                                <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center text-white text-lg font-bold">
                                    {{ substr(Auth::user()->name, 0, 1) }}
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-semibold text-white truncate">{{ Auth::user()->name }}</p>
                                    <p class="text-xs text-white/80 truncate">{{ Auth::user()->email }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Menu Items -->
                        <div class="py-2">
                            @if(Auth::user()->hasRole('admin'))
                            <a href="{{ route('admin.dashboard') }}" 
                               class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 hover:text-primary transition-colors duration-200">
                                <svg class="w-4 h-4 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                </svg>
                                Dashboard Admin
                            </a>
                            @endif

                            @if(Auth::user()->hasRole('designer'))
                            <a href="{{ route('designer.designs.index') }}" 
                               class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 hover:text-primary transition-colors duration-200">
                                <svg class="w-4 h-4 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h4a2 2 0 002-2V9a2 2 0 00-2-2H7a2 2 0 00-2 2v6a2 2 0 002 2z"/>
                                </svg>
                                Designs Manager
                            </a>
                            @endif

                            <a href="{{ route('client.dashboard') }}" 
                               class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 hover:text-primary transition-colors duration-200">
                                <svg class="w-4 h-4 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                                Mon Compte
                            </a>

                            <a href="{{ route('client.orders.index') }}" 
                               class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 hover:text-primary transition-colors duration-200">
                                <svg class="w-4 h-4 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                                </svg>
                                Mes Commandes
                            </a>

                            <a href="{{ route('artworks.index') }}" 
                               class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 hover:text-primary transition-colors duration-200">
                                <svg class="w-4 h-4 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                Mes Créations
                            </a>

                            <a href="{{ route('client.cart.index') }}" 
                               class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 hover:text-primary transition-colors duration-200">
                                <svg class="w-4 h-4 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                                </svg>
                                Mon Panier
                                @if(session()->has('cart') && count(session('cart')) > 0)
                                <span class="ml-auto w-5 h-5 bg-red-500 text-white text-xs font-bold rounded-full flex items-center justify-center">{{ count(session('cart')) }}</span>
                                @endif
                            </a>
                        </div>

                        <div class="border-t border-gray-100"></div>
                        
                        <form action="{{ route('logout') }}" method="POST" class="m-0">
                            @csrf
                            <button type="submit" 
                                    class="flex items-center w-full px-4 py-3 text-sm text-gray-700 hover:bg-red-50 hover:text-red-600 transition-colors duration-200">
                                <svg class="w-4 h-4 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                </svg>
                                Déconnexion
                            </button>
                        </form>
                    </div>
                </div>
                @else
                <!-- Guest Actions -->
                <div class="flex items-center space-x-2">
                    <a href="{{ route('login') }}" 
                       class="px-4 py-2 text-sm font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-100 rounded-xl transition-all duration-300">
                        Connexion
                    </a>
                    <a href="{{ route('registerform') }}" 
                       class="px-4 py-2 bg-primary text-white text-sm font-medium rounded-xl hover:bg-primary/90 hover:shadow-md transition-all duration-300">
                        Inscription
                    </a>
                </div>
                @endauth

                <!-- Mobile Menu Button -->
                <button id="mobile-menu-button" 
                        class="lg:hidden w-10 h-10 flex items-center justify-center text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded-xl transition-all duration-300">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Search -->
    <div class="lg:hidden border-t border-gray-200/50 p-4">
        <form action="{{ route('shop.index') }}" method="GET">
            <div class="relative">
                <input type="text" 
                       name="search" 
                       placeholder="Rechercher..." 
                       class="w-full pl-10 pr-4 py-3 bg-gray-50 border-0 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/20 focus:bg-white transition-all duration-300">
                <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </div>
        </form>
    </div>
</header>

<!-- Featured Categories Bar (Optional) -->
@if(isset($featuredCategories) && count($featuredCategories) > 0)
<div class="bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200 hidden lg:block">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-center space-x-8 py-2 overflow-x-auto">
            @foreach($featuredCategories as $category)
            <a href="{{ route('shop.index', ['category' => $category->id]) }}" 
               class="text-sm text-gray-600 hover:text-primary transition-colors duration-200 whitespace-nowrap font-medium">
                {{ $category->name }}
            </a>
            @endforeach
        </div>
    </div>
</div>
@endif