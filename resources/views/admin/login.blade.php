<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Login</title>
    <link rel="stylesheet" href="/app.css">
</head>
<body class="font-serif bg-white text-slate-900">
    <div class="min-h-screen bg-white">
        <header class="bg-black py-6 text-center text-white">
            <h1 class="text-3xl font-semibold tracking-wide">FOODCITA ADMIN</h1>
        </header>
        <main class="mx-auto w-full max-w-3xl px-6 pb-16 pt-10">
            <div class="rounded border border-slate-200 bg-white p-6 shadow-sm">
                <h2 class="text-2xl font-semibold text-center">Administrator Login</h2>
                <p class="mt-2 text-center text-slate-600">
                    Use your admin username and password to manage restaurants, categories, and dish approvals.
                </p>

                @if ($errors->any())
                    <div class="mt-4 rounded border border-slate-400 bg-white p-4 text-sm text-slate-900">
                        <p>{{ $errors->first() }}</p>
                    </div>
                @endif

                <form method="POST" action="{{ url('/admin/login') }}" class="mt-6 space-y-6">
                    @csrf
                    <label class="flex flex-col gap-2">
                        <span class="text-sm font-semibold">Username</span>
                        <input
                            class="rounded border border-slate-300 px-3 py-2"
                            name="username"
                            value="{{ old('username') }}"
                            placeholder="admin"
                            required
                        />
                    </label>

                    <label class="flex flex-col gap-2">
                        <span class="text-sm font-semibold">Password</span>
                        <input
                            type="password"
                            class="rounded border border-slate-300 px-3 py-2"
                            name="password"
                            placeholder="••••••••"
                            required
                        />
                    </label>

                    <button type="submit" class="w-full rounded border border-slate-500 px-6 py-3 text-lg">
                        Sign in
                    </button>
                </form>
            </div>
        </main>
    </div>
</body>
</html>
