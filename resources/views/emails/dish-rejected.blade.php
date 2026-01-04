<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update on Your Dish Submission</title>
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
            background-color: #fef2f2;
            border-radius: 12px;
            padding: 25px;
            margin: 25px 0;
            border-left: 4px solid #ef4444;
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
            background-color: #ef4444;
            color: #ffffff;
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 600;
            margin-top: 10px;
        }
        .reasons-box {
            background-color: #fffbeb;
            border: 1px solid #fde68a;
            border-radius: 8px;
            padding: 20px;
            margin: 25px 0;
        }
        .reasons-box h3 {
            color: #92400e;
            margin-top: 0;
            font-size: 16px;
        }
        .reasons-box ul {
            color: #a16207;
            margin: 10px 0 0 0;
            padding-left: 20px;
        }
        .reasons-box li {
            margin-bottom: 8px;
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
        .encouragement {
            background-color: #f0f9ff;
            border: 1px solid #bae6fd;
            color: #0369a1;
            padding: 15px;
            border-radius: 8px;
            text-align: center;
            margin-top: 25px;
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
            <div class="logo">🍽️ FOODCITA</div>
        </div>
        
        <h1>Update on Your Dish Submission</h1>
        
        <p>Hello {{ $user->name }},</p>
        
        <p>Thank you for taking the time to share with our community. Unfortunately, after careful review, we were unable to approve your dish submission at this time.</p>
        
        <div class="dish-card">
            <div class="dish-name">{{ $dish->name }}</div>
            @if($dish->restaurant)
            <div class="dish-detail">🏪 <span>Restaurant:</span> {{ $dish->restaurant->name }}</div>
            @endif
            <div class="status-badge">Not Approved</div>
        </div>
        
        <div class="reasons-box">
            <h3>📋 Common Reasons for Non-Approval:</h3>
            <ul>
                <li>Image quality is too low or blurry</li>
                <li>Photo doesn't clearly show the dish</li>
                <li>Duplicate submission of an existing dish</li>
                <li>Restaurant information is incomplete or incorrect</li>
                <li>Content doesn't meet our community guidelines</li>
            </ul>
        </div>
        
        <div style="text-align: center;">
            <a href="{{ $myDishesUrl }}" class="btn">View My Dishes</a>
        </div>
        
        <div class="encouragement">
            💡 <strong>Don't be discouraged!</strong> We'd love to see you try again. Make sure your photos are clear and well-lit, and that all restaurant details are accurate.
        </div>
        
        <p style="text-align: center; color: #94a3b8; font-size: 14px; margin-top: 25px;">If you believe this was a mistake, please contact our support team.</p>
        
        <div class="footer">
            <p>This email was sent to {{ $user->email }}</p>
            <p>&copy; {{ date('Y') }} FOODCITA. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
