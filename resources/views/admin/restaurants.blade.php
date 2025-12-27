<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin — Restaurants</title>
    <link rel="stylesheet" href="/app.css">
</head>
<body class="font-serif bg-white text-slate-900">
    <div class="min-h-screen bg-white">
        <header class="bg-black py-6 text-center text-white">
            <h1 class="text-3xl font-semibold tracking-wide">FOODCITA ADMIN</h1>
        </header>
        <main class="mx-auto w-full max-w-5xl px-6 pb-16 pt-10">
            <div class="flex gap-6">
                @include('admin._nav')
                <section class="flex-1 rounded border border-slate-200 bg-white p-6 shadow-sm">
                    <h2 class="text-2xl font-semibold">Add Restaurant</h2>
                    <p class="text-slate-600">This is a placeholder to create restaurants via the API.</p>

                    <form id="add-restaurant" class="mt-4 space-y-4">
                        <label class="flex flex-col gap-2">
                            <span class="text-sm font-semibold">Name</span>
                            <input name="name" class="rounded border border-slate-300 px-3 py-2" />
                        </label>
                        <label class="flex flex-col gap-2">
                            <span class="text-sm font-semibold">Address</span>
                            <input name="address" class="rounded border border-slate-300 px-3 py-2" />
                        </label>
                        <button type="submit" class="rounded border border-slate-500 px-6 py-2">Create</button>
                    </form>
                </section>
            </div>
        </main>
    </div>
    <script>
        document.getElementById('add-restaurant')?.addEventListener('submit', async function(e){
            e.preventDefault();
            const data = { name: this.name.value, address: this.address.value, city:'', region:'', country:'', postcode:'' };
            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const res = await fetch('/admin/api/restaurants', {
                method:'POST',
                credentials: 'same-origin',
                headers:{'Content-Type':'application/json','X-CSRF-TOKEN': token},
                body:JSON.stringify(data)
            });
            if(res.ok){ alert('Created'); location.reload(); } else { alert('Failed'); }
        });
    </script>
</body>
</html>
