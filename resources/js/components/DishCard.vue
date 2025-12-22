<template>
  <article class="overflow-hidden rounded border border-slate-200 bg-white shadow-sm">
    <img :src="dish.image" :alt="dish.name" class="h-48 w-full object-cover" />
    <div class="space-y-2 p-4">
      <div class="flex items-center justify-between">
        <h3 class="text-lg font-semibold">{{ dish.name }}</h3>
        <span class="text-sm text-slate-500">{{ dish.city }}</span>
      </div>
      <p class="text-sm text-slate-600">{{ dish.restaurant }}</p>
      <div class="flex items-center justify-between text-sm">
        <span class="font-medium">⭐ {{ dish.rating }}</span>
        <span class="text-slate-500">{{ dish.likes }} likes</span>
      </div>
      <a
        class="inline-flex items-center text-sm font-semibold text-slate-800 underline"
        href="/dishes/1"
      >
        View dish
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
