<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Dish Has Been Approved!</title>
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
            font-size: 28px;
            font-weight: bold;
            color: #e85d04;
        }
        .celebration {
            font-size: 64px;
            margin-bottom: 15px;
        }
        h1 {
            color: #1e293b;
            font-size: 28px;
            margin-bottom: 10px;
        }
        .subtitle {
            color: #16a34a;
            font-size: 18px;
            font-weight: 500;
        }
        p {
            color: #64748b;
            margin-bottom: 15px;
        }
        .dish-card {
            background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
            border-radius: 12px;
            padding: 25px;
            margin: 25px 0;
            border-left: 4px solid #22c55e;
        }
        .dish-name {
            font-size: 22px;
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 10px;
        }
        .dish-detail {
            color: #64748b;
            font-size: 14px;
            margin-bottom: 5px;
        }
        .dish-detail span {
            color: #475569;
            font-weight: 500;
        }
        .status-badge {
            display: inline-block;
            background-color: #22c55e;
            color: #ffffff;
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 600;
            margin-top: 10px;
        }
        .btn {
            display: inline-block;
            background-color: #e85d04;
            color: #ffffff !important;
            text-decoration: none;
            padding: 14px 32px;
            border-radius: 8px;
            font-weight: 600;
            margin: 10px;
        }
        .btn-secondary {
            background-color: #1e293b;
        }
        .share-section {
            background-color: #faf9f7;
            border-radius: 8px;
            padding: 20px;
            margin-top: 25px;
            text-align: center;
        }
        .share-section h3 {
            color: #1e293b;
            margin-bottom: 10px;
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
            <div class="celebration">🎉</div>
            <div class="logo">🍽️ FOODCITA</div>
            <h1>Congratulations!</h1>
            <p class="subtitle">Your dish has been approved!</p>
        </div>
        
        <p>Hello {{ $user->name }},</p>
        
        <p>Great news! Your dish submission has been reviewed and approved by our team. It's now live on FOODCITA and visible to our entire community of food lovers!</p>
        
        <div class="dish-card">
            <div class="dish-name">{{ $dish->name }}</div>
            @if($dish->restaurant)
            <div class="dish-detail">🏪 <span>Restaurant:</span> {{ $dish->restaurant->name }}</div>
            @endif
            @if($dish->meal_cost)
            <div class="dish-detail">💰 <span>Price:</span> ${{ number_format($dish->meal_cost, 2) }}</div>
            @endif
            <div class="status-badge">✓ Approved & Live</div>
        </div>
        
        <div style="text-align: center;">
            <a href="{{ $dishUrl }}" class="btn">View Your Dish</a>
            <a href="{{ url('/upload') }}" class="btn btn-secondary">Share Another Dish</a>
        </div>
        
        <div class="share-section">
            <h3>📢 Spread the Word!</h3>
            <p style="margin: 0; color: #64748b;">Share your dish with friends and family so they can discover this delicious find too!</p>
        </div>
        
        <p style="text-align: center; color: #94a3b8; font-size: 14px; margin-top: 25px;">Thank you for being an active member of our food community! 🙏</p>
        
        <div class="footer">
            <p>This email was sent to {{ $user->email }}</p>
            <p>&copy; {{ date('Y') }} FOODCITA. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
