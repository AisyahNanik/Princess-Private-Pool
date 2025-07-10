<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Welcome to Princess Private Pools</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Playfair+Display:700|Open+Sans:400,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
        integrity="sha512-..." crossorigin="anonymous" referrerpolicy="no-referrer" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Open Sans', sans-serif;
            color: #4A5568; /* Darker gray for better readability */
        }
        h1, h2, h3 {
            font-family: 'Playfair Display', serif;
        }
        .nav-link {
            transition: all 0.3s ease-in-out;
            position: relative;
            overflow: hidden;
            border-radius: 9999px; /* Pill shape */
        }
        .nav-link::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(to right, rgba(255,255,255,0) 0%, rgba(255,255,255,0.3) 50%, rgba(255,255,255,0) 100%);
            transition: all 0.4s ease-in-out;
            z-index: 1;
        }
        .nav-link:hover::before {
            left: 100%;
        }
        .nav-link span {
            position: relative;
            z-index: 2;
        }
        .nav-icon {
            width: 20px;
            text-align: center;
            margin-right: 8px;
        }
        .card-button {
            border-radius: 9999px; /* Pill shape for buttons too */
            transition: all 0.3s ease;
        }
        .card-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body class="bg-gradient-to-br from-purple-100 via-pink-100 to-blue-100 min-h-screen text-gray-700 flex flex-col">

    <nav class="bg-white/90 backdrop-blur-md shadow-lg sticky top-0 z-50 px-8 py-4 flex items-center justify-between border-b border-purple-200">
        <div class="flex items-center space-x-5">
            <a href="{{ url('/') }}">
                {{-- Replace with your elegant logo --}}
                <img src="{{ asset('images/princess-logo.png') }}" alt="Princess Pools Logo" class="h-12 w-auto filter drop-shadow-md" onerror="this.src='https://via.placeholder.com/100x60?text=Princess+Pools';">
            </a>
            <span class="text-3xl font-bold bg-gradient-to-r from-purple-600 to-pink-500 bg-clip-text text-transparent tracking-wide">Princess Private Pools</span>
        </div>
        <div class="flex items-center space-x-3">
            @if (Route::has('login'))
                @auth
                    @if(auth()->user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="nav-link px-4 py-2 text-purple-700 hover:bg-purple-100 transition-colors duration-200">
                            <i class="fas fa-tachometer-alt text-purple-500 nav-icon"></i> <span>Dashboard</span>
                        </a>
                        <a href="{{ route('admin.swimmingpools.index') }}" class="nav-link px-4 py-2 text-pink-700 hover:bg-pink-100 transition-colors duration-200">
                            <i class="fas fa-swimming-pool text-pink-500 nav-icon"></i> <span>Pools</span>
                        </a>
                        <a href="{{ route('admin.allotments.index') }}" class="nav-link px-4 py-2 text-red-700 hover:bg-red-100 transition-colors duration-200">
                            <i class="fas fa-ticket-alt text-red-500 nav-icon"></i> <span>Allotments</span>
                        </a>
                        <a href="{{ route('admin.bookings.index') }}" class="nav-link px-4 py-2 text-blue-700 hover:bg-blue-100 transition-colors duration-200">
                            <i class="far fa-calendar-check text-blue-500 nav-icon"></i> <span>Bookings</span>
                        </a>
                        <a href="{{ route('admin.payments.index') }}" class="nav-link px-4 py-2 text-green-700 hover:bg-green-100 transition-colors duration-200">
                            <i class="fas fa-money-bill-wave text-green-500 nav-icon"></i> <span>Payments</span>
                        </a>
                    @else {{-- Customer User --}}
                        <a href="{{ url('/dashboard') }}" class="nav-link px-4 py-2 text-purple-700 hover:bg-purple-100 transition-colors duration-200">
                            <i class="fas fa-tachometer-alt text-purple-500 nav-icon"></i> <span>My Dashboard</span>
                        </a>
                    @endif
                    <a href="#" onclick="confirmLogout(event)" class="nav-link text-white bg-gradient-to-r from-pink-500 to-purple-600 hover:from-pink-600 hover:to-purple-700 px-5 py-2.5 rounded-full shadow-md transition-all duration-300 transform hover:scale-105">
                        <i class="fas fa-sign-out-alt nav-icon"></i> <span>Logout</span>
                    </a>
                @else
                    <a href="{{ route('login') }}" class="nav-link px-4 py-2 text-purple-700 hover:bg-purple-100 transition-colors duration-200">
                        <span>Log in</span>
                    </a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="nav-link px-4 py-2 text-pink-700 hover:bg-pink-100 transition-colors duration-200">
                            <span>Register</span>
                        </a>
                    @endif
                @endauth
            @endif
        </div>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
            @csrf
        </form>
    </nav>

    <main class="flex-grow p-8 md:p-12">
        <div class="bg-white/70 backdrop-blur-sm rounded-3xl shadow-xl p-8 lg:p-12 border-4 border-white transform transition-all duration-500 ease-in-out hover:shadow-2xl hover:scale-[1.01]">
            <h2 class="text-5xl lg:text-6xl font-extrabold text-center mb-12 bg-gradient-to-r from-purple-700 to-pink-600 bg-clip-text text-transparent drop-shadow-lg leading-tight">
                Discover Our Exquisite Private Retreats
            </h2>

            {{-- Add Button for Admin Only --}}
            @if(Auth::check() && auth()->user()->role === 'admin')
                <div class="mb-14 text-center">
                    <a href="{{ route('admin.swimmingpools.create') }}" class="inline-flex items-center px-10 py-5 border border-transparent text-xl font-semibold rounded-full shadow-lg text-white bg-gradient-to-r from-purple-500 to-pink-600 hover:from-purple-600 hover:to-pink-700 focus:outline-none focus:ring-4 focus:ring-offset-2 focus:ring-purple-400 transition duration-300 ease-in-out transform hover:scale-105 card-button">
                        <svg class="-ml-1 mr-3 h-8 w-8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                        </svg>
                        Add New Private Oasis
                    </a>
                </div>
            @endif

            {{-- Display list of swimming pools --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-10 justify-items-center">
                @if(isset($swimmingpools) && $swimmingpools->isNotEmpty())
                    @foreach($swimmingpools as $swimmingpool)
                        <div class="bg-white rounded-3xl shadow-2xl overflow-hidden transform transition duration-500 hover:scale-105 hover:shadow-3xl max-w-sm w-full border-4 border-purple-200">
                            <div class="relative">
                                <img src="{{ Storage::url($swimmingpool->image) }}" alt="{{ $swimmingpool->name }}" class="w-full h-72 object-cover object-center rounded-t-2xl">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent rounded-t-2xl flex items-end p-6">
                                    <h3 class="text-3xl font-bold text-white drop-shadow-lg leading-tight">{{ $swimmingpool->name }}</h3>
                                </div>
                            </div>
                            <div class="p-8">
                                <p class="text-gray-600 text-base leading-relaxed mb-8 line-clamp-3">{{ $swimmingpool->description }}</p>
                                <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
                                    @if(Auth::check() && auth()->user()->role === 'admin')
                                        <a href="{{ route('admin.swimmingpools.show', $swimmingpool->id) }}" class="flex-1 w-full text-center px-6 py-3 text-base font-medium rounded-full shadow-md text-white bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-400 card-button">
                                            View
                                        </a>
                                        <a href="{{ route('admin.swimmingpools.edit', $swimmingpool->id) }}" class="flex-1 w-full text-center px-6 py-3 text-base font-medium rounded-full shadow-md text-white bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-400 card-button">
                                            Edit
                                        </a>
                                        <form action="{{ route('admin.swimmingpools.destroy', $swimmingpool->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this exquisite pool?');" class="flex-1 w-full">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="w-full px-6 py-3 text-base font-medium rounded-full shadow-md text-white bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-400 card-button">
                                                Delete
                                            </button>
                                        </form>
                                    @elseif(Auth::check() && auth()->user()->role === 'customer')
                                        <a href="{{ route('customer.swimmingpools.show', $swimmingpool->id) }}" class="flex-1 w-full text-center px-6 py-3 text-base font-medium rounded-full shadow-md text-white bg-gradient-to-r from-purple-500 to-pink-500 hover:from-purple-600 hover:to-pink-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-400 card-button">
                                            View Details
                                        </a>
                                    @else {{-- Guest user --}}
                                         <a href="{{ route('login') }}" class="flex-1 w-full text-center px-6 py-3 text-base font-medium rounded-full shadow-md text-white bg-gradient-to-r from-indigo-500 to-purple-500 hover:from-indigo-600 hover:to-purple-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-400 card-button">
                                            Log in to Explore
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <p class="text-3xl text-gray-500 font-semibold col-span-full mt-10 text-center">No private pools are listed yet. We're preparing something truly special!</p>
                @endif
            </div>
        </div>
    </main>

    <footer class="py-10 text-center text-sm text-gray-500 mt-auto">
        Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})
    </footer>

    <script>
        function confirmLogout(event) {
            event.preventDefault();
            if (confirm("Are you sure you want to gracefully exit your royal session?")) {
                document.getElementById('logout-form').submit();
            }
        }
    </script>

</body>
</html>