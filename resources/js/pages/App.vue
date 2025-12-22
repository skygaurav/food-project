<template>
  <div>
    <SiteHeader />
    <main class="mx-auto w-full max-w-6xl px-6 pb-16 pt-10">
      <HomePage v-if="route === '/'" />
      <UploadPage v-else-if="route === '/upload'" />
      <DishPage v-else />
    </main>
  </div>
</template>

<script setup>
import { computed } from 'vue';
import SiteHeader from '../components/SiteHeader.vue';
import HomePage from './HomePage.vue';
import UploadPage from './UploadPage.vue';
import DishPage from './DishPage.vue';

const route = computed(() => window.location.pathname);
</script>
