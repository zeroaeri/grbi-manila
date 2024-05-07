<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&display=swap');

        body {
            font-family: 'DM Sans', sans-serif !important;
            background-color: #f8f9fa; 
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-image: url(images/cityhall3.jpg);
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-size: cover;
        }
        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100%;  
        }
        .message {
            text-align: center;
            border: 2px solid #dc3545; 
            border-radius: 10px; 
            background-color: #ffffff; 
            font-size: 20px;
            padding: 30px; 
            max-width: 600px; 
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.3); 
        }
        .shake {
            animation: shake 0.5s infinite alternate;
        }
         @keyframes shake {
          from {
            transform: translateX(-5px);
         }
           to {
            transform: translateX(5px);
     }
  }
    </style>
</head>
<body>
    <div class="container">
        <div class="message" id="message">
        <i class="fas fa-lock shake" style="font-size: 58px; color: red;"></i>  
            <h2 class="mt-3" style="color: darkred; font-weight: 800;">Forgot Your Password?</h2>
            <p class="mb-4">Don't worry! Contact our administrators at <strong>[contact details]</strong> to reset your password.</p>
            <a href="login.php" class="btn btn-success btn-lg btn-block">Back to Login Page</a>
        </div>
    </div>
</body>
</html>
