<nav class="bg-navy/95 fixed w-full z-50 backdrop-blur-sm">
    <div class="container mx-auto px-6">
        <div class="flex justify-between items-center h-20">
            <!-- Logo -->
            <div class="flex items-center">
                <a href="{{ route('home') }}" class="flex items-center space-x-2">
                    <span class="font-serif text-gold text-3xl tracking-wide">Maison</span>
                    <span class="font-serif text-ivory text-3xl tracking-wide">Royale</span>
                </a>
            </div>

            <!-- Mobile menu button -->
            <div class="flex md:hidden">
                <button type="button" class="text-ivory hover:text-gold focus:outline-none" aria-label="Toggle menu" id="mobile-menu-button">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>

            <!-- Desktop Navigation -->
            <div class="hidden md:flex items-center space-x-10">
                <a href="{{ route('home') }}" class="text-ivory hover:text-gold text-sm uppercase tracking-widest font-light transition duration-200 {{ Route::is('home') ? 'text-gold' : '' }}">
                    Home
                </a>
                <a href="{{ route('designs.index') }}" class="text-ivory hover:text-gold text-sm uppercase tracking-widest font-light transition duration-200 {{ Route::is('designs.*') ? 'text-gold' : '' }}">
                    Collection
                </a>
                <a href="{{ route('about') }}" class="text-ivory hover:text-gold text-sm uppercase tracking-widest font-light transition duration-200 {{ Route::is('about') ? 'text-gold' : '' }}">
                    About
                </a>
                {{-- <a href="{{ route('contact') }}" class="text-ivory hover:text-gold text-sm uppercase tracking-widest font-light transition duration-200 {{ Route::is('contact') ? 'text-gold' : '' }}">
                    Contact
                </a> --}}
                
                @guest
                    <a href="{{ route('login') }}" class="text-ivory hover:text-gold text-sm uppercase tracking-widest font-light transition duration-200">
                        Login
                    </a>
                    <a href="{{ route('registerform') }}" class="border border-gold text-gold hover:bg-gold hover:text-navy text-sm uppercase tracking-widest font-light px-5 py-2 transition duration-200">
                        Register
                    </a>
                @else
                    <div class="relative group" x-data="{ isOpen: false }">
                        <button @click="isOpen = !isOpen" class="flex items-center text-ivory hover:text-gold text-sm uppercase tracking-widest font-light focus:outline-none">
                            <span>Account</span>
                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div x-show="isOpen" @click.away="isOpen = false" class="absolute right-0 mt-2 w-48 bg-white rounded-sm shadow-lg py-1 z-50">
                            @if(Auth::user()->role == 'admin')
                                <a href="{{ route('admin.categories.index') }}" class="block px-4 py-2 text-charcoal hover:bg-neutral hover:text-navy text-sm">
                                    Admin Dashboard
                                </a>
                            @endif
                            
                            <a href="{{ route('artworks.index') }}" class="block px-4 py-2 text-charcoal hover:bg-neutral hover:text-navy text-sm">
                                My Account
                            </a>
                            
                            <a href="{{ route('logout') }}" class="block px-4 py-2 text-charcoal hover:bg-neutral hover:text-navy text-sm">
                                Logout
                            </a>
                        </div>
                    </div>
                @endguest
            </div>
        </div>
    </div>

    <!-- Mobile Navigation (Hidden by default) -->
    <div class="md:hidden hidden absolute w-full bg-navy-dark" id="mobile-menu">
        <div class="px-4 py-3 space-y-2 border-t border-navy-light">
            <a href="{{ route('home') }}" class="block py-2 text-ivory hover:text-gold text-sm uppercase tracking-widest {{ Route::is('home') ? 'text-gold' : '' }}">
                Home
            </a>
            <a href="{{ route('designs.index') }}" class="block py-2 text-ivory hover:text-gold text-sm uppercase tracking-widest {{ Route::is('designs.*') ? 'text-gold' : '' }}">
                Collection
            </a>
            <a href="{{ route('about') }}" class="block py-2 text-ivory hover:text-gold text-sm uppercase tracking-widest {{ Route::is('about') ? 'text-gold' : '' }}">
                About
            </a>
            {{-- <a href="{{ route('contact') }}" class="block py-2 text-ivory hover:text-gold text-sm uppercase tracking-widest {{ Route::is('contact') ? 'text-gold' : '' }}">
                Contact
            </a>
             --}}
            @guest
                <a href="{{ route('login') }}" class="block py-2 text-ivory hover:text-gold text-sm uppercase tracking-widest">
                    Login
                </a>
                <a href="{{ route('registerform') }}" class="block py-2 text-gold hover:text-gold-light text-sm uppercase tracking-widest">
                    Register
                </a>
            @else
                <div class="border-t border-navy-light mt-2 pt-2">
                    <p class="py-1 text-ivory text-sm uppercase tracking-widest">{{ Auth::user()->name }}</p>
                    
                    @if(Auth::user()->role == 'admin')
                        <a href="{{ route('admin.categories.index') }}" class="block py-2 text-ivory hover:text-gold text-sm uppercase tracking-widest">
                            Admin Dashboard
                        </a>
                    @endif
                    
                    <a href="{{ route('artworks.index') }}" class="block py-2 text-ivory hover:text-gold text-sm uppercase tracking-widest">
                        My Account
                    </a>
                    
                    <a href="{{ route('logout') }}" class="block py-2 text-ivory hover:text-gold text-sm uppercase tracking-widest">
                        Logout
                    </a>
                </div>
            @endguest
        </div>
    </div>
</nav>

<!-- JavaScript for mobile menu toggle -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const mobileMenuButton = document.getElementById('mobile-menu-button');
        const mobileMenu = document.getElementById('mobile-menu');
        
        mobileMenuButton.addEventListener('click', function() {
            mobileMenu.classList.toggle('hidden');
        });
    });
</script>

<!-- Spacer for fixed navbar -->
<div class="h-20"></div>