<template>
  <div class="admin-restaurants">
    <h2>Restaurants</h2>
    <admin-grid
      :columns="columns"
      :fetch-url="'/admin/api/restaurants'"
      :search-fields="['name','address','city','website']"
      add-label="Add Restaurant"
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
  { key: 'address', label: 'Address' },
  { key: 'city', label: 'City' },
  { key: 'website', label: 'Website' },
];

function onAdd() {
  router.push('/restaurants/create');
}
function onEdit(row) {
  router.push(`/restaurants/${row.id}/edit`);
}
</script>

<style scoped>
.admin-restaurants { padding: 2rem; }
</style>
