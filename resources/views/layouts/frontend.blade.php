<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('meta_title', $seoSettings['default_meta_title'] ?? 'FOODCITA - Discover Delicious Dishes')</title>
    <meta name="description" content="@yield('meta_description', $seoSettings['default_meta_description'] ?? 'Share your favorite meals and explore dishes loved by food enthusiasts in your city.')">
    <meta name="keywords" content="@yield('meta_keywords', $seoSettings['default_meta_keywords'] ?? 'food, dishes, restaurants, reviews, dining')">
    
    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('storage/favicon/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('storage/favicon/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('storage/favicon/favicon-16x16.png') }}">
    <link rel="shortcut icon" href="{{ asset('storage/favicon/favicon.ico') }}">
    
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-6579J2TEHH"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());
      gtag('config', 'G-6579J2TEHH');
    </script>
    
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
        
        /* Hamburger Menu */
        .hamburger {
            display: none;
            flex-direction: column;
            justify-content: center;
            gap: 5px;
            width: 30px;
            height: 30px;
            cursor: pointer;
            z-index: 101;
        }
        
        .hamburger span {
            display: block;
            width: 100%;
            height: 3px;
            background: #fff;
            border-radius: 3px;
            transition: all 0.3s ease;
        }
        
        .hamburger.active span:nth-child(1) {
            transform: rotate(45deg) translate(6px, 6px);
        }
        
        .hamburger.active span:nth-child(2) {
            opacity: 0;
        }
        
        .hamburger.active span:nth-child(3) {
            transform: rotate(-45deg) translate(6px, -6px);
        }
        
        /* Mobile Menu Overlay */
        .mobile-menu-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 99;
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        
        .mobile-menu-overlay.active {
            display: block;
            opacity: 1;
        }
        
        /* Mobile Menu */
        .mobile-menu {
            display: none;
            position: fixed;
            top: 0;
            right: -280px;
            width: 280px;
            height: 100vh;
            background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
            z-index: 100;
            padding: 80px 1.5rem 2rem;
            transition: right 0.3s ease;
            overflow-y: auto;
        }
        
        .mobile-menu.active {
            right: 0;
        }
        
        .mobile-menu a {
            display: block;
            color: rgba(255,255,255,0.9);
            text-decoration: none;
            padding: 0.875rem 0;
            font-size: 1rem;
            font-weight: 500;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            transition: color 0.2s;
        }
        
        .mobile-menu a:hover {
            color: var(--primary);
        }
        
        .mobile-menu .mobile-menu-section {
            margin-top: 1.5rem;
            padding-top: 1.5rem;
            border-top: 1px solid rgba(255,255,255,0.2);
        }
        
        .mobile-menu .btn-mobile {
            display: block;
            text-align: center;
            padding: 0.75rem 1rem;
            border-radius: 8px;
            margin-top: 0.75rem;
            font-weight: 500;
        }
        
        .mobile-menu .btn-mobile-outline {
            border: 1px solid rgba(255,255,255,0.3);
            color: #fff;
        }
        
        .mobile-menu .btn-mobile-primary {
            background: var(--primary);
            color: #fff;
        }
        
        .mobile-menu .user-info {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 1rem 0;
            color: #fff;
        }
        
        .mobile-menu .user-info .user-avatar {
            width: 40px;
            height: 40px;
        }
        
        /* Mobile Responsive */
        @media (max-width: 768px) {
            .hamburger {
                display: flex;
            }
            
            .mobile-menu {
                display: block;
            }
            
            .nav-links {
                display: none;
            }
            
            .header-actions {
                display: none;
            }
            
            .header-container {
                height: 60px;
            }
            
            .logo {
                font-size: 1.5rem;
            }
            
            .main-content {
                padding: 1.5rem 1rem;
            }
            
            .footer-grid {
                grid-template-columns: 1fr;
                gap: 1.5rem;
            }
            
            .footer-bottom {
                flex-direction: column;
                text-align: center;
            }
        }
        
        @media (max-width: 480px) {
            .main-content {
                padding: 1rem 0.75rem;
            }
            
            .logo {
                font-size: 1.25rem;
            }
            
            .footer-container {
                padding: 2rem 1rem 1.5rem;
            }
            
            .dish-card-image {
                height: 160px;
            }
            
            .dish-card-body {
                padding: 1rem;
            }
            
            .dish-card-title {
                font-size: 1rem;
            }
        }
        
        /* Responsive Grid Helper */
        .responsive-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 1.5rem;
        }
        
        @media (max-width: 640px) {
            .responsive-grid {
                grid-template-columns: 1fr;
                gap: 1rem;
            }
        }
        
        /* Responsive Section Headers */
        .section-header {
            margin-bottom: 1.5rem;
        }
        
        .section-title {
            font-family: 'Playfair Display', Georgia, serif;
            font-size: 2rem;
            font-weight: 700;
            margin: 0 0 0.5rem 0;
        }
        
        @media (max-width: 768px) {
            .section-title {
                font-size: 1.5rem;
            }
        }
        
        @media (max-width: 480px) {
            .section-title {
                font-size: 1.25rem;
            }
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
            color: #1e293b;
            background: rgba(255,255,255,0.9);
        }
        
        .btn-header-outline:hover {
            border-color: #fff;
            background: #fff;
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
        
        @media (max-width: 768px) {
            .hero-section {
                padding: 2rem 1.5rem;
                border-radius: 12px;
            }
            
            .hero-title {
                font-size: 1.75rem;
            }
            
            .hero-subtitle {
                font-size: 1rem;
            }
        }
        
        @media (max-width: 480px) {
            .hero-section {
                padding: 1.5rem 1rem;
                border-radius: 8px;
            }
            
            .hero-title {
                font-size: 1.5rem;
            }
            
            .hero-subtitle {
                font-size: 0.9rem;
            }
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
        
        @media (max-width: 480px) {
            .filter-section {
                padding: 1rem;
                border-radius: 8px;
            }
            
            .filter-grid {
                grid-template-columns: 1fr;
            }
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
        
        /* Smart Validation Styles */
        .form-group.has-error .form-control {
            border-color: #dc2626;
            background-color: #fef2f2;
        }
        
        .form-group.has-error .form-control:focus {
            border-color: #dc2626;
            box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.1);
        }
        
        .form-group.has-success .form-control {
            border-color: #10b981;
        }
        
        .form-group.has-success .form-control:focus {
            border-color: #10b981;
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
        }
        
        .form-error {
            display: none;
            color: #dc2626;
            font-size: 0.8rem;
            margin-top: 0.35rem;
            padding-left: 0.25rem;
        }
        
        .form-error svg {
            vertical-align: -2px;
            margin-right: 0.25rem;
        }
        
        .form-group.has-error .form-error {
            display: block;
            animation: fadeInUp 0.2s ease-out;
        }
        
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(-5px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
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
                @if($seoSettings['site_logo'] ?? null)
                    <img src="{{ asset('storage/' . $seoSettings['site_logo']) }}" alt="{{ $seoSettings['site_name'] ?? 'FOODCITA' }}" class="logo-img" style="height: 36px; width: auto; max-width: 180px; object-fit: contain;">
                @else
                    <svg class="icon icon-lg"><use href="#icon-utensils"></use></svg>
                    {{ $seoSettings['site_name'] ?? 'FOODCITA' }}
                @endif
            </a>
            
            <nav class="nav-links">
                <a href="/">Home</a>
                <a href="/dishes">Dishes</a>
                <a href="/popular">🔥 Popular</a>
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
            
            <!-- Hamburger Menu Button -->
            <div class="hamburger" id="hamburger" onclick="toggleMobileMenu()">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
    </header>
    
    <!-- Mobile Menu Overlay -->
    <div class="mobile-menu-overlay" id="mobileMenuOverlay" onclick="toggleMobileMenu()"></div>
    
    <!-- Mobile Menu -->
    <nav class="mobile-menu" id="mobileMenu">
        <a href="/" onclick="toggleMobileMenu()">Home</a>
        <a href="/dishes" onclick="toggleMobileMenu()">Dishes</a>
        <a href="/popular" onclick="toggleMobileMenu()">🔥 Popular</a>
        
        @auth
            <a href="/my-dishes" onclick="toggleMobileMenu()">My Dishes</a>
            <a href="/upload" onclick="toggleMobileMenu()">+ Upload Dish</a>
            
            <div class="mobile-menu-section">
                <div class="user-info">
                    <div class="user-avatar">{{ substr(auth()->user()->name, 0, 1) }}</div>
                    <span>{{ auth()->user()->name }}</span>
                </div>
                <form method="POST" action="/logout">
                    @csrf
                    <button type="submit" class="btn-mobile btn-mobile-outline" style="width: 100%; cursor: pointer; border: 1px solid rgba(255,255,255,0.3); background: transparent;">Logout</button>
                </form>
            </div>
        @else
            <div class="mobile-menu-section">
                <a href="/login" class="btn-mobile btn-mobile-outline" onclick="toggleMobileMenu()">Login</a>
                <a href="/register" class="btn-mobile btn-mobile-primary" onclick="toggleMobileMenu()">Sign Up</a>
            </div>
        @endauth
    </nav>
    
    <!-- Main Content -->
    <main class="main-content">
        @yield('content')
    </main>
    
    <!-- Footer -->
    <footer class="site-footer">
        <div class="footer-container">
            <div class="footer-grid">
                <div class="footer-section">
                    <h4>
                        @if($seoSettings['site_logo'] ?? null)
                            <img src="{{ asset('storage/' . $seoSettings['site_logo']) }}" alt="{{ $seoSettings['site_name'] ?? 'FOODCITA' }}" style="height: 28px; width: auto; max-width: 140px; object-fit: contain; vertical-align: middle;">
                        @else
                            <svg class="icon"><use href="#icon-utensils"></use></svg> {{ $seoSettings['site_name'] ?? 'FOODCITA' }}
                        @endif
                    </h4>
                    <p>Discover and share the best dishes from restaurants in your city. Join our community of food lovers!</p>
                </div>
                
                <div class="footer-section">
                    <h4>Explore</h4>
                    <ul>
                        <li><a href="/">Home</a></li>
                        <li><a href="/dishes">Dishes</a></li>
                        <li><a href="/popular">🔥 Popular Dishes</a></li>
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
                        @if($seoSettings['social_facebook'] ?? null)
                        <li><a href="{{ $seoSettings['social_facebook'] }}" target="_blank" rel="noopener"><svg class="icon icon-sm"><use href="#icon-globe"></use></svg> Facebook</a></li>
                        @endif
                        @if($seoSettings['social_instagram'] ?? null)
                        <li><a href="{{ $seoSettings['social_instagram'] }}" target="_blank" rel="noopener"><svg class="icon icon-sm"><use href="#icon-camera"></use></svg> Instagram</a></li>
                        @endif
                        @if($seoSettings['social_twitter'] ?? null)
                        <li><a href="{{ $seoSettings['social_twitter'] }}" target="_blank" rel="noopener"><svg class="icon icon-sm"><use href="#icon-comment"></use></svg> Twitter / X</a></li>
                        @endif
                        @if($seoSettings['social_youtube'] ?? null)
                        <li><a href="{{ $seoSettings['social_youtube'] }}" target="_blank" rel="noopener"><svg class="icon icon-sm"><use href="#icon-external-link"></use></svg> YouTube</a></li>
                        @endif
                        @if($seoSettings['social_tiktok'] ?? null)
                        <li><a href="{{ $seoSettings['social_tiktok'] }}" target="_blank" rel="noopener"><svg class="icon icon-sm"><use href="#icon-external-link"></use></svg> TikTok</a></li>
                        @endif
                        @if(!($seoSettings['social_facebook'] ?? null) && !($seoSettings['social_instagram'] ?? null) && !($seoSettings['social_twitter'] ?? null) && !($seoSettings['social_youtube'] ?? null) && !($seoSettings['social_tiktok'] ?? null))
                        <li><span style="color: var(--text-muted);">No social links configured</span></li>
                        @endif
                    </ul>
                </div>
            </div>
            
            <div class="footer-bottom">
                <p>&copy; {{ date('Y') }} {{ $seoSettings['site_name'] ?? 'FOODCITA' }}. All rights reserved.</p>
                <div class="social-links">
                    @if($seoSettings['social_facebook'] ?? null)
                    <a href="{{ $seoSettings['social_facebook'] }}" target="_blank" rel="noopener"><svg class="icon"><use href="#icon-globe"></use></svg></a>
                    @endif
                    @if($seoSettings['social_instagram'] ?? null)
                    <a href="{{ $seoSettings['social_instagram'] }}" target="_blank" rel="noopener"><svg class="icon"><use href="#icon-camera"></use></svg></a>
                    @endif
                    @if($seoSettings['social_twitter'] ?? null)
                    <a href="{{ $seoSettings['social_twitter'] }}" target="_blank" rel="noopener"><svg class="icon"><use href="#icon-comment"></use></svg></a>
                    @endif
                </div>
            </div>
        </div>
    </footer>
    
    <script>
    // Smart Form Validation Utility
    window.SmartValidator = {
        rules: {
            required: (value, message) => ({
                valid: value && value.toString().trim() !== '',
                message: message || 'This field is required'
            }),
            email: (value, message) => ({
                valid: !value || /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value),
                message: message || 'Please enter a valid email address'
            }),
            minLength: (value, length, message) => ({
                valid: !value || value.length >= length,
                message: message || `Must be at least ${length} characters`
            }),
            maxLength: (value, length, message) => ({
                valid: !value || value.length <= length,
                message: message || `Must be no more than ${length} characters`
            }),
            match: (value, targetValue, message) => ({
                valid: value === targetValue,
                message: message || 'Values do not match'
            }),
            url: (value, message) => ({
                valid: !value || /^https?:\/\/.+/.test(value),
                message: message || 'Please enter a valid URL (starting with http:// or https://)'
            }),
            number: (value, message) => ({
                valid: !value || !isNaN(parseFloat(value)),
                message: message || 'Please enter a valid number'
            }),
            min: (value, minVal, message) => ({
                valid: !value || parseFloat(value) >= minVal,
                message: message || `Value must be at least ${minVal}`
            }),
            phone: (value, message) => ({
                valid: !value || /^[\d\s\-\+\(\)\.]{7,}$/.test(value),
                message: message || 'Please enter a valid phone number'
            }),
            files: (input, message) => ({
                valid: input && input.files && input.files.length > 0,
                message: message || 'Please select at least one file'
            })
        },
        
        setError(input, message) {
            const group = input.closest('.form-group');
            if (!group) return;
            
            group.classList.remove('has-success');
            group.classList.add('has-error');
            
            let errorEl = group.querySelector('.form-error');
            if (!errorEl) {
                errorEl = document.createElement('div');
                errorEl.className = 'form-error';
                input.parentNode.insertBefore(errorEl, input.nextSibling);
            }
            errorEl.innerHTML = `<svg class="icon icon-xs"><use href="#icon-x"></use></svg> ${message}`;
        },
        
        clearError(input) {
            const group = input.closest('.form-group');
            if (!group) return;
            
            group.classList.remove('has-error');
            const errorEl = group.querySelector('.form-error');
            if (errorEl) errorEl.style.display = 'none';
        },
        
        setSuccess(input) {
            const group = input.closest('.form-group');
            if (!group) return;
            
            group.classList.remove('has-error');
            group.classList.add('has-success');
            const errorEl = group.querySelector('.form-error');
            if (errorEl) errorEl.style.display = 'none';
        },
        
        validateField(input, validations) {
            const value = input.value;
            
            for (const validation of validations) {
                const result = validation(value, input);
                if (!result.valid) {
                    this.setError(input, result.message);
                    return false;
                }
            }
            
            this.setSuccess(input);
            return true;
        },
        
        validateForm(form, fieldValidations) {
            let isValid = true;
            
            for (const [fieldId, validations] of Object.entries(fieldValidations)) {
                const input = form.querySelector(`#${fieldId}`) || form.querySelector(`[name="${fieldId}"]`);
                if (input && !this.validateField(input, validations)) {
                    isValid = false;
                }
            }
            
            return isValid;
        },
        
        attachLiveValidation(form, fieldValidations) {
            for (const [fieldId, validations] of Object.entries(fieldValidations)) {
                const input = form.querySelector(`#${fieldId}`) || form.querySelector(`[name="${fieldId}"]`);
                if (!input) continue;
                
                // Validate on blur
                input.addEventListener('blur', () => {
                    if (input.value) this.validateField(input, validations);
                });
                
                // Clear error on input
                input.addEventListener('input', () => {
                    const group = input.closest('.form-group');
                    if (group && group.classList.contains('has-error')) {
                        this.validateField(input, validations);
                    }
                });
            }
        }
    };
    </script>
    
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
    
    // Mobile Menu Toggle
    function toggleMobileMenu() {
        const hamburger = document.getElementById('hamburger');
        const mobileMenu = document.getElementById('mobileMenu');
        const overlay = document.getElementById('mobileMenuOverlay');
        
        hamburger.classList.toggle('active');
        mobileMenu.classList.toggle('active');
        overlay.classList.toggle('active');
        
        // Prevent body scroll when menu is open
        if (mobileMenu.classList.contains('active')) {
            document.body.style.overflow = 'hidden';
        } else {
            document.body.style.overflow = '';
        }
    }
    
    // Close mobile menu on window resize (if switching to desktop)
    window.addEventListener('resize', function() {
        if (window.innerWidth > 768) {
            const hamburger = document.getElementById('hamburger');
            const mobileMenu = document.getElementById('mobileMenu');
            const overlay = document.getElementById('mobileMenuOverlay');
            
            hamburger.classList.remove('active');
            mobileMenu.classList.remove('active');
            overlay.classList.remove('active');
            document.body.style.overflow = '';
        }
    });
    </script>
    
    {{-- Google reCAPTCHA Script --}}
    @if(config('captcha.enabled', true) && config('captcha.sitekey'))
        {!! app('captcha')->renderJs() !!}
    @endif
    
    @stack('scripts')
</body>
</html>
