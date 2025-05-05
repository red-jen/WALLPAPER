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
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@500;600;700&family=Montserrat:wght@300;400;500&family=Libre+Baskerville:ital@0;1&display=swap" rel="stylesheet">
    
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
                        'gold': '#D4AF37',
                        'sage': '#7D8E7B',
                        'ivory': '#F8F3E6',
                        'charcoal': '#2F353B',
                        'terracotta': '#C67D5C',
                    },
                    fontFamily: {
                        'heading': ['Cormorant Garamond', 'serif'],
                        'sans': ['Montserrat', 'sans-serif'],
                        'serif': ['Libre Baskerville', 'serif'],
                    }
                }
            }
        }
    </script>
    
    @vite(['resources/js/app.js'])
    
    <!-- Styles -->
    @yield('styles')
</head>
<body class="font-sans antialiased bg-ivory">
    <div x-data="{ sidebarOpen: window.innerWidth >= 1024 }" class="flex h-screen bg-ivory">
        <!-- Mobile Sidebar Backdrop -->
        <div 
            x-show="sidebarOpen" 
            @click="sidebarOpen = false" 
            class="fixed inset-0 z-20 bg-black bg-opacity-50 transition-opacity lg:hidden"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-300"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
        ></div>
        
        <!-- Sidebar -->
        <div 
            x-cloak
            :class="{'translate-x-0': sidebarOpen, '-translate-x-full': !sidebarOpen, 'lg:translate-x-0': true}"
            class="fixed top-0 left-0 z-30 h-full w-64 transform bg-navy text-white transition-transform duration-300 ease-in-out lg:relative lg:inset-0"
        >
            <!-- Logo & Toggle -->
            <div class="flex h-16 items-center justify-between px-4 border-b border-white/10">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-gold/20 flex items-center justify-center text-gold">
                        <i class="fas fa-paint-brush"></i>
                    </div>
                    <span class="font-heading text-xl font-bold text-white">MurArt</span>
                </a>
                <button 
                    @click="sidebarOpen = false" 
                    class="text-white hover:text-gold lg:hidden"
                >
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <!-- User Info -->
            <div class="border-b border-white/10 p-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-gold/20 flex items-center justify-center text-gold">
                        <i class="fas fa-user"></i>
                    </div>
                    <div>
                        <h4 class="font-medium text-white">{{ auth()->user()->name }}</h4>
                        <p class="text-xs text-white/70">{{ ucfirst(auth()->user()->role ?? 'User') }}</p>
                    </div>
                </div>
            </div>
            
            <!-- Navigation -->
            <div class="py-4 overflow-y-auto">
                <div class="px-3">
                    <h5 class="text-xs uppercase tracking-wider text-white/50 font-semibold px-3 mb-2">Dashboard</h5>
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-3 py-2 rounded-md mb-1 {{ request()->routeIs('admin.dashboard') ? 'bg-gold text-navy' : 'text-white hover:bg-white/10' }}">
                        <i class="fas fa-tachometer-alt w-5 text-center"></i>
                        <span>Dashboard</span>
                    </a>
                </div>
                
                <!-- Content Management -->
                <div class="mt-6 px-3">
                    <h5 class="text-xs uppercase tracking-wider text-white/50 font-semibold px-3 mb-2">Content</h5>
                    
                    <!-- Designs -->
                    <div x-data="{ subMenuOpen: {{ request()->routeIs('designer.designs.*') ? 'true' : 'false' }} }">
                        <button @click="subMenuOpen = !subMenuOpen" class="w-full flex items-center justify-between px-3 py-2 rounded-md {{ request()->routeIs('designer.designs.*') ? 'bg-white/10 text-gold' : 'text-white hover:bg-white/10' }}">
                            <div class="flex items-center gap-3">
                                <i class="fas fa-paint-brush w-5 text-center"></i>
                                <span>My Designs</span>
                            </div>
                            <i :class="subMenuOpen ? 'fa-chevron-down' : 'fa-chevron-right'" class="fas text-xs"></i>
                        </button>
                        
                        <div x-show="subMenuOpen" x-collapse class="pl-8 pr-3 py-2 space-y-1">
                            <a href="{{ route('designer.designs.index') }}" class="block px-3 py-1.5 rounded-md text-sm {{ request()->routeIs('designer.designs.index') ? 'bg-white/10 text-gold' : 'text-white hover:bg-white/5' }}">
                                All Designs
                            </a>
                            <a href="{{ route('designer.designs.create') }}" class="block px-3 py-1.5 rounded-md text-sm {{ request()->routeIs('designer.designs.create') ? 'bg-white/10 text-gold' : 'text-white hover:bg-white/5' }}">
                                Create Design
                            </a>
                        </div>
                    </div>
                    
                    <!-- Wallpapers (For admin) -->
                    @if(auth()->user()->hasRole('admin'))
                    <div x-data="{ subMenuOpen: {{ request()->routeIs('admin.wallpapers.*') ? 'true' : 'false' }} }" class="mt-1">
                        <button @click="subMenuOpen = !subMenuOpen" class="w-full flex items-center justify-between px-3 py-2 rounded-md {{ request()->routeIs('admin.wallpapers.*') ? 'bg-white/10 text-gold' : 'text-white hover:bg-white/10' }}">
                            <div class="flex items-center gap-3">
                                <i class="fas fa-images w-5 text-center"></i>
                                <span>Wallpapers</span>
                            </div>
                            <i :class="subMenuOpen ? 'fa-chevron-down' : 'fa-chevron-right'" class="fas text-xs"></i>
                        </button>
                        
                        <div x-show="subMenuOpen" x-collapse class="pl-8 pr-3 py-2 space-y-1">
                            <a href="{{ route('admin.wallpapers.index') }}" class="block px-3 py-1.5 rounded-md text-sm {{ request()->routeIs('admin.wallpapers.index') ? 'bg-white/10 text-gold' : 'text-white hover:bg-white/5' }}">
                                All Wallpapers
                            </a>
                            <a href="{{ route('admin.wallpapers.create') }}" class="block px-3 py-1.5 rounded-md text-sm {{ request()->routeIs('admin.wallpapers.create') ? 'bg-white/10 text-gold' : 'text-white hover:bg-white/5' }}">
                                Create Wallpaper
                            </a>
                        </div>
                    </div>
                    @endif

                    <!-- Designs (For admin) -->
                    @if(auth()->user()->hasRole('admin'))
                    <div x-data="{ subMenuOpen: {{ request()->routeIs('admin.designs.*') ? 'true' : 'false' }} }" class="mt-1">
                        <button @click="subMenuOpen = !subMenuOpen" class="w-full flex items-center justify-between px-3 py-2 rounded-md {{ request()->routeIs('admin.designs.*') ? 'bg-white/10 text-gold' : 'text-white hover:bg-white/10' }}">
                            <div class="flex items-center gap-3">
                                <i class="fas fa-palette w-5 text-center"></i>
                                <span>Designs</span>
                            </div>
                            <i :class="subMenuOpen ? 'fa-chevron-down' : 'fa-chevron-right'" class="fas text-xs"></i>
                        </button>
                        
                        <div x-show="subMenuOpen" x-collapse class="pl-8 pr-3 py-2 space-y-1">
                            <a href="{{ route('admin.designs.index') }}" class="block px-3 py-1.5 rounded-md text-sm {{ request()->routeIs('admin.designs.index') ? 'bg-white/10 text-gold' : 'text-white hover:bg-white/5' }}">
                                All Designs
                            </a>
                        </div>
                    </div>
                    @endif
                    
                    <!-- Categories -->
                    @if(auth()->user()->hasRole('admin'))
                    <a href="{{ route('admin.categories.index') }}" class="mt-1 flex items-center gap-3 px-3 py-2 rounded-md {{ request()->routeIs('admin.categories.*') ? 'bg-white/10 text-gold' : 'text-white hover:bg-white/10' }}">
                        <i class="fas fa-tags w-5 text-center"></i>
                        <span>Categories</span>
                    </a>
                    @endif

                    <!-- Artworks Management (For admin) -->
                    @if(auth()->user()->hasRole('admin'))
                    <div x-data="{ subMenuOpen: {{ request()->routeIs('admin.artworks.*') ? 'true' : 'false' }} }" class="mt-1">
                        <button @click="subMenuOpen = !subMenuOpen" class="w-full flex items-center justify-between px-3 py-2 rounded-md {{ request()->routeIs('admin.artworks.*') ? 'bg-white/10 text-gold' : 'text-white hover:bg-white/10' }}">
                            <div class="flex items-center gap-3">
                                <i class="fas fa-image w-5 text-center"></i>
                                <span>Artworks</span>
                            </div>
                            <i :class="subMenuOpen ? 'fa-chevron-down' : 'fa-chevron-right'" class="fas text-xs"></i>
                        </button>
                        
                        <div x-show="subMenuOpen" x-collapse class="pl-8 pr-3 py-2 space-y-1">
                            <a href="{{ route('admin.artworks.index') }}" class="block px-3 py-1.5 rounded-md text-sm {{ request()->is('admin/artworks') ? 'bg-white/10 text-gold' : 'text-white hover:bg-white/5' }}">
                                All Artworks
                            </a>
                            <a href="{{ route('admin.artworks.index') }}?status=pending" class="block px-3 py-1.5 rounded-md text-sm {{ request()->is('admin/artworks') && request()->query('status') == 'pending' ? 'bg-white/10 text-gold' : 'text-white hover:bg-white/5' }}">
                                Pending Approval
                            </a>
                            <a href="{{ route('admin.artworks.index') }}?preview=pending" class="block px-3 py-1.5 rounded-md text-sm {{ request()->is('admin/artworks') && request()->query('preview') == 'pending' ? 'bg-white/10 text-gold' : 'text-white hover:bg-white/5' }}">
                                Preview Requests
                            </a>
                            <a href="{{ route('admin.artworks.index') }}?production=pending" class="block px-3 py-1.5 rounded-md text-sm {{ request()->is('admin/artworks') && request()->query('production') == 'pending' ? 'bg-white/10 text-gold' : 'text-white hover:bg-white/5' }}">
                                Production Images
                            </a>
                        </div>
                    </div>
                    @endif
                </div>
                
                <!-- Orders & Reviews (For admin) -->
                @if(auth()->user()->hasRole('admin'))
                <div class="mt-6 px-3">
                    <h5 class="text-xs uppercase tracking-wider text-white/50 font-semibold px-3 mb-2">Sales</h5>
                    
                    {{-- <a href="{{ route('admin.orders.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-md mb-1 {{ request()->routeIs('admin.orders.*') ? 'bg-white/10 text-gold' : 'text-white hover:bg-white/10' }}">
                        <i class="fas fa-shopping-cart w-5 text-center"></i>
                        <span>Orders</span>
                    </a> --}}
                    
                    <a href="{{ route('admin.reviews.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-md mb-1 {{ request()->routeIs('admin.reviews.*') ? 'bg-white/10 text-gold' : 'text-white hover:bg-white/10' }}">
                        <i class="fas fa-star w-5 text-center"></i>
                        <span>Reviews</span>
                    </a>
                </div>
                @endif
                
                <!-- System -->
                <div class="mt-6 px-3">
                    <h5 class="text-xs uppercase tracking-wider text-white/50 font-semibold px-3 mb-2">System</h5>
                    
                    @if(auth()->user()->hasRole('admin'))
                    <a href="{{ route('admin.users.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-md mb-1 {{ request()->routeIs('admin.users.*') ? 'bg-white/10 text-gold' : 'text-white hover:bg-white/10' }}">
                        <i class="fas fa-users w-5 text-center"></i>
                        <span>Users</span>
                    </a>
                    
                    <a href="{{ route('admin.settings.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-md mb-1 {{ request()->routeIs('admin.settings.*') ? 'bg-white/10 text-gold' : 'text-white hover:bg-white/10' }}">
                        <i class="fas fa-cog w-5 text-center"></i>
                        <span>Settings</span>
                    </a>
                    @endif
                 
                </div>
            </div>
            
            <!-- Footer Links -->
            <div class="p-4 mt-auto border-t border-white/10">
                <a href="{{ url('/') }}" class="flex items-center gap-3 px-3 py-2 rounded-md text-white hover:bg-white/10">
                    <i class="fas fa-home w-5 text-center"></i>
                    <span>Visit Site</span>
                </a>
                
                <form method="POST" action="{{ route('logout') }}" class="mt-1">
                    @csrf
                    <button type="submit" class="flex items-center gap-3 px-3 py-2 rounded-md w-full text-left text-white hover:bg-white/10">
                        <i class="fas fa-sign-out-alt w-5 text-center"></i>
                        <span>Log Out</span>
                    </button>
                </form>
            </div>
        </div>
        
        <!-- Content -->
        <div class="flex-1 flex flex-col">
            <!-- Top Navigation Bar -->
            <div class="bg-white shadow-sm px-4 py-3 flex items-center justify-between sticky top-0 z-10">
                <!-- Mobile Sidebar Toggle -->
                <button 
                    @click="sidebarOpen = true" 
                    class="text-gray-500 hover:text-gray-700 lg:hidden"
                >
                    <i class="fas fa-bars"></i>
                </button>
                
                <!-- Page Title -->
                <h1 class="text-lg font-medium text-gray-800">@yield('title', 'Dashboard')</h1>
                
                <!-- Right Nav Items -->
                <div class="flex items-center gap-4">
                    <!-- Notifications Dropdown -->
                    <div x-data="{ notificationOpen: false }" class="relative">
                        <button @click="notificationOpen = !notificationOpen" class="text-gray-500 hover:text-gray-700">
                            <i class="fas fa-bell"></i>
                        </button>
                        <div 
                            x-show="notificationOpen" 
                            @click.away="notificationOpen = false" 
                            class="absolute right-0 w-80 mt-2 bg-white rounded-md shadow-lg overflow-hidden z-20"
                            x-cloak
                        >
                            <div class="py-2 px-3 bg-gray-50 border-b border-gray-100 flex justify-between items-center">
                                <span class="text-sm font-medium text-gray-700">Notifications</span>
                                <a href="#" class="text-xs text-blue-500 hover:text-blue-700">Mark all as read</a>
                            </div>
                            <div class="max-h-64 overflow-y-auto">
                                <!-- Sample notifications -->
                                <div class="px-4 py-3 hover:bg-gray-50 border-b border-gray-100">
                                    <p class="text-sm text-gray-700">New design uploaded</p>
                                    <p class="text-xs text-gray-500">5 minutes ago</p>
                                </div>
                                <div class="px-4 py-3 hover:bg-gray-50">
                                    <p class="text-sm text-gray-700">New review received</p>
                                    <p class="text-xs text-gray-500">1 hour ago</p>
                                </div>
                            </div>
                            <a href="#" class="block text-center text-sm text-blue-500 hover:text-blue-700 py-2 border-t border-gray-100">
                                View all notifications
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Main Content -->
            <main class="flex-1 overflow-y-auto bg-ivory p-6">
                @yield('content')
            </main>
        </div>
    </div>

    <style>
        [x-cloak] { display: none !important; }
    </style>
    
    @stack('scripts')
</body>
</html>