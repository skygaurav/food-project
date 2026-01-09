<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to FOODCITA!</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f5f5f5;
        }
        .container {
            background-color: #ffffff;
            border-radius: 12px;
            padding: 40px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .logo {
            font-size: 32px;
            font-weight: bold;
            color: #e85d04;
        }
        .welcome-emoji {
            font-size: 48px;
            margin-bottom: 15px;
        }
        h1 {
            color: #1e293b;
            font-size: 28px;
            margin-bottom: 10px;
        }
        .subtitle {
            color: #64748b;
            font-size: 16px;
        }
        p {
            color: #64748b;
            margin-bottom: 15px;
        }
        .features {
            background-color: #faf9f7;
            border-radius: 8px;
            padding: 25px;
            margin: 25px 0;
        }
        .feature {
            display: flex;
            align-items: flex-start;
            margin-bottom: 15px;
        }
        .feature:last-child {
            margin-bottom: 0;
        }
        .feature-icon {
            font-size: 20px;
            margin-right: 12px;
            flex-shrink: 0;
        }
        .feature-text {
            color: #475569;
        }
        .feature-text strong {
            color: #1e293b;
        }
        .btn {
            display: inline-block;
            background-color: #e85d04;
            color: #ffffff !important;
            text-decoration: none;
            padding: 14px 32px;
            border-radius: 8px;
            font-weight: 600;
            margin: 10px 10px 10px 0;
        }
        .btn-secondary {
            background-color: #1e293b;
        }
        .cta {
            text-align: center;
            margin: 30px 0;
        }
        .footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #e2e8f0;
            text-align: center;
            color: #94a3b8;
            font-size: 13px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="welcome-emoji">🎉</div>
            @if($seoSettings['site_logo'] ?? null)
                <img src="{{ asset('storage/' . $seoSettings['site_logo']) }}" alt="{{ $seoSettings['site_name'] ?? 'FOODCITA' }}" style="height: 48px; width: auto; max-width: 200px; object-fit: contain; margin-bottom: 15px;">
            @else
                <div class="logo">{{ $seoSettings['site_name'] ?? 'FOODCITA' }}</div>
            @endif
            <h1>Welcome, {{ $user->name }}!</h1>
            <p class="subtitle">You've joined a community of food lovers!</p>
        </div>
        
        <p>Thank you for creating your {{ $seoSettings['site_name'] ?? 'FOODCITA' }} account! We're thrilled to have you as part of our food-loving community.</p>
        
        <div class="features">
            <h3 style="margin-top: 0; color: #1e293b;">What you can do with {{ $seoSettings['site_name'] ?? 'FOODCITA' }}:</h3>
            
            <div class="feature">
                <span class="feature-icon">📸</span>
                <div class="feature-text">
                    <strong>Share Your Favorite Dishes</strong><br>
                    Upload photos of delicious meals you've discovered at local restaurants
                </div>
            </div>
            
            <!--<div class="feature">
                <span class="feature-icon">⭐</span>
                <div class="feature-text">
                    <strong>Rate & Review</strong><br>
                    Help others find great food by sharing your honest reviews
                </div>
            </div>-->
            
            <div class="feature">
                <span class="feature-icon">❤️</span>
                <div class="feature-text">
                    <strong>Like & Discover</strong><br>
                    Like dishes you love and discover trending meals in your city
                </div>
            </div>
            
            <div class="feature">
                <span class="feature-icon">🍽️</span>
                <div class="feature-text">
                    <strong>Find Hidden Gems</strong><br>
                    Explore restaurants and dishes recommended by fellow food enthusiasts
                </div>
            </div>
        </div>
        
        <div class="cta">
            <a href="{{ $uploadUrl }}" class="btn">Share Your First Dish</a>
            <a href="{{ url('/dishes') }}" class="btn btn-secondary">Explore Dishes</a>
        </div>
        
        <p style="text-align: center; color: #94a3b8;">Ready to start your culinary journey? We can't wait to see what delicious discoveries you'll share!</p>
        
        <div class="footer">
            <p>This email was sent to {{ $user->email }}</p>
            <p>&copy; {{ date('Y') }} {{ $seoSettings['site_name'] ?? 'FOODCITA' }}. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
