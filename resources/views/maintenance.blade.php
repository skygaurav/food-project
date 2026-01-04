<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Site Under Maintenance</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }
        
        .maintenance-container {
            background: #fff;
            border-radius: 24px;
            padding: 3rem;
            max-width: 500px;
            width: 100%;
            text-align: center;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        }
        
        .maintenance-icon {
            width: 120px;
            height: 120px;
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 2rem;
            animation: pulse 2s infinite;
        }
        
        .maintenance-icon svg {
            width: 60px;
            height: 60px;
            fill: #fff;
        }
        
        @keyframes pulse {
            0%, 100% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.05);
            }
        }
        
        h1 {
            font-size: 2rem;
            color: #1e293b;
            margin-bottom: 1rem;
            font-weight: 700;
        }
        
        p {
            font-size: 1.1rem;
            color: #64748b;
            line-height: 1.6;
            margin-bottom: 2rem;
        }
        
        .progress-bar {
            background: #e2e8f0;
            border-radius: 50px;
            height: 8px;
            overflow: hidden;
            margin-bottom: 1rem;
        }
        
        .progress-bar-inner {
            background: linear-gradient(90deg, #667eea, #764ba2);
            height: 100%;
            width: 60%;
            border-radius: 50px;
            animation: loading 2s ease-in-out infinite;
        }
        
        @keyframes loading {
            0% {
                width: 20%;
            }
            50% {
                width: 80%;
            }
            100% {
                width: 20%;
            }
        }
        
        .status-text {
            font-size: 0.9rem;
            color: #94a3b8;
        }
        
        .footer {
            margin-top: 2rem;
            padding-top: 2rem;
            border-top: 1px solid #e2e8f0;
        }
        
        .footer p {
            font-size: 0.85rem;
            color: #94a3b8;
            margin-bottom: 0;
        }
    </style>
</head>
<body>
    <div class="maintenance-container">
        <div class="maintenance-icon">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                <path d="M22.7 19l-9.1-9.1c.9-2.3.4-5-1.5-6.9-2-2-5-2.4-7.4-1.3L9 6 6 9 1.6 4.7C.4 7.1.9 10.1 2.9 12.1c1.9 1.9 4.6 2.4 6.9 1.5l9.1 9.1c.4.4 1 .4 1.4 0l2.3-2.3c.5-.4.5-1.1.1-1.4z"/>
            </svg>
        </div>
        
        <h1>We're Under Maintenance</h1>
        <p>Our site is currently undergoing scheduled maintenance. We'll be back shortly with an even better experience!</p>
        
        <div class="progress-bar">
            <div class="progress-bar-inner"></div>
        </div>
        <p class="status-text">Working hard to improve your experience...</p>
        
        <div class="footer">
            <p>Thank you for your patience</p>
        </div>
    </div>
</body>
</html>
