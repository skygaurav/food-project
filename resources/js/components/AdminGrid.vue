<template>
  <div class="admin-grid">
    <div class="admin-grid-toolbar">
      <input v-model="search" :placeholder="'Search ' + searchFields.join(', ')" @input="fetchData" />
      <button @click="$emit('add')">{{ addLabel }}</button>
      <div class="admin-grid-columns">
        <label v-for="col in columns" :key="col.key">
          <input type="checkbox" v-model="visibleColumns" :value="col.key" /> {{ col.label }}
        </label>
      </div>
    </div>
    <table>
      <thead>
        <tr>
          <th v-for="col in shownColumns" :key="col.key">{{ col.label }}</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="row in filteredRows" :key="row.id">
          <td v-for="col in shownColumns" :key="col.key">{{ row[col.key] }}</td>
          <td>
            <button @click="$emit('edit', row)">Edit</button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script setup>
import { ref, computed, watch, onMounted } from 'vue';
const props = defineProps({
  columns: Array,
  fetchUrl: String,
  searchFields: Array,
  addLabel: String
});
const emit = defineEmits(['add','edit']);
const rows = ref([]);
const search = ref('');
const visibleColumns = ref(props.columns.map(c=>c.key));
const shownColumns = computed(() => props.columns.filter(c=>visibleColumns.value.includes(c.key)));
const filteredRows = computed(() => {
  if (!search.value) return rows.value;
  return rows.value.filter(row =>
    props.searchFields.some(f => (row[f]||'').toLowerCase().includes(search.value.toLowerCase()))
  );
});
async function fetchData() {
  const res = await fetch(props.fetchUrl);
  rows.value = await res.json();
}
onMounted(fetchData);
watch(search, fetchData);
</script>

<style scoped>
.admin-grid { background: #fff; border-radius: 8px; box-shadow: 0 2px 8px #0001; padding: 1.5rem; }
.admin-grid-toolbar { display: flex; gap: 1rem; align-items: center; margin-bottom: 1rem; }
.admin-grid-columns { display: flex; gap: 0.5rem; }
table { width: 100%; border-collapse: collapse; }
th, td { padding: 0.5rem 1rem; border-bottom: 1px solid #eee; }
</style>
