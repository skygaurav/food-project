<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin — Categories</title>
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
                    <h2 class="text-2xl font-semibold">Add Category</h2>
                    <p class="text-slate-600">Use the API endpoint to add categories. This page is a placeholder UI.</p>

                    <form id="add-category" class="mt-4 space-y-4">
                        <label class="flex flex-col gap-2">
                            <span class="text-sm font-semibold">Name</span>
                            <input name="name" class="rounded border border-slate-300 px-3 py-2" />
                        </label>
                        <button type="submit" class="rounded border border-slate-500 px-6 py-2">Create</button>
                    </form>
                </section>
            </div>
        </main>
    </div>
    <script>
        document.getElementById('add-category')?.addEventListener('submit', async function(e){
            e.preventDefault();
            const name = this.querySelector('[name="name"]').value;
            const res = await fetch('/api/admin/categories', {method:'POST', headers:{'Content-Type':'application/json'}, body:JSON.stringify({name})});
            if(res.ok){ alert('Created'); location.reload(); } else { alert('Failed'); }
        });
    </script>
</body>
</html>
