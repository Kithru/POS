<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rajarata Sakura - Login</title>
    <link href="{{ asset('css/login.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
</head>
<body>

    <div class="login-container">
        <div class="login-card">
            <h2>Login</h2>
            <p>Welcome back! Please login to your account.</p>
            <form method="POST" action="#">
                @csrf
                <div class="input-group">
                    <label for="email">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus>
                    @error('email')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="input-group">
                    <label for="password">Password</label>
                    <input id="password" type="password" name="password" required>
                    @error('password')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-footer">
                    <div class="remember">
                        <input type="checkbox" name="remember" id="remember">
                        <label for="remember">Remember Me</label>
                    </div>
                </div>

                <button type="submit">Login</button>

                <p class="signup-text">Don't have an account? <a href="#">Sign Up</a></p>
            </form>

            <!-- Home Icon at bottom -->
            <div class="home-icon">
                <a href="{{ url('/') }}" title="Home">
                    <i class="fas fa-home"></i>
                </a>
            </div>

        </div>
    </div>

</body>
</html>