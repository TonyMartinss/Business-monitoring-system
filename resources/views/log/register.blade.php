<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Register</title>
  <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background: url('{{ asset('images/bg.jpg') }}') no-repeat center center fixed;
            background-size: cover;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Create Your Account</h2>
        <form action="login.html" method="POST">
            <div class="input-box">
                <input type="text" name="username" placeholder="Enter your full name" required>
                <i class="fas fa-user"></i>
            </div>
            <div class="input-box">
                <input type="email" name="email" placeholder="Enter your email" required>
                <i class="fas fa-envelope"></i>
            </div>
            <div class="input-box">
                <input type="password" name="password" placeholder="Create password" required>
                <i class="fas fa-lock"></i>
            </div>
            <div class="input-box">
                <input type="password" name="confirm_password" placeholder="Confirm password" required>
                <i class="fas fa-lock"></i>
            </div>

            <button type="submit" class="btn">Register</button>

            <div class="register">
               <p>Already have an account? <a href="{{ route('login') }}">Login here</a></p>
            </div>
        </form>
    </div>

  
</body>

</html>