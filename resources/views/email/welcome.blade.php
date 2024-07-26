<!DOCTYPE html>
<html>
<head>
    <title>Welcome to Our Platform</title>
    <style>
        body {
            font-family: 'Arial, sans-serif';
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .header {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            text-align: center;
        }
        .content {
            padding: 20px;
        }
        .footer {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            text-align: center;
        }
        .button {
            display: inline-block;
            padding: 10px 20px;
            margin: 10px 0;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        .button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Gym Trainer Account Created</h1>
        </div>
        <div class="content">
            <p>Dear {{ $user->username }},</p>
            <p>Your account has been created successfully. Below are your login details:</p>
            <p><strong>Email:</strong> {{ $user->email }}</p>
            <p><strong>Password:</strong> {{ $password }}</p>
            <p>Please log in and change your password as soon as possible.</p>
            <p>To verify your email address, please click the button below:</p>
            @php
            $verificationUrl = URL::temporarySignedRoute(
                    'verification.verify',
                    now()->addMinutes(180),
                    ['id' => $user->user_id, 'hash' => sha1($user->email)]
                );
        
            @endphp
            <p><a class="button" href="{{$verificationUrl}}">Verify Email Address</a></p>
            <p>Best regards,</p>
            <p>APGym</p>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} APGym. All rights reserved.</p>
        </div>
    </div>
</body>
</html>


