<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dish Submitted for Review</title>
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
        .status-icon {
            font-size: 48px;
            margin-bottom: 15px;
        }
        h1 {
            color: #1e293b;
            font-size: 24px;
            margin-bottom: 20px;
        }
        p {
            color: #64748b;
            margin-bottom: 15px;
        }
        .dish-card {
            background-color: #faf9f7;
            border-radius: 12px;
            padding: 25px;
            margin: 25px 0;
            border-left: 4px solid #f59e0b;
        }
        .dish-name {
            font-size: 20px;
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
            background-color: #fef3cd;
            color: #856404;
            padding: 6px 12px;
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
            margin: 20px 0;
        }
        .info-box {
            background-color: #eff6ff;
            border: 1px solid #bfdbfe;
            color: #1e40af;
            padding: 15px;
            border-radius: 8px;
            font-size: 14px;
            margin-top: 20px;
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
            <div class="status-icon">📝</div>
            @if($seoSettings['site_logo'] ?? null)
                <img src="{{ asset('storage/' . $seoSettings['site_logo']) }}" alt="{{ $seoSettings['site_name'] ?? 'FOODCITA' }}" style="height: 48px; width: auto; max-width: 200px; object-fit: contain; margin-bottom: 15px;">
            @else
                <div class="logo">🍽️ {{ $seoSettings['site_name'] ?? 'FOODCITA' }}</div>
            @endif
        </div>
        
        <h1>Your Dish Has Been Submitted!</h1>
        
        <p>Hello {{ $user->name }},</p>
        
        <p>Thank you for sharing your culinary discovery with the {{ $seoSettings['site_name'] ?? 'FOODCITA' }} community! Your dish submission has been received and is now pending review by our team.</p>
        
        <div class="dish-card">
            <div class="dish-name">{{ $dish->name }}</div>
            @if($dish->restaurant)
            <div class="dish-detail">🏪 <span>Restaurant:</span> {{ $dish->restaurant->name }}</div>
            @endif
            @if($dish->comment)
            <div class="dish-detail">💬 <span>Your Review:</span> {{ Str::limit($dish->comment, 100) }}</div>
            @endif
            @if($dish->meal_cost)
            <div class="dish-detail">💰 <span>Price:</span> ${{ number_format($dish->meal_cost, 2) }}</div>
            @endif
            <div class="status-badge">⏳ Pending Review</div>
        </div>
        
        <div class="info-box">
            <strong>What happens next?</strong><br>
            Our team reviews all dish submissions to ensure they meet our community guidelines. This usually takes 1-2 business days. We'll send you another email once your dish has been reviewed.
        </div>
        
        <div style="text-align: center;">
            <a href="{{ $myDishesUrl }}" class="btn">View My Dishes</a>
        </div>
        
        <p style="text-align: center; color: #94a3b8; font-size: 14px;">While you wait, why not explore other dishes shared by our community?</p>
        
        <div class="footer">
            <p>This email was sent to {{ $user->email }}</p>
            <p>&copy; {{ date('Y') }} {{ $seoSettings['site_name'] ?? 'FOODCITA' }}. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
