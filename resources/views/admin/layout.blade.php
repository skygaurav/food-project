<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin') — FOODCITA</title>
    <link rel="stylesheet" href="/app.css">
    <style>
        /* Admin theme improvements */
        body { font-family: Inter, ui-sans-serif, system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', Arial; }
        .admin-container{max-width:1300px;margin:0 auto;padding:1rem}
        .admin-aside{width:260px;background:#0b1220;color:#fff;border-radius:8px;padding:1rem}
        .admin-main{flex:1}
        .card{background:#fff;border-radius:8px;padding:1rem;box-shadow:0 2px 8px rgba(12,18,28,0.06)}
        .nav-link{display:block;padding:.7rem .8rem;border-radius:6px;color:#cbd5e1;text-decoration:none}
        .nav-link:hover{background:#0f172a;color:#fff}
        .nav-link.active{background:#0f172a;color:#fff;font-weight:600}
        .form-row{display:flex;gap:1rem}
        .form-col{flex:1}
        header.admin-top{background:#0b1220;color:#fff;padding:12px 0;margin-bottom:1rem}
        .top-actions{display:flex;gap:.5rem;align-items:center}
        .small-muted{color:#94a3b8;font-size:13px}
    </style>
</head>
<body class="font-sans bg-slate-50 text-slate-900">
    <header class="bg-black py-4 text-center text-white mb-6">
        <div class="container mx-auto">
            <h1 class="text-2xl font-semibold">FOODCITA — Admin</h1>
        </div>
    </header>

    <div class="admin-container">
        <div style="display:flex;gap:1.5rem;align-items:flex-start">
            <aside class="admin-aside">
                @include('admin._nav')
            </aside>

            <main class="admin-main">
                <div class="card">
                    @yield('content')
                </div>
            </main>
        </div>
    </div>

    <!-- Modal placeholder for admin edits -->
    <div id="admin-modal" style="display:none;position:fixed;inset:0;align-items:center;justify-content:center;z-index:60">
        <div style="background:rgba(2,6,23,.6);position:absolute;inset:0"></div>
        <div style="position:relative;z-index:70;width:720px;max-width:95%;margin:0 auto">
            <div class="card" id="admin-modal-body">
                <!-- dynamic content injected here -->
            </div>
            <div style="text-align:right;margin-top:.5rem"><button id="admin-modal-close" class="rounded border px-3 py-1">Close</button></div>
        </div>
    </div>

    <script>
    // simple modal helpers
    window.adminModal = {
        open(html){
            document.getElementById('admin-modal-body').innerHTML = html;
            document.getElementById('admin-modal').style.display = 'flex';
        },
        close(){
            document.getElementById('admin-modal').style.display = 'none';
            document.getElementById('admin-modal-body').innerHTML = '';
        }
    };
    document.getElementById('admin-modal-close').addEventListener('click', ()=>window.adminModal.close());

    async function adminFetch(method, url, body){
        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const opts = { method, credentials:'same-origin', headers:{'X-CSRF-TOKEN': token} };
        if(body){ opts.headers['Content-Type']='application/json'; opts.body = JSON.stringify(body); }
        const res = await fetch(url, opts);
        if(!res.ok) throw new Error('request-failed');
        return res.json().catch(()=>null);
    }

    // load admin settings on page load and expose
    window.adminSettings = {};
    (async function(){
        try{ const s = await adminFetch('GET','/admin/api/settings'); window.adminSettings = s||{}; }catch(e){ /* ignore */ }
    })();
    </script>

    @stack('scripts')
</body>
</html>
