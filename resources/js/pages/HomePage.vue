<template>
  <section class="space-y-10">
    <div class="rounded border border-slate-300 bg-white p-6 text-center">
      <h1 class="text-2xl font-medium">Upload a Dish or Drink!</h1>
      <a
        href="/upload"
        class="mt-4 inline-flex items-center justify-center rounded border border-slate-500 px-8 py-2 text-lg"
      >
        Upload
      </a>
    </div>

    <div class="rounded border border-slate-300 bg-white p-6">
      <h2 class="text-xl font-medium text-center mb-6">Filters</h2>
      <div class="grid gap-4 md:grid-cols-3">
        <label class="flex flex-col gap-2 text-left">
          <span class="text-sm font-semibold">Category</span>
          <select v-model="filters.category" @change="loadDishes" class="rounded border border-slate-300 px-3 py-2">
            <option value="">All Categories</option>
            <option v-for="category in categories" :key="category.id" :value="category.slug">
              {{ category.name }}
            </option>
          </select>
        </label>
        <label class="flex flex-col gap-2 text-left">
          <span class="text-sm font-semibold">City</span>
          <select v-model="filters.city" @change="loadDishes" class="rounded border border-slate-300 px-3 py-2">
            <option value="">All Cities</option>
            <option v-for="city in cities" :key="city" :value="city">
              {{ city }}
            </option>
          </select>
        </label>
        <label class="flex flex-col gap-2 text-left">
          <span class="text-sm font-semibold">Sort by</span>
          <select v-model="filters.sort" @change="loadDishes" class="rounded border border-slate-300 px-3 py-2">
            <option value="newest">Newest</option>
            <option value="top-reviewed">Highest Rated</option>
          </select>
        </label>
      </div>
    </div>

    <div v-if="loading" class="text-center py-12">
      <div class="text-4xl mb-2">🍽️</div>
      <p class="text-slate-500">Loading dishes...</p>
    </div>

    <div v-else-if="dishes.length === 0" class="text-center py-12">
      <div class="text-4xl mb-2">🍽️</div>
      <p class="text-slate-500">No dishes found. Be the first to upload one!</p>
    </div>

    <div v-else class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
      <DishCard
        v-for="dish in dishes"
        :key="dish.id"
        :dish="dish"
      />
    </div>

    <div v-if="pagination.lastPage > 1" class="flex justify-center gap-2">
      <button 
        @click="goToPage(pagination.currentPage - 1)"
        :disabled="pagination.currentPage === 1"
        class="rounded border border-slate-300 px-4 py-2 disabled:opacity-50"
      >
        ← Prev
      </button>
      <span class="px-4 py-2 text-slate-600">
        Page {{ pagination.currentPage }} of {{ pagination.lastPage }}
      </span>
      <button 
        @click="goToPage(pagination.currentPage + 1)"
        :disabled="pagination.currentPage === pagination.lastPage"
        class="rounded border border-slate-300 px-4 py-2 disabled:opacity-50"
      >
        Next →
      </button>
    </div>
  </section>
</template>

<script setup>
import { ref, onMounted, reactive } from 'vue';
import DishCard from '../components/DishCard.vue';

const dishes = ref([]);
const categories = ref([]);
const cities = ref(['Portland', 'Austin', 'Chicago', 'Seattle', 'San Jose', 'Denver', 'New York', 'Los Angeles']);
const loading = ref(true);

const filters = reactive({
  category: '',
  city: '',
  sort: 'newest'
});

const pagination = reactive({
  currentPage: 1,
  lastPage: 1,
  total: 0
});

async function loadCategories() {
  try {
    const res = await fetch('/api/categories');
    if (res.ok) {
      categories.value = await res.json();
    }
  } catch (e) {
    console.error('Failed to load categories:', e);
  }
}

async function loadDishes() {
  loading.value = true;
  try {
    const params = new URLSearchParams();
    if (filters.category) params.set('category', filters.category);
    if (filters.city) params.set('city', filters.city);
    if (filters.sort) params.set('sort', filters.sort);
    params.set('page', pagination.currentPage.toString());

    const res = await fetch(`/api/dishes?${params.toString()}`);
    if (res.ok) {
      const data = await res.json();
      dishes.value = (data.data || []).map(d => ({
        id: d.id,
        name: d.name,
        restaurant: d.restaurant?.name || 'Unknown Restaurant',
        city: d.restaurant?.city || '',
        rating: d.reviews_avg_rating ? parseFloat(d.reviews_avg_rating).toFixed(1) : '—',
        likes: d.likes_count || 0,
        image: d.images?.[0]?.path 
          ? `/storage/${d.images[0].path}` 
          : 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?auto=format&fit=crop&w=600&q=80'
      }));
      pagination.currentPage = data.current_page || 1;
      pagination.lastPage = data.last_page || 1;
      pagination.total = data.total || 0;
    }
  } catch (e) {
    console.error('Failed to load dishes:', e);
    dishes.value = [];
  } finally {
    loading.value = false;
  }
}

function goToPage(page) {
  if (page < 1 || page > pagination.lastPage) return;
  pagination.currentPage = page;
  loadDishes();
}

onMounted(() => {
  loadCategories();
  loadDishes();
});
</script>
