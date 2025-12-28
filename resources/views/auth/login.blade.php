<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - FOODCITA</title>
    <link rel="stylesheet" href="/app.css">
</head>
<body class="font-serif text-slate-900 bg-slate-50">
    <div class="min-h-screen flex flex-col">
        <header class="bg-black py-6 text-center text-white">
            <a href="/" class="text-3xl font-semibold tracking-wide">FOODCITA</a>
        </header>
        
        <main class="flex-1 flex items-center justify-center px-6 py-12">
            <div class="w-full max-w-md">
                <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-8">
                    <h1 class="text-2xl font-semibold text-center mb-6">Login</h1>
                    
                    @if ($errors->any())
                        <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded text-red-600 text-sm">
                            @foreach ($errors->all() as $error)
                                <p>{{ $error }}</p>
                            @endforeach
                        </div>
                    @endif
                    
                    <form method="POST" action="/login" class="space-y-4">
                        @csrf
                        
                        <div>
                            <label for="email" class="block text-sm font-medium text-slate-700 mb-1">Email</label>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" required 
                                   class="w-full px-3 py-2 border border-slate-300 rounded focus:outline-none focus:ring-2 focus:ring-slate-400">
                        </div>
                        
                        <div>
                            <label for="password" class="block text-sm font-medium text-slate-700 mb-1">Password</label>
                            <input type="password" id="password" name="password" required 
                                   class="w-full px-3 py-2 border border-slate-300 rounded focus:outline-none focus:ring-2 focus:ring-slate-400">
                        </div>
                        
                        <button type="submit" 
                                class="w-full bg-black text-white py-2 px-4 rounded font-medium hover:bg-slate-800 transition">
                            Login
                        </button>
                    </form>
                    
                    <p class="mt-6 text-center text-sm text-slate-600">
                        Don't have an account? 
                        <a href="/register" class="text-black font-medium underline">Register</a>
                    </p>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
