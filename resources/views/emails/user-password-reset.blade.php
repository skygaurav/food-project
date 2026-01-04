<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Your Password</title>
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
        .btn:hover {
            background-color: #dc2f02;
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
            background-color: #fef3cd;
            border: 1px solid #ffc107;
            color: #856404;
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
        </div>
        
        <h1>Reset Your Password</h1>
        
        <p>Hello {{ $user->name }},</p>
        
        <p>We received a request to reset the password for your FOODCITA account. Click the button below to create a new password:</p>
        
        <div style="text-align: center;">
            <a href="{{ $resetUrl }}" class="btn">Reset My Password</a>
        </div>
        
        <div class="warning">
            ⚠️ This password reset link will expire in 60 minutes. If you didn't request a password reset, please ignore this email or contact support if you have concerns.
        </div>
        
        <p style="margin-top: 30px;">If the button above doesn't work, copy and paste this link into your browser:</p>
        <p style="word-break: break-all; font-size: 13px; color: #94a3b8;">{{ $resetUrl }}</p>
        
        <div class="footer">
            <p>This email was sent to {{ $user->email }}</p>
            <p>&copy; {{ date('Y') }} FOODCITA. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
