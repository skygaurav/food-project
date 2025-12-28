<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Foodcita</title>
    <link rel="stylesheet" href="/app.css">
</head>
<body class="font-serif text-slate-900 bg-white">
    <div id="frontend-home">
        <header class="bg-black py-6 text-center text-white">
            <a href="/" class="text-3xl font-semibold tracking-wide">FOODCITA</a>
        </header>
        <main class="mx-auto w-full max-w-6xl px-6 pb-16 pt-10">
            <section class="space-y-10">
                <div class="rounded border border-slate-300 bg-white p-6 text-center">
                    <h1 class="text-2xl font-medium">Upload a Dish or Drink!</h1>
                    <a
                        href="/upload"
                        class="mt-4 inline-flex items-center justify-center rounded border border-slate-500 px-8 py-2 text-lg"
                    >
                        Upload
                    </a>
                </div>

                <div class="rounded border border-slate-300 bg-white p-6 text-center">
                    <h2 class="text-xl font-medium">Filters (in the future)</h2>
                    <div class="mt-6 grid gap-4 md:grid-cols-3">
                        <label class="flex flex-col gap-2 text-left">
                            <span class="text-sm font-semibold">Category</span>
                            <select class="rounded border border-slate-300 px-3 py-2">
                                <option>All</option>
                                <option v-for="category in categories" :key="category">{{ category }}</option>
                            </select>
                        </label>
                        <label class="flex flex-col gap-2 text-left">
                            <span class="text-sm font-semibold">Near by me</span>
                            <select class="rounded border border-slate-300 px-3 py-2">
                                <option>Use my city</option>
                                <option>Portland</option>
                                <option>Austin</option>
                                <option>Chicago</option>
                            </select>
                        </label>
                        <label class="flex flex-col gap-2 text-left">
                            <span class="text-sm font-semibold">Top reviewed</span>
                            <select class="rounded border border-slate-300 px-3 py-2">
                                <option>Newest</option>
                                <option>Highest rating</option>
                                <option>Most liked</option>
                            </select>
                        </label>
                    </div>
                </div>

                <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                    <article
                        v-for="dish in dishes"
                        :key="dish.id"
                        class="overflow-hidden rounded border border-slate-200 bg-white shadow-sm"
                    >
                        <img :src="dish.image" :alt="dish.name" class="h-48 w-full object-cover" />
                        <div class="space-y-2 p-4">
                            <div class="flex items-center justify-between">
                                <h3 class="text-lg font-semibold">{{ dish.name }}</h3>
                                <span class="text-sm text-slate-500">{{ dish.city }}</span>
                            </div>
                            <p class="text-sm text-slate-600">{{ dish.restaurant }}</p>
                            <div class="flex items-center justify-between text-sm">
                                <span class="font-medium">⭐ {{ dish.rating }}</span>
                                <span class="text-slate-500">{{ dish.likes }} likes</span>
                            </div>
                            <a class="inline-flex items-center text-sm font-semibold text-slate-800 underline" :href="`/dishes/${dish.id}`">
                                View dish
                            </a>
                        </div>
                    </article>
                </div>
            </section>
        </main>
    </div>

    <script src="https://unpkg.com/vue@3/dist/vue.global.prod.js"></script>
    <script>
        const { createApp } = Vue;

        createApp({
            data() {
                return {
                    categories: ['American', 'Asian', 'Mexican', 'Italian', 'Mediterranean'],
                    dishes: [
                        {
                            id: 1,
                            name: 'Chili Garlic Ramen',
                            restaurant: \"Kumar's Indian Grill\",
                            city: 'Portland',
                            rating: 4.8,
                            likes: 164,
                            image: 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?auto=format&fit=crop&w=600&q=80',
                        },
                        {
                            id: 2,
                            name: 'Truffle Carbonara',
                            restaurant: 'Violet & Co.',
                            city: 'Austin',
                            rating: 4.6,
                            likes: 130,
                            image: 'https://images.unsplash.com/photo-1525755662778-989d0524087e?auto=format&fit=crop&w=600&q=80',
                        },
                        {
                            id: 3,
                            name: 'Smoky Birria Tacos',
                            restaurant: 'Casa Naranja',
                            city: 'Chicago',
                            rating: 4.9,
                            likes: 212,
                            image: 'https://images.unsplash.com/photo-1555939594-58d7cb561ad1?auto=format&fit=crop&w=600&q=80',
                        },
                        {
                            id: 4,
                            name: 'Lemon Herb Salmon',
                            restaurant: 'Coastal Table',
                            city: 'Seattle',
                            rating: 4.7,
                            likes: 98,
                            image: 'https://images.unsplash.com/photo-1504674900247-0877df9cc836?auto=format&fit=crop&w=600&q=80',
                        },
                        {
                            id: 5,
                            name: 'Matcha Tart',
                            restaurant: 'Kumo Sweets',
                            city: 'San Jose',
                            rating: 4.5,
                            likes: 74,
                            image: 'https://images.unsplash.com/photo-1481391032119-d89fee407e44?auto=format&fit=crop&w=600&q=80',
                        },
                        {
                            id: 6,
                            name: 'Seared Ribeye Bowl',
                            restaurant: 'Grill Union',
                            city: 'Denver',
                            rating: 4.4,
                            likes: 62,
                            image: 'https://images.unsplash.com/photo-1482049016688-2d3e1b311543?auto=format&fit=crop&w=600&q=80',
                        },
                    ],
                };
            },
        }).mount('#frontend-home');
    </script>
</body>
</html>
