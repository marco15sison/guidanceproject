<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Login - {{ config('app.name', 'Guidance Services') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Styles -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        :root {
            --primary-color: #1a3c61;
            --secondary-color: #2c5f8e;
            --accent-color: #4d8bc9;
            --light-accent: #e9f0f9;
        }
        
        body {
            font-family: 'Figtree', sans-serif;
            background-color: #f5f7fa;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        
        .login-container {
            width: 100%;
            max-width: 420px;
            padding: 20px;
        }
        
        .login-card {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
            overflow: hidden;
        }
        
        .login-header {
            background-color: var(--primary-color);
            color: white;
            padding: 25px 30px;
            text-align: center;
        }
        
        .login-header h2 {
            margin: 0;
            font-size: 24px;
            font-weight: 600;
        }
        
        .login-body {
            padding: 30px;
        }
        
        .logo-wrapper {
            text-align: center;
            margin-bottom: 15px;
        }
        
        .logo {
            width: 80px;
            height: 80px;
            margin-bottom: 10px;
        }
        
        .input-group {
            margin-bottom: 20px;
            position: relative;
        }
        
        .input-group i {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            left: 15px;
            color: #6c757d;
        }
        
        .form-control {
            padding: 12px 15px 12px 45px;
            border-radius: 6px;
            border: 1px solid #e2e8f0;
            background-color: #f8fafc;
            font-size: 0.95rem;
        }
        
        .form-control:focus {
            border-color: var(--accent-color);
            box-shadow: 0 0 0 0.2rem rgba(77, 139, 201, 0.25);
        }
        
        .login-button {
            background-color: var(--accent-color);
            border: none;
            border-radius: 6px;
            color: white;
            padding: 12px;
            font-size: 1rem;
            font-weight: 500;
            width: 100%;
            cursor: pointer;
            transition: all 0.2s;
        }
        
        .login-button:hover {
            background-color: var(--secondary-color);
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        
        .form-check-label {
            color: #6b7280;
            font-size: 0.9rem;
        }
        
        .login-footer {
            text-align: center;
            margin-top: 20px;
            color: #6b7280;
            font-size: 0.9rem;
        }
        
        .login-error {
            color: #dc3545;
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
            border-radius: 6px;
            padding: 12px 15px;
            margin-bottom: 20px;
            font-size: 0.9rem;
        }
        
        .register-link {
            color: var(--accent-color);
            text-decoration: none;
            font-weight: 500;
            transition: all 0.2s;
        }
        
        .register-link:hover {
            color: var(--secondary-color);
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <h2>Welcome Back</h2>
            </div>
            <div class="login-body">
                <div class="logo-wrapper">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="logo" onerror="this.src='data:image/svg+xml;utf8,<svg xmlns=\'http:\\www.w3.org/2000/svg\' width=\'80\' height=\'80\' viewBox=\'0 0 80 80\'><rect width=\'80\' height=\'80\' fill=\'%231a3c61\'/><text x=\'50%\' y=\'55%\' font-size=\'20\' text-anchor=\'middle\' fill=\'white\' font-family=\'Arial,sans-serif\'>LOGO</text></svg>'">
                    <h3>Guidance Services</h3>
                </div>
                
                @if($errors->has('login_error'))
                    <div class="login-error">
                        <i class="fas fa-exclamation-circle me-2"></i>{{ $errors->first('login_error') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="input-group">
                        <i class="fas fa-user"></i>
                        <input id="email" type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Enter your ID number">
                        
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="input-group">
                        <i class="fas fa-lock"></i>
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Enter your password">
                        
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label" for="remember">
                                Remember Me
                            </label>
                        </div>
                        
                        @if (Route::has('password.request'))
                            <a class="register-link" href="{{ route('password.request') }}">
                                Forgot Password?
                            </a>
                        @endif
                    </div>

                    <button type="submit" class="login-button">
                        Login
                    </button>
                </form>
            </div>
        </div>
        
       
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>