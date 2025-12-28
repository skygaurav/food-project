<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Upload Dish - FOODCITA</title>
    <link rel="stylesheet" href="/app.css">
</head>
<body class="font-serif text-slate-900 bg-slate-50">
    <div>
        <header class="bg-black py-6 text-white">
            <div class="mx-auto max-w-6xl px-6 flex items-center justify-between">
                <a href="/" class="text-3xl font-semibold tracking-wide">FOODCITA</a>
                <div class="flex items-center gap-4">
                    <span class="text-sm">Welcome, {{ auth()->user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="text-sm underline hover:text-slate-300">Logout</button>
                    </form>
                </div>
            </div>
        </header>
        <main class="mx-auto max-w-3xl space-y-10 px-6 pb-16 pt-10">
            <section class="mx-auto max-w-3xl space-y-10">
                <div class="text-center space-y-4">
                    <h1 class="text-2xl font-semibold">Upload a Dish or Drink!</h1>
                    <p class="text-slate-600">Share your favorite dishes with the community</p>
                </div>

                <div id="success-message" class="hidden rounded border border-green-200 bg-green-50 p-4 text-green-700">
                    <p class="font-medium">🎉 Your dish has been submitted!</p>
                    <p class="text-sm mt-1">It will be visible after admin approval.</p>
                </div>

                <form id="upload-form" class="rounded border border-slate-200 bg-white p-6 shadow-sm" enctype="multipart/form-data">
                    <h2 class="text-xl font-medium text-center mb-6">Tell us about your dish</h2>

                    <div class="mx-auto max-w-xl space-y-6">
                        <div class="flex flex-col gap-2">
                            <label for="restaurant_id" class="text-sm font-semibold">Select Restaurant <span class="text-red-500">*</span></label>
                            <select id="restaurant_id" name="restaurant_id" required class="rounded border border-slate-300 px-3 py-2">
                                <option value="">-- Select a restaurant --</option>
                            </select>
                        </div>

                        <div class="flex flex-col gap-2">
                            <label for="name" class="text-sm font-semibold">Dish Name <span class="text-red-500">*</span></label>
                            <input type="text" id="name" name="name" required class="rounded border border-slate-300 px-3 py-2" placeholder="e.g. Chili Garlic Ramen" />
                        </div>

                        <div class="flex flex-col gap-2">
                            <label for="comment" class="text-sm font-semibold">Your Comment / Review</label>
                            <textarea id="comment" name="comment" rows="3" class="rounded border border-slate-300 px-3 py-2" placeholder="What did you think of this dish?"></textarea>
                        </div>

                        <div class="flex flex-col gap-2">
                            <label for="images" class="text-sm font-semibold">Photos <span class="text-red-500">*</span></label>
                            <input type="file" id="images" name="images[]" accept="image/*" multiple required class="rounded border border-slate-300 px-3 py-2 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:font-semibold file:bg-slate-100 file:text-slate-700 hover:file:bg-slate-200" />
                            <p class="text-xs text-slate-500">You can select multiple photos</p>
                        </div>

                        <div class="flex flex-col gap-2">
                            <label for="meal_cost" class="text-sm font-semibold">Meal Cost ($)</label>
                            <input type="number" id="meal_cost" name="meal_cost" step="0.01" min="0" class="rounded border border-slate-300 px-3 py-2" placeholder="e.g. 25.00" />
                        </div>

                        <div class="flex flex-col gap-2">
                            <span class="text-sm font-semibold">Good Date Spot?</span>
                            <div class="flex gap-4">
                                <label class="flex items-center gap-2">
                                    <input type="radio" name="good_date_spot" value="1" class="rounded border-slate-300" />
                                    <span>Yes</span>
                                </label>
                                <label class="flex items-center gap-2">
                                    <input type="radio" name="good_date_spot" value="0" class="rounded border-slate-300" checked />
                                    <span>No</span>
                                </label>
                            </div>
                        </div>

                        <div class="flex flex-col gap-2">
                            <label for="website" class="text-sm font-semibold">Restaurant Website (if known)</label>
                            <input type="url" id="website" name="website" class="rounded border border-slate-300 px-3 py-2" placeholder="https://..." />
                        </div>

                        <div class="pt-4">
                            <button type="submit" id="submit-btn" class="w-full rounded bg-black text-white px-6 py-3 text-lg font-medium hover:bg-slate-800 transition disabled:opacity-50">
                                Submit Dish
                            </button>
                        </div>
                    </div>
                </form>
            </section>
        </main>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', async function() {
        // Load restaurants
        try {
            const res = await fetch('/api/restaurants');
            const restaurants = await res.json();
            const select = document.getElementById('restaurant_id');
            restaurants.forEach(r => {
                const option = document.createElement('option');
                option.value = r.id;
                option.textContent = r.name + (r.city ? ` (${r.city})` : '');
                select.appendChild(option);
            });
        } catch (e) {
            console.error('Failed to load restaurants:', e);
        }

        // Handle form submission
        document.getElementById('upload-form').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const submitBtn = document.getElementById('submit-btn');
            submitBtn.disabled = true;
            submitBtn.textContent = 'Uploading...';
            
            const formData = new FormData(this);
            
            try {
                const res = await fetch('/api/dishes', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    },
                    body: formData
                });
                
                if (!res.ok) {
                    const error = await res.json();
                    throw new Error(error.message || 'Failed to upload dish');
                }
                
                document.getElementById('upload-form').classList.add('hidden');
                document.getElementById('success-message').classList.remove('hidden');
                
            } catch (err) {
                alert('Error: ' + err.message);
                submitBtn.disabled = false;
                submitBtn.textContent = 'Submit Dish';
            }
        });
    });
    </script>
</body>
</html>
