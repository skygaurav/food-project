<template>
  <div class="admin-category-form">
    <h2>{{ isEdit ? 'Edit' : 'Add' }} Category</h2>
    <form @submit.prevent="onSubmit">
      <div class="form-group">
        <label for="name">Name</label>
        <input v-model="form.name" id="name" type="text" placeholder="Name" />
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
const form = ref({ name: '' });
async function fetchCategory() {
  if (!id) return;
  const res = await fetch(`/admin/api/categories/${id}`);
  form.value = await res.json();
}
onMounted(fetchCategory);
async function onSubmit() {
  const method = isEdit.value ? 'PUT' : 'POST';
  const url = isEdit.value ? `/admin/api/categories/${id}` : '/admin/api/categories';
  await fetch(url, {
    method,
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify(form.value)
  });
  router.push('/categories');
}
</script>

<style scoped>
.admin-category-form { padding: 2rem; max-width: 400px; margin: auto; }
.form-group { margin-bottom: 1rem; }
label { display: block; margin-bottom: 0.3rem; }
input { width: 100%; padding: 0.5rem; border-radius: 4px; border: 1px solid #ccc; }
button { margin-top: 1rem; }
</style>
