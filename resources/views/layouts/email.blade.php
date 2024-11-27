<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $subject ?? 'Your Subject Here' }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            padding: 20px;
        }
        .header {
            background-color: #f8f9fa;
            padding: 10px;
            text-align: center;
        }
        .footer {
            margin-top: 20px;
            text-align: center;
            font-size: 12px;
            color: #888;
        }
    </style>
</head>
<body>
<div class="header">
    <h1>Welcome to Our Cryptocurrency Gateway</h1>
    <p>Your trusted partner in cryptocurrency transactions.</p>
</div>

<div class="content">
    @yield('content')
</div>

<div class="footer">
    <p>&copy; {{ date('Y') }} Your Company Name. All rights reserved.</p>
</div>
</body>
</html>
