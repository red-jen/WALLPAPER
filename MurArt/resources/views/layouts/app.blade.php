<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Maison Royale') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;1,400&family=Poppins:wght@200;300;400;500;600&display=swap" rel="stylesheet">

    <!-- Scripts and Styles -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        // Primary color palette
                        navy: '#4A6C8B',      // Muted blue (primary)
                        'navy-light': '#6D8BA6', // Lighter version for hover states
                        'navy-dark': '#354E64',  // Darker version for contrast
                        gold: '#D9A566',      // Warm gold (secondary)
                        'gold-light': '#E6C393', // Lighter gold for hover states
                        'gold-dark': '#B78546',  // Darker gold for contrast
                        accent: '#9C6A8C',    // Soft purple as an accent
                        ivory: '#F8F7F5',     // Off-white background
                        charcoal: '#2D3142',  // Deep blue-gray for text
                        neutral: '#E0DED8',   // Warm gray for backgrounds
                        
                        // UI state colors
                        success: '#5A7D63',    // Muted green for success states
                        error: '#A55042',      // Muted red for error states
                        warning: '#D4B86A',    // Muted yellow for warning states
                        info: '#4A6C8B',       // Using our navy for info states
                    },
                    fontFamily: {
                        sans: ['Poppins', 'ui-sans-serif', 'system-ui', 'sans-serif'],
                        serif: ['Playfair Display', 'ui-serif', 'Georgia', 'serif'],
                    },
                    boxShadow: {
                        'subtle': '0 4px 20px rgba(0, 0, 0, 0.05)',
                        'elevated': '0 10px 30px rgba(0, 0, 0, 0.08)',
                    },
                    borderRadius: {
                        'sm': '2px',
                        DEFAULT: '4px',
                        'lg': '8px',
                    },
                    animation: {
                        'fade-in': 'fadeIn 0.7s ease-in-out forwards',
                        'slide-up': 'slideUp 0.7s ease-out forwards',
                    },
                    keyframes: {
                        fadeIn: {
                            '0%': { opacity: '0' },
                            '100%': { opacity: '1' },
                        },
                        slideUp: {
                            '0%': { transform: 'translateY(20px)', opacity: '0' },
                            '100%': { transform: 'translateY(0)', opacity: '1' },
                        },
                    },
                },
            },
        }
    </script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Custom Styles -->
    <style>
        body {
            font-feature-settings: "liga" 1, "kern" 1;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }
        
        /* Subtle textured background */
        .bg-texture {
            background-image: url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm-43-7c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm63 31c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM34 90c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm56-76c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM12 86c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm28-65c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm23-11c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-6 60c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm29 22c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zM32 63c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm57-13c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-9-21c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM60 91c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM35 41c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM12 60c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2z' fill='%234A6C8B' fill-opacity='0.03' fill-rule='evenodd'/%3E%3C/svg%3E");
        }
        
        /* French fleur-de-lis pattern for accents */
        .border-fleur {
            position: relative;
        }
        
        .border-fleur::before {
            content: "";
            position: absolute;
            top: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 60px;
            height: 2px;
            background-color: #D9A566;
        }
        
        .border-fleur::after {
            content: "⚜";
            position: absolute;
            top: -12px;
            left: 50%;
            transform: translateX(-50%);
            font-size: 24px;
            color: #D9A566;
        }
        
        /* Elegant link underline animation */
        .link-underline {
            position: relative;
        }
        
        .link-underline::after {
            content: '';
            position: absolute;
            width: 100%;
            transform: scaleX(0);
            height: 1px;
            bottom: -2px;
            left: 0;
            background-color: currentColor;
            transform-origin: bottom right;
            transition: transform 0.3s ease-out;
        }
        
        .link-underline:hover::after {
            transform: scaleX(1);
            transform-origin: bottom left;
        }
    </style>
</head>
<body class="font-sans antialiased bg-ivory text-charcoal min-h-screen flex flex-col bg-texture">
    <!-- Navbar -->
    @include('layouts.navbar')
    
    <!-- Main Content -->
    <main class="flex-grow">
        @yield('content')
    </main>
    
    <!-- Footer -->
    <footer class="bg-navy-dark text-ivory">
        <div class="container mx-auto px-6 pt-16 pb-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-10">
                <div class="md:col-span-1">
                    <a href="{{ route('home') }}" class="inline-block mb-6">
                        <div class="flex items-center space-x-2">
                            <span class="font-serif text-gold text-2xl tracking-wide">Maison</span>
                            <span class="font-serif text-ivory text-2xl tracking-wide">Royale</span>
                        </div>
                    </a>
                    <p class="text-ivory/70 text-sm font-light leading-relaxed">
                        Exquisite wallpaper designs crafted with French and British heritage, bringing timeless elegance to sophisticated interiors since 2010.
                    </p>
                    <div class="mt-8 flex space-x-5">
                        <a href="#" class="text-ivory/50 hover:text-gold transition duration-300">
                            <span class="sr-only">Facebook</span>
                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd" />
                            </svg>
                        </a>
                        <a href="#" class="text-ivory/50 hover:text-gold transition duration-300">
                            <span class="sr-only">Instagram</span>
                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path fill-rule="evenodd" d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z" clip-rule="evenodd" />
                            </svg>
                        </a>
                        <a href="#" class="text-ivory/50 hover:text-gold transition duration-300">
                            <span class="sr-only">Pinterest</span>
                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M12 0C5.373 0 0 5.372 0 12c0 5.084 3.163 9.426 7.627 11.174-.105-.949-.2-2.405.042-3.441.218-.937 1.407-5.965 1.407-5.965s-.359-.719-.359-1.782c0-1.668.967-2.914 2.171-2.914 1.023 0 1.518.769 1.518 1.69 0 1.029-.655 2.568-.994 3.995-.283 1.194.599 2.169 1.777 2.169 2.133 0 3.772-2.249 3.772-5.495 0-2.873-2.064-4.882-5.012-4.882-3.414 0-5.418 2.561-5.418 5.207 0 1.031.397 2.138.893 2.738.098.119.112.224.083.345l-.333 1.36c-.053.22-.174.267-.402.161-1.499-.698-2.436-2.889-2.436-4.649 0-3.785 2.75-7.262 7.929-7.262 4.163 0 7.398 2.967 7.398 6.931 0 4.136-2.607 7.464-6.227 7.464-1.216 0-2.359-.631-2.75-1.378l-.748 2.853c-.271 1.043-1.002 2.35-1.492 3.146C9.57 23.812 10.763 24 12 24c6.627 0 12-5.373 12-12 0-6.628-5.373-12-12-12z" />
                            </svg>
                        </a>
                    </div>
                </div>
                
                <div>
                    <h3 class="font-serif text-base text-gold uppercase tracking-wide mb-6">Navigation</h3>
                    <ul class="space-y-4">
                        <li>
                            <a href="{{ route('home') }}" class="text-ivory/70 hover:text-gold text-sm font-light transition duration-300 link-underline">Home</a>
                        </li>
                        <li>
                            <a href="{{ route('designs.index') }}" class="text-ivory/70 hover:text-gold text-sm font-light transition duration-300 link-underline">Collection</a>
                        </li>
                        <li>
                            <a href="{{ route('about') }}" class="text-ivory/70 hover:text-gold text-sm font-light transition duration-300 link-underline">About</a>
                        </li>
                        {{-- <li>
                            <a href="{{ route('contact') }}" class="text-ivory/70 hover:text-gold text-sm font-light transition duration-300 link-underline">Contact</a>
                        </li> --}}
                    </ul>
                </div>
                
                <div>
                    <h3 class="font-serif text-base text-gold uppercase tracking-wide mb-6">Collections</h3>
                    <ul class="space-y-4">
                        <li>
                            <a href="#" class="text-ivory/70 hover:text-gold text-sm font-light transition duration-300 link-underline">French Classical</a>
                        </li>
                        <li>
                            <a href="#" class="text-ivory/70 hover:text-gold text-sm font-light transition duration-300 link-underline">British Heritage</a>
                        </li>
                        <li>
                            <a href="#" class="text-ivory/70 hover:text-gold text-sm font-light transition duration-300 link-underline">Botanical Studies</a>
                        </li>
                        <li>
                            <a href="#" class="text-ivory/70 hover:text-gold text-sm font-light transition duration-300 link-underline">Modern Elegance</a>
                        </li>
                        <li>
                            <a href="#" class="text-ivory/70 hover:text-gold text-sm font-light transition duration-300 link-underline">Château Collection</a>
                        </li>
                    </ul>
                </div>
                
                <div>
                    <h3 class="font-serif text-base text-gold uppercase tracking-wide mb-6">Contact</h3>
                    <ul class="space-y-5">
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-gold/70 mr-3 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            <span class="text-ivory/70 text-sm font-light">
                                15 Rue St. Honoré<br>
                                75001 Paris, France
                            </span>
                        </li>
                        <li class="flex items-center">
                            <svg class="w-5 h-5 text-gold/70 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a
                    </div>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>