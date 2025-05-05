<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'MurArt') }} - @yield('title', 'Designer Studio')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600;700&family=Montserrat:wght@300;400;500;600&display=swap" rel="stylesheet">
    
    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        [x-cloak] { display: none !important; }
        
        /* Reduced motion preferences */
        @media (prefers-reduced-motion: reduce) {
            * {
                animation-duration: 0.01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: 0.01ms !important;
                scroll-behavior: auto !important;
            }
        }
    </style>
    
    @stack('styles')
</head>
<body class="bg-ivory font-body text-charcoal antialiased min-h-screen">
    <div id="app" class="flex flex-col min-h-screen">
        <!-- Navigation -->
        <nav id="main-nav" class="fixed w-full z-50 transition-all duration-300" x-data="{ scrolled: false, mobileOpen: false }" 
            x-init="window.addEventListener('scroll', () => { scrolled = window.scrollY > 50 })">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8"
                :class="{ 'py-6': !scrolled, 'py-3 bg-ivory/80 backdrop-blur-sm shadow-sm': scrolled }">
                <div class="flex justify-between items-center">
                    <div class="flex items-center">
                        <a href="{{ route('home') }}" class="flex items-center">
                            <span class="text-navy font-heading text-2xl font-semibold tracking-wider">MurArt</span>
                            <span class="ml-2 text-gold font-heading">Designer Studio</span>
                        </a>
                    </div>
                    
                    <!-- Desktop Navigation -->
                    <div class="hidden md:flex items-center space-x-8">
                        <a href="{{ route('home') }}" class="text-navy hover:text-gold transition-colors font-medium">Home</a>
                        <a href="{{ route('designs.index') }}" class="text-navy hover:text-gold transition-colors font-medium">Designs</a>
                        <a href="{{ route('papers.index') }}" class="text-navy hover:text-gold transition-colors font-medium">Papers</a>
                        
                        @auth
                            <div class="relative" x-data="{ open: false }">
                                <button @click="open = !open" class="flex items-center text-navy hover:text-gold transition-colors font-medium focus:outline-none">
                                    <span>{{ Auth::user()->name }}</span>
                                    <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </button>
                                
                                <div x-show="open" @click.away="open = false" x-transition:enter="transition ease-out duration-200"
                                    x-transition:enter-start="opacity-0 transform scale-95"
                                    x-transition:enter-end="opacity-100 transform scale-100"
                                    x-transition:leave="transition ease-in duration-75"
                                    x-transition:leave-start="opacity-100 transform scale-100"
                                    x-transition:leave-end="opacity-0 transform scale-95"
                                    class="absolute right-0 mt-2 w-48 py-2 bg-white rounded-md shadow-xl z-20" x-cloak>
                                    
                                    {{-- <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-navy hover:bg-ivory transition">
                                        Profile
                                    </a> --}}
                                    
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="w-full text-left block px-4 py-2 text-sm text-navy hover:bg-ivory transition">
                                            Sign out
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @else
                            <a href="{{ route('login') }}" class="text-navy hover:text-gold transition-colors font-medium">Log in</a>
                        @endauth
                    </div>
                    
                    <!-- Mobile Menu Button -->
                    <button @click="mobileOpen = !mobileOpen" class="md:hidden text-navy focus:outline-none">
                        <svg x-show="!mobileOpen" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                        <svg x-show="mobileOpen" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" x-cloak>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                
                <!-- Mobile Menu -->
                <div x-show="mobileOpen" class="md:hidden mt-4 pb-4 animate-fade-in" x-cloak>
                    <a href="{{ route('home') }}" class="block py-2 text-navy hover:text-gold transition-colors font-medium">Home</a>
                    <a href="{{ route('designs.index') }}" class="block py-2 text-navy hover:text-gold transition-colors font-medium">Designs</a>
                    <a href="{{ route('papers.index') }}" class="block py-2 text-navy hover:text-gold transition-colors font-medium">Papers</a>
                    
                    @auth
                        {{-- <a href="{{ route('profile.edit') }}" class="block py-2 text-navy hover:text-gold transition-colors font-medium">
                            Profile
                        </a> --}}
                        
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left block py-2 text-navy hover:text-gold transition-colors font-medium">
                                Sign out
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="block py-2 text-navy hover:text-gold transition-colors font-medium">Log in</a>
                    @endauth
                </div>
            </div>
        </nav>

        <!-- Page Content -->
        <main class="flex-grow mt-24">
            @yield('content')
        </main>

        <!-- Footer -->
        <footer class="bg-navy text-ivory py-12 mt-12">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                    <div>
                        <h3 class="font-heading text-xl font-semibold mb-4">MurArt</h3>
                        <p class="text-sm leading-relaxed">Creating elegant, bespoke wall coverings for discerning designers and clients since 2023.</p>
                    </div>
                    
                    <div>
                        <h4 class="font-heading text-lg font-semibold mb-4">Explore</h4>
                        <ul class="space-y-2">
                            <li><a href="#" class="text-ivory/80 hover:text-gold transition-colors text-sm">Designs</a></li>
                            <li><a href="#" class="text-ivory/80 hover:text-gold transition-colors text-sm">Papers</a></li>
                            <li><a href="#" class="text-ivory/80 hover:text-gold transition-colors text-sm">Collections</a></li>
                            <li><a href="#" class="text-ivory/80 hover:text-gold transition-colors text-sm">Designers</a></li>
                        </ul>
                    </div>
                    
                    <div>
                        <h4 class="font-heading text-lg font-semibold mb-4">Information</h4>
                        <ul class="space-y-2">
                            <li><a href="#" class="text-ivory/80 hover:text-gold transition-colors text-sm">About Us</a></li>
                            <li><a href="#" class="text-ivory/80 hover:text-gold transition-colors text-sm">Sustainability</a></li>
                            <li><a href="#" class="text-ivory/80 hover:text-gold transition-colors text-sm">Installation</a></li>
                            <li><a href="#" class="text-ivory/80 hover:text-gold transition-colors text-sm">Contact</a></li>
                        </ul>
                    </div>
                    
                    <div>
                        <h4 class="font-heading text-lg font-semibold mb-4">Subscribe</h4>
                        <p class="text-sm mb-4">Join our newsletter for exclusive updates and design inspiration.</p>
                        <form class="space-y-2">
                            <div>
                                <input type="email" placeholder="Your email address" class="w-full px-3 py-2 bg-navy border border-ivory/30 rounded-md text-ivory focus:outline-none focus:border-gold transition-colors">
                            </div>
                            <button type="submit" class="bg-gold text-navy px-4 py-2 rounded-md text-sm font-medium hover:bg-gold/90 transition-colors">
                                Subscribe
                            </button>
                        </form>
                    </div>
                </div>
                
                <div class="border-t border-ivory/20 mt-12 pt-6 flex flex-col md:flex-row justify-between items-center">
                    <p class="text-sm text-ivory/60">&copy; {{ date('Y') }} MurArt. All rights reserved.</p>
                    <div class="flex space-x-4 mt-4 md:mt-0">
                        <a href="#" class="text-ivory/60 hover:text-gold transition-colors">
                            <span class="sr-only">Facebook</span>
                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd" />
                            </svg>
                        </a>
                        <a href="#" class="text-ivory/60 hover:text-gold transition-colors">
                            <span class="sr-only">Instagram</span>
                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path fill-rule="evenodd" d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z" clip-rule="evenodd" />
                            </svg>
                        </a>
                        <a href="#" class="text-ivory/60 hover:text-gold transition-colors">
                            <span class="sr-only">Pinterest</span>
                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M12 0c-6.627 0-12 5.372-12 12 0 5.084 3.163 9.426 7.627 11.174-.105-.949-.2-2.405.042-3.441.218-.937 1.407-5.965 1.407-5.965s-.359-.719-.359-1.782c0-1.668.967-2.914 2.171-2.914 1.023 0 1.518.769 1.518 1.69 0 1.029-.655 2.568-.994 3.995-.283 1.194.599 2.169 1.777 2.169 2.133 0 3.772-2.249 3.772-5.495 0-2.873-2.064-4.882-5.012-4.882-3.414 0-5.418 2.561-5.418 5.207 0 1.031.397 2.138.893 2.738.098.119.112.224.083.345l-.333 1.36c-.053.22-.174.267-.402.161-1.499-.698-2.436-2.889-2.436-4.649 0-3.785 2.75-7.262 7.929-7.262 4.163 0 7.398 2.967 7.398 6.931 0 4.136-2.607 7.464-6.227 7.464-1.216 0-2.359-.631-2.75-1.378l-.748 2.853c-.271 1.043-1.002 2.35-1.492 3.146 1.124.347 2.317.535 3.554.535 6.627 0 12-5.373 12-12 0-6.628-5.373-12-12-12z" fill-rule="evenodd" clip-rule="evenodd"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </footer>
    </div>

    <!-- Scripts -->
    <script defer src="https://unpkg.com/alpinejs@3.10.5/dist/cdn.min.js"></script>
    
    <script>
        // Parallax scroll effect for hero sections
        document.addEventListener('DOMContentLoaded', function() {
            const parallaxElements = document.querySelectorAll('.js-parallax');
            
            window.addEventListener('scroll', function() {
                const scrollTop = window.pageYOffset;
                
                parallaxElements.forEach(element => {
                    const speed = element.getAttribute('data-parallax-speed') || 0.5;
                    element.style.transform = `translateY(${scrollTop * speed}px)`;
                });
            });
            
            // Add smooth scroll for browsers that don't support scroll-behavior
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();
                    
                    const targetId = this.getAttribute('href');
                    if (targetId === '#') return;
                    
                    const targetElement = document.querySelector(targetId);
                    if (targetElement) {
                        targetElement.scrollIntoView({
                            behavior: 'smooth'
                        });
                    }
                });
            });
        });
    </script>
    
    @stack('scripts')
</body>
</html> 