<template>
  <article class="overflow-hidden rounded border border-slate-200 bg-white shadow-sm transition-shadow hover:shadow-md">
    <a :href="`/dishes/${dish.id}`" class="block">
      <img :src="dish.image" :alt="dish.name" class="h-48 w-full object-cover" />
    </a>
    <div class="space-y-2 p-4">
      <div class="flex items-center justify-between">
        <h3 class="text-lg font-semibold truncate">{{ dish.name }}</h3>
        <span class="text-sm text-slate-500 ml-2 whitespace-nowrap">{{ dish.city }}</span>
      </div>
      <p class="text-sm text-slate-600 truncate">{{ dish.restaurant }}</p>
      <div class="flex items-center justify-between text-sm">
        <span class="font-medium">⭐ {{ dish.rating }}</span>
        <span class="text-slate-500">❤️ {{ dish.likes }} likes</span>
      </div>
      <a
        class="inline-flex items-center text-sm font-semibold text-slate-800 hover:text-orange-600 transition-colors"
        :href="`/dishes/${dish.id}`"
      >
        View dish →
      </a>
    </div>
  </article>
</template>

<script setup>
defineProps({
  dish: {
    type: Object,
    required: true,
  },
});
</script>
