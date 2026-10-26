<template>
  <AppLayout>
    <!-- Hero Section - Mobile First -->
    <section class="relative overflow-hidden bg-gradient-to-br from-[#4B7C9D]/95 to-[#D4A04F]/90 px-4 py-12 sm:py-16 lg:py-20">
      <div class="absolute inset-0 opacity-10">
        <img 
          src="/imgs/floral-wallpaper-empty-room-with-wooden-floor_53876-74596.jpg" 
          alt="" 
          class="w-full h-full object-cover"
        >
      </div>
      
      <div class="relative max-w-7xl mx-auto">
        <div class="text-center lg:text-left lg:grid lg:grid-cols-2 lg:gap-12 lg:items-center">
          <!-- Content -->
          <div class="mb-8 lg:mb-0">
            <span class="inline-block text-white/90 font-semibold text-xs sm:text-sm uppercase tracking-widest mb-3">
              Papiers Peints Premium
            </span>
            <h1 class="font-['Playfair_Display'] text-3xl sm:text-4xl lg:text-5xl font-bold text-white mb-4 leading-tight">
              Créez le Papier Peint de vos Rêves
            </h1>
            <p class="text-white/95 text-base sm:text-lg mb-6 leading-relaxed max-w-xl mx-auto lg:mx-0">
              Découvrez notre plateforme de personnalisation avancée pour concevoir des papiers peints uniques
            </p>
            
            <!-- CTA Buttons - Mobile Optimized -->
            <div class="flex flex-col sm:flex-row gap-3 sm:gap-4 justify-center lg:justify-start mb-8">
              <Link 
                href="/shop" 
                class="bg-white text-[#4B7C9D] px-6 py-3.5 rounded-full font-semibold text-center hover:bg-white/95 transition-all shadow-lg hover:shadow-xl inline-block min-h-[48px] flex items-center justify-center"
              >
                Explorer le Catalogue
              </Link>
              <Link 
                href="/designs" 
                class="bg-transparent border-2 border-white text-white px-6 py-3.5 rounded-full font-semibold text-center hover:bg-white/10 transition-all inline-block min-h-[48px] flex items-center justify-center"
              >
                Personnaliser
              </Link>
            </div>
            
            <!-- Stats - Mobile Optimized -->
            <div class="grid grid-cols-3 gap-4 sm:gap-6 max-w-md mx-auto lg:mx-0">
              <div class="text-center">
                <div class="font-['Playfair_Display'] text-2xl sm:text-3xl font-bold text-white">
                  {{ wallpapers.length }}+
                </div>
                <div class="text-white/80 text-xs sm:text-sm uppercase tracking-wide mt-1">Designs</div>
              </div>
              <div class="text-center">
                <div class="font-['Playfair_Display'] text-2xl sm:text-3xl font-bold text-white">
                  {{ categories.length }}
                </div>
                <div class="text-white/80 text-xs sm:text-sm uppercase tracking-wide mt-1">Collections</div>
              </div>
              <div class="text-center">
                <div class="font-['Playfair_Display'] text-2xl sm:text-3xl font-bold text-white">
                  {{ designers.length }}+
                </div>
                <div class="text-white/80 text-xs sm:text-sm uppercase tracking-wide mt-1">Designers</div>
              </div>
            </div>
          </div>
          
          <!-- Featured Image (hidden on mobile) -->
          <div class="hidden lg:block">
            <div class="rounded-2xl overflow-hidden shadow-2xl border-2 border-white/20">
              <img 
                v-if="wallpapers[0]?.primary_image"
                :src="`/storage/${wallpapers[0].primary_image.image_path}`" 
                :alt="wallpapers[0]?.title"
                class="w-full h-auto"
              >
              <img 
                v-else
                src="/imgs/floral-wallpaper-empty-room-with-wooden-floor_53876-74596.jpg" 
                alt="Intérieur avec papier peint design"
                class="w-full h-auto"
              >
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Featured Collections - Mobile First Grid -->
    <section class="py-12 sm:py-16 lg:py-20 bg-[#FAF9F7]">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-8 sm:mb-12">
          <h2 class="font-['Playfair_Display'] text-2xl sm:text-3xl lg:text-4xl font-bold text-[#2A3240] mb-3">
            Collections Populaires
          </h2>
          <p class="text-gray-600 text-sm sm:text-base max-w-2xl mx-auto">
            Découvrez nos papiers peints les plus appréciés
          </p>
        </div>
        
        <!-- Grid - Mobile: 1 col, Tablet: 2 cols, Desktop: 3-4 cols -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 sm:gap-6">
          <Link 
            v-for="wallpaper in wallpapers.slice(0, 8)" 
            :key="wallpaper.id"
            :href="`/shop/${wallpaper.id}`"
            class="group bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-2"
          >
            <div class="aspect-[3/4] overflow-hidden relative">
              <img 
                v-if="wallpaper.primary_image"
                :src="`/storage/${wallpaper.primary_image.image_path}`" 
                :alt="wallpaper.title"
                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
              >
              <img 
                v-else
                src="/imgs/nocturne.jpg" 
                :alt="wallpaper.title"
                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
              >
              <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent flex items-end p-4">
                <span class="text-white text-xs uppercase tracking-wide font-medium">
                  {{ wallpaper.category?.name || 'Design' }}
                </span>
              </div>
            </div>
            <div class="p-4">
              <h3 class="font-semibold text-base sm:text-lg text-gray-900 mb-1 truncate">
                {{ wallpaper.title }}
              </h3>
              <p class="text-gray-500 text-xs sm:text-sm mb-3 line-clamp-2">
                {{ wallpaper.description }}
              </p>
              <span class="text-[#D4A04F] font-bold text-base sm:text-lg">
                {{ parseFloat(wallpaper.price).toFixed(2) }} €
              </span>
            </div>
          </Link>
        </div>
        
        <div class="text-center mt-8 sm:mt-12">
          <Link 
            href="/shop" 
            class="inline-block bg-[#4B7C9D] text-white px-8 py-3.5 rounded-full font-semibold hover:bg-[#355871] transition-all shadow-lg hover:shadow-xl min-h-[48px]"
          >
            Voir Toute la Collection
          </Link>
        </div>
      </div>
    </section>

    <!-- How It Works - Mobile Optimized Cards -->
    <section class="py-12 sm:py-16 lg:py-20 bg-white">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-8 sm:mb-12">
          <h2 class="font-['Playfair_Display'] text-2xl sm:text-3xl lg:text-4xl font-bold text-[#2A3240] mb-3">
            Comment Ça Marche
          </h2>
          <p class="text-gray-600 text-sm sm:text-base max-w-2xl mx-auto">
            Notre processus simple en trois étapes
          </p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 lg:gap-8">
          <div class="bg-[#FAF9F7] p-6 sm:p-8 rounded-2xl text-center hover:shadow-lg transition-all">
            <div class="w-16 h-16 sm:w-20 sm:h-20 bg-gradient-to-br from-[#4B7C9D] to-[#6A96B3] rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg">
              <i class="fas fa-search text-white text-2xl sm:text-3xl"></i>
            </div>
            <h3 class="font-['Playfair_Display'] text-lg sm:text-xl font-semibold text-[#2A3240] mb-3">
              1. Explorez
            </h3>
            <p class="text-gray-600 text-sm sm:text-base leading-relaxed">
              Parcourez notre collection de motifs créés par des designers talentueux
            </p>
          </div>
          
          <div class="bg-[#FAF9F7] p-6 sm:p-8 rounded-2xl text-center hover:shadow-lg transition-all">
            <div class="w-16 h-16 sm:w-20 sm:h-20 bg-gradient-to-br from-[#4B7C9D] to-[#6A96B3] rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg">
              <i class="fas fa-palette text-white text-2xl sm:text-3xl"></i>
            </div>
            <h3 class="font-['Playfair_Display'] text-lg sm:text-xl font-semibold text-[#2A3240] mb-3">
              2. Personnalisez
            </h3>
            <p class="text-gray-600 text-sm sm:text-base leading-relaxed">
              Ajustez les couleurs, dimensions et choisissez la qualité de papier
            </p>
          </div>
          
          <div class="bg-[#FAF9F7] p-6 sm:p-8 rounded-2xl text-center hover:shadow-lg transition-all">
            <div class="w-16 h-16 sm:w-20 sm:h-20 bg-gradient-to-br from-[#4B7C9D] to-[#6A96B3] rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg">
              <i class="fas fa-shipping-fast text-white text-2xl sm:text-3xl"></i>
            </div>
            <h3 class="font-['Playfair_Display'] text-lg sm:text-xl font-semibold text-[#2A3240] mb-3">
              3. Recevez
            </h3>
            <p class="text-gray-600 text-sm sm:text-base leading-relaxed">
              Nous imprimons et livrons votre papier peint directement chez vous
            </p>
          </div>
        </div>
      </div>
    </section>

    <!-- Featured Designs (if available) -->
    <section v-if="designs.length > 0" class="py-12 sm:py-16 lg:py-20 bg-[#FAF9F7]">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-8 sm:mb-12">
          <h2 class="font-['Playfair_Display'] text-2xl sm:text-3xl lg:text-4xl font-bold text-[#2A3240] mb-3">
            Designs des Créateurs
          </h2>
          <p class="text-gray-600 text-sm sm:text-base max-w-2xl mx-auto">
            Découvrez les créations uniques de nos designers
          </p>
        </div>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
          <Link 
            v-for="design in designs.slice(0, 6)" 
            :key="design.id"
            :href="`/designs/${design.id}`"
            class="group bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-2"
          >
            <div class="aspect-[4/3] overflow-hidden relative">
              <img 
                v-if="design.image_path"
                :src="`/storage/${design.image_path}`" 
                :alt="design.name"
                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
              >
              <img 
                v-else
                src="/imgs/nocturne.jpg" 
                :alt="design.name"
                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
              >
            </div>
            <div class="p-4">
              <h3 class="font-semibold text-base sm:text-lg text-gray-900 mb-1">
                {{ design.name }}
              </h3>
              <p class="text-gray-500 text-xs sm:text-sm">
                Par {{ design.designer?.name || 'Designer' }}
              </p>
            </div>
          </Link>
        </div>
        
        <div class="text-center mt-8 sm:mt-12">
          <Link 
            href="/designs" 
            class="inline-block bg-transparent border-2 border-[#D4A04F] text-[#D4A04F] px-8 py-3.5 rounded-full font-semibold hover:bg-[#D4A04F] hover:text-white transition-all min-h-[48px]"
          >
            Tous les Designs
          </Link>
        </div>
      </div>
    </section>

    <!-- CTA Section -->
    <section class="relative py-16 sm:py-20 lg:py-24 overflow-hidden">
      <div class="absolute inset-0 bg-gradient-to-br from-[#4B7C9D]/95 to-[#D4A04F]/90"></div>
      <div class="absolute inset-0 opacity-10">
        <img 
          src="/imgs/nocturne.jpg" 
          alt="" 
          class="w-full h-full object-cover"
        >
      </div>
      
      <div class="relative max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-white">
        <h2 class="font-['Playfair_Display'] text-2xl sm:text-3xl lg:text-4xl font-bold mb-4 sm:mb-6">
          Prêt à Transformer Votre Intérieur ?
        </h2>
        <p class="text-base sm:text-lg mb-8 sm:mb-10 max-w-2xl mx-auto opacity-95">
          Créez dès maintenant votre papier peint unique qui reflète parfaitement votre style
        </p>
        <div class="flex flex-col sm:flex-row gap-3 sm:gap-4 justify-center">
          <Link 
            href="/shop" 
            class="bg-white text-[#4B7C9D] px-8 py-3.5 rounded-full font-semibold hover:bg-white/95 transition-all shadow-lg hover:shadow-xl inline-block min-h-[48px] flex items-center justify-center"
          >
            <i class="fas fa-rocket mr-2"></i>
            Commencer Maintenant
          </Link>
          <Link 
            href="/about" 
            class="bg-transparent border-2 border-white text-white px-8 py-3.5 rounded-full font-semibold hover:bg-white/10 transition-all inline-block min-h-[48px] flex items-center justify-center"
          >
            <i class="fas fa-info-circle mr-2"></i>
            En Savoir Plus
          </Link>
        </div>
      </div>
    </section>
  </AppLayout>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';

defineProps({
  wallpapers: {
    type: Array,
    required: true,
  },
  categories: {
    type: Array,
    required: true,
  },
  designs: {
    type: Array,
    required: true,
  },
  designers: {
    type: Array,
    required: true,
  },
});
</script>
