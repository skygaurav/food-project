<template>
  <section class="mx-auto max-w-3xl space-y-10">
    <div class="text-center space-y-4">
      <h1 class="text-2xl font-semibold">Upload a Dish or Drink!</h1>
      <p class="text-slate-600">Share your favorite dishes with the community</p>
    </div>

    <div class="rounded border border-slate-200 bg-white p-6 shadow-sm">
      <div v-if="submitted" class="text-center py-8">
        <div class="text-4xl mb-4">🎉</div>
        <h2 class="text-xl font-semibold text-green-600">Thank you for your submission!</h2>
        <p class="text-slate-600 mt-2">Your dish is pending review and will appear once approved.</p>
        <a href="/" class="mt-4 inline-block text-orange-600 hover:underline">← Back to home</a>
      </div>

      <form v-else @submit.prevent="submit" class="space-y-6">
        <div class="grid gap-6 md:grid-cols-2">
          <label class="flex flex-col gap-2">
            <span class="text-sm font-semibold">Restaurant <span class="text-red-500">*</span></span>
            <select v-model="form.restaurant_id" class="rounded border border-slate-300 px-3 py-2" required>
              <option value="">Select a restaurant...</option>
              <option v-for="r in restaurants" :key="r.id" :value="r.id">
                {{ r.name }} — {{ r.city }}
              </option>
            </select>
          </label>

          <label class="flex flex-col gap-2">
            <span class="text-sm font-semibold">Dish Name <span class="text-red-500">*</span></span>
            <input v-model="form.name" class="rounded border border-slate-300 px-3 py-2" placeholder="e.g., Spicy Ramen" required />
          </label>
        </div>

        <label class="flex flex-col gap-2">
          <span class="text-sm font-semibold">Comment</span>
          <textarea v-model="form.comment" class="rounded border border-slate-300 px-3 py-2" rows="3" placeholder="Tell us about this dish..."></textarea>
        </label>

        <div class="grid gap-6 md:grid-cols-2">
          <label class="flex flex-col gap-2">
            <span class="text-sm font-semibold">Meal Cost ($)</span>
            <input v-model="form.meal_cost" type="number" step="0.01" min="0" class="rounded border border-slate-300 px-3 py-2" placeholder="25.00" />
          </label>

          <label class="flex flex-col gap-2">
            <span class="text-sm font-semibold">Website</span>
            <input v-model="form.website" type="url" class="rounded border border-slate-300 px-3 py-2" placeholder="https://..." />
          </label>
        </div>

        <label class="flex items-center gap-3 cursor-pointer">
          <input type="checkbox" v-model="form.good_date_spot" class="w-5 h-5 accent-orange-500" />
          <span class="text-sm font-semibold">Good date spot</span>
        </label>

        <label class="flex flex-col gap-2">
          <span class="text-sm font-semibold">Photos</span>
          <div class="border-2 border-dashed border-slate-300 rounded-lg p-6 text-center hover:border-orange-500 transition-colors cursor-pointer" @click="$refs.fileInput.click()">
            <input ref="fileInput" type="file" accept="image/*" multiple class="hidden" @change="handleFiles" />
            <div v-if="form.images.length === 0">
              <div class="text-3xl mb-2">📷</div>
              <p class="text-slate-600">Click to upload images</p>
              <p class="text-xs text-slate-400 mt-1">PNG, JPG up to 5MB each</p>
            </div>
            <div v-else class="flex flex-wrap gap-2 justify-center">
              <div v-for="(img, idx) in previewImages" :key="idx" class="relative">
                <img :src="img" class="w-20 h-20 object-cover rounded" />
                <button type="button" @click.stop="removeImage(idx)" class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-5 h-5 text-xs">×</button>
              </div>
            </div>
          </div>
        </label>

        <div v-if="selectedRestaurant" class="bg-slate-50 rounded p-4 space-y-2 text-sm">
          <p class="font-semibold text-slate-700">Restaurant Information:</p>
          <p class="font-semibold">{{ selectedRestaurant.name }}</p>
          <p>{{ selectedRestaurant.address }}</p>
          <p>{{ selectedRestaurant.city }}, {{ selectedRestaurant.region }} {{ selectedRestaurant.postcode }}</p>
          <p v-if="selectedRestaurant.website">
            <a :href="selectedRestaurant.website" target="_blank" class="text-orange-600 hover:underline">{{ selectedRestaurant.website }}</a>
          </p>
          <p v-if="selectedRestaurant.categories && selectedRestaurant.categories.length">
            Categories: {{ selectedRestaurant.categories.map(c => c.name).join(', ') }}
          </p>
        </div>

        <div class="flex flex-col gap-4">
          <button type="submit" :disabled="submitting" class="rounded bg-orange-500 text-white px-6 py-3 text-lg font-semibold hover:bg-orange-600 transition-colors disabled:opacity-50">
            {{ submitting ? 'Submitting...' : 'Submit Dish' }}
          </button>
        </div>
        
        <p v-if="error" class="text-red-500 text-sm text-center">{{ error }}</p>
      </form>
    </div>
  </section>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue';

const restaurants = ref([]);
const form = ref({
  restaurant_id: '',
  name: '',
  comment: '',
  meal_cost: '',
  good_date_spot: false,
  website: '',
  images: []
});
const previewImages = ref([]);
const submitting = ref(false);
const submitted = ref(false);
const error = ref('');

const selectedRestaurant = computed(() => {
  if (!form.value.restaurant_id) return null;
  return restaurants.value.find(r => r.id === parseInt(form.value.restaurant_id));
});

async function loadRestaurants() {
  try {
    const res = await fetch('/api/restaurants');
    if (res.ok) {
      restaurants.value = await res.json();
    }
  } catch (e) {
    console.error('Failed to load restaurants:', e);
  }
}

function handleFiles(event) {
  const files = Array.from(event.target.files);
  form.value.images.push(...files);
  
  files.forEach(file => {
    const reader = new FileReader();
    reader.onload = (e) => {
      previewImages.value.push(e.target.result);
    };
    reader.readAsDataURL(file);
  });
}

function removeImage(index) {
  form.value.images.splice(index, 1);
  previewImages.value.splice(index, 1);
}

async function submit() {
  error.value = '';
  
  if (!form.value.restaurant_id || !form.value.name) {
    error.value = 'Please select a restaurant and enter a dish name';
    return;
  }
  
  submitting.value = true;
  
  const fd = new FormData();
  fd.append('restaurant_id', form.value.restaurant_id);
  fd.append('name', form.value.name);
  fd.append('comment', form.value.comment || '');
  if (form.value.meal_cost) fd.append('meal_cost', form.value.meal_cost);
  fd.append('good_date_spot', form.value.good_date_spot ? '1' : '0');
  if (form.value.website) fd.append('website', form.value.website);
  
  form.value.images.forEach((file, idx) => {
    fd.append(`images[${idx}]`, file);
  });

  try {
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
    const res = await fetch('/api/dishes', {
      method: 'POST',
      credentials: 'same-origin',
      headers: {
        'X-CSRF-TOKEN': csrfToken
      },
      body: fd
    });
    
    if (!res.ok) {
      const data = await res.json().catch(() => ({}));
      throw new Error(data.message || 'Submission failed');
    }
    
    submitted.value = true;
  } catch (e) {
    error.value = e.message || 'Failed to submit dish. Please try again.';
  } finally {
    submitting.value = false;
  }
}

onMounted(() => {
  loadRestaurants();
});
</script>
