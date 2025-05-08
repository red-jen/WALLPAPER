<!-- Header Component -->
<header class="bg-white shadow-sm sticky top-0 z-40">
    <div class="container mx-auto px-4 py-2">
        <div class="flex items-center justify-between">
            <!-- Logo and Brand -->
            <div class="flex items-center">
                <a href="{{ route('home') }}" class="flex items-center">
                    <img src="{{ asset('imgs/logo.png') }}" alt="MurArt Logo" class="h-14 mr-3">
                </a>
            </div>
            
            <!-- Desktop Navigation -->
            <nav class="hidden md:flex items-center space-x-8">
                <a href="{{ route('home') }}" class="font-heading font-medium hover:text-primary transition {{ request()->routeIs('home') ? 'text-primary' : '' }}">Home</a>
                <a href="{{ route('shop.index') }}" class="font-heading font-medium hover:text-primary transition {{ request()->routeIs('shop.*') ? 'text-primary' : '' }}">Shop</a>
                
                @auth
                <a href="{{ route('designs.index') }}" class="font-heading font-medium hover:text-primary transition {{ request()->routeIs('designs.*') ? 'text-primary' : '' }}">Designs</a>
                <a href="{{ route('artworks.index') }}" class="font-heading font-medium hover:text-primary transition {{ request()->routeIs('artworks.*') ? 'text-primary' : '' }}">My Creations</a>
                @endauth
                
                <div class="relative" x-data="{ open: false }" @click.away="open = false">
                    <button @click="open = !open" class="font-heading font-medium hover:text-primary transition flex items-center">
                        More
                        <svg class="w-4 h-4 ml-1" :class="{'transform rotate-180': open}" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div x-show="open" class="absolute left-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-10">
                        <a href="{{ route('about') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">About Us</a>
                        <a href="{{ route('contact') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Contact</a>
                        @if(Route::has('faq'))
                            <a href="{{ route('faq') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">FAQ</a>
                        @endif
                    </div>
                </div>
            </nav>
            
            <!-- User Actions -->
            <div class="flex items-center space-x-4">
                <!-- Search Button -->
                <div class="hidden sm:block relative" x-data="{ open: false }">
                    <button @click="open = !open" class="text-dark hover:text-primary transition p-2">
                        <i class="fas fa-search"></i>
                    </button>
                    <!-- Search Dropdown -->
                    <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-64 bg-white rounded-md shadow-lg p-2 z-20">
                        <form action="{{ route('shop.index') }}" method="GET" class="flex">
                            <input type="text" name="search" placeholder="Search..." class="w-full px-3 py-2 border border-gray-300 rounded-l-md focus:outline-none focus:ring-2 focus:ring-secondary">
                            <button type="submit" class="px-3 py-2 bg-secondary text-white rounded-r-md hover:bg-primary transition">
                                <i class="fas fa-search"></i>
                            </button>
                        </form>
                    </div>
                </div>
                
                <!-- Cart -->
                <a href="{{ auth()->check() ? route('client.cart.index') : route('login') }}" class="text-dark hover:text-primary transition relative p-2">
                    <i class="fas fa-shopping-cart"></i>
                    @if(session()->has('cart') && count(session('cart')) > 0)
                    <span class="absolute -top-1 -right-1 w-5 h-5 rounded-full bg-primary text-white text-xs flex items-center justify-center">
                        {{ count(session('cart')) }}
                    </span>
                    @endif
                </a>
                
                <!-- User Account -->
                @auth
                <div class="relative" x-data="{ open: false }" @click.away="open = false">
                    <button @click="open = !open" class="text-dark hover:text-primary transition flex items-center p-1">
                        <i class="fas fa-user-circle mr-1 text-lg"></i>
                        <span class="hidden sm:inline-block text-sm max-w-[100px] truncate">{{ Auth::user()->name }}</span>
                        <svg class="w-4 h-4 ml-1" :class="{'transform rotate-180': open}" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div x-show="open" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-20">
                        @if(Auth::user()->hasRole('admin'))
                        <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            <i class="fas fa-tachometer-alt mr-2"></i>Admin Dashboard
                        </a>
                        @endif
                        @if(Auth::user()->hasRole('designer'))
                        <a href="{{ route('designer.designs.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            <i class="fas fa-palette mr-2"></i>My Designs
                        </a>
                        @endif
                        <a href="{{ route('client.dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            <i class="fas fa-user mr-2"></i>My Account
                        </a>
                        <a href="{{ route('client.orders.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            <i class="fas fa-shopping-bag mr-2"></i>My Orders
                        </a>
                        <a href="{{ route('artworks.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            <i class="fas fa-images mr-2"></i>My Creations
                        </a>
                        <div class="border-t border-gray-100 my-1"></div>
                        <a href="{{ route('logout') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            <i class="fas fa-sign-out-alt mr-2"></i>Logout
                        </a>
                    </div>
                </div>
                @else
                <div class="relative" x-data="{ open: false }" @click.away="open = false">
                    <button @click="open = !open" class="text-dark hover:text-primary transition p-2">
                        <i class="fas fa-user-circle text-lg"></i>
                    </button>
                    <div x-show="open" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-20">
                        <a href="{{ route('login') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            <i class="fas fa-sign-in-alt mr-2"></i>Login
                        </a>
                        <a href="{{ route('registerform') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            <i class="fas fa-user-plus mr-2"></i>Register
                        </a>
                    </div>
                </div>
                @endauth
                
                <!-- Mobile Menu Button -->
                <button id="mobile-menu-button" class="md:hidden text-dark hover:text-primary focus:outline-none p-2">
                    <i class="fas fa-bars text-xl"></i>
                </button>
            </div>
        </div>
    </div>
    
    <!-- Mobile Search (visible only on small screens) -->
    <div class="sm:hidden bg-gray-100 py-2 px-4">
        <form action="{{ route('shop.index') }}" method="GET" class="flex">
            <input type="text" name="search" placeholder="Search..." class="w-full px-3 py-2 text-sm border border-gray-300 rounded-l-md focus:outline-none focus:ring-2 focus:ring-secondary">
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