<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Tatreez</title>
    <link href="https://fonts.googleapis.com/css2?family=Cairo&display=swap" rel="stylesheet">
    <style>
        body {
            margin: 0;
            font-family: 'Cairo', sans-serif;
            background: url("{{ asset('images/back.png') }}") no-repeat center center fixed;
            background-size: cover;
        }

        body::before {
            content: "";
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(255, 255, 255, 0.7);
            z-index: -1;
        }

        .auth-form {
            max-width: 500px;
            margin: 60px auto;
            padding: 35px;
            border: 3px solid rgba(145, 51, 51, 0.85);
            background-color: rgba(255, 255, 255, 0.95);
            border-radius: 15px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }

        .auth-form h1 {
            background-color: rgb(145, 51, 51);
            color: white;
            text-align: center;
            margin-bottom: 25px;
            font-weight: 600;
            padding: 15px;
            border-radius: 8px;
            font-size: 28px;
        }

        .auth-input {
            display: block;
            width: 100%;
            margin-bottom: 15px;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 16px;
        }

        .auth-button {
            width: 100%;
            padding: 12px;
            background-color: rgb(145, 51, 51);
            color: white;
            font-size: 18px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: 0.3s ease;
        }

        .auth-button:hover {
            background-color: #a73838;
        }

        .remember-me {
            margin: 10px 0;
        }

        .remember-me label {
            font-size: 14px;
            color: #333;
        }

        .forgot-password {
            display: block;
            text-align: right;
            color: rgb(145, 51, 51);
            text-decoration: none;
            margin-top: 10px;
        }

        .forgot-password:hover {
            text-decoration: underline;
        }

        .bottom-link {
            text-align: center;
            margin-top: 20px;
        }

        .bottom-link a {
            color: rgb(145, 51, 51);
            text-decoration: none;
        }

        .bottom-link a:hover {
            text-decoration: underline;
        }

        label {
            display: block;
            margin-bottom: 6px;
            font-weight: 600;
            color: #333;
        }

        .error {
            color: red;
            font-size: 14px;
            margin-top: -10px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>

    @if (session('status'))
        <div class="auth-form" style="color: green; text-align: center; font-weight: bold;">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}" class="auth-form">
    @method('POST')
        <h1>Login to Your Account</h1>
        @csrf

        <!-- Email -->
        <div>
            <label for="email">Email Address</label>
            <input id="email" class="auth-input" type="email" name="email" value="{{ old('email') }}" required autofocus>
            @error('email')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <!-- Password -->
        <div>
            <label for="password">Password</label>
            <input id="password" class="auth-input" type="password" name="password" required>
            @error('password')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <!-- Remember Me -->
        <div class="remember-me">
            <label>
                <input type="checkbox" name="remember">
                Remember me
            </label>
        </div>

        <!-- Forgot Password -->
        @if (Route::has('password.request'))
            <a class="forgot-password" href="{{ route('password.request') }}">
                Forgot your password?
            </a>
        @endif

        <!-- Submit Button -->
        <button type="submit" class="auth-button">Log in</button>

        <!-- Register Link -->
        <div class="bottom-link">
            <p>Don't have an account? <a href="{{ route('register') }}">Register here</a></p>
        </div>
    </form>

</body>
</html>
