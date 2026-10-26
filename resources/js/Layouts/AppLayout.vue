<template>
  <div class="min-h-screen flex flex-col bg-[#FAF9F7]">
    <!-- Mobile-First Navigation -->
    <header class="bg-white/95 backdrop-blur-lg border-b border-gray-200/50 sticky top-0 z-50">
      <div class="max-w-7xl mx-auto">
        <!-- Main Navbar Row -->
        <div class="flex items-center justify-between h-16 px-4">
          <!-- Logo -->
          <Link href="/" class="flex items-center space-x-2">
            <div class="w-10 h-10 bg-gradient-to-br from-[#4B7C9D] to-[#D4A04F] rounded-xl flex items-center justify-center">
              <img src="/imgs/logo.png" alt="MurArt" class="w-6 h-6 object-contain filter brightness-0 invert">
            </div>
            <span class="hidden sm:block text-xl font-bold text-gray-900">
              Mur<span class="text-[#4B7C9D]">Art</span>
            </span>
          </Link>

          <!-- Desktop Navigation Links (hidden on mobile) -->
          <nav class="hidden lg:flex items-center space-x-1">
            <Link 
              href="/" 
              :class="isCurrentRoute('home') ? 'text-[#4B7C9D] bg-[#4B7C9D]/10' : 'text-gray-700 hover:text-gray-900 hover:bg-gray-100'"
              class="px-4 py-2 text-sm font-medium rounded-xl transition-all"
            >
              Accueil
            </Link>
            <Link 
              href="/shop" 
              :class="isCurrentRoute('shop.*') ? 'text-[#4B7C9D] bg-[#4B7C9D]/10' : 'text-gray-700 hover:text-gray-900 hover:bg-gray-100'"
              class="px-4 py-2 text-sm font-medium rounded-xl transition-all"
            >
              Boutique
            </Link>
            <template v-if="$page.props.auth.user">
              <Link 
                href="/designs" 
                :class="isCurrentRoute('designs.*') ? 'text-[#4B7C9D] bg-[#4B7C9D]/10' : 'text-gray-700 hover:text-gray-900 hover:bg-gray-100'"
                class="px-4 py-2 text-sm font-medium rounded-xl transition-all"
              >
                Designs
              </Link>
            </template>
          </nav>

          <!-- Right Actions -->
          <div class="flex items-center space-x-2">
            <!-- Cart Icon -->
            <Link 
              :href="$page.props.auth.user ? '/client/cart' : '/login'" 
              class="relative w-10 h-10 flex items-center justify-center text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded-xl transition-all"
            >
              <i class="fas fa-shopping-cart text-lg"></i>
              <span 
                v-if="$page.props.cart.count > 0" 
                class="absolute -top-1 -right-1 w-5 h-5 bg-red-500 text-white text-xs font-bold rounded-full flex items-center justify-center"
              >
                {{ $page.props.cart.count }}
              </span>
            </Link>

            <!-- Desktop Auth Actions (hidden on mobile) -->
            <template v-if="$page.props.auth.user">
              <div class="hidden md:block relative">
                <button 
                  @click="showUserMenu = !showUserMenu"
                  class="flex items-center space-x-2 px-3 py-2 hover:bg-gray-100 rounded-xl transition-all"
                >
                  <div class="w-8 h-8 bg-gradient-to-br from-[#4B7C9D] to-[#D4A04F] rounded-lg flex items-center justify-center text-white text-sm font-bold">
                    {{ $page.props.auth.user.name.charAt(0).toUpperCase() }}
                  </div>
                  <span class="text-sm font-medium text-gray-700 max-w-20 truncate">{{ $page.props.auth.user.name }}</span>
                  <i class="fas fa-chevron-down text-xs text-gray-400"></i>
                </button>

                <!-- User Dropdown -->
                <div 
                  v-show="showUserMenu"
                  @click.away="showUserMenu = false"
                  class="absolute right-0 mt-2 w-64 bg-white rounded-2xl shadow-xl border border-gray-200/50 overflow-hidden"
                >
                  <div class="p-4 bg-gradient-to-br from-[#4B7C9D] to-[#D4A04F] text-white">
                    <div class="flex items-center space-x-3">
                      <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center text-white text-lg font-bold">
                        {{ $page.props.auth.user.name.charAt(0).toUpperCase() }}
                      </div>
                      <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold truncate">{{ $page.props.auth.user.name }}</p>
                        <p class="text-xs text-white/80 truncate">{{ $page.props.auth.user.email }}</p>
                      </div>
                    </div>
                  </div>

                  <div class="py-2">
                    <Link href="/client/dashboard" class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 hover:text-[#4B7C9D]">
                      <i class="fas fa-user w-4 mr-3 text-gray-400"></i>
                      Mon Compte
                    </Link>
                    <Link href="/client/orders" class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 hover:text-[#4B7C9D]">
                      <i class="fas fa-shopping-bag w-4 mr-3 text-gray-400"></i>
                      Mes Commandes
                    </Link>
                    <Link href="/client/cart" class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 hover:text-[#4B7C9D]">
                      <i class="fas fa-shopping-cart w-4 mr-3 text-gray-400"></i>
                      Mon Panier
                    </Link>
                  </div>

                  <div class="border-t border-gray-100">
                    <Link href="/logout" method="post" class="flex items-center w-full px-4 py-3 text-sm text-gray-700 hover:bg-red-50 hover:text-red-600">
                      <i class="fas fa-sign-out-alt w-4 mr-3 text-gray-400"></i>
                      Déconnexion
                    </Link>
                  </div>
                </div>
              </div>
            </template>
            <template v-else>
              <Link href="/login" class="hidden md:block px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100 rounded-xl transition-all">
                Connexion
              </Link>
              <Link href="/register" class="hidden md:block px-4 py-2 bg-[#4B7C9D] text-white text-sm font-medium rounded-xl hover:bg-[#355871] transition-all">
                Inscription
              </Link>
            </template>

            <!-- Mobile Menu Button -->
            <button 
              @click="showMobileMenu = !showMobileMenu"
              class="lg:hidden w-10 h-10 flex items-center justify-center text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded-xl transition-all"
            >
              <i class="fas fa-bars text-lg"></i>
            </button>
          </div>
        </div>
      </div>
    </header>

    <!-- Mobile Drawer Menu -->
    <transition
      enter-active-class="transition-opacity duration-200"
      leave-active-class="transition-opacity duration-200"
      enter-from-class="opacity-0"
      leave-to-class="opacity-0"
    >
      <div 
        v-show="showMobileMenu"
        @click="showMobileMenu = false"
        class="fixed inset-0 bg-black/50 z-50 lg:hidden"
      ></div>
    </transition>

    <transition
      enter-active-class="transition-transform duration-300"
      leave-active-class="transition-transform duration-300"
      enter-from-class="translate-x-full"
      leave-to-class="translate-x-full"
    >
      <div 
        v-show="showMobileMenu"
        class="fixed right-0 top-0 bottom-0 w-80 max-w-full bg-white z-50 overflow-y-auto lg:hidden shadow-2xl"
      >
        <!-- Mobile Menu Header -->
        <div class="flex justify-between items-center p-6 border-b">
          <div class="flex items-center space-x-2">
            <img src="/imgs/logo.png" alt="MurArt Logo" class="h-8 w-auto">
            <span class="font-bold text-lg text-gray-900">MurArt</span>
          </div>
          <button @click="showMobileMenu = false" class="text-gray-700 hover:text-[#4B7C9D] p-2">
            <i class="fas fa-times text-2xl"></i>
          </button>
        </div>

        <!-- Mobile Menu Content -->
        <div class="p-6">
          <!-- User Section (if authenticated) -->
          <template v-if="$page.props.auth.user">
            <div class="mb-6 p-4 bg-gradient-to-br from-[#4B7C9D] to-[#D4A04F] rounded-xl text-white">
              <div class="flex items-center space-x-3">
                <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center text-lg font-bold">
                  {{ $page.props.auth.user.name.charAt(0).toUpperCase() }}
                </div>
                <div class="flex-1 min-w-0">
                  <p class="text-sm font-semibold truncate">{{ $page.props.auth.user.name }}</p>
                  <p class="text-xs text-white/80 truncate">{{ $page.props.auth.user.email }}</p>
                </div>
              </div>
            </div>
          </template>

          <!-- Navigation Links -->
          <nav class="space-y-1 mb-6">
            <Link 
              href="/" 
              @click="showMobileMenu = false"
              :class="isCurrentRoute('home') ? 'text-[#4B7C9D] bg-[#4B7C9D]/10' : 'text-gray-700'"
              class="flex items-center py-3 px-3 text-base font-medium hover:bg-gray-50 rounded-lg"
            >
              <i class="fas fa-home w-5 mr-3"></i>
              Accueil
            </Link>
            <Link 
              href="/shop" 
              @click="showMobileMenu = false"
              :class="isCurrentRoute('shop.*') ? 'text-[#4B7C9D] bg-[#4B7C9D]/10' : 'text-gray-700'"
              class="flex items-center py-3 px-3 text-base font-medium hover:bg-gray-50 rounded-lg"
            >
              <i class="fas fa-store w-5 mr-3"></i>
              Boutique
            </Link>
            <template v-if="$page.props.auth.user">
              <Link 
                href="/designs" 
                @click="showMobileMenu = false"
                :class="isCurrentRoute('designs.*') ? 'text-[#4B7C9D] bg-[#4B7C9D]/10' : 'text-gray-700'"
                class="flex items-center py-3 px-3 text-base font-medium hover:bg-gray-50 rounded-lg"
              >
                <i class="fas fa-palette w-5 mr-3"></i>
                Designs
              </Link>
              <Link 
                href="/client/dashboard" 
                @click="showMobileMenu = false"
                class="flex items-center py-3 px-3 text-base font-medium text-gray-700 hover:bg-gray-50 rounded-lg"
              >
                <i class="fas fa-user w-5 mr-3"></i>
                Mon Compte
              </Link>
              <Link 
                href="/client/orders" 
                @click="showMobileMenu = false"
                class="flex items-center py-3 px-3 text-base font-medium text-gray-700 hover:bg-gray-50 rounded-lg"
              >
                <i class="fas fa-shopping-bag w-5 mr-3"></i>
                Mes Commandes
              </Link>
            </template>
            <Link 
              href="/about" 
              @click="showMobileMenu = false"
              class="flex items-center py-3 px-3 text-base font-medium text-gray-700 hover:bg-gray-50 rounded-lg"
            >
              <i class="fas fa-info-circle w-5 mr-3"></i>
              À propos
            </Link>
            <Link 
              href="/contact" 
              @click="showMobileMenu = false"
              class="flex items-center py-3 px-3 text-base font-medium text-gray-700 hover:bg-gray-50 rounded-lg"
            >
              <i class="fas fa-envelope w-5 mr-3"></i>
              Contact
            </Link>
          </nav>

          <!-- Auth Actions (guest mobile) -->
          <template v-if="!$page.props.auth.user">
            <div class="space-y-3 pt-6 border-t">
              <Link href="/login" @click="showMobileMenu = false" class="block w-full py-3 px-4 text-center text-base font-medium text-gray-700 border border-gray-300 rounded-xl hover:bg-gray-50">
                <i class="fas fa-sign-in-alt mr-2"></i>
                Connexion
              </Link>
              <Link href="/register" @click="showMobileMenu = false" class="block w-full py-3 px-4 text-center text-base font-medium bg-[#4B7C9D] text-white rounded-xl hover:bg-[#355871]">
                <i class="fas fa-user-plus mr-2"></i>
                Inscription
              </Link>
            </div>
          </template>

          <!-- Logout (authenticated mobile) -->
          <template v-else>
            <div class="pt-6 border-t">
              <Link href="/logout" method="post" @click="showMobileMenu = false" class="flex items-center py-3 px-3 text-base font-medium text-red-600 hover:bg-red-50 rounded-lg">
                <i class="fas fa-sign-out-alt w-5 mr-3"></i>
                Déconnexion
              </Link>
            </div>
          </template>
        </div>
      </div>
    </transition>

    <!-- Flash Messages -->
    <div v-if="$page.props.flash.success" class="mx-4 mt-4">
      <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg relative" role="alert">
        <span class="block sm:inline">{{ $page.props.flash.success }}</span>
        <button @click="$page.props.flash.success = null" class="absolute top-0 bottom-0 right-0 px-4 py-3">
          <i class="fas fa-times text-green-500"></i>
        </button>
      </div>
    </div>

    <div v-if="$page.props.flash.error" class="mx-4 mt-4">
      <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg relative" role="alert">
        <span class="block sm:inline">{{ $page.props.flash.error }}</span>
        <button @click="$page.props.flash.error = null" class="absolute top-0 bottom-0 right-0 px-4 py-3">
          <i class="fas fa-times text-red-500"></i>
        </button>
      </div>
    </div>

    <!-- Main Content -->
    <main class="flex-grow">
      <slot />
    </main>

    <!-- Footer -->
    <footer class="bg-[#2A3240] text-white py-12 mt-16">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
          <div class="col-span-1 md:col-span-2">
            <div class="flex items-center space-x-2 mb-4">
              <img src="/imgs/logo.png" alt="MurArt Logo" class="h-10 w-auto filter brightness-0 invert">
              <span class="text-2xl font-bold">Mur<span class="text-[#D4A04F]">Art</span></span>
            </div>
            <p class="text-gray-300 text-sm mb-4">
              Créez des papiers peints artistiques personnalisés avec nos designs uniques. Transformez vos murs en œuvres d'art.
            </p>
          </div>

          <div>
            <h3 class="font-semibold text-lg mb-4">Navigation</h3>
            <ul class="space-y-2 text-sm">
              <li><Link href="/" class="text-gray-300 hover:text-[#D4A04F] transition">Accueil</Link></li>
              <li><Link href="/shop" class="text-gray-300 hover:text-[#D4A04F] transition">Boutique</Link></li>
              <li><Link href="/about" class="text-gray-300 hover:text-[#D4A04F] transition">À propos</Link></li>
              <li><Link href="/contact" class="text-gray-300 hover:text-[#D4A04F] transition">Contact</Link></li>
            </ul>
          </div>

          <div>
            <h3 class="font-semibold text-lg mb-4">Contact</h3>
            <ul class="space-y-2 text-sm text-gray-300">
              <li class="flex items-start">
                <i class="fas fa-envelope w-5 mt-1 text-[#D4A04F]"></i>
                <span class="ml-2">contact@murart.fr</span>
              </li>
              <li class="flex items-start">
                <i class="fas fa-phone w-5 mt-1 text-[#D4A04F]"></i>
                <span class="ml-2">+33 1 23 45 67 89</span>
              </li>
            </ul>
          </div>
        </div>

        <div class="border-t border-gray-700 mt-8 pt-8 text-center text-sm text-gray-400">
          <p>&copy; {{ new Date().getFullYear() }} MurArt. Tous droits réservés.</p>
        </div>
      </div>
    </footer>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import { Link, usePage } from '@inertiajs/vue3';

const showMobileMenu = ref(false);
const showUserMenu = ref(false);

const isCurrentRoute = (routeName) => {
  const currentRoute = usePage().url;
  if (routeName === 'home') {
    return currentRoute === '/' || currentRoute === '/home';
  }
  return currentRoute.startsWith('/' + routeName.replace('.*', ''));
};
</script>

<style scoped>
/* Butterfly-inspired color palette */
:root {
  --primary: #4B7C9D;
  --primary-dark: #355871;
  --secondary: #D4A04F;
  --accent: #9B6D94;
  --light: #FAF9F7;
  --dark: #2A3240;
}
</style>
