<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dish</title>
    <link rel="stylesheet" href="/app.css">
</head>
<body class="font-serif text-slate-900 bg-white">
    <div>
        <header class="bg-black py-6 text-center text-white">
            <a href="/" class="text-3xl font-semibold tracking-wide">FOODCITA</a>
        </header>
        <main class="mx-auto w-full max-w-6xl px-6 pb-16 pt-10">
            <section class="space-y-10">
                <div class="grid gap-8 lg:grid-cols-[2fr,1fr]">
                    <img src="https://images.unsplash.com/photo-1473093295043-cdd812d0e601?auto=format&fit=crop&w=900&q=80" alt="Chili Garlic Ramen" class="h-full w-full rounded border border-slate-200 object-cover" />
                    <div class="space-y-4">
                        <div>
                            <h1 class="text-3xl font-semibold">Chili Garlic Ramen</h1>
                            <p class="mt-2 text-slate-600">Kumar's Indian Grill</p>
                            <p class="text-sm text-slate-500">123 Street Name, Portland, OR 97025</p>
                        </div>
                        <div class="space-y-2 text-sm">
                            <p><span class="font-semibold">Category:</span> Asian</p>
                            <p><span class="font-semibold">Meal cost:</span> $$</p>
                            <p><span class="font-semibold">Good date spot:</span> Yes</p>
                            <p><span class="font-semibold">Website:</span> www.kumarsgrill.com</p>
                            <p><span class="font-semibold">Opening hours:</span> Mon-Sun 11AM - 10PM</p>
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
                        <div class="rounded border border-slate-200 p-3">
                            <img src="https://images.unsplash.com/photo-1540189549336-e6e99c3679fe?auto=format&fit=crop&w=600&q=80" alt="Tikka Masala Bowl" class="h-32 w-full rounded object-cover" />
                            <p class="mt-2 text-sm font-semibold">Tikka Masala Bowl</p>
                            <p class="text-xs text-slate-500">Kumar's Indian Grill</p>
                        </div>
                        <div class="rounded border border-slate-200 p-3">
                            <img src="https://images.unsplash.com/photo-1504674900247-0877df9cc836?auto=format&fit=crop&w=600&q=80" alt="Coconut Shrimp" class="h-32 w-full rounded object-cover" />
                            <p class="mt-2 text-sm font-semibold">Coconut Shrimp</p>
                            <p class="text-xs text-slate-500">Coastal Table</p>
                        </div>
                        <div class="rounded border border-slate-200 p-3">
                            <img src="https://images.unsplash.com/photo-1478145046317-39f10e56b5e9?auto=format&fit=crop&w=600&q=80" alt="Sesame Bento" class="h-32 w-full rounded object-cover" />
                            <p class="mt-2 text-sm font-semibold">Sesame Bento</p>
                            <p class="text-xs text-slate-500">Kumo Sweets</p>
                        </div>
                        <div class="rounded border border-slate-200 p-3">
                            <img src="https://images.unsplash.com/photo-1543353071-873f17a7a088?auto=format&fit=crop&w=600&q=80" alt="Harvest Salad" class="h-32 w-full rounded object-cover" />
                            <p class="mt-2 text-sm font-semibold">Harvest Salad</p>
                            <p class="text-xs text-slate-500">Green &amp; Gold</p>
                        </div>
                    </div>
                </section>
            </section>
        </main>
    </div>
</body>
</html>
