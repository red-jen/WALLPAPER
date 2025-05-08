<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'MurArt - Papiers Peints Artistiques Personnalisables')</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts: Montserrat and Open Sans -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&family=Open+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Custom Tailwind Configuration -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#FFA500', // Orange
                        secondary: '#6C9BCF', // Bleu clair
                        background: '#F5F5F5', // Blanc cassé
                        dark: '#333333', // Gris foncé
                    },
                    fontFamily: {
                        heading: ['Montserrat', 'sans-serif'],
                        sans: ['Open Sans', 'sans-serif'],
                    },
                }
            }
        }
    </script>
    <!-- Custom Styles -->
    <style>
        h1, h2, h3, h4, h5, h6 { font-family: 'Montserrat', sans-serif; }
        body { font-family: 'Open Sans', sans-serif; }
        
        /* Animation pour le loader */
        .loader {
            border-top-color: #6C9BCF;
            -webkit-animation: spinner 1.5s linear infinite;
            animation: spinner 1.5s linear infinite;
        }
        
        @-webkit-keyframes spinner {
            0% { -webkit-transform: rotate(0deg); }
            100% { -webkit-transform: rotate(360deg); }
        }
        
        @keyframes spinner {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        /* Animation pour les transitions de pages */
        .page-transition {
            transition: opacity 0.3s ease-in-out;
        }
        
        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 10px;
        }
        
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }
        
        ::-webkit-scrollbar-thumb {
            background: #6C9BCF;
            border-radius: 5px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: #FFA500;
        }
    </style>
    
    <!-- Additional CSS -->
    @stack('styles')
</head>
<body class="bg-background text-dark min-h-screen flex flex-col">
    <!-- Page Loader (hidden by default) -->
    <div id="page-loader" class="fixed inset-0 z-50 flex items-center justify-center bg-white bg-opacity-80 hidden">
        <div class="loader ease-linear rounded-full border-4 border-t-4 border-gray-200 h-12 w-12"></div>
    </div>

    <!-- Header Navigation -->
    @include('partials.header')

    <!-- Flash Messages -->
    @if (session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4 mx-4 md:mx-8 mt-4" role="alert">
        <span class="block sm:inline">{{ session('success') }}</span>
        <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
            <svg class="fill-current h-6 w-6 text-green-500 cursor-pointer" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" onclick="this.parentElement.parentElement.remove()">
                <title>Fermer</title>
                <path d="M14.348 14.849a1 1 0 01-1.414 0L10 11.414l-2.93 2.93a1 1 0 01-1.414-1.414l2.93-2.93-2.93-2.93a1 1 0 011.414-1.414l2.93 2.93 2.93-2.93a1 1 0 011.414 1.414l-2.93 2.93 2.93 2.93a1 1 0 010 1.414z"></path>
            </svg>
        </span>
    </div>
    @endif

    @if (session('error'))
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4 mx-4 md:mx-8 mt-4" role="alert">
        <span class="block sm:inline">{{ session('error') }}</span>
        <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
            <svg class="fill-current h-6 w-6 text-red-500 cursor-pointer" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" onclick="this.parentElement.parentElement.remove()">
                <title>Fermer</title>
                <path d="M14.348 14.849a1 1 0 01-1.414 0L10 11.414l-2.93 2.93a1 1 0 01-1.414-1.414l2.93-2.93-2.93-2.93a1 1 0 011.414-1.414l2.93 2.93 2.93-2.93a1 1 0 011.414 1.414l-2.93 2.93 2.93 2.93a1 1 0 010 1.414z"></path>
            </svg>
        </span>
    </div>
    @endif

    <!-- Main Content -->
    <main class="flex-grow page-transition">
        @yield('content')
    </main>

    <!-- Footer -->
    @include('partials.footer')

    <!-- Mobile Menu (Hidden by default) -->
    <div id="mobile-menu" class="fixed inset-0 bg-dark bg-opacity-90 z-50 hidden">
        <div class="flex justify-end p-6">
            <button id="close-mobile-menu" class="focus:outline-none text-white">
                <i class="fas fa-times text-2xl"></i>
            </button>
        </div>
        <div class="flex flex-col items-center mt-10 text-white">
            <a href="{{ route('home') }}" class="py-3 text-xl font-heading font-medium hover:text-primary transition">Accueil</a>
            <a href="{{ route('shop.index') }}" class="py-3 text-xl font-heading font-medium hover:text-primary transition">Boutique</a>
            
            @auth
            <a href="{{ route('designs.index') }}" class="py-3 text-xl font-heading font-medium hover:text-primary transition">Designs</a>
            <a href="{{ route('artworks.index') }}" class="py-3 text-xl font-heading font-medium hover:text-primary transition">Mes Créations</a>
            @endauth
            
            <a href="{{ route('about') }}" class="py-3 text-xl font-heading font-medium hover:text-primary transition">À propos</a>
            <a href="{{ route('contact') }}" class="py-3 text-xl font-heading font-medium hover:text-primary transition">Contact</a>
            
            @auth
                <div class="mt-4 pt-4 border-t border-gray-700 w-4/5 flex flex-col items-center">
                    <span class="text-gray-400 mb-2">{{ Auth::user()->name }}</span>
                    @if(Auth::user()->hasRole('admin'))
                        <a href="{{ route('admin.dashboard') }}" class="py-2 text-lg font-medium hover:text-primary transition">Dashboard Admin</a>
                    @endif
                    @if(Auth::user()->hasRole('designer'))
                        <a href="{{ route('designer.designs.index') }}" class="py-2 text-lg font-medium hover:text-primary transition">Designs Manager</a>
                    @endif
                    <a href="{{ route('client.dashboard') }}" class="py-2 text-lg font-medium hover:text-primary transition">Mon Compte</a>
                    <a href="{{ route('cart.index') }}" class="py-2 text-lg font-medium hover:text-primary transition">
                        Mon Panier
                        @if(session()->has('cart') && count(session('cart')) > 0)
                            <span class="ml-2 bg-primary text-white text-xs px-1.5 py-0.5 rounded-full">{{ count(session('cart')) }}</span>
                        @endif
                    </a>
                    <a href="{{ route('logout') }}" class="py-2 text-lg font-medium hover:text-primary transition">Déconnexion</a>
                </div>
            @else
                <div class="mt-4 pt-4 border-t border-gray-700 w-4/5 flex flex-col items-center">
                    <a href="{{ route('login') }}" class="py-2 text-lg font-medium hover:text-primary transition">Connexion</a>
                    <a href="{{ route('registerform') }}" class="py-2 text-lg font-medium hover:text-primary transition">Inscription</a>
                </div>
            @endauth
        </div>
    </div>

    <!-- Back to Top Button -->
    <button id="back-to-top" class="fixed bottom-8 right-8 bg-secondary text-white p-3 rounded-full shadow-lg cursor-pointer hidden hover:bg-primary transition-colors duration-300">
        <i class="fas fa-arrow-up"></i>
    </button>

    <!-- Alpine.js for interactive components -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@2.8.2/dist/alpine.min.js" defer></script>
    
    <!-- Global Scripts -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Mobile menu toggle
            const menuButton = document.querySelector('#mobile-menu-button');
            const closeButton = document.querySelector('#close-mobile-menu');
            const mobileMenu = document.querySelector('#mobile-menu');
            
            if (menuButton && closeButton && mobileMenu) {
                menuButton.addEventListener('click', function() {
                    mobileMenu.classList.remove('hidden');
                    document.body.style.overflow = 'hidden'; // Prevent scrolling
                });
                
                closeButton.addEventListener('click', function() {
                    mobileMenu.classList.add('hidden');
                    document.body.style.overflow = ''; // Re-enable scrolling
                });
            }
            
            // Back to top button functionality
            const backToTopButton = document.querySelector('#back-to-top');
            
            if (backToTopButton) {
                window.addEventListener('scroll', function() {
                    if (window.scrollY > 500) {
                        backToTopButton.classList.remove('hidden');
                    } else {
                        backToTopButton.classList.add('hidden');
                    }
                });
                
                backToTopButton.addEventListener('click', function() {
                    window.scrollTo({
                        top: 0,
                        behavior: 'smooth'
                    });
                });
            }
            
            // Flash message auto-close
            const flashMessages = document.querySelectorAll('[role="alert"]');
            flashMessages.forEach(message => {
                setTimeout(() => {
                    message.classList.add('opacity-0');
                    setTimeout(() => {
                        message.remove();
                    }, 300);
                }, 5000);
            });
            
            // AJAX setup for CSRF token
            if (typeof fetch !== 'undefined') {
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                
                if (csrfToken) {
                    window.fetchWithCsrf = function(url, options = {}) {
                        options.headers = options.headers || {};
                        options.headers['X-CSRF-TOKEN'] = csrfToken;
                        return fetch(url, options);
                    };
                }
            }
            
            // Page transitions
            const pageLinks = document.querySelectorAll('a:not([target="_blank"]):not([href^="#"]):not([href^="mailto:"]):not([href^="tel:"])');
            const main = document.querySelector('main');
            const loader = document.getElementById('page-loader');
            
            pageLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    // Ignore if modifier keys pressed or not same origin
                    if (e.metaKey || e.ctrlKey || e.shiftKey || !this.href.includes(window.location.origin)) {
                        return;
                    }
                    
                    // Show loader and fade out content
                    loader.classList.remove('hidden');
                    main.style.opacity = '0.5';
                });
            });
            
            // Fade in content when page loaded
            window.addEventListener('load', function() {
                loader.classList.add('hidden');
                main.style.opacity = '1';
            });
        });
    </script>
    
    <!-- Additional Scripts -->
    @stack('scripts')
</body>
</html>
