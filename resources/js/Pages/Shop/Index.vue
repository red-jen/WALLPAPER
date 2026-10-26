<template>
  <AppLayout>
    <!-- Page Header -->
    <section class="bg-gradient-to-br from-[#4B7C9D]/10 to-[#D4A04F]/10 py-8 sm:py-12">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="font-['Playfair_Display'] text-3xl sm:text-4xl lg:text-5xl font-bold text-[#2A3240] mb-3">
          Boutique
        </h1>
        <p class="text-gray-600 text-sm sm:text-base">
          Découvrez notre collection de papiers peints premium
        </p>
      </div>
    </section>

    <!-- Filters & Content -->
    <section class="py-8 sm:py-12">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Filters Bar - Mobile Optimized -->
        <div class="mb-6 sm:mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
          <!-- Category Filter -->
          <div class="flex items-center gap-2 overflow-x-auto pb-2 sm:pb-0">
            <Link 
              href="/shop"
              :class="!selectedCategory ? 'bg-[#4B7C9D] text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'"
              class="px-4 py-2 rounded-full text-sm font-medium whitespace-nowrap transition-all min-h-[40px] flex items-center"
            >
              Tous
            </Link>
            <Link 
              v-for="category in categories" 
              :key="category.id"
              :href="`/shop?category=${category.id}`"
              :class="selectedCategory === category.id ? 'bg-[#4B7C9D] text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'"
              class="px-4 py-2 rounded-full text-sm font-medium whitespace-nowrap transition-all min-h-[40px] flex items-center"
            >
              {{ category.name }}
            </Link>
          </div>

          <!-- Sort Filter -->
          <div class="flex items-center gap-3">
            <label class="text-sm font-medium text-gray-700 whitespace-nowrap">Trier par:</label>
            <select 
              v-model="sortOption"
              @change="handleSortChange"
              class="px-3 py-2 bg-white border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#4B7C9D]/20 min-h-[40px]"
            >
              <option value="">Plus récent</option>
              <option value="price_low">Prix croissant</option>
              <option value="price_high">Prix décroissant</option>
              <option value="popular">Popularité</option>
            </select>
          </div>
        </div>

        <!-- Results Count -->
        <div class="mb-6 text-sm text-gray-600">
          <span class="font-medium">{{ wallpapers.total }}</span> papier(s) peint(s) trouvé(s)
        </div>

        <!-- Products Grid - Mobile First -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 sm:gap-6 mb-8">
          <Link 
            v-for="wallpaper in wallpapers.data" 
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
              
              <!-- Stock Badge -->
              <div v-if="wallpaper.stock <= 5 && wallpaper.stock > 0" class="absolute top-3 right-3">
                <span class="bg-yellow-500 text-white text-xs font-semibold px-2 py-1 rounded-full">
                  Stock limité
                </span>
              </div>
              <div v-else-if="wallpaper.stock === 0" class="absolute top-3 right-3">
                <span class="bg-red-500 text-white text-xs font-semibold px-2 py-1 rounded-full">
                  Épuisé
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
              <div class="flex items-center justify-between">
                <span class="text-[#D4A04F] font-bold text-base sm:text-lg">
                  {{ parseFloat(wallpaper.price).toFixed(2) }} €
                </span>
                <div v-if="wallpaper.reviews_count > 0" class="flex items-center text-xs text-gray-500">
                  <i class="fas fa-star text-yellow-500 mr-1"></i>
                  <span>{{ wallpaper.reviews_count }}</span>
                </div>
              </div>
            </div>
          </Link>
        </div>

        <!-- No Results -->
        <div v-if="wallpapers.data.length === 0" class="text-center py-12">
          <i class="fas fa-search text-6xl text-gray-300 mb-4"></i>
          <h3 class="text-xl font-semibold text-gray-700 mb-2">Aucun résultat trouvé</h3>
          <p class="text-gray-500 mb-6">Essayez de modifier vos filtres</p>
          <Link 
            href="/shop"
            class="inline-block bg-[#4B7C9D] text-white px-6 py-3 rounded-full font-semibold hover:bg-[#355871] transition-all"
          >
            Réinitialiser les filtres
          </Link>
        </div>

        <!-- Pagination - Mobile Friendly -->
        <div v-if="wallpapers.last_page > 1" class="flex flex-col sm:flex-row items-center justify-between gap-4">
          <!-- Page Info -->
          <div class="text-sm text-gray-600 order-2 sm:order-1">
            Affichage de {{ wallpapers.from }} à {{ wallpapers.to }} sur {{ wallpapers.total }} résultats
          </div>

          <!-- Pagination Buttons -->
          <div class="flex items-center gap-2 order-1 sm:order-2">
            <Link 
              v-if="wallpapers.prev_page_url"
              :href="wallpapers.prev_page_url"
              class="px-4 py-2 bg-white border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 transition-all min-h-[40px] flex items-center"
            >
              <i class="fas fa-chevron-left mr-2"></i>
              <span class="hidden sm:inline">Précédent</span>
            </Link>
            <div v-else class="px-4 py-2 bg-gray-100 border border-gray-200 rounded-lg text-sm font-medium text-gray-400 cursor-not-allowed min-h-[40px] flex items-center">
              <i class="fas fa-chevron-left mr-2"></i>
              <span class="hidden sm:inline">Précédent</span>
            </div>

            <!-- Page Numbers (simplified for mobile) -->
            <div class="hidden md:flex items-center gap-2">
              <template v-for="page in paginationPages" :key="page">
                <Link 
                  v-if="page !== '...'"
                  :href="`/shop?page=${page}${categoryQuery}${sortQuery}`"
                  :class="wallpapers.current_page === page ? 'bg-[#4B7C9D] text-white' : 'bg-white border border-gray-300 text-gray-700 hover:bg-gray-50'"
                  class="px-4 py-2 rounded-lg text-sm font-medium transition-all min-h-[40px] flex items-center justify-center min-w-[40px]"
                >
                  {{ page }}
                </Link>
                <span v-else class="px-2 text-gray-400">...</span>
              </template>
            </div>

            <!-- Current Page (mobile only) -->
            <div class="md:hidden px-4 py-2 bg-white border border-gray-300 rounded-lg text-sm font-medium text-gray-700 min-h-[40px] flex items-center">
              {{ wallpapers.current_page }} / {{ wallpapers.last_page }}
            </div>

            <Link 
              v-if="wallpapers.next_page_url"
              :href="wallpapers.next_page_url"
              class="px-4 py-2 bg-white border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 transition-all min-h-[40px] flex items-center"
            >
              <span class="hidden sm:inline">Suivant</span>
              <i class="fas fa-chevron-right ml-2"></i>
            </Link>
            <div v-else class="px-4 py-2 bg-gray-100 border border-gray-200 rounded-lg text-sm font-medium text-gray-400 cursor-not-allowed min-h-[40px] flex items-center">
              <span class="hidden sm:inline">Suivant</span>
              <i class="fas fa-chevron-right ml-2"></i>
            </div>
          </div>
        </div>
      </div>
    </section>
  </AppLayout>
</template>

<script setup>
import { ref, computed } from 'vue';
import { Link, router } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';

const props = defineProps({
  wallpapers: {
    type: Object,
    required: true,
  },
  categories: {
    type: Array,
    required: true,
  },
  selectedCategory: {
    type: Number,
    default: null,
  },
});

const sortOption = ref('');

const categoryQuery = computed(() => {
  return props.selectedCategory ? `&category=${props.selectedCategory}` : '';
});

const sortQuery = computed(() => {
  return sortOption.value ? `&sort=${sortOption.value}` : '';
});

const paginationPages = computed(() => {
  const pages = [];
  const currentPage = props.wallpapers.current_page;
  const lastPage = props.wallpapers.last_page;
  
  if (lastPage <= 7) {
    for (let i = 1; i <= lastPage; i++) {
      pages.push(i);
    }
  } else {
    if (currentPage <= 3) {
      for (let i = 1; i <= 5; i++) {
        pages.push(i);
      }
      pages.push('...');
      pages.push(lastPage);
    } else if (currentPage >= lastPage - 2) {
      pages.push(1);
      pages.push('...');
      for (let i = lastPage - 4; i <= lastPage; i++) {
        pages.push(i);
      }
    } else {
      pages.push(1);
      pages.push('...');
      for (let i = currentPage - 1; i <= currentPage + 1; i++) {
        pages.push(i);
      }
      pages.push('...');
      pages.push(lastPage);
    }
  }
  
  return pages;
});

const handleSortChange = () => {
  router.visit(`/shop?sort=${sortOption.value}${categoryQuery.value}`, {
    preserveState: true,
    preserveScroll: true,
  });
};
</script>
