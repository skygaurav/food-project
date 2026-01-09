<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Login — {{ $seoSettings['site_name'] ?? 'FOODCITA' }}</title>
    
    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('storage/favicon/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('storage/favicon/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('storage/favicon/favicon-16x16.png') }}">
    <link rel="shortcut icon" href="{{ asset('storage/favicon/favicon.ico') }}">
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #eb5202;
            --primary-dark: #c94400;
        }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, #0f172a 0%, #1e3a5f 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }
        .login-container {
            width: 100%;
            max-width: 420px;
        }
        .login-header {
            text-align: center;
            margin-bottom: 2rem;
        }
        .login-logo {
            font-size: 2.5rem;
            margin-bottom: 0.5rem;
        }
        .login-title {
            color: #fff;
            font-size: 1.75rem;
            font-weight: 700;
        }
        .login-subtitle {
            color: #94a3b8;
            font-size: 0.875rem;
            margin-top: 0.5rem;
        }
        .login-card {
            background: #fff;
            border-radius: 12px;
            padding: 2rem;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        }
        .login-card h2 {
            font-size: 1.25rem;
            font-weight: 600;
            color: #0f172a;
            margin-bottom: 0.5rem;
        }
        .login-card p {
            color: #64748b;
            font-size: 0.875rem;
            margin-bottom: 1.5rem;
        }
        .form-group {
            margin-bottom: 1.25rem;
        }
        .form-label {
            display: block;
            font-size: 0.875rem;
            font-weight: 500;
            color: #334155;
            margin-bottom: 0.5rem;
        }
        .form-control {
            width: 100%;
            padding: 0.75rem 1rem;
            font-size: 1rem;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            transition: border-color 0.15s, box-shadow 0.15s;
        }
        .form-control:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(235, 82, 2, 0.15);
        }
        .form-control::placeholder {
            color: #94a3b8;
        }
        .btn-login {
            width: 100%;
            padding: 0.875rem 1.5rem;
            font-size: 1rem;
            font-weight: 600;
            color: #fff;
            background: var(--primary);
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background 0.15s;
            margin-top: 0.5rem;
        }
        .btn-login:hover {
            background: var(--primary-dark);
        }
        .error-box {
            background: #fef2f2;
            border: 1px solid #fecaca;
            color: #991b1b;
            padding: 0.75rem 1rem;
            border-radius: 8px;
            font-size: 0.875rem;
            margin-bottom: 1.25rem;
        }
        .login-footer {
            text-align: center;
            margin-top: 1.5rem;
            color: #94a3b8;
            font-size: 0.75rem;
        }
        .login-footer a {
            color: #fff;
            text-decoration: none;
        }
        .login-footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-header">
            <div class="login-logo">
                @if($seoSettings['site_logo'] ?? null)
                    <img src="{{ asset('storage/' . $seoSettings['site_logo']) }}" alt="{{ $seoSettings['site_name'] ?? 'FOODCITA' }}" style="height: 64px; width: auto; max-width: 200px; object-fit: contain;">
                @else
                    <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M3 2v7c0 1.1.9 2 2 2h4a2 2 0 0 0 2-2V2"></path>
                        <path d="M7 2v20"></path>
                        <path d="M21 15V2v0a5 5 0 0 0-5 5v6c0 1.1.9 2 2 2h3Zm0 0v7"></path>
                    </svg>
                @endif
            </div>
            <h1 class="login-title">{{ $seoSettings['site_name'] ?? 'FOODCITA' }}</h1>
            <p class="login-subtitle">Admin Control Panel</p>
        </div>
        
        <div class="login-card">
            <h2>Welcome back</h2>
            <p>Sign in to manage restaurants, categories, and dish approvals.</p>

            @if ($errors->any())
                <div class="error-box">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ url('/admin/login') }}">
                @csrf
                <div class="form-group">
                    <label class="form-label">Username</label>
                    <input
                        class="form-control"
                        name="username"
                        value="{{ old('username') }}"
                        placeholder="Enter your username"
                        required
                        autocomplete="username"
                    />
                </div>

                <div class="form-group">
                    <label class="form-label">Password</label>
                    <input
                        type="password"
                        class="form-control"
                        name="password"
                        placeholder="Enter your password"
                        required
                        autocomplete="current-password"
                    />
                </div>

                <div class="form-group" style="text-align: right; margin-bottom: 0.5rem;">
                    <a href="/admin/forgot-password" style="color: var(--primary); font-size: 0.875rem; text-decoration: none;">Forgot your password?</a>
                </div>

                <button type="submit" class="btn-login">
                    Sign In
                </button>
            </form>
        </div>
        
        <div class="login-footer">
            <a href="/">← Back to website</a>
        </div>
    </div>
</body>
</html>
