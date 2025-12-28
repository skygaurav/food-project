<template>
  <div class="admin-dashboard">
    <h1>Admin Dashboard</h1>
    <div class="quick-links">
      <router-link to="/restaurants">Restaurants</router-link>
      <router-link to="/categories">Categories</router-link>
    </div>
  </div>
</template>

<script setup>
</script>

<style scoped>
.admin-dashboard {
  padding: 2rem;
}
.quick-links {
  margin-top: 2rem;
  display: flex;
  gap: 2rem;
}
</style>
