<template>
  <section class="space-y-10">
    <div v-if="loading" class="text-center py-12">
      <div class="text-4xl mb-2">🍽️</div>
      <p class="text-slate-500">Loading dish details...</p>
    </div>

    <template v-else-if="dish">
      <div class="grid gap-8 lg:grid-cols-[2fr,1fr]">
        <div class="space-y-4">
          <img :src="dish.image" :alt="dish.name" class="h-96 w-full rounded border border-slate-200 object-cover" />
          <div v-if="dish.images && dish.images.length > 1" class="flex gap-2 overflow-x-auto">
            <img 
              v-for="(img, idx) in dish.images" 
              :key="idx"
              :src="img"
              :alt="`${dish.name} - image ${idx + 1}`"
              class="h-20 w-20 rounded object-cover cursor-pointer border-2 hover:border-orange-500"
              :class="{ 'border-orange-500': currentImage === img }"
              @click="dish.image = img"
            />
          </div>
        </div>
        <div class="space-y-4">
          <div>
            <h1 class="text-3xl font-semibold">{{ dish.name }}</h1>
            <p class="mt-2 text-slate-600">{{ dish.restaurant }}</p>
            <p class="text-sm text-slate-500">{{ dish.address }}</p>
          </div>
          
          <div v-if="dish.comment" class="bg-slate-50 rounded p-4">
            <p class="text-slate-700 italic">"{{ dish.comment }}"</p>
          </div>
          
          <div class="space-y-2 text-sm">
            <p v-if="dish.category"><span class="font-semibold">Category:</span> {{ dish.category }}</p>
            <p><span class="font-semibold">Meal cost:</span> {{ dish.cost || '—' }}</p>
            <p><span class="font-semibold">Good date spot:</span> {{ dish.dateSpot }}</p>
            <p v-if="dish.website"><span class="font-semibold">Website:</span> 
              <a :href="dish.website" target="_blank" class="text-orange-600 hover:underline">{{ dish.website }}</a>
            </p>
            <p v-if="dish.hours"><span class="font-semibold">Opening hours:</span> {{ dish.hours }}</p>
          </div>
          
          <div class="flex items-center gap-4 text-lg">
            <span>⭐ {{ dish.rating || '—' }}</span>
            <span>❤️ {{ dish.likes }} likes</span>
          </div>
          
          <div class="flex gap-3">
            <button 
              @click="reactToDish('like')" 
              class="rounded border border-slate-400 px-4 py-2 hover:bg-green-50 hover:border-green-500 transition-colors"
              :class="{ 'bg-green-50 border-green-500': userReaction === 'like' }"
            >
              👍 Like
            </button>
            <button 
              @click="reactToDish('dislike')" 
              class="rounded border border-slate-400 px-4 py-2 hover:bg-red-50 hover:border-red-500 transition-colors"
              :class="{ 'bg-red-50 border-red-500': userReaction === 'dislike' }"
            >
              👎 Dislike
            </button>
          </div>
        </div>
      </div>

      <section class="rounded border border-slate-200 bg-white p-6 shadow-sm">
        <h2 class="text-xl font-semibold">Reviews ({{ reviews.length }})</h2>
        
        <form @submit.prevent="submitReview" class="mt-4 grid gap-4 md:grid-cols-[1fr,3fr]">
          <label class="flex flex-col gap-2">
            <span class="text-sm font-semibold">Rating</span>
            <select v-model="newReview.rating" class="rounded border border-slate-300 px-3 py-2">
              <option value="5">5 - Excellent</option>
              <option value="4">4 - Great</option>
              <option value="3">3 - Good</option>
              <option value="2">2 - Fair</option>
              <option value="1">1 - Poor</option>
            </select>
          </label>
          <label class="flex flex-col gap-2">
            <span class="text-sm font-semibold">Comment</span>
            <input v-model="newReview.comment" class="rounded border border-slate-300 px-3 py-2" placeholder="Share your experience..." />
          </label>
          <button type="submit" class="md:col-span-2 rounded border border-slate-500 px-5 py-2 text-sm hover:bg-slate-100 transition-colors">
            Submit review
          </button>
        </form>
        
        <div v-if="reviews.length" class="mt-6 space-y-4">
          <div v-for="review in reviews" :key="review.id" class="border-t pt-4">
            <div class="flex items-center gap-2">
              <span class="font-semibold">{{ review.user || 'Anonymous' }}</span>
              <span class="text-orange-500">{{ '⭐'.repeat(review.rating) }}</span>
            </div>
            <p class="text-slate-600 mt-1">{{ review.comment }}</p>
            <p class="text-xs text-slate-400 mt-1">{{ review.date }}</p>
          </div>
        </div>
        <p v-else class="mt-4 text-slate-500">No reviews yet. Be the first to review!</p>
      </section>

      <section v-if="relatedDishes.length">
        <h2 class="text-xl font-semibold">Other dishes from {{ dish.restaurant }}</h2>
        <div class="mt-4 grid gap-4 md:grid-cols-2 lg:grid-cols-4">
          <a v-for="relatedDish in relatedDishes" :key="relatedDish.id" :href="`/dishes/${relatedDish.id}`" class="rounded border border-slate-200 p-3 hover:shadow-md transition-shadow">
            <img :src="relatedDish.image" :alt="relatedDish.name" class="h-32 w-full rounded object-cover" />
            <p class="mt-2 text-sm font-semibold">{{ relatedDish.name }}</p>
            <p class="text-xs text-slate-500">{{ relatedDish.restaurant }}</p>
          </a>
        </div>
      </section>
    </template>

    <div v-else class="text-center py-12">
      <div class="text-4xl mb-2">😕</div>
      <p class="text-slate-500">Dish not found</p>
      <a href="/" class="mt-4 inline-block text-orange-600 hover:underline">← Back to home</a>
    </div>
  </section>
</template>

<script setup>
import { ref, reactive, onMounted } from 'vue';

const dish = ref(null);
const loading = ref(true);
const reviews = ref([]);
const relatedDishes = ref([]);
const userReaction = ref(null);
const currentImage = ref('');

const newReview = reactive({
  rating: '5',
  comment: ''
});

// Get dish ID from URL
function getDishId() {
  const path = window.location.pathname;
  const match = path.match(/\/dishes\/(\d+)/);
  return match ? parseInt(match[1]) : null;
}

async function loadDish() {
  const dishId = getDishId();
  if (!dishId) {
    loading.value = false;
    return;
  }

  try {
    const res = await fetch(`/api/dishes/${dishId}`);
    if (res.ok) {
      const data = await res.json();
      const images = (data.images || []).map(img => `/storage/${img.path}`);
      
      dish.value = {
        id: data.id,
        name: data.name,
        comment: data.comment,
        restaurant: data.restaurant?.name || 'Unknown Restaurant',
        restaurantId: data.restaurant?.id,
        address: data.restaurant ? `${data.restaurant.address}, ${data.restaurant.city}, ${data.restaurant.region} ${data.restaurant.postcode}` : '',
        category: data.restaurant?.categories?.[0]?.name || '',
        cost: data.meal_cost ? `$${data.meal_cost}` : '—',
        dateSpot: data.good_date_spot ? 'Yes' : 'No',
        website: data.website || data.restaurant?.website,
        hours: data.restaurant?.opening_hours || '',
        image: images[0] || 'https://images.unsplash.com/photo-1473093295043-cdd812d0e601?auto=format&fit=crop&w=900&q=80',
        images: images,
        rating: data.reviews_avg_rating ? parseFloat(data.reviews_avg_rating).toFixed(1) : null,
        likes: data.likes_count || 0
      };
      currentImage.value = dish.value.image;
      
      // Load reviews
      reviews.value = (data.reviews || []).map(r => ({
        id: r.id,
        user: r.user?.name || 'Anonymous',
        rating: r.rating,
        comment: r.comment,
        date: new Date(r.created_at).toLocaleDateString()
      }));
      
      // Load related dishes from same restaurant
      if (data.restaurant?.id) {
        loadRelatedDishes(data.restaurant.id, data.id);
      }
    }
  } catch (e) {
    console.error('Failed to load dish:', e);
  } finally {
    loading.value = false;
  }
}

async function loadRelatedDishes(restaurantId, excludeId) {
  try {
    const res = await fetch(`/api/restaurants/${restaurantId}`);
    if (res.ok) {
      const data = await res.json();
      relatedDishes.value = (data.dishes || [])
        .filter(d => d.id !== excludeId && d.status === 'approved')
        .slice(0, 4)
        .map(d => ({
          id: d.id,
          name: d.name,
          restaurant: data.name,
          image: d.images?.[0]?.path 
            ? `/storage/${d.images[0].path}` 
            : 'https://images.unsplash.com/photo-1540189549336-e6e99c3679fe?auto=format&fit=crop&w=600&q=80'
        }));
    }
  } catch (e) {
    console.error('Failed to load related dishes:', e);
  }
}

async function reactToDish(type) {
  const dishId = getDishId();
  if (!dishId) return;
  
  try {
    const res = await fetch(`/api/dishes/${dishId}/reactions`, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
      },
      body: JSON.stringify({ type })
    });
    
    if (res.ok) {
      userReaction.value = type;
      if (type === 'like') {
        dish.value.likes++;
      }
    }
  } catch (e) {
    console.error('Failed to react:', e);
  }
}

async function submitReview() {
  const dishId = getDishId();
  if (!dishId || !newReview.comment.trim()) return;
  
  try {
    const res = await fetch(`/api/dishes/${dishId}/reviews`, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
      },
      body: JSON.stringify({
        rating: parseInt(newReview.rating),
        comment: newReview.comment
      })
    });
    
    if (res.ok) {
      const data = await res.json();
      reviews.value.unshift({
        id: data.id,
        user: 'You',
        rating: data.rating,
        comment: data.comment,
        date: 'Just now'
      });
      newReview.comment = '';
      newReview.rating = '5';
    }
  } catch (e) {
    console.error('Failed to submit review:', e);
  }
}

onMounted(() => {
  loadDish();
});
</script>
