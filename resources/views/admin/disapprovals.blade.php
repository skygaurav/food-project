<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin — Dish Disapprovals</title>
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
                    <h2 class="text-2xl font-semibold">Pending Dish Approvals</h2>
                    <div id="dishes" class="mt-4 space-y-4">Loading...</div>
                </section>
            </div>
        </main>
    </div>
    <script>
        async function loadPending(){
            const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
            const res = await fetch('/admin/api/dishes/pending', { credentials: 'same-origin', headers: {'X-CSRF-TOKEN': token} });
            const data = res.ok ? await res.json() : [];
            const el = document.getElementById('dishes');
            el.innerHTML = data.length ? data.map(d=>`<div class="p-3 border rounded"><strong>${d.name}</strong> — ${d.restaurant?.name || ''} <div class="mt-2"><button data-id="${d.id}" class="approve">Approve</button> <button data-id="${d.id}" class="disapprove">Disapprove</button></div></div>`).join('') : '<p>No pending dishes</p>';
            document.querySelectorAll('.approve').forEach(b=>b.addEventListener('click', async ev=>{ const id=ev.target.dataset.id; await fetch('/admin/api/dishes/'+id+'/approve',{method:'POST', credentials:'same-origin', headers:{'X-CSRF-TOKEN': token}}); loadPending(); }));
            document.querySelectorAll('.disapprove').forEach(b=>b.addEventListener('click', async ev=>{ const id=ev.target.dataset.id; await fetch('/admin/api/dishes/'+id+'/disapprove',{method:'POST', credentials:'same-origin', headers:{'X-CSRF-TOKEN': token}}); loadPending(); }));
        }
        loadPending();
    </script>
</body>
</html>
