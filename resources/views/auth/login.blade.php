<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Pangasinan State University - Login Portal</title>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary: #284277;
            --secondary: #F7CA18;
            --accent: #1C7293;
            --white: #FFFFFF;
            --gray: #EEEEEE;
            --text: #374151;
            --text-light: #6B7280;
            --success: #10B981;
            --warning: #F59E0B;
            --danger: #EF4444;
            --gray-100: #F3F4F6;
            --gray-200: #E5E7EB;
            --gray-300: #D1D5DB;
            --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --shadow-md: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            --shadow-lg: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            min-height: 100vh;
            background-color: var(--white);
            color: var(--text);
            display: flex;
            flex-direction: column;
        }
        
        .header {
            background-color: var(--primary);
            padding: 1rem 2rem;
            box-shadow: var(--shadow);
            display: flex;
            align-items: center;
            justify-content: space-between;
            color: white;
        }
        
        .logo-container {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        
        .logo {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background-color: white;
            padding: 5px;
        }
        
        .university-name {
            font-size: 1.75rem;
            font-weight: 700;
            margin: 0;
        }
        
        .university-name-mobile {
            display: none;
        }
        
        .theme-switch {
            color: white;
            background: none;
            border: none;
            cursor: pointer;
            font-size: 1.25rem;
            transition: all 0.3s ease;
        }
        
        .portal-banner {
            background-color: var(--secondary);
            color: var(--primary);
            text-align: right;
            padding: 0.5rem 2rem;
            font-size: 1.5rem;
            font-weight: 700;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.1);
            background-image: linear-gradient(to right, transparent, rgba(255,255,255,0.3));
        }
        
        .main-content {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            background-color: var(--gray);
            background-size: cover;
            background-position: center;
        }
        
        .login-container {
            width: 100%;
            max-width: 450px;
            background-color: var(--white);
            border-radius: 12px;
            box-shadow: var(--shadow-lg);
            overflow: hidden;
        }
        
        .login-header {
            background-color: var(--primary);
            color: white;
            padding: 1.5rem;
            text-align: center;
            position: relative;
        }
        
        .login-header h1 {
            margin: 0;
            font-size: 1.5rem;
            font-weight: 600;
        }
        
        .login-header p {
            margin: 0.5rem 0 0;
            opacity: 0.9;
            font-size: 0.9rem;
        }
        
        .login-body {
            padding: 2rem;
        }
        
        .form-group {
            margin-bottom: 1.5rem;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: var(--text);
        }
        
        .form-control {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 1px solid var(--gray-300);
            border-radius: 8px;
            font-size: 1rem;
            background-color: var(--white);
            color: var(--text);
            transition: all 0.3s ease;
        }
        
        .form-control:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(40, 66, 119, 0.2);
        }
        
        .form-actions {
            display: flex;
            justify-content: space-between;
            margin-top: 1rem;
            align-items: center;
        }
        
        .form-check {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .form-check-input {
            width: 1rem;
            height: 1rem;
            accent-color: var(--primary);
        }
        
        .form-check-label {
            font-size: 0.9rem;
            color: var(--text-light);
        }
        
        .forgot-password {
            font-size: 0.9rem;
        }
        
        .forgot-password a {
            color: var(--accent);
            text-decoration: none;
            transition: all 0.3s ease;
        }
        
        .forgot-password a:hover {
            text-decoration: underline;
        }
        
        .login-buttons {
            margin-top: 2rem;
            display: flex;
            gap: 1rem;
        }
        
        .btn {
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 1rem;
            border: none;
        }
        
        .btn-primary {
            background-color: var(--primary);
            color: white;
            flex: 2;
        }
        
        .btn-primary:hover {
            background-color: #1d3564;
            transform: translateY(-2px);
            box-shadow: var(--shadow);
        }
        
        .btn-secondary {
            background-color: var(--gray-200);
            color: var(--text);
            flex: 1;
        }
        
        .btn-secondary:hover {
            background-color: var(--gray-300);
        }
        
        .login-helper {
            background-color: #f0f7ff;
            border: 1px solid #d0e3ff;
            border-radius: 8px;
            padding: 0.75rem 1rem;
            margin-bottom: 1.5rem;
            font-size: 0.85rem;
            color: var(--primary);
        }
        
        .login-error {
            background-color: #fde8e8;
            border: 1px solid #f8b4b4;
            border-radius: 8px;
            padding: 0.75rem 1rem;
            margin-bottom: 1.5rem;
            font-size: 0.9rem;
            color: var(--danger);
            display: flex;
            align-items: center;
            animation: shake 0.5s ease;
        }
        
        .login-success {
            background-color: #def7ec;
            border: 1px solid #84e1bc;
            border-radius: 8px;
            padding: 0.75rem 1rem;
            margin-bottom: 1.5rem;
            font-size: 0.9rem;
            color: #03543e;
            display: flex;
            align-items: center;
            animation: fadeIn 0.5s ease;
        }
        
        .login-success i {
            margin-right: 0.5rem;
            color: #057a55;
        }
        
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); }
            20%, 40%, 60%, 80% { transform: translateX(5px); }
        }
        
        .login-error i,
        .login-helper i {
            margin-right: 0.5rem;
        }
        
        .footer {
            background-color: var(--primary);
            color: white;
            text-align: center;
            padding: 1rem;
            font-size: 0.85rem;
        }
        
        .footer a {
            color: var(--secondary);
            text-decoration: none;
            margin: 0 0.5rem;
            transition: all 0.3s ease;
        }
        
        .footer a:hover {
            text-decoration: underline;
        }
        
        /* Animations */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .animate {
            animation: fadeIn 0.5s ease forwards;
        }
        
        /* Responsive styles */
        @media (max-width: 768px) {
            .header {
                padding: 1rem;
            }
            
            .university-name {
                display: none;
            }
            
            .university-name-mobile {
                display: block;
                font-size: 1.25rem;
                font-weight: 700;
                margin: 0;
            }
            
            .logo {
                width: 60px;
                height: 60px;
            }
            
            .portal-banner {
                font-size: 1.25rem;
                padding: 0.5rem 1rem;
            }
            
            .main-content {
                padding: 1rem;
            }
            
            .login-container {
                max-width: 100%;
            }
            
            .login-body {
                padding: 1.5rem;
            }
            
            .login-buttons {
                flex-direction: column;
            }
            
            .btn-primary, .btn-secondary {
                flex: auto;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="logo-container">
            <img src="{{ asset('storage/images/psu logo.png') }}" alt="PSU Logo" class="logo" onerror="this.src='data:image/svg+xml;utf8,<svg xmlns=\'http://www.w3.org/2000/svg\' width=\'80\' height=\'80\' viewBox=\'0 0 80 80\'><rect width=\'80\' height=\'80\' fill=\'%23284277\'/><text x=\'50%\' y=\'55%\' font-size=\'14\' text-anchor=\'middle\' fill=\'white\' font-family=\'Arial,sans-serif\'>PSU LOGO</text></svg>'">
            <div>
                <h1 class="university-name">PANGASINAN STATE UNIVERSITY</h1>
                <h1 class="university-name-mobile">PSU</h1>
            </div>
        </div>
    </div>
    
    <div class="portal-banner">
        PSU-SC GUIDANCE
    </div>
    
    <div class="main-content">
        <div class="login-container animate">
            <div class="login-header">
                <h1>Login to PSU Guidance</h1>
                <p>Enter your credentials to access the system</p>
            </div>
            
            <div class="login-body">
                <div class="login-helper">
                    <i class="fas fa-info-circle"></i>
                    Email: SNCA (admin), FAC-SC (faculty), 22-SC-0000 (student)
                </div>
                
                @if(session('status'))
                    <div class="login-success">
                        <i class="fas fa-check-circle"></i>
                        {{ session('status') }}
                    </div>
                @endif
                
                @if($errors->has('login_error'))
                    <div class="login-error">
                        <i class="fas fa-exclamation-circle"></i>
                        {{ $errors->first('login_error') }}
                    </div>
                @endif
                
                <form action="{{ route('login') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="login_id">User Name:</label>
                        <input type="text" class="form-control @error('email') is-invalid @enderror" id="login_id" name="email" value="{{ old('email') }}" placeholder="Enter your ID" required>
                        @error('email')
                            <div class="login-error mt-2">
                                <i class="fas fa-exclamation-circle"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="password">Password:</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="Enter your password" required>
                        @error('password')
                            <div class="login-error mt-2">
                                <i class="fas fa-exclamation-circle"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    
                    <div class="form-actions">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label" for="remember">Remember me</label>
                        </div>
                        
                        @if (Route::has('password.request'))
                        <div class="forgot-password">
                            <a href="{{ route('password.request') }}">Forgot Password?</a>
                        </div>
                        @endif
                    </div>
                    
                    <div class="login-buttons">
                        <button type="submit" class="btn btn-primary">Login</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="footer">
        <p>All rights reserved. PANGASINAN STATE UNIVERSITY © 2025 | <a href="/policy">POLICY</a> | <a href="/help">HELP</a></p>
    </div>
</body>
</html>