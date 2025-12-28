<template>
  <div class="admin-categories">
    <h2>Categories</h2>
    <admin-grid
      :columns="columns"
      :fetch-url="'/admin/api/categories'"
      :search-fields="['name']"
      add-label="Add Category"
      @add="onAdd"
      @edit="onEdit"
    />
  </div>
</template>

<script setup>
import AdminGrid from '../components/AdminGrid.vue';
import { useRouter } from 'vue-router';

const router = useRouter();
const columns = [
  { key: 'name', label: 'Name' },
];

function onAdd() {
  router.push('/categories/create');
}
function onEdit(row) {
  router.push(`/categories/${row.id}/edit`);
}
</script>

<style scoped>
.admin-categories { padding: 2rem; }
</style>
