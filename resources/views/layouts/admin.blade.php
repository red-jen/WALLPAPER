<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Admin Dashboard') - {{ config('app.name', 'MurArt') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@500;600;700&family=Montserrat:wght@300;400;500;600&family=Libre+Baskerville:ital@0;1&display=swap" rel="stylesheet">
    
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    
    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.12.0/dist/cdn.min.js" defer></script>
    <script src="https://cdn.tailwindcss.com"></script>
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'navy': '#2C3E50',
                        'navy-light': '#34495E',
                        'gold': '#D4AF37',
                        'gold-light': '#E6C65C',
                        'sage': '#7D8E7B',
                        'ivory': '#F8F3E6',
                        'charcoal': '#2F353B',
                        'terracotta': '#C67D5C',
                    },
                    fontFamily: {
                        'heading': ['Cormorant Garamond', 'serif'],
                        'sans': ['Montserrat', 'sans-serif'],
                        'serif': ['Libre Baskerville', 'serif'],
                    },
                    boxShadow: {
                        'inner-lg': 'inset 0 2px 4px 0 rgba(0, 0, 0, 0.06)'
                    }
                }
            }
        }
    </script>
    
    @vite(['resources/js/app.js'])
    
    <!-- Styles -->
    @yield('styles')
</head>
<body class="font-sans antialiased bg-gray-50">
    <div x-data="{ sidebarOpen: window.Alpine?.store?.('sidebar')?.open ?? window.innerWidth >= 1024 }" 
         x-init="$watch('sidebarOpen', value => { if(window.Alpine?.store) Alpine.store('sidebar', { open: value }); })" 
         class="flex h-screen bg-gray-50">
        <!-- Mobile Sidebar Backdrop -->
        <div 
            x-show="sidebarOpen" 
            @click="sidebarOpen = false" 
            class="fixed inset-0 z-40 bg-black bg-opacity-50 transition-opacity lg:hidden"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-300"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
        ></div>
        
        <!-- Sidebar -->
        <div 
            class="fixed inset-y-0 left-0 z-50 w-64 transform bg-gradient-to-b from-navy to-navy-light text-white transition duration-300 ease-in-out lg:relative lg:inset-auto lg:z-auto flex flex-col"
            :class="{'translate-x-0': sidebarOpen, '-translate-x-full': !sidebarOpen, 'lg:translate-x-0': true}"
        >
            <!-- Logo & Toggle -->
            <div class="flex h-16 items-center justify-between px-4 border-b border-white/10">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-gold/20 flex items-center justify-center text-gold animate-pulse">
                        <i class="fas fa-paint-brush"></i>
                    </div>
                    <span class="font-heading text-xl font-bold text-white">MurArt</span>
                </a>
                <button 
                    @click="sidebarOpen = false" 
                    class="text-white hover:text-gold lg:hidden transition-colors duration-200"
                >
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <!-- User Info -->
            <div class="flex-shrink-0 border-b border-white/10 p-4 bg-navy-light/30">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-gold/20 flex items-center justify-center text-gold">
                        <i class="fas fa-user"></i>
                    </div>
                    <div>
                        <h4 class="font-medium text-white">{{ auth()->user()->name }}</h4>
                        <div class="flex items-center text-xs text-white/70">
                            <span class="inline-block w-2 h-2 rounded-full bg-green-400 mr-1.5"></span>
                            {{ ucfirst(auth()->user()->role ?? 'User') }}
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Navigation - THIS IS THE SCROLLABLE SECTION -->
            <div class="flex-grow flex flex-col min-h-0">
                <div class="py-2 overflow-y-auto scrollbar-thin scrollbar-thumb-white/20 scrollbar-track-transparent flex-grow">
                    <!-- Dashboard Link -->
                    <div class="px-3 py-2">
                        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-md mb-1 {{ request()->routeIs('admin.dashboard') ? 'bg-gold text-navy font-medium shadow-sm' : 'text-white hover:bg-white/10' }} transition-colors duration-200">
                            <i class="fas fa-tachometer-alt w-5 text-center"></i>
                            <span>Dashboard</span>
                        </a>
                    </div>
                    
                    <!-- Main Navigation Groups -->
                    <div class="mt-2 px-3 space-y-6">
                        <!-- Content Management Group -->
                        <div>
                            <h5 class="text-xs uppercase tracking-wider text-gold font-semibold px-3 mb-3">Content</h5>
                            
                            <!-- Designs -->
                            <div x-data="{ subMenuOpen: {{ request()->routeIs('designer.designs.*') || request()->routeIs('admin.designs.*') ? 'true' : 'false' }} }" class="mb-1.5">
                                <button @click="subMenuOpen = !subMenuOpen" class="w-full flex items-center justify-between px-3 py-2 rounded-md {{ request()->routeIs('designer.designs.*') || request()->routeIs('admin.designs.*') ? 'bg-white/10 text-gold' : 'text-white hover:bg-white/10' }} transition-colors duration-200">
                                    <div class="flex items-center gap-3">
                                        <i class="fas fa-palette w-5 text-center"></i>
                                        <span>Designs</span>
                                    </div>
                                    <i :class="subMenuOpen ? 'fa-chevron-down' : 'fa-chevron-right'" class="fas text-xs transition-transform duration-200"></i>
                                </button>
                                
                                <div x-show="subMenuOpen" x-collapse x-cloak class="pl-8 pr-3 py-1 space-y-1">
                                    @if(auth()->user()->hasRole('admin'))
                                        <a href="{{ route('admin.designs.index') }}" class="block px-3 py-1.5 rounded-md text-sm {{ request()->routeIs('admin.designs.index') ? 'bg-white/10 text-gold' : 'text-white hover:bg-white/5' }} transition-colors duration-150">
                                            All Designs
                                        </a>
                                    @endif
                                    
                                    @if(auth()->user()->hasRole('designer'))
                                        <a href="{{ route('designer.designs.index') }}" class="block px-3 py-1.5 rounded-md text-sm {{ request()->routeIs('designer.designs.index') ? 'bg-white/10 text-gold' : 'text-white hover:bg-white/5' }} transition-colors duration-150">
                                            My Designs
                                        </a>
                                        <a href="{{ route('designer.designs.create') }}" class="block px-3 py-1.5 rounded-md text-sm {{ request()->routeIs('designer.designs.create') ? 'bg-white/10 text-gold' : 'text-white hover:bg-white/5' }} transition-colors duration-150">
                                            Create Design
                                        </a>
                                    @endif
                                </div>
                            </div>
                            
                            <!-- Wallpapers (Admin only) -->
                            @if(auth()->user()->hasRole('admin'))
                            <div x-data="{ subMenuOpen: {{ request()->routeIs('admin.wallpapers.*') ? 'true' : 'false' }} }" class="mb-1.5">
                                <button @click="subMenuOpen = !subMenuOpen" class="w-full flex items-center justify-between px-3 py-2 rounded-md {{ request()->routeIs('admin.wallpapers.*') ? 'bg-white/10 text-gold' : 'text-white hover:bg-white/10' }} transition-colors duration-200">
                                    <div class="flex items-center gap-3">
                                        <i class="fas fa-images w-5 text-center"></i>
                                        <span>Wallpapers</span>
                                    </div>
                                    <i :class="subMenuOpen ? 'fa-chevron-down' : 'fa-chevron-right'" class="fas text-xs transition-transform duration-200"></i>
                                </button>
                                
                                <div x-show="subMenuOpen" x-collapse x-cloak class="pl-8 pr-3 py-1 space-y-1">
                                    <a href="{{ route('admin.wallpapers.index') }}" class="block px-3 py-1.5 rounded-md text-sm {{ request()->routeIs('admin.wallpapers.index') ? 'bg-white/10 text-gold' : 'text-white hover:bg-white/5' }} transition-colors duration-150">
                                        All Wallpapers
                                    </a>
                                    <a href="{{ route('admin.wallpapers.create') }}" class="block px-3 py-1.5 rounded-md text-sm {{ request()->routeIs('admin.wallpapers.create') ? 'bg-white/10 text-gold' : 'text-white hover:bg-white/5' }} transition-colors duration-150">
                                        Create Wallpaper
                                    </a>
                                </div>
                            </div>
                            @endif

                            <!-- Categories (Admin only) -->
                            @if(auth()->user()->hasRole('admin'))
                            <a href="{{ route('admin.categories.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-md mb-1.5 {{ request()->routeIs('admin.categories.*') ? 'bg-white/10 text-gold' : 'text-white hover:bg-white/10' }} transition-colors duration-200">
                                <i class="fas fa-tags w-5 text-center"></i>
                                <span>Categories</span>
                            </a>
                            @endif
                            
                            <!-- Papers Management (Admin only) -->
                            @if(auth()->user()->hasRole('admin'))
                            <div x-data="{ subMenuOpen: {{ request()->routeIs('admin.papers.*') ? 'true' : 'false' }} }" class="mb-1.5">
                                <button @click="subMenuOpen = !subMenuOpen" class="w-full flex items-center justify-between px-3 py-2 rounded-md {{ request()->routeIs('admin.papers.*') ? 'bg-white/10 text-gold' : 'text-white hover:bg-white/10' }} transition-colors duration-200">
                                    <div class="flex items-center gap-3">
                                        <i class="fas fa-scroll w-5 text-center"></i>
                                        <span>Papers</span>
                                    </div>
                                    <i :class="subMenuOpen ? 'fa-chevron-down' : 'fa-chevron-right'" class="fas text-xs transition-transform duration-200"></i>
                                </button>
                                
                                <div x-show="subMenuOpen" x-collapse x-cloak class="pl-8 pr-3 py-1 space-y-1">
                                    <a href="{{ route('admin.papers.index') }}" class="block px-3 py-1.5 rounded-md text-sm {{ request()->routeIs('admin.papers.index') ? 'bg-white/10 text-gold' : 'text-white hover:bg-white/5' }} transition-colors duration-150">
                                        All Papers
                                    </a>
                                    <a href="{{ route('admin.papers.create') }}" class="block px-3 py-1.5 rounded-md text-sm {{ request()->routeIs('admin.papers.create') ? 'bg-white/10 text-gold' : 'text-white hover:bg-white/5' }} transition-colors duration-150">
                                        Add New Paper
                                    </a>
                                </div>
                            </div>
                            @endif

                            <!-- Artworks Management (Admin only) -->
                            @if(auth()->user()->hasRole('admin'))
                            <div x-data="{ subMenuOpen: {{ request()->routeIs('admin.artworks.*') ? 'true' : 'false' }} }" class="mb-1.5">
                                <button @click="subMenuOpen = !subMenuOpen" class="w-full flex items-center justify-between px-3 py-2 rounded-md {{ request()->routeIs('admin.artworks.*') ? 'bg-white/10 text-gold' : 'text-white hover:bg-white/10' }} transition-colors duration-200">
                                    <div class="flex items-center gap-3">
                                        <i class="fas fa-image w-5 text-center"></i>
                                        <span>Artworks</span>
                                    </div>
                                    <i :class="subMenuOpen ? 'fa-chevron-down' : 'fa-chevron-right'" class="fas text-xs transition-transform duration-200"></i>
                                </button>
                                
                                <div x-show="subMenuOpen" x-collapse x-cloak class="pl-8 pr-3 py-1 space-y-1">
                                    <a href="{{ route('admin.artworks.index') }}" class="block px-3 py-1.5 rounded-md text-sm {{ request()->is('admin/artworks') && !request()->hasAny(['status', 'preview', 'production']) ? 'bg-white/10 text-gold' : 'text-white hover:bg-white/5' }} transition-colors duration-150">
                                        All Artworks
                                    </a>
                                    <a href="{{ route('admin.artworks.index') }}?preview=pending" class="block px-3 py-1.5 rounded-md text-sm {{ request()->is('admin/artworks') && request()->query('preview') == 'pending' ? 'bg-white/10 text-gold' : 'text-white hover:bg-white/5' }} transition-colors duration-150">
                                        <div class="flex justify-between items-center">
                                            <span>Pending Previews</span>
                                            @if(isset($pendingPreviews) && $pendingPreviews > 0)
                                                <span class="bg-yellow-400 text-navy text-xs font-bold px-1.5 py-0.5 rounded-full">{{ $pendingPreviews }}</span>
                                            @endif
                                        </div>
                                    </a>
                                    <a href="{{ route('admin.artworks.index') }}?preview=rejected" class="block px-3 py-1.5 rounded-md text-sm {{ request()->is('admin/artworks') && request()->query('preview') == 'rejected' ? 'bg-white/10 text-gold' : 'text-white hover:bg-white/5' }} transition-colors duration-150">
                                        <div class="flex justify-between items-center">
                                            <span>Rejected Previews</span>
                                            @if(isset($rejectedPreviews) && $rejectedPreviews > 0)
                                                <span class="bg-red-400 text-white text-xs font-bold px-1.5 py-0.5 rounded-full">{{ $rejectedPreviews }}</span>
                                            @endif
                                        </div>
                                    </a>
                                    <a href="{{ route('admin.artworks.index') }}?production=queued" class="block px-3 py-1.5 rounded-md text-sm {{ request()->is('admin/artworks') && request()->query('production') == 'queued' ? 'bg-white/10 text-gold' : 'text-white hover:bg-white/5' }} transition-colors duration-150">
                                        Production Queue
                                    </a>
                                </div>
                            </div>
                            @endif
                        </div>
                        
                        <!-- Sales & Orders Group (Admin only) -->
                        @if(auth()->user()->hasRole('admin'))
                        <div>
                            <h5 class="text-xs uppercase tracking-wider text-gold font-semibold px-3 mb-3">Sales</h5>
                            
                            <a href="{{ route('admin.orders.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-md mb-1.5 {{ request()->routeIs('admin.orders.*') ? 'bg-white/10 text-gold' : 'text-white hover:bg-white/10' }} transition-colors duration-200">
                                <i class="fas fa-shopping-cart w-5 text-center"></i>
                                <span>Orders</span>
                                @if(isset($pendingOrders) && $pendingOrders > 0)
                                    <span class="ml-auto bg-yellow-400 text-navy text-xs font-bold px-1.5 py-0.5 rounded-full">{{ $pendingOrders }}</span>
                                @endif
                            </a>
                            
                            <a href="{{ route('admin.reviews.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-md mb-1.5 {{ request()->routeIs('admin.reviews.*') ? 'bg-white/10 text-gold' : 'text-white hover:bg-white/10' }} transition-colors duration-200">
                                <i class="fas fa-star w-5 text-center"></i>
                                <span>Reviews</span>
                                {{-- @if(isset($pendingReviews) && $pendingReviews > 0)
                                    <span class="ml-auto bg-blue-400 text-white text-xs font-bold px-1.5 py-0.5 rounded-full">{{ $pendingReviews }}</span>
                                @endif --}}
                            </a>
                        </div>
                        @endif
                        
                        <!-- System Group (Admin only) -->
                        @if(auth()->user()->hasRole('admin'))
                        <div>
                            <h5 class="text-xs uppercase tracking-wider text-gold font-semibold px-3 mb-3">System</h5>
                            
                            <a href="{{ route('admin.users.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-md mb-1.5 {{ request()->routeIs('admin.users.*') ? 'bg-white/10 text-gold' : 'text-white hover:bg-white/10' }} transition-colors duration-200">
                                <i class="fas fa-users w-5 text-center"></i>
                                <span>Users</span>
                            </a>
                            
                            <a href="{{ route('admin.settings.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-md mb-1.5 {{ request()->routeIs('admin.settings.*') ? 'bg-white/10 text-gold' : 'text-white hover:bg-white/10' }} transition-colors duration-200">
                                <i class="fas fa-cog w-5 text-center"></i>
                                <span>Settings</span>
                            </a>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            
            <!-- Footer Links -->
            <div class="flex-shrink-0 p-4 border-t border-white/10 bg-navy-light/30">
                {{-- <a href="{{ url('/') }}" class="flex items-center gap-3 px-3 py-2 rounded-md text-white hover:bg-white/10 transition-colors duration-150 mb-2">
                    <i class="fas fa-home w-5 text-center"></i>
                    <span>Visit Site</span>
                </a> --}}
                
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center gap-3 px-3 py-2 rounded-md text-left text-white hover:bg-white/10 transition-colors duration-150">
                        <i class="fas fa-sign-out-alt w-5 text-center"></i>
                        <span>Log Out</span>
                    </button>
                </form>
            </div>
        </div>
        
        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden w-full">
            <!-- Top Navigation Bar -->
            <header class="bg-white shadow-sm z-10">
                <div class="px-4 py-3 flex items-center justify-between">
                    <!-- Mobile Sidebar Toggle -->
                    {{-- <button 
                        @click="sidebarOpen = true" 
                        class="text-gray-500 hover:text-gray-700 focus:outline-none focus:text-gray-700 lg:hidden"
                    >
                        <i class="fas fa-bars"></i>
                    </button>
                     --}}
                    <!-- Page Title -->
                    {{-- <h1 class="text-lg font-medium text-gray-800 hidden sm:block">@yield('title', 'Dashboard')</h1>
                     --}}
                    <!-- Right Nav Items -->
                    <div class="flex items-center gap-4">
                        <!-- Search -->
                        {{-- <div class="hidden md:block relative">
                            <input type="text" placeholder="Search..." class="w-48 lg:w-64 bg-gray-100 text-sm rounded-full px-4 py-1.5 focus:outline-none focus:ring-2 focus:ring-indigo-300">
                            <button class="absolute right-0 top-0 h-full flex items-center pr-3 text-gray-400">
                                <i class="fas fa-search"></i>
                            </button>
                        </div> --}}
                        
                        
                        
                        <!-- User Dropdown -->
                       
                    </div>
                </div>
                
                <!-- Breadcrumbs (optional) -->
                <div class="px-4 py-2 bg-gray-50 border-t border-b border-gray-200">
                    <nav class="text-sm">
                        <ol class="list-none p-0 flex items-center text-gray-500">
                            <li class="flex items-center">
                                <a href="{{ route('admin.dashboard') }}" class="hover:text-gray-700 transition-colors duration-150">Dashboard</a>
                                @if(isset($breadcrumbs))
                                    <svg class="h-4 w-4 mx-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                @endif
                            </li>
                            @if(isset($breadcrumbs))
                                @foreach($breadcrumbs as $breadcrumb)
                                    <li class="flex items-center">
                                        @if(!$loop->last)
                                            <a href="{{ $breadcrumb['url'] }}" class="hover:text-gray-700 transition-colors duration-150">{{ $breadcrumb['label'] }}</a>
                                            <svg class="h-4 w-4 mx-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                            </svg>
                                        @else
                                            <span class="text-gray-700">{{ $breadcrumb['label'] }}</span>
                                        @endif
                                    </li>
                                @endforeach
                            @endif
                        </ol>
                    </nav>
                </div>
            </header>
            
            <!-- Main Content -->
            <main class="flex-1 overflow-y-auto bg-gray-50 p-6">
                @yield('content')
            </main>
        </div>
    </div>

    <style>
        [x-cloak] { display: none !important; }
        
        /* Custom Scrollbar */
        .scrollbar-thin::-webkit-scrollbar {
            width: 4px;
        }
        
        .scrollbar-thin::-webkit-scrollbar-track {
            background: transparent;
        }
        
        .scrollbar-thin::-webkit-scrollbar-thumb {
            background-color: rgba(255, 255, 255, 0.2);
            border-radius: 20px;
        }
        
        /* Firefox scrollbar */
        .scrollbar-thin {
            scrollbar-width: thin;
            scrollbar-color: rgba(255, 255, 255, 0.2) transparent;
        }
        
        /* Fix height issues */
        html, body {
            height: 100%;
            overflow: hidden;
        }
        
        /* Ensure tables display properly */
        .overflow-x-auto {
            max-width: 100%;
        }
        
        /* Fix table layouts */
        table.table-fixed {
            table-layout: fixed;
        }
        
        /* Responsive text handling */
        .break-words {
            word-break: break-word;
        }
        
        /* Fix content overflow in main container */
        main.overflow-y-auto {
            max-height: calc(100vh - 116px); /* Account for header height */
        }
    </style>
    
    <script>
        // Fix for sidebar persistence and mobile height
        document.addEventListener('DOMContentLoaded', function() {
            // Fix for mobile height issues (100vh bug in mobile browsers)
            function setVH() {
                let vh = window.innerHeight * 0.01;
                document.documentElement.style.setProperty('--vh', `${vh}px`);
            }
            
            setVH();
            window.addEventListener('resize', setVH);
            
            // Get stored sidebar state from localStorage
            const storedSidebarState = localStorage.getItem('sidebarOpen');
            
            // Set initial state based on screen size and stored preference
            if (window.Alpine) {
                window.Alpine.store('sidebar', {
                    open: storedSidebarState !== null 
                        ? storedSidebarState === 'true'
                        : window.innerWidth >= 1024
                });
                
                // Update Alpine data binding
                const sidebarComponent = document.querySelector('[x-data]');
                if (sidebarComponent && sidebarComponent.__x) {
                    sidebarComponent.__x.$data.sidebarOpen = window.Alpine.store('sidebar').open;
                }
                
                // Watch for changes to save preference
                window.Alpine.effect(() => {
                    if (window.Alpine.store('sidebar')) {
                        const open = window.Alpine.store('sidebar').open;
                        localStorage.setItem('sidebarOpen', open);
                    }
                });
            }
            
            // Make sure sidebar responds properly to resize
            window.addEventListener('resize', function() {
                if (window.Alpine && window.innerWidth >= 1024) {
                    window.Alpine.store('sidebar', { open: true });
                    const sidebarComponent = document.querySelector('[x-data]');
                    if (sidebarComponent && sidebarComponent.__x) {
                        sidebarComponent.__x.$data.sidebarOpen = true;
                    }
                }
            });
        });
    </script>
    
    @stack('scripts')
</body>
</html>