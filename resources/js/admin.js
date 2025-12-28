import { createApp } from 'vue';
import { createRouter, createWebHistory } from 'vue-router';
import AdminApp from './pages/AdminApp.vue';


import AdminDashboard from './pages/AdminDashboard.vue';
import AdminRestaurants from './pages/AdminRestaurants.vue';
import AdminCategories from './pages/AdminCategories.vue';
import AdminRestaurantForm from './pages/AdminRestaurantForm.vue';

const routes = [
  { path: '/', component: AdminDashboard },
  { path: '/restaurants', component: AdminRestaurants },
  { path: '/categories', component: AdminCategories },
  { path: '/restaurants/create', component: AdminRestaurantForm },
  { path: '/restaurants/:id/edit', component: AdminRestaurantForm },
];

const router = createRouter({
  history: createWebHistory('/admin/'),
  routes,
});

createApp(AdminApp).use(router).mount('#admin-app');
