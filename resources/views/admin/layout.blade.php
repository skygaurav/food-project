<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin') — FOODCITA</title>
    <link rel="stylesheet" href="/app.css">
    <style>
        /* small admin layout tweaks */
        .admin-container{max-width:1100px;margin:0 auto;padding:2rem}
        .admin-aside{width:220px}
        .admin-main{flex:1}
        .card{background:#fff;border:1px solid #e6e6e6;padding:1rem;border-radius:8px}
        .nav-link{display:block;padding:.6rem .8rem;border-radius:6px;color:#0f172a}
        .nav-link:hover{background:#f8fafc}
        .form-row{display:flex;gap:1rem}
        .form-col{flex:1}
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

    @stack('scripts')
</body>
</html>
