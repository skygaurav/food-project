@php($title = 'Categories')

<x-admin-layout :title="$title">
    <div id="admin-categories">
        <div class="admin-header">
            <div>
                <h1 class="text-2xl font-semibold">Categories</h1>
                <p class="text-slate-600">Manage cuisine categories and keep the listing searchable.</p>
            </div>
            <button class="rounded border border-slate-500 px-4 py-2" @click="openForm('create')">
                + Add new category
            </button>
        </div>

        <div class="admin-card">
            <div class="admin-card-header">
                <div class="admin-toolbar">
                    <input
                        v-model="filters.query"
                        class="rounded border border-slate-300 px-3 py-2 admin-search"
                        placeholder="Search by name or slug"
                    />
                    <span class="admin-pill">{{ filteredCategories.length }} results</span>
                </div>
                <div class="admin-toolbar">
                    <div class="flex gap-2 text-sm">
                        <label v-for="column in columns" :key="column.key" class="flex items-center gap-2">
                            <input type="checkbox" v-model="column.visible" @change="saveColumns" />
                            {{ column.label }}
                        </label>
                    </div>
                </div>
            </div>
            <div class="admin-card-body">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th v-if="isVisible('name')">Name</th>
                            <th v-if="isVisible('slug')">Slug</th>
                            <th v-if="isVisible('created')">Created</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="category in filteredCategories" :key="category.id">
                            <td v-if="isVisible('name')">{{ category.name }}</td>
                            <td v-if="isVisible('slug')">{{ category.slug }}</td>
                            <td v-if="isVisible('created')">{{ category.createdAt }}</td>
                            <td>
                                <button class="rounded border border-slate-500 px-3 py-1" @click="openForm('edit', category)">
                                    Edit
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="admin-card mt-6">
            <div class="admin-card-header">
                <div>
                    <h2 class="text-xl font-semibold">{{ form.mode === 'create' ? 'Add category' : 'Edit category' }}</h2>
                    <p class="text-slate-600">All fields are required except where marked.</p>
                </div>
            </div>
            <div class="admin-card-body">
                <form class="admin-form-grid">
                    <label class="flex flex-col gap-2">
                        <span class="text-sm font-semibold">Name</span>
                        <input v-model="form.values.name" class="rounded border border-slate-300 px-3 py-2" />
                    </label>
                    <label class="flex flex-col gap-2">
                        <span class="text-sm font-semibold">Slug</span>
                        <input v-model="form.values.slug" class="rounded border border-slate-300 px-3 py-2" />
                    </label>
                </form>
                <div class="mt-4 flex gap-3">
                    <button class="rounded border border-slate-500 px-4 py-2" type="button">
                        {{ form.mode === 'create' ? 'Create category' : 'Save changes' }}
                    </button>
                    <button class="rounded border border-slate-300 px-4 py-2" type="button" @click="resetForm">
                        Reset
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://unpkg.com/vue@3/dist/vue.global.prod.js"></script>
    <script>
        const { createApp } = Vue;

        createApp({
            data() {
                return {
                    filters: {
                        query: '',
                    },
                    categories: [
                        { id: 1, name: 'American', slug: 'american', createdAt: '2024-05-01' },
                        { id: 2, name: 'Asian', slug: 'asian', createdAt: '2024-05-04' },
                        { id: 3, name: 'Mexican', slug: 'mexican', createdAt: '2024-05-07' },
                        { id: 4, name: 'Italian', slug: 'italian', createdAt: '2024-05-09' },
                    ],
                    columns: [
                        { key: 'name', label: 'Name', visible: true },
                        { key: 'slug', label: 'Slug', visible: true },
                        { key: 'created', label: 'Created', visible: true },
                    ],
                    form: {
                        mode: 'create',
                        values: {
                            name: '',
                            slug: '',
                        },
                    },
                };
            },
            computed: {
                filteredCategories() {
                    const query = this.filters.query.toLowerCase();
                    return this.categories.filter((category) => {
                        return (
                            category.name.toLowerCase().includes(query) ||
                            category.slug.toLowerCase().includes(query)
                        );
                    });
                },
            },
            created() {
                const saved = localStorage.getItem('foodcita_admin_category_columns');
                if (saved) {
                    this.columns = JSON.parse(saved);
                }
            },
            methods: {
                isVisible(key) {
                    return this.columns.find((column) => column.key === key)?.visible;
                },
                saveColumns() {
                    localStorage.setItem('foodcita_admin_category_columns', JSON.stringify(this.columns));
                },
                openForm(mode, category = null) {
                    this.form.mode = mode;
                    this.form.values = category
                        ? { name: category.name, slug: category.slug }
                        : { name: '', slug: '' };
                },
                resetForm() {
                    this.form.values = { name: '', slug: '' };
                },
            },
        }).mount('#admin-categories');
    </script>
</x-admin-layout>
