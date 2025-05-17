<!DOCTYPE html>
<html>
<head>
    <title>Email Verification</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .button { 
            display: inline-block; 
            padding: 10px 20px; 
            background-color: #780000; 
            color: white; 
            text-decoration: none; 
            border-radius: 5px; 
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Verify Your Email Address</h2>
        <p>Hello {{ $user->first_name }},</p>
        <p>Thank you for registering with our platform. Please click the button below to verify your email address:</p>
        
        <a href="{{ $verificationUrl }}" class="button">Verify Email Address</a>
        
        <p>If you did not create an account, no further action is required.</p>
        
        <p>Regards,<br>ACTION Center Inventory Team</p>
    </div>
</body>
</html>