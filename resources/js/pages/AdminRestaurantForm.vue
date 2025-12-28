<template>
  <div class="admin-restaurant-form">
    <h2>{{ isEdit ? 'Edit' : 'Add' }} Restaurant</h2>
    <form @submit.prevent="onSubmit">
      <div v-for="field in fields" :key="field.key" class="form-group">
        <label :for="field.key">{{ field.label }}</label>
        <input v-model="form[field.key]" :id="field.key" :type="field.type || 'text'" :placeholder="field.label" />
      </div>
      <button type="submit">{{ isEdit ? 'Update' : 'Create' }}</button>
    </form>
  </div>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue';
import { useRoute, useRouter } from 'vue-router';
const route = useRoute();
const router = useRouter();
const id = route.params.id;
const isEdit = computed(() => !!id);
const fields = [
  { key: 'name', label: 'Name' },
  { key: 'address', label: 'Address' },
  { key: 'city', label: 'City' },
  { key: 'website', label: 'Website' },
  { key: 'phone', label: 'Phone' },
  { key: 'email', label: 'Email' },
  { key: 'description', label: 'Description' },
];
const form = ref({});
async function fetchRestaurant() {
  if (!id) return;
  const res = await fetch(`/admin/api/restaurants/${id}`);
  form.value = await res.json();
}
onMounted(fetchRestaurant);
async function onSubmit() {
  const method = isEdit.value ? 'PUT' : 'POST';
  const url = isEdit.value ? `/admin/api/restaurants/${id}` : '/admin/api/restaurants';
  await fetch(url, {
    method,
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify(form.value)
  });
  router.push('/restaurants');
}
</script>

<style scoped>
.admin-restaurant-form { padding: 2rem; max-width: 600px; margin: auto; }
.form-group { margin-bottom: 1rem; }
label { display: block; margin-bottom: 0.3rem; }
input { width: 100%; padding: 0.5rem; border-radius: 4px; border: 1px solid #ccc; }
button { margin-top: 1rem; }
</style>
