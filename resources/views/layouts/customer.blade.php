<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Dashboard - Swimming Pool</title>

    @vite('resources/css/app.css')
    @viteReactRefresh

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" 
        integrity="sha512-..." crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        .nav-link {
            transition: all 0.3s ease;
        }
        .nav-link:hover {
            transform: translateY(-2px);
        }
        .nav-icon {
            width: 20px;
            text-align: center;
            margin-right: 8px;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-[#E4B5BB] via-[#A1C8D9] to-white min-h-screen text-gray-800">

    <!-- Navbar -->
    <nav class="bg-white/90 backdrop-blur-lg shadow-md sticky top-0 z-50 px-6 py-3 flex items-center justify-between border-b border-pink-200">
        <div class="flex items-center space-x-4">
            <a href="{{ url('/') }}">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-10 w-auto" onerror="this.src='https://via.placeholder.com/80x60?text=Logo';">
            </a>
            <span class="text-xl font-bold bg-gradient-to-r from-blue-500 to-green-600 bg-clip-text text-transparent">Customer Dashboard</span>
        </div>
        <div class="flex items-center space-x-2">
            <a href="{{ route('customer.dashboard') }}" class="nav-link text-gray-700 hover:bg-blue-100 hover:text-blue-700 px-3 py-2 rounded-md transition">
                <i class="fas fa-tachometer-alt text-blue-500 nav-icon"></i> Dashboard
            </a>
            <a href="{{ route('customer.bookings.index') }}" class="nav-link text-gray-700 hover:bg-purple-100 hover:text-purple-700 px-3 py-2 rounded-md transition">
                <i class="far fa-calendar-check text-purple-500 nav-icon"></i> My Bookings
            </a>
            <a href="#" onclick="confirmLogout(event)" class="nav-link text-white bg-gradient-to-r from-blue-500 to-blue-600 hover:to-blue-700 px-4 py-2 rounded-md shadow-sm transition">
                <i class="fas fa-sign-out-alt nav-icon"></i> Logout
            </a>
        </div>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
            @csrf
        </form>
    </nav>

    <!-- Main Content -->
    <main class="p-6 md:p-8">
        <div class="bg-white/80 backdrop-blur-sm rounded-xl shadow-lg p-6 border border-white">
            @yield('content')
        </div>
    </main>

    <script>
        function confirmLogout(event) {
            event.preventDefault();
            if (confirm("Are you sure you want to logout?")) {
                document.getElementById('logout-form').submit();
            }
        }
    </script>

</body>
</html>