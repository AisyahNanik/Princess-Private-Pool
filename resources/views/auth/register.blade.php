<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Swimming Pool</title>
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .register-container {
            width: 420px;  /* Slightly wider */
            margin: 3rem auto;  /* More top margin */
        }
        .register-card {
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
            font-size: 0.9375rem;  /* Slightly larger base font */
        }
        .form-input:focus {
            border-color: #A1C8D9;
            box-shadow: 0 0 0 3px rgba(161, 200, 217, 0.2);
        }
        .btn-register {
            background: linear-gradient(to right, #EC4899, #3B82F6);
            transition: all 0.3s ease;
            font-size: 1rem;  /* Larger button text */
        }
        .btn-register:hover {
            background: linear-gradient(to right, #DB2777, #2563EB);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.2);
        }
        .text-gradient {
            background-clip: text;
            -webkit-background-clip: text;
            color: transparent;
            background-image: linear-gradient(to right, #EC4899, #3B82F6);
            font-size: 1.75rem;  /* Larger heading */
        }
    </style>
</head>
<body class="bg-gradient-to-br from-[#E4B5BB] via-[#A1C8D9] to-white min-h-screen flex items-start pt-16 font-sans"> <!-- Increased top padding -->

    <div class="register-container">
        <!-- Header - Enlarged -->
        <div class="text-center mb-8">  <!-- Increased margin -->
            <div class="flex items-center justify-center space-x-4 mb-4">  <!-- More spacing -->
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-12" onerror="this.src='https://via.placeholder.com/96x72?text=Logo'">  <!-- Larger logo (50% bigger) -->
                <span class="text-2xl font-bold text-gradient">Register</span>  <!-- Larger text -->
            </div>
            <p class="text-base text-gray-600">Create your swimming pool account</p>  <!-- Larger subtitle -->
        </div>

        <!-- Form Card -->
        <div class="register-card p-6">
            <form method="POST" action="{{ route('register') }}" class="space-y-5">  <!-- More spacing -->
                @csrf

                <!-- Name -->
                <div>
                    <label for="name" class="block text-base font-medium text-gray-700 mb-2">  <!-- Larger label -->
                        <i class="fas fa-user mr-2 text-gray-500"></i>Full Name
                    </label>
                    <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
                        class="form-input w-full px-4 py-3 rounded-lg placeholder-gray-400">  <!-- Taller input -->
                    @error('name')
                        <p class="mt-2 text-sm text-pink-600">{{ $message }}</p>  <!-- Larger error text -->
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-base font-medium text-gray-700 mb-2">  <!-- Larger label -->
                        <i class="fas fa-envelope mr-2 text-gray-500"></i>Email
                    </label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required
                        class="form-input w-full px-4 py-3 rounded-lg placeholder-gray-400">  <!-- Taller input -->
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
                        class="form-input w-full px-4 py-3 rounded-lg placeholder-gray-400">  <!-- Taller input -->
                    @error('password')
                        <p class="mt-2 text-sm text-pink-600">{{ $message }}</p>  <!-- Larger error text -->
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div>
                    <label for="password_confirmation" class="block text-base font-medium text-gray-700 mb-2">  <!-- Larger label -->
                        <i class="fas fa-lock mr-2 text-gray-500"></i>Confirm Password
                    </label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required
                        class="form-input w-full px-4 py-3 rounded-lg placeholder-gray-400">  <!-- Taller input -->
                </div>

                <!-- Submit Button - Enlarged -->
                <div class="pt-4">  <!-- More padding -->
                    <button type="submit" class="btn-register w-full py-3 rounded-lg text-white font-medium">
                        <i class="fas fa-user-plus mr-3"></i> Register  <!-- Larger icon margin -->
                    </button>
                </div>
            </form>

            <!-- Login Link - Enlarged -->
            <div class="text-center mt-6 pt-5 border-t border-gray-200/50">  <!-- More spacing -->
                <p class="text-base text-gray-600">  <!-- Larger text -->
                    Already have an account? 
                    <a href="{{ route('login') }}" class="font-medium text-blue-600 hover:text-blue-500 transition-colors">
                        Sign In
                    </a>
                </p>
            </div>
        </div>

        <!-- Error Messages - Enlarged -->
        @if ($errors->any())
            <div class="mt-6 bg-pink-50/90 rounded-lg p-4">  <!-- More margin -->
                <div class="flex items-start">
                    <i class="fas fa-exclamation-circle text-pink-500 text-lg mr-3 mt-0.5"></i>  <!-- Larger icon -->
                    <div>
                        <h3 class="text-base font-medium text-pink-800 mb-2">Please fix these errors:</h3>  <!-- Larger text -->
                        <ul class="text-sm text-pink-700 space-y-1.5">  <!-- Larger text -->
                            @foreach ($errors->all() as $error)
                                <li class="flex items-start">
                                    <i class="fas fa-circle text-[6px] mt-2 mr-2"></i>
                                    <span>{{ $error }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif
    </div>

</body>
</html>