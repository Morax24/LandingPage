<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - WALUYA LAND</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f8f9fa;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }

        .login-wrapper {
            width: 100%;
            max-width: 400px;
            animation: fadeIn 0.5s ease;
        }

        .login-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .logo-container {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 0.8rem;
            margin-bottom: 1rem;
        }

        .logo-box {
            background: #7cb342;
            color: white;
            padding: 0.6rem 0.8rem;
            font-size: 1.2rem;
            border-radius: 5px;
            font-weight: bold;
        }

        .brand-name {
            font-size: 1.8rem;
            font-weight: bold;
            color: #333;
            letter-spacing: 1px;
        }

        .login-subtitle {
            color: #666;
            font-size: 0.95rem;
        }

        .login-card {
            background: white;
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        }

        /* Session Status */
        .session-status {
            padding: 0.8rem;
            background: #d4f1f4;
            border-radius: 6px;
            margin-bottom: 1.5rem;
            text-align: center;
            font-size: 0.9rem;
            color: #333;
            border-left: 4px solid #7cb342;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            color: #333;
            font-size: 0.9rem;
        }

        /* Password Container */
        .password-container {
            position: relative;
        }

        .form-input {
            width: 100%;
            padding: 0.8rem 1rem;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            background: white;
        }

        .password-input {
            padding-right: 45px;
        }

        .form-input:focus {
            outline: none;
            border-color: #7cb342;
            box-shadow: 0 0 0 3px rgba(124, 179, 66, 0.1);
        }

        .form-input.error {
            border-color: #dc3545;
        }

        /* Eye Icon Button */
        .password-toggle {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            color: #666;
            font-size: 1.2rem;
            padding: 0;
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: color 0.3s ease;
        }

        .password-toggle:hover {
            color: #7cb342;
        }

        .password-toggle:focus {
            outline: none;
            color: #689f38;
        }

        .error-text {
            color: #dc3545;
            font-size: 0.8rem;
            margin-top: 0.3rem;
            display: block;
        }

        .remember-me {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 1.5rem;
        }

        .remember-me input[type="checkbox"] {
            width: 16px;
            height: 16px;
            accent-color: #7cb342;
        }

        .remember-me label {
            font-size: 0.9rem;
            color: #666;
            cursor: pointer;
        }

        .btn-login {
            width: 100%;
            padding: 0.9rem;
            background: linear-gradient(135deg, #7cb342 0%, #689f38 100%);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-bottom: 1rem;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(124, 179, 66, 0.3);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        .login-links {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 1.5rem;
            padding-top: 1rem;
            border-top: 1px solid #eee;
        }

        .login-links a {
            color: #7cb342;
            text-decoration: none;
            font-size: 0.85rem;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .login-links a:hover {
            color: #689f38;
            text-decoration: underline;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @media (max-width: 480px) {
            .login-card {
                padding: 1.5rem;
            }

            .login-links {
                flex-direction: column;
                gap: 0.8rem;
                text-align: center;
            }

            .brand-name {
                font-size: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="login-wrapper">
        <div class="login-header">
            <div class="logo-container">
                <span class="logo-box">■</span>
                <span class="brand-name">WALUYA LAND</span>
            </div>
            <p class="login-subtitle">Masuk ke akun Anda</p>
        </div>

        <div class="login-card">
            <!-- Session Status -->
            @if (session('status'))
                <div class="session-status">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email Address -->
                <div class="form-group">
                    <label for="email" class="form-label">Email</label>
                    <input
                        id="email"
                        class="form-input @error('email') error @enderror"
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        required
                        autofocus
                        autocomplete="email"
                        placeholder="email@contoh.com"
                    >
                    @error('email')
                        <span class="error-text">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Password with Toggle -->
                <div class="form-group">
                    <label for="password" class="form-label">Password</label>
                    <div class="password-container">
                        <input
                            id="password"
                            class="form-input password-input @error('password') error @enderror"
                            type="password"
                            name="password"
                            required
                            autocomplete="current-password"
                            placeholder="••••••••"
                        >
                        <button type="button" class="password-toggle" id="togglePassword">
                            <span id="eyeIcon">👁️</span>
                        </button>
                    </div>
                    @error('password')
                        <span class="error-text">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Remember Me -->
                <div class="remember-me">
                    <input id="remember_me" type="checkbox" name="remember">
                    <label for="remember_me">Ingat saya</label>
                </div>

                <button type="submit" class="btn-login">
                    MASUK
                </button>

                <!-- <div class="login-links">
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}">
                            Lupa password?
                        </a>
                    @endif

                    <a href="{{ route('register') }}">
                        Daftar akun baru
                    </a>
                </div> -->
            </form>
        </div>
    </div>

    <script>
        // Toggle Password Visibility
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');
        const eyeIcon = document.getElementById('eyeIcon');

        togglePassword.addEventListener('click', function() {
            // Toggle the type attribute
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);

            // Toggle the eye icon
            if (type === 'text') {
                eyeIcon.textContent = '👁️‍🗨️'; // Open eye
            } else {
                eyeIcon.textContent = '👁️'; // Closed eye
            }

            // Focus back to password input
            passwordInput.focus();
        });

        // Form validation
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('form');
            const emailInput = document.getElementById('email');

            form.addEventListener('submit', function(e) {
                let isValid = true;

                // Email validation
                if (!emailInput.value.trim()) {
                    showError(emailInput, 'Email harus diisi');
                    isValid = false;
                } else if (!isValidEmail(emailInput.value)) {
                    showError(emailInput, 'Format email tidak valid');
                    isValid = false;
                }

                // Password validation
                if (!passwordInput.value.trim()) {
                    showError(passwordInput, 'Password harus diisi');
                    isValid = false;
                }

                if (!isValid) {
                    e.preventDefault();
                }
            });

            function showError(input, message) {
                input.classList.add('error');
                const errorSpan = input.nextElementSibling;
                if (errorSpan && errorSpan.classList.contains('error-text')) {
                    errorSpan.textContent = message;
                }
            }

            function isValidEmail(email) {
                const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                return re.test(email);
            }
        });
    </script>
</body>
</html>
