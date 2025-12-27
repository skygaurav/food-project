<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Dashboard</title>
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
                <section class="flex-1 rounded border border-slate-200 bg-white p-6 shadow-sm space-y-4">
                    <h2 class="text-2xl font-semibold">Welcome back</h2>
                    <p class="text-slate-600">
                        You are signed in as an admin. Use the links to manage restaurants, categories,
                        and approve submitted dishes.
                    </p>

                    <form method="POST" action="{{ url('/admin/logout') }}">
                        @csrf
                        <button type="submit" class="rounded border border-slate-500 px-6 py-2 text-lg">
                            Log out
                        </button>
                    </form>
                </section>
            </div>
        </main>
    </div>
</body>
</html>
