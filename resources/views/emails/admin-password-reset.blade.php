<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Your Admin Password</title>
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
        h1 {
            color: #1e293b;
            font-size: 24px;
            margin-bottom: 20px;
        }
        p {
            color: #64748b;
            margin-bottom: 15px;
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
        .btn:hover {
            background-color: #c94400;
        }
        .footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #e2e8f0;
            text-align: center;
            color: #94a3b8;
            font-size: 13px;
        }
        .warning {
            background-color: #fee2e2;
            border: 1px solid #fecaca;
            color: #991b1b;
            padding: 12px;
            border-radius: 8px;
            font-size: 14px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo">🍽️ FOODCITA</div>
            <div class="admin-badge">ADMIN PANEL</div>
        </div>
        
        <h1>Reset Your Admin Password</h1>
        
        <p>Hello {{ $admin->username }},</p>
        
        <p>We received a request to reset the password for your FOODCITA Admin account. Click the button below to create a new password:</p>
        
        <div style="text-align: center;">
            <a href="{{ $resetUrl }}" class="btn">Reset Admin Password</a>
        </div>
        
        <div class="warning">
            🔒 <strong>Security Notice:</strong> This password reset link will expire in 60 minutes. If you didn't request this password reset, please secure your account immediately and contact the system administrator.
        </div>
        
        <p style="margin-top: 30px;">If the button above doesn't work, copy and paste this link into your browser:</p>
        <p style="word-break: break-all; font-size: 13px; color: #94a3b8;">{{ $resetUrl }}</p>
        
        <div class="footer">
            <p>This email was sent to {{ $admin->email }}</p>
            <p>&copy; {{ date('Y') }} FOODCITA Admin. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
