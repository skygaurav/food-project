<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Upload Dish</title>
    <link rel="stylesheet" href="/app.css">
</head>
<body class="font-serif text-slate-900 bg-white">
    <div id="frontend-upload">
        <header class="bg-black py-6 text-center text-white">
            <a href="/" class="text-3xl font-semibold tracking-wide">FOODCITA</a>
        </header>
        <main class="mx-auto max-w-3xl space-y-10 px-6 pb-16 pt-10">
            <section class="mx-auto max-w-3xl space-y-10">
                <div class="text-center space-y-4">
                    <h1 class="text-2xl font-semibold">Upload a Dish or Drink!</h1>
                    <button type="button" class="inline-flex rounded border border-slate-500 px-8 py-2 text-lg">
                        Upload
                    </button>
                </div>

                <div class="rounded border border-slate-200 bg-white p-6 text-center shadow-sm">
                    <h2 class="text-xl font-medium">Answer a few quick questions:</h2>

                    <div class="mx-auto mt-6 max-w-xl space-y-6 text-left">
                        <label class="flex flex-col gap-2">
                            <span class="text-sm font-semibold">What Restaurant Are You At?</span>
                            <select class="rounded border border-slate-300 px-3 py-2" v-model="selectedRestaurantId">
                                <option v-for="restaurant in restaurants" :key="restaurant.id" :value="restaurant.id">
                                    {{ restaurant.name }}
                                </option>
                            </select>
                        </label>

                        <div class="space-y-2 text-sm text-slate-600">
                            <p>Please review the following information we found to see if it is accurate:</p>
                            <div class="text-slate-900">
                                <p class="font-semibold">{{ selectedRestaurant.name }}</p>
                                <p>{{ selectedRestaurant.address }}</p>
                                <p>{{ selectedRestaurant.city }}, {{ selectedRestaurant.region }} {{ selectedRestaurant.postcode }}</p>
                                <p>{{ selectedRestaurant.phone }}</p>
                                <p>{{ selectedRestaurant.website }}</p>
                                <p>Cuisine Type: {{ selectedRestaurant.cuisine }}</p>
                                <p>Reservations: {{ selectedRestaurant.reservations }}</p>
                                <p>Good Date Spot: {{ selectedRestaurant.dateSpot }}</p>
                            </div>
                        </div>

                        <div class="flex flex-col gap-4">
                            <button type="button" class="rounded border border-slate-500 px-6 py-2 text-lg">
                                Submit
                            </button>
                            <button type="button" class="rounded border border-slate-500 px-6 py-2 text-lg">
                                Update Information
                            </button>
                        </div>
                    </div>
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
                    selectedRestaurantId: 1,
                    restaurants: [
                        {
                            id: 1,
                            name: \"Kumar's Indian Grill\",
                            address: '123 Street Name',
                            city: 'Portland',
                            region: 'OR',
                            postcode: '97025',
                            phone: 'XXX-XXX-XXXX',
                            website: 'www.XXXX.com',
                            cuisine: 'Indian',
                            reservations: 'Yes',
                            dateSpot: 'Yes',
                        },
                        {
                            id: 2,
                            name: 'Violet & Co.',
                            address: '45 Main Road',
                            city: 'Austin',
                            region: 'TX',
                            postcode: '73301',
                            phone: 'XXX-XXX-XXXX',
                            website: 'www.violetco.com',
                            cuisine: 'American',
                            reservations: 'No',
                            dateSpot: 'Yes',
                        },
                    ],
                };
            },
            computed: {
                selectedRestaurant() {
                    return this.restaurants.find((restaurant) => restaurant.id === this.selectedRestaurantId);
                },
            },
        }).mount('#frontend-upload');
    </script>
</body>
</html>
