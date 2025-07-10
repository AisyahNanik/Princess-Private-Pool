<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Swimming Pool</title>
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .login-container {
            width: 420px;  /* Slightly wider */
            margin: 3rem auto;  /* More top margin */
        }
        .login-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(8px);
            border: 1px solid rgba(255, 255, 255, 0.6);
            box-shadow: 0 4px 20px rgba(228, 181, 187, 0.15);
            border-radius: 12px;
        }
        .form-input {
            background: rgba(255, 255, 255, 0.95);
            border: 1px solid rgba(228, 181, 187, 0.4);
            transition: all 0.3s ease;
        }
        .form-input:focus {
            border-color: #A1C8D9;
            box-shadow: 0 0 0 3px rgba(161, 200, 217, 0.2);
        }
        .btn-login {
            background: linear-gradient(to right, #EC4899, #3B82F6);
            transition: all 0.3s ease;
        }
        .btn-login:hover {
            background: linear-gradient(to right, #DB2777, #2563EB);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.2);
        }
        .text-gradient {
            background-clip: text;
            -webkit-background-clip: text;
            color: transparent;
            background-image: linear-gradient(to right, #EC4899, #3B82F6);
            font-size: 1.75rem;  /* Larger text */
        }
    </style>
</head>
<body class="bg-gradient-to-br from-[#E4B5BB] via-[#A1C8D9] to-white min-h-screen flex items-start pt-16 font-sans"> <!-- Increased padding-top -->

    <div class="login-container">
        <!-- Header - Enlarged -->
        <div class="text-center mb-8">  <!-- Increased margin-bottom -->
            <div class="flex items-center justify-center space-x-4 mb-4">  <!-- Increased spacing -->
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-12" onerror="this.src='https://via.placeholder.com/96x72?text=Logo'">  <!-- Larger logo -->
                <span class="text-2xl font-bold text-gradient">Login</span>  <!-- Larger text -->
            </div>
            <p class="text-base text-gray-600">Access your swimming pool account</p>  <!-- Larger subtitle -->
        </div>

        <!-- Session Status -->
        @if(session('status'))
            <div class="mb-4 text-sm text-green-600">
                {{ session('status') }}
            </div>
        @endif

        <!-- Form Card -->
        <div class="login-card p-6">
            <form method="POST" action="{{ route('login') }}" class="space-y-5">  <!-- Increased spacing -->
                @csrf

                <!-- Email -->
                <div>
                    <label for="email" class="block text-base font-medium text-gray-700 mb-2">  <!-- Larger label -->
                        <i class="fas fa-envelope mr-2 text-gray-500"></i>Email
                    </label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                        class="form-input w-full px-4 py-3 rounded-lg placeholder-gray-400 text-base">  <!-- Larger input -->
                    @error('email')
                        <p class="mt-2 text-sm text-pink-600">{{ $message }}</p>  <!-- Larger error text -->
                    @enderror
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-base font-medium text-gray-700 mb-2">  <!-- Larger label -->
                        <i class="fas fa-lock mr-2 text-gray-500"></i>Password
                    </label>
                    <input id="password" type="password" name="password" required
                        class="form-input w-full px-4 py-3 rounded-lg placeholder-gray-400 text-base">  <!-- Larger input -->
                    @error('password')
                        <p class="mt-2 text-sm text-pink-600">{{ $message }}</p>  <!-- Larger error text -->
                    @enderror
                </div>

                <!-- Remember Me & Forgot Password -->
                <div class="flex items-center justify-between mt-5">  <!-- Increased margin-top -->
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="remember" class="h-4 w-4 rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500">  <!-- Larger checkbox -->
                        <span class="ml-3 text-base text-gray-600">Remember me</span>  <!-- Larger text -->
                    </label>

                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-base text-blue-600 hover:text-blue-500">  <!-- Larger text -->
                            Forgot password?
                        </a>
                    @endif
                </div>

                <!-- Submit Button - Enlarged -->
                <div class="pt-4">  <!-- Increased padding-top -->
                    <button type="submit" class="btn-login w-full py-3 rounded-lg text-white font-medium text-base">  <!-- Larger button -->
                        <i class="fas fa-sign-in-alt mr-3"></i> Log In
                    </button>
                </div>
            </form>

            <!-- Register Link - Enlarged -->
            <div class="text-center mt-6 pt-5 border-t border-gray-200/50">  <!-- Increased spacing -->
                <p class="text-base text-gray-600">  <!-- Larger text -->
                    Don't have an account? 
                    <a href="{{ route('register') }}" class="font-medium text-blue-600 hover:text-blue-500">
                        Register
                    </a>
                </p>
            </div>
        </div>
    </div>

</body>
</html>