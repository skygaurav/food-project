<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Foodcita</title>
    <link rel="stylesheet" href="/app.css">
</head>
<body class="font-serif text-slate-900 bg-white">
    <div>
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
                                <option>American</option>
                                <option>Asian</option>
                                <option>Mexican</option>
                                <option>Italian</option>
                                <option>Mediterranean</option>
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
                    <article class="overflow-hidden rounded border border-slate-200 bg-white shadow-sm">
                        <img src="https://images.unsplash.com/photo-1546069901-ba9599a7e63c?auto=format&fit=crop&w=600&q=80" alt="Chili Garlic Ramen" class="h-48 w-full object-cover" />
                        <div class="space-y-2 p-4">
                            <div class="flex items-center justify-between">
                                <h3 class="text-lg font-semibold">Chili Garlic Ramen</h3>
                                <span class="text-sm text-slate-500">Portland</span>
                            </div>
                            <p class="text-sm text-slate-600">Kumar's Indian Grill</p>
                            <div class="flex items-center justify-between text-sm">
                                <span class="font-medium">⭐ 4.8</span>
                                <span class="text-slate-500">164 likes</span>
                            </div>
                            <a class="inline-flex items-center text-sm font-semibold text-slate-800 underline" href="/dishes/1">
                                View dish
                            </a>
                        </div>
                    </article>
                    <article class="overflow-hidden rounded border border-slate-200 bg-white shadow-sm">
                        <img src="https://images.unsplash.com/photo-1525755662778-989d0524087e?auto=format&fit=crop&w=600&q=80" alt="Truffle Carbonara" class="h-48 w-full object-cover" />
                        <div class="space-y-2 p-4">
                            <div class="flex items-center justify-between">
                                <h3 class="text-lg font-semibold">Truffle Carbonara</h3>
                                <span class="text-sm text-slate-500">Austin</span>
                            </div>
                            <p class="text-sm text-slate-600">Violet &amp; Co.</p>
                            <div class="flex items-center justify-between text-sm">
                                <span class="font-medium">⭐ 4.6</span>
                                <span class="text-slate-500">130 likes</span>
                            </div>
                            <a class="inline-flex items-center text-sm font-semibold text-slate-800 underline" href="/dishes/1">
                                View dish
                            </a>
                        </div>
                    </article>
                    <article class="overflow-hidden rounded border border-slate-200 bg-white shadow-sm">
                        <img src="https://images.unsplash.com/photo-1555939594-58d7cb561ad1?auto=format&fit=crop&w=600&q=80" alt="Smoky Birria Tacos" class="h-48 w-full object-cover" />
                        <div class="space-y-2 p-4">
                            <div class="flex items-center justify-between">
                                <h3 class="text-lg font-semibold">Smoky Birria Tacos</h3>
                                <span class="text-sm text-slate-500">Chicago</span>
                            </div>
                            <p class="text-sm text-slate-600">Casa Naranja</p>
                            <div class="flex items-center justify-between text-sm">
                                <span class="font-medium">⭐ 4.9</span>
                                <span class="text-slate-500">212 likes</span>
                            </div>
                            <a class="inline-flex items-center text-sm font-semibold text-slate-800 underline" href="/dishes/1">
                                View dish
                            </a>
                        </div>
                    </article>
                    <article class="overflow-hidden rounded border border-slate-200 bg-white shadow-sm">
                        <img src="https://images.unsplash.com/photo-1504674900247-0877df9cc836?auto=format&fit=crop&w=600&q=80" alt="Lemon Herb Salmon" class="h-48 w-full object-cover" />
                        <div class="space-y-2 p-4">
                            <div class="flex items-center justify-between">
                                <h3 class="text-lg font-semibold">Lemon Herb Salmon</h3>
                                <span class="text-sm text-slate-500">Seattle</span>
                            </div>
                            <p class="text-sm text-slate-600">Coastal Table</p>
                            <div class="flex items-center justify-between text-sm">
                                <span class="font-medium">⭐ 4.7</span>
                                <span class="text-slate-500">98 likes</span>
                            </div>
                            <a class="inline-flex items-center text-sm font-semibold text-slate-800 underline" href="/dishes/1">
                                View dish
                            </a>
                        </div>
                    </article>
                    <article class="overflow-hidden rounded border border-slate-200 bg-white shadow-sm">
                        <img src="https://images.unsplash.com/photo-1481391032119-d89fee407e44?auto=format&fit=crop&w=600&q=80" alt="Matcha Tart" class="h-48 w-full object-cover" />
                        <div class="space-y-2 p-4">
                            <div class="flex items-center justify-between">
                                <h3 class="text-lg font-semibold">Matcha Tart</h3>
                                <span class="text-sm text-slate-500">San Jose</span>
                            </div>
                            <p class="text-sm text-slate-600">Kumo Sweets</p>
                            <div class="flex items-center justify-between text-sm">
                                <span class="font-medium">⭐ 4.5</span>
                                <span class="text-slate-500">74 likes</span>
                            </div>
                            <a class="inline-flex items-center text-sm font-semibold text-slate-800 underline" href="/dishes/1">
                                View dish
                            </a>
                        </div>
                    </article>
                    <article class="overflow-hidden rounded border border-slate-200 bg-white shadow-sm">
                        <img src="https://images.unsplash.com/photo-1482049016688-2d3e1b311543?auto=format&fit=crop&w=600&q=80" alt="Seared Ribeye Bowl" class="h-48 w-full object-cover" />
                        <div class="space-y-2 p-4">
                            <div class="flex items-center justify-between">
                                <h3 class="text-lg font-semibold">Seared Ribeye Bowl</h3>
                                <span class="text-sm text-slate-500">Denver</span>
                            </div>
                            <p class="text-sm text-slate-600">Grill Union</p>
                            <div class="flex items-center justify-between text-sm">
                                <span class="font-medium">⭐ 4.4</span>
                                <span class="text-slate-500">62 likes</span>
                            </div>
                            <a class="inline-flex items-center text-sm font-semibold text-slate-800 underline" href="/dishes/1">
                                View dish
                            </a>
                        </div>
                    </article>
                </div>
            </section>
        </main>
    </div>
</body>
</html>
<?php /**PATH /var/www/html/resources/views/home.blade.php ENDPATH**/ ?>