@php($title = 'Dishes')

<x-admin-layout :title="$title">
    <div id="admin-dishes">
        <div class="admin-header">
            <div>
                <h1 class="text-2xl font-semibold">Dishes</h1>
                <p class="text-slate-600">Review dish submissions and track approval status.</p>
            </div>
            <a class="rounded border border-slate-500 px-4 py-2" href="/">
                View public site
            </a>
        </div>

        <div class="admin-card">
            <div class="admin-card-header">
                <div class="admin-toolbar">
                    <input
                        v-model="filters.query"
                        class="rounded border border-slate-300 px-3 py-2 admin-search"
                        placeholder="Search by dish, restaurant, or status"
                    />
                    <select v-model="filters.status" class="rounded border border-slate-300 px-3 py-2">
                        <option value="">All statuses</option>
                        <option value="pending">Pending</option>
                        <option value="approved">Approved</option>
                        <option value="rejected">Rejected</option>
                    </select>
                    <span class="admin-pill">{{ filteredDishes.length }} results</span>
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
                            <th v-if="isVisible('dish')">Dish</th>
                            <th v-if="isVisible('restaurant')">Restaurant</th>
                            <th v-if="isVisible('comment')">Comment</th>
                            <th v-if="isVisible('status')">Status</th>
                            <th v-if="isVisible('created')">Submitted</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="dish in filteredDishes" :key="dish.id">
                            <td v-if="isVisible('dish')">{{ dish.name }}</td>
                            <td v-if="isVisible('restaurant')">{{ dish.restaurant }}</td>
                            <td v-if="isVisible('comment')">{{ dish.comment }}</td>
                            <td v-if="isVisible('status')">
                                <span class="admin-pill">{{ dish.status }}</span>
                            </td>
                            <td v-if="isVisible('created')">{{ dish.createdAt }}</td>
                            <td>
                                <button class="rounded border border-slate-500 px-3 py-1">View</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
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
                        status: '',
                    },
                    dishes: [
                        {
                            id: 1,
                            name: 'Chili Garlic Ramen',
                            restaurant: "Kumar's Indian Grill",
                            comment: 'Loved the spice and broth.',
                            status: 'pending',
                            createdAt: '2024-05-10',
                        },
                        {
                            id: 2,
                            name: 'Smoky Birria Tacos',
                            restaurant: 'Casa Naranja',
                            comment: 'Perfect crunch and smoky flavor.',
                            status: 'approved',
                            createdAt: '2024-05-11',
                        },
                    ],
                    columns: [
                        { key: 'dish', label: 'Dish', visible: true },
                        { key: 'restaurant', label: 'Restaurant', visible: true },
                        { key: 'comment', label: 'Comment', visible: true },
                        { key: 'status', label: 'Status', visible: true },
                        { key: 'created', label: 'Submitted', visible: true },
                    ],
                };
            },
            computed: {
                filteredDishes() {
                    const query = this.filters.query.toLowerCase();
                    return this.dishes.filter((dish) => {
                        const matchesQuery = [dish.name, dish.restaurant, dish.comment, dish.status]
                            .join(' ')
                            .toLowerCase()
                            .includes(query);
                        const matchesStatus = this.filters.status
                            ? dish.status === this.filters.status
                            : true;
                        return matchesQuery && matchesStatus;
                    });
                },
            },
            created() {
                const saved = localStorage.getItem('foodcita_admin_dish_columns');
                if (saved) {
                    this.columns = JSON.parse(saved);
                }
            },
            methods: {
                isVisible(key) {
                    return this.columns.find((column) => column.key === key)?.visible;
                },
                saveColumns() {
                    localStorage.setItem('foodcita_admin_dish_columns', JSON.stringify(this.columns));
                },
            },
        }).mount('#admin-dishes');
    </script>
</x-admin-layout>
