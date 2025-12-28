<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dish</title>
    <link rel="stylesheet" href="/app.css">
</head>
<body class="font-serif text-slate-900 bg-white">
    <div id="frontend-dish">
        <header class="bg-black py-6 text-center text-white">
            <a href="/" class="text-3xl font-semibold tracking-wide">FOODCITA</a>
        </header>
        <main class="mx-auto w-full max-w-6xl px-6 pb-16 pt-10">
            <section class="space-y-10">
                <div class="grid gap-8 lg:grid-cols-[2fr,1fr]">
                    <img :src="dish.image" :alt="dish.name" class="h-full w-full rounded border border-slate-200 object-cover" />
                    <div class="space-y-4">
                        <div>
                            <h1 class="text-3xl font-semibold">{{ dish.name }}</h1>
                            <p class="mt-2 text-slate-600">{{ dish.restaurant }}</p>
                            <p class="text-sm text-slate-500">{{ dish.address }}</p>
                        </div>
                        <div class="space-y-2 text-sm">
                            <p><span class="font-semibold">Category:</span> {{ dish.category }}</p>
                            <p><span class="font-semibold">Meal cost:</span> {{ dish.cost }}</p>
                            <p><span class="font-semibold">Good date spot:</span> {{ dish.dateSpot }}</p>
                            <p><span class="font-semibold">Website:</span> {{ dish.website }}</p>
                            <p><span class="font-semibold">Opening hours:</span> {{ dish.hours }}</p>
                        </div>
                        <div class="flex gap-3">
                            <button class="rounded border border-slate-400 px-4 py-2">👍 Like</button>
                            <button class="rounded border border-slate-400 px-4 py-2">👎 Dislike</button>
                        </div>
                    </div>
                </div>

                <section class="rounded border border-slate-200 bg-white p-6 shadow-sm">
                    <h2 class="text-xl font-semibold">Add a review</h2>
                    <form class="mt-4 grid gap-4 md:grid-cols-[1fr,3fr]">
                        <label class="flex flex-col gap-2">
                            <span class="text-sm font-semibold">Rating</span>
                            <select class="rounded border border-slate-300 px-3 py-2">
                                <option>5 - Excellent</option>
                                <option>4 - Great</option>
                                <option>3 - Good</option>
                                <option>2 - Fair</option>
                                <option>1 - Poor</option>
                            </select>
                        </label>
                        <label class="flex flex-col gap-2">
                            <span class="text-sm font-semibold">Comment</span>
                            <input class="rounded border border-slate-300 px-3 py-2" placeholder="Share your experience..." />
                        </label>
                        <button class="md:col-span-2 rounded border border-slate-500 px-5 py-2 text-sm">
                            Submit review
                        </button>
                    </form>
                </section>

                <section>
                    <h2 class="text-xl font-semibold">Other favorite dishes from customers</h2>
                    <div class="mt-4 grid gap-4 md:grid-cols-2 lg:grid-cols-4">
                        <div v-for="related in relatedDishes" :key="related.name" class="rounded border border-slate-200 p-3">
                            <img :src="related.image" :alt="related.name" class="h-32 w-full rounded object-cover" />
                            <p class="mt-2 text-sm font-semibold">{{ related.name }}</p>
                            <p class="text-xs text-slate-500">{{ related.restaurant }}</p>
                        </div>
                    </div>
                </section>
            </section>
        </main>
    </div>

    <script src="https://unpkg.com/vue@3/dist/vue.global.prod.js"></script>
    <script>
        const { createApp } = Vue;

        createApp({
            data() {
                return {
                    dish: {
                        name: 'Chili Garlic Ramen',
                        restaurant: "Kumar's Indian Grill",
                        address: '123 Street Name, Portland, OR 97025',
                        category: 'Asian',
                        cost: '$$',
                        dateSpot: 'Yes',
                        website: 'www.kumarsgrill.com',
                        hours: 'Mon-Sun 11AM - 10PM',
                        image: 'https://images.unsplash.com/photo-1473093295043-cdd812d0e601?auto=format&fit=crop&w=900&q=80',
                    },
                    relatedDishes: [
                        {
                            name: 'Tikka Masala Bowl',
                            restaurant: "Kumar's Indian Grill",
                            image: 'https://images.unsplash.com/photo-1540189549336-e6e99c3679fe?auto=format&fit=crop&w=600&q=80',
                        },
                        {
                            name: 'Coconut Shrimp',
                            restaurant: 'Coastal Table',
                            image: 'https://images.unsplash.com/photo-1504674900247-0877df9cc836?auto=format&fit=crop&w=600&q=80',
                        },
                        {
                            name: 'Sesame Bento',
                            restaurant: 'Kumo Sweets',
                            image: 'https://images.unsplash.com/photo-1478145046317-39f10e56b5e9?auto=format&fit=crop&w=600&q=80',
                        },
                        {
                            name: 'Harvest Salad',
                            restaurant: 'Green & Gold',
                            image: 'https://images.unsplash.com/photo-1543353071-873f17a7a088?auto=format&fit=crop&w=600&q=80',
                        },
                    ],
                };
            },
        }).mount('#frontend-dish');
    </script>
</body>
</html>
