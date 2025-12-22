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

    <div class="rounded border border-slate-300 bg-white p-6 text-center">
      <h2 class="text-xl font-medium">Filters (in the future)</h2>
      <div class="mt-6 grid gap-4 md:grid-cols-3">
        <label class="flex flex-col gap-2 text-left">
          <span class="text-sm font-semibold">Category</span>
          <select class="rounded border border-slate-300 px-3 py-2">
            <option>All</option>
            <option v-for="category in categories" :key="category">
              {{ category }}
            </option>
          </select>
        </label>
        <label class="flex flex-col gap-2 text-left">
          <span class="text-sm font-semibold">Near by me</span>
          <select class="rounded border border-slate-300 px-3 py-2">
            <option>Use my city</option>
            <option>Portland</option>
            <option>Austin</option>
            <option>Chicago</option>
          </select>
        </label>
        <label class="flex flex-col gap-2 text-left">
          <span class="text-sm font-semibold">Top reviewed</span>
          <select class="rounded border border-slate-300 px-3 py-2">
            <option>Newest</option>
            <option>Highest rating</option>
            <option>Most liked</option>
          </select>
        </label>
      </div>
    </div>

    <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
      <DishCard
        v-for="dish in dishes"
        :key="dish.id"
        :dish="dish"
      />
    </div>
  </section>
</template>

<script setup>
import DishCard from '../components/DishCard.vue';

const categories = ['American', 'Asian', 'Mexican', 'Italian', 'Mediterranean'];

const dishes = [
  {
    id: 1,
    name: 'Chili Garlic Ramen',
    restaurant: 'Kumar\'s Indian Grill',
    city: 'Portland',
    rating: 4.8,
    likes: 164,
    image: 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?auto=format&fit=crop&w=600&q=80',
  },
  {
    id: 2,
    name: 'Truffle Carbonara',
    restaurant: 'Violet & Co.',
    city: 'Austin',
    rating: 4.6,
    likes: 130,
    image: 'https://images.unsplash.com/photo-1525755662778-989d0524087e?auto=format&fit=crop&w=600&q=80',
  },
  {
    id: 3,
    name: 'Smoky Birria Tacos',
    restaurant: 'Casa Naranja',
    city: 'Chicago',
    rating: 4.9,
    likes: 212,
    image: 'https://images.unsplash.com/photo-1555939594-58d7cb561ad1?auto=format&fit=crop&w=600&q=80',
  },
  {
    id: 4,
    name: 'Lemon Herb Salmon',
    restaurant: 'Coastal Table',
    city: 'Seattle',
    rating: 4.7,
    likes: 98,
    image: 'https://images.unsplash.com/photo-1504674900247-0877df9cc836?auto=format&fit=crop&w=600&q=80',
  },
  {
    id: 5,
    name: 'Matcha Tart',
    restaurant: 'Kumo Sweets',
    city: 'San Jose',
    rating: 4.5,
    likes: 74,
    image: 'https://images.unsplash.com/photo-1481391032119-d89fee407e44?auto=format&fit=crop&w=600&q=80',
  },
  {
    id: 6,
    name: 'Seared Ribeye Bowl',
    restaurant: 'Grill Union',
    city: 'Denver',
    rating: 4.4,
    likes: 62,
    image: 'https://images.unsplash.com/photo-1482049016688-2d3e1b311543?auto=format&fit=crop&w=600&q=80',
  },
];
</script>
