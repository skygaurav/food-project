<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Foodcita Admin' }}</title>
    <link rel="stylesheet" href="/app.css">
</head>
<body class="font-serif text-slate-900">
    <div class="admin-shell">
        <aside class="admin-sidebar">
            <div class="admin-brand">FOODCITA</div>
            <nav class="admin-nav">
                <a href="/admin" class="{{ request()->is('admin') ? 'active' : '' }}">Dashboard</a>
                <a href="/admin/categories" class="{{ request()->is('admin/categories') ? 'active' : '' }}">Categories</a>
                <a href="/admin/restaurants" class="{{ request()->is('admin/restaurants') ? 'active' : '' }}">Restaurants</a>
                <a href="/admin/dishes" class="{{ request()->is('admin/dishes') ? 'active' : '' }}">Dishes</a>
                <form method="POST" action="{{ url('/admin/logout') }}">
                    @csrf
                    <button type="submit" class="rounded border border-slate-500 px-4 py-2 text-sm">
                        Log out
                    </button>
                </form>
            </nav>
        </aside>
        <main class="admin-main">
            {{ $slot }}
        </main>
    </div>
</body>
</html>
