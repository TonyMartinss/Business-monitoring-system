<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login</title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- Your CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
</head>

<body>

    <div class="container">
        <h2>Login</h2>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email -->
            <div class="input-box">
                <i class="fa-solid fa-envelope"></i>
                <input type="email" name="email" required value="{{ old('email') }}">
                <label>Email</label>
                <span></span>
            </div>

            <!-- Password -->
            <div class="input-box">
                <i class="fa-solid fa-lock"></i>
                <input type="password" name="password" required >
                <label>Password</label>
                <span></span>
            </div>

            <div class="remember">
                <label>
                    <input type="checkbox" name="remember"> Remember me
                </label>
            </div>

            <button type="submit" class="btn">Login</button>

            <div class="register">
              

                <a href="{{ route('password.request') }}" class="text-sm text-blue-500 hover:underline">
                    Forgot your password?
                </a>

            </div>
        </form>
    </div>

</body>

</html>
