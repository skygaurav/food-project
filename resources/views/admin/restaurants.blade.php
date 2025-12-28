@php($title = 'Restaurants')

<x-admin-layout :title="$title">
    <div id="admin-restaurants">
        <div class="admin-header">
            <div>
                <h1 class="text-2xl font-semibold">Restaurants</h1>
                <p class="text-slate-600">Add, edit, and search restaurants across locations.</p>
            </div>
            <button class="rounded border border-slate-500 px-4 py-2" @click="openForm('create')">
                + Add new restaurant
            </button>
        </div>

        <div class="admin-card">
            <div class="admin-card-header">
                <div class="admin-toolbar">
                    <input
                        v-model="filters.query"
                        class="rounded border border-slate-300 px-3 py-2 admin-search"
                        placeholder="Search by name, address, city, region, or country"
                    />
                    <span class="admin-pill">{{ filteredRestaurants.length }} results</span>
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
                            <th v-if="isVisible('address')">Address</th>
                            <th v-if="isVisible('city')">City</th>
                            <th v-if="isVisible('region')">Region</th>
                            <th v-if="isVisible('country')">Country</th>
                            <th v-if="isVisible('postcode')">Postcode</th>
                            <th v-if="isVisible('website')">Website</th>
                            <th v-if="isVisible('opening')">Opening hours</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="restaurant in filteredRestaurants" :key="restaurant.id">
                            <td v-if="isVisible('name')">{{ restaurant.name }}</td>
                            <td v-if="isVisible('address')">{{ restaurant.address }}</td>
                            <td v-if="isVisible('city')">{{ restaurant.city }}</td>
                            <td v-if="isVisible('region')">{{ restaurant.region }}</td>
                            <td v-if="isVisible('country')">{{ restaurant.country }}</td>
                            <td v-if="isVisible('postcode')">{{ restaurant.postcode }}</td>
                            <td v-if="isVisible('website')">{{ restaurant.website }}</td>
                            <td v-if="isVisible('opening')">{{ restaurant.openingHours }}</td>
                            <td>
                                <button class="rounded border border-slate-500 px-3 py-1" @click="openForm('edit', restaurant)">
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
                    <h2 class="text-xl font-semibold">{{ form.mode === 'create' ? 'Add restaurant' : 'Edit restaurant' }}</h2>
                    <p class="text-slate-600">Fill in every restaurant field from the database table.</p>
                </div>
            </div>
            <div class="admin-card-body">
                <form class="admin-form-grid">
                    <label class="flex flex-col gap-2">
                        <span class="text-sm font-semibold">Name</span>
                        <input v-model="form.values.name" class="rounded border border-slate-300 px-3 py-2" />
                    </label>
                    <label class="flex flex-col gap-2">
                        <span class="text-sm font-semibold">Address</span>
                        <input v-model="form.values.address" class="rounded border border-slate-300 px-3 py-2" />
                    </label>
                    <label class="flex flex-col gap-2">
                        <span class="text-sm font-semibold">City</span>
                        <input v-model="form.values.city" class="rounded border border-slate-300 px-3 py-2" />
                    </label>
                    <label class="flex flex-col gap-2">
                        <span class="text-sm font-semibold">Region</span>
                        <input v-model="form.values.region" class="rounded border border-slate-300 px-3 py-2" />
                    </label>
                    <label class="flex flex-col gap-2">
                        <span class="text-sm font-semibold">Country</span>
                        <input v-model="form.values.country" class="rounded border border-slate-300 px-3 py-2" />
                    </label>
                    <label class="flex flex-col gap-2">
                        <span class="text-sm font-semibold">Postcode</span>
                        <input v-model="form.values.postcode" class="rounded border border-slate-300 px-3 py-2" />
                    </label>
                    <label class="flex flex-col gap-2">
                        <span class="text-sm font-semibold">Website</span>
                        <input v-model="form.values.website" class="rounded border border-slate-300 px-3 py-2" />
                    </label>
                    <label class="flex flex-col gap-2">
                        <span class="text-sm font-semibold">Opening hours</span>
                        <input v-model="form.values.openingHours" class="rounded border border-slate-300 px-3 py-2" />
                    </label>
                </form>
                <div class="mt-4 flex gap-3">
                    <button class="rounded border border-slate-500 px-4 py-2" type="button">
                        {{ form.mode === 'create' ? 'Create restaurant' : 'Save changes' }}
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
                    restaurants: [
                        {
                            id: 1,
                            name: "Kumar's Indian Grill",
                            address: '123 Street Name',
                            city: 'Portland',
                            region: 'OR',
                            country: 'USA',
                            postcode: '97025',
                            website: 'www.kumarsgrill.com',
                            openingHours: 'Mon-Sun 11AM - 10PM',
                        },
                        {
                            id: 2,
                            name: 'Casa Naranja',
                            address: '45 Market Lane',
                            city: 'Chicago',
                            region: 'IL',
                            country: 'USA',
                            postcode: '60601',
                            website: 'www.casanaranja.com',
                            openingHours: 'Daily 12PM - 11PM',
                        },
                    ],
                    columns: [
                        { key: 'name', label: 'Name', visible: true },
                        { key: 'address', label: 'Address', visible: true },
                        { key: 'city', label: 'City', visible: true },
                        { key: 'region', label: 'Region', visible: true },
                        { key: 'country', label: 'Country', visible: true },
                        { key: 'postcode', label: 'Postcode', visible: true },
                        { key: 'website', label: 'Website', visible: true },
                        { key: 'opening', label: 'Opening', visible: false },
                    ],
                    form: {
                        mode: 'create',
                        values: {
                            name: '',
                            address: '',
                            city: '',
                            region: '',
                            country: '',
                            postcode: '',
                            website: '',
                            openingHours: '',
                        },
                    },
                };
            },
            computed: {
                filteredRestaurants() {
                    const query = this.filters.query.toLowerCase();
                    return this.restaurants.filter((restaurant) => {
                        return [
                            restaurant.name,
                            restaurant.address,
                            restaurant.city,
                            restaurant.region,
                            restaurant.country,
                            restaurant.postcode,
                            restaurant.website,
                        ]
                            .join(' ')
                            .toLowerCase()
                            .includes(query);
                    });
                },
            },
            created() {
                const saved = localStorage.getItem('foodcita_admin_restaurant_columns');
                if (saved) {
                    this.columns = JSON.parse(saved);
                }
            },
            methods: {
                isVisible(key) {
                    return this.columns.find((column) => column.key === key)?.visible;
                },
                saveColumns() {
                    localStorage.setItem('foodcita_admin_restaurant_columns', JSON.stringify(this.columns));
                },
                openForm(mode, restaurant = null) {
                    this.form.mode = mode;
                    this.form.values = restaurant
                        ? { ...restaurant }
                        : {
                              name: '',
                              address: '',
                              city: '',
                              region: '',
                              country: '',
                              postcode: '',
                              website: '',
                              openingHours: '',
                          };
                },
                resetForm() {
                    this.form.values = {
                        name: '',
                        address: '',
                        city: '',
                        region: '',
                        country: '',
                        postcode: '',
                        website: '',
                        openingHours: '',
                    };
                },
            },
        }).mount('#admin-restaurants');
    </script>
</x-admin-layout>
