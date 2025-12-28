<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('meta_title', $seoSettings['default_meta_title'] ?? 'FOODCITA - Discover Delicious Dishes')</title>
    <meta name="description" content="@yield('meta_description', $seoSettings['default_meta_description'] ?? 'Share your favorite meals and explore dishes loved by food enthusiasts in your city.')">
    <meta name="keywords" content="@yield('meta_keywords', $seoSettings['default_meta_keywords'] ?? 'food, dishes, restaurants, reviews, dining')">
    <link rel="stylesheet" href="/app.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #e85d04;
            --primary-dark: #dc2f02;
            --secondary: #1e293b;
            --accent: #f48c06;
            --bg-light: #faf9f7;
            --text-dark: #1e293b;
            --text-muted: #64748b;
        }
        
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: var(--bg-light);
            color: var(--text-dark);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        
        .font-display {
            font-family: 'Playfair Display', Georgia, serif;
        }
        
        /* Header Styles */
        .site-header {
            background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            position: sticky;
            top: 0;
            z-index: 100;
        }
        
        .header-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            height: 70px;
        }
        
        .logo {
            font-family: 'Playfair Display', Georgia, serif;
            font-size: 1.75rem;
            font-weight: 700;
            color: #fff;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .logo-icon {
            font-size: 1.5rem;
        }
        
        .nav-links {
            display: flex;
            align-items: center;
            gap: 2rem;
        }
        
        .nav-links a {
            color: rgba(255,255,255,0.85);
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 500;
            transition: color 0.2s;
        }
        
        .nav-links a:hover {
            color: #fff;
        }
        
        .header-actions {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        
        .btn-header {
            padding: 0.5rem 1.25rem;
            border-radius: 6px;
            font-size: 0.875rem;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.2s;
        }
        
        .btn-header-outline {
            border: 1px solid rgba(255,255,255,0.3);
            color: #fff;
        }
        
        .btn-header-outline:hover {
            border-color: #fff;
            background: rgba(255,255,255,0.1);
        }
        
        .btn-header-primary {
            background: var(--primary);
            color: #fff;
            border: none;
        }
        
        .btn-header-primary:hover {
            background: var(--primary-dark);
        }
        
        .user-menu {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            color: rgba(255,255,255,0.9);
            font-size: 0.875rem;
        }
        
        .user-avatar {
            width: 36px;
            height: 36px;
            background: var(--primary);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            color: #fff;
        }
        
        /* Main Content */
        .main-content {
            flex: 1;
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem 1.5rem;
            width: 100%;
        }
        
        /* Footer Styles */
        .site-footer {
            background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
            color: #fff;
            margin-top: auto;
        }
        
        .footer-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 3rem 1.5rem 2rem;
        }
        
        .footer-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 2rem;
            margin-bottom: 2rem;
        }
        
        .footer-section h4 {
            font-family: 'Playfair Display', Georgia, serif;
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 1rem;
            color: #fff;
        }
        
        .footer-section ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        
        .footer-section ul li {
            margin-bottom: 0.5rem;
        }
        
        .footer-section ul li a {
            color: rgba(255,255,255,0.7);
            text-decoration: none;
            font-size: 0.9rem;
            transition: color 0.2s;
        }
        
        .footer-section ul li a:hover {
            color: #fff;
        }
        
        .footer-section p {
            color: rgba(255,255,255,0.7);
            font-size: 0.9rem;
            line-height: 1.6;
        }
        
        .footer-bottom {
            border-top: 1px solid rgba(255,255,255,0.1);
            padding-top: 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
        }
        
        .footer-bottom p {
            color: rgba(255,255,255,0.5);
            font-size: 0.85rem;
            margin: 0;
        }
        
        .social-links {
            display: flex;
            gap: 1rem;
        }
        
        .social-links a {
            color: rgba(255,255,255,0.7);
            font-size: 1.25rem;
            transition: color 0.2s;
        }
        
        .social-links a:hover {
            color: var(--primary);
        }
        
        /* Loader */
        .loader {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 3rem;
        }
        
        .loader-spinner {
            width: 40px;
            height: 40px;
            border: 3px solid #e2e8f0;
            border-top-color: var(--primary);
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
        }
        
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
        
        /* Cards */
        .dish-card {
            background: #fff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0,0,0,0.08), 0 4px 12px rgba(0,0,0,0.05);
            transition: transform 0.2s, box-shadow 0.2s;
        }
        
        .dish-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.1), 0 8px 24px rgba(0,0,0,0.08);
        }
        
        .dish-card-image {
            height: 200px;
            width: 100%;
            object-fit: cover;
        }
        
        .dish-card-body {
            padding: 1.25rem;
        }
        
        .dish-card-title {
            font-family: 'Playfair Display', Georgia, serif;
            font-size: 1.1rem;
            font-weight: 600;
            margin: 0 0 0.25rem 0;
            color: var(--text-dark);
        }
        
        .dish-card-restaurant {
            font-size: 0.875rem;
            color: var(--text-muted);
            margin: 0 0 0.75rem 0;
        }
        
        .dish-card-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 0.85rem;
        }
        
        .dish-card-rating {
            display: flex;
            align-items: center;
            gap: 0.25rem;
            font-weight: 500;
        }
        
        .dish-card-likes {
            color: var(--text-muted);
        }
        
        /* Buttons */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            font-size: 0.9rem;
            font-weight: 500;
            text-decoration: none;
            cursor: pointer;
            transition: all 0.2s;
            border: none;
        }
        
        .btn-primary {
            background: var(--primary);
            color: #fff;
        }
        
        .btn-primary:hover {
            background: var(--primary-dark);
        }
        
        .btn-secondary {
            background: var(--secondary);
            color: #fff;
        }
        
        .btn-secondary:hover {
            background: #0f172a;
        }
        
        .btn-outline {
            background: transparent;
            border: 2px solid var(--secondary);
            color: var(--secondary);
        }
        
        .btn-outline:hover {
            background: var(--secondary);
            color: #fff;
        }
        
        /* Hero Section */
        .hero-section {
            background: linear-gradient(135deg, #fff5eb 0%, #fef3c7 100%);
            border-radius: 16px;
            padding: 3rem;
            text-align: center;
            margin-bottom: 2rem;
        }
        
        .hero-title {
            font-family: 'Playfair Display', Georgia, serif;
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--text-dark);
            margin: 0 0 0.5rem 0;
        }
        
        .hero-subtitle {
            color: var(--text-muted);
            font-size: 1.1rem;
            margin: 0 0 1.5rem 0;
        }
        
        /* Filter Section */
        .filter-section {
            background: #fff;
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 2rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        }
        
        .filter-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
        }
        
        .filter-group label {
            display: block;
            font-size: 0.8rem;
            font-weight: 600;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 0.5rem;
        }
        
        .filter-group select {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            font-size: 0.9rem;
            color: var(--text-dark);
            background: #fff;
            cursor: pointer;
            transition: border-color 0.2s;
        }
        
        .filter-group select:focus {
            outline: none;
            border-color: var(--primary);
        }
        
        /* Dishes Grid */
        .dishes-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 1.5rem;
        }
        
        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            background: #fff;
            border-radius: 12px;
        }
        
        .empty-state-icon {
            font-size: 4rem;
            margin-bottom: 1rem;
        }
        
        .empty-state-title {
            font-family: 'Playfair Display', Georgia, serif;
            font-size: 1.5rem;
            color: var(--text-dark);
            margin: 0 0 0.5rem 0;
        }
        
        .empty-state-text {
            color: var(--text-muted);
            margin: 0;
        }
        
        /* Mobile menu */
        @media (max-width: 768px) {
            .nav-links {
                display: none;
            }
            
            .hero-title {
                font-size: 1.75rem;
            }
            
            .hero-section {
                padding: 2rem 1.5rem;
            }
            
            .dishes-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
    @stack('styles')
</head>
<body>
    @include('partials.icons')
    
    <!-- Header -->
    <header class="site-header">
        <div class="header-container">
            <a href="/" class="logo">
                <svg class="icon icon-lg"><use href="#icon-utensils"></use></svg>
                FOODCITA
            </a>
            
            <nav class="nav-links">
                <a href="/">Home</a>
                <a href="/#dishes">Dishes</a>
                <a href="/#categories">Categories</a>
            </nav>
            
            <div class="header-actions">
                @auth
                    <a href="/my-dishes" class="nav-links-item" style="color: rgba(255,255,255,0.85); text-decoration: none; font-size: 0.9rem; font-weight: 500;">My Dishes</a>
                    <a href="/upload" class="btn-header btn-header-primary">+ Upload Dish</a>
                    <div class="user-menu">
                        <div class="user-avatar">{{ substr(auth()->user()->name, 0, 1) }}</div>
                        <span>{{ auth()->user()->name }}</span>
                        <form method="POST" action="/logout" style="margin: 0;">
                            @csrf
                            <button type="submit" class="btn-header btn-header-outline" style="cursor: pointer;">Logout</button>
                        </form>
                    </div>
                @else
                    <a href="/login" class="btn-header btn-header-outline">Login</a>
                    <a href="/register" class="btn-header btn-header-primary">Sign Up</a>
                @endauth
            </div>
        </div>
    </header>
    
    <!-- Main Content -->
    <main class="main-content">
        @yield('content')
    </main>
    
    <!-- Footer -->
    <footer class="site-footer">
        <div class="footer-container">
            <div class="footer-grid">
                <div class="footer-section">
                    <h4><svg class="icon"><use href="#icon-utensils"></use></svg> FOODCITA</h4>
                    <p>Discover and share the best dishes from restaurants in your city. Join our community of food lovers!</p>
                </div>
                
                <div class="footer-section">
                    <h4>Explore</h4>
                    <ul>
                        <li><a href="/">Home</a></li>
                        <li><a href="/#dishes">Popular Dishes</a></li>
                        <li><a href="/#categories">Categories</a></li>
                        <li><a href="/upload">Upload a Dish</a></li>
                    </ul>
                </div>
                
                <div class="footer-section">
                    <h4>Company</h4>
                    <ul id="footer-cms-links">
                        <li><a href="#">Loading...</a></li>
                    </ul>
                </div>
                
                <div class="footer-section">
                    <h4>Connect</h4>
                    <ul>
                        <li><a href="#"><svg class="icon icon-sm"><use href="#icon-globe"></use></svg> Facebook</a></li>
                        <li><a href="#"><svg class="icon icon-sm"><use href="#icon-camera"></use></svg> Instagram</a></li>
                        <li><a href="#"><svg class="icon icon-sm"><use href="#icon-comment"></use></svg> Twitter</a></li>
                        <li><a href="#"><svg class="icon icon-sm"><use href="#icon-external-link"></use></svg> Newsletter</a></li>
                    </ul>
                </div>
            </div>
            
            <div class="footer-bottom">
                <p>&copy; {{ date('Y') }} FOODCITA. All rights reserved.</p>
                <div class="social-links">
                    <a href="#"><svg class="icon"><use href="#icon-globe"></use></svg></a>
                    <a href="#"><svg class="icon"><use href="#icon-camera"></use></svg></a>
                    <a href="#"><svg class="icon"><use href="#icon-comment"></use></svg></a>
                </div>
            </div>
        </div>
    </footer>
    
    <script>
    // Load CMS footer links
    document.addEventListener('DOMContentLoaded', async function() {
        try {
            const res = await fetch('/api/cms-pages/footer');
            const pages = await res.json();
            const container = document.getElementById('footer-cms-links');
            
            if (pages.length) {
                container.innerHTML = pages.map(p => 
                    `<li><a href="/page/${p.slug}">${p.title}</a></li>`
                ).join('');
            } else {
                container.innerHTML = '<li><a href="/page/about">About Us</a></li>';
            }
        } catch (e) {
            console.error('Failed to load footer links:', e);
            document.getElementById('footer-cms-links').innerHTML = '';
        }
    });
    </script>
    
    @stack('scripts')
</body>
</html>
