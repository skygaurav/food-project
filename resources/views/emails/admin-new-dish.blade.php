<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Dish Submitted for Review</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #0f172a;
        }
        .container {
            background-color: #ffffff;
            border-radius: 12px;
            padding: 40px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.3);
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .logo {
            font-size: 28px;
            font-weight: bold;
            color: #eb5202;
        }
        .admin-badge {
            display: inline-block;
            background-color: #1e293b;
            color: #fff;
            padding: 4px 12px;
            border-radius: 4px;
            font-size: 12px;
            margin-top: 8px;
        }
        .notification-icon {
            font-size: 40px;
            margin-bottom: 10px;
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
            background-color: #f8fafc;
            border-radius: 12px;
            padding: 25px;
            margin: 25px 0;
            border: 1px solid #e2e8f0;
        }
        .dish-name {
            font-size: 22px;
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 15px;
        }
        .detail-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid #f1f5f9;
        }
        .detail-row:last-child {
            border-bottom: none;
        }
        .detail-label {
            color: #64748b;
            font-size: 14px;
            padding-right:
        }
        .detail-value {
            color: #1e293b;
            font-size: 14px;
            font-weight: 500;
        }
        .status-pending {
            display: inline-block;
            background-color: #fef3cd;
            color: #856404;
            padding: 4px 10px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 600;
        }
        .btn {
            display: inline-block;
            background-color: #eb5202;
            color: #ffffff !important;
            text-decoration: none;
            padding: 14px 32px;
            border-radius: 8px;
            font-weight: 600;
            margin: 20px 0;
        }
        .action-section {
            text-align: center;
            background-color: #faf9f7;
            border-radius: 8px;
            padding: 25px;
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
            <div class="notification-icon">🔔</div>
            @if($seoSettings['site_logo'] ?? null)
                <img src="{{ asset('storage/' . $seoSettings['site_logo']) }}" alt="{{ $seoSettings['site_name'] ?? 'FOODCITA' }}" style="height: 48px; width: auto; max-width: 200px; object-fit: contain; margin-bottom: 15px;">
            @else
                <div class="logo">🍽️ {{ $seoSettings['site_name'] ?? 'FOODCITA' }}</div>
            @endif
            <div class="admin-badge">ADMIN NOTIFICATION</div>
        </div>
        
        <h1>New Dish Pending Review</h1>
        
        <p>A new dish has been submitted by a user and requires your review. Please check the details below and take action.</p>
        
        <div class="dish-card">
            <div class="dish-name">{{ $dish->name }}</div>
            
            <div class="detail-row">
                <span class="detail-label">Submitted By</span>
                <span class="detail-value">{{ $dish->user?->name ?? 'Unknown' }} ({{ $dish->user?->email ?? 'N/A' }})</span>
            </div>
            
            <div class="detail-row">
                <span class="detail-label">Restaurant</span>
                <span class="detail-value">{{ $dish->restaurant?->name ?? 'N/A' }}</span>
            </div>
            
            @if($dish->restaurant)
            <div class="detail-row">
                <span class="detail-label">Location</span>
                <span class="detail-value">{{ $dish->restaurant->city ?? 'N/A' }}</span>
            </div>
            @endif
            
            @if($dish->meal_cost)
            <div class="detail-row">
                <span class="detail-label">Price</span>
                <span class="detail-value">${{ number_format($dish->meal_cost, 2) }}</span>
            </div>
            @endif
            
            <div class="detail-row">
                <span class="detail-label">Submitted On</span>
                <span class="detail-value">{{ $dish->created_at->format('M j, Y g:i A') }}</span>
            </div>
            
            <div class="detail-row">
                <span class="detail-label">Status</span>
                <span class="status-pending">⏳ Pending Review</span>
            </div>
        </div>
        
        @if($dish->comment)
        <div style="background-color: #f0f9ff; border-radius: 8px; padding: 15px; margin-bottom: 20px;">
            <strong style="color: #0369a1;">User's Comment:</strong>
            <p style="margin: 10px 0 0 0; color: #0c4a6e;">"{{ \Illuminate\Support\Str::limit($dish->comment, 300) }}"</p>
        </div>
        @endif
        
        <div class="action-section">
            <p style="margin-top: 0; color: #475569;"><strong>Review this submission:</strong></p>
            <a href="{{ $adminUrl }}" class="btn">Review Dish in Admin Panel</a>
        </div>
        
        <div class="footer">
            <p>This is an automated notification from {{ $seoSettings['site_name'] ?? 'FOODCITA' }} Admin</p>
            <p>&copy; {{ date('Y') }} {{ $seoSettings['site_name'] ?? 'FOODCITA' }}. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
