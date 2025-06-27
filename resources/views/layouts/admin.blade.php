<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Swimming Pool</title>

    @vite('resources/css/app.css')
    @viteReactRefresh

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" 
        integrity="sha512-..." crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body class="bg-gradient-to-tr from-pink-200 via-blue-200 to-white min-h-screen text-gray-800">

    <!-- Navbar -->
    <nav class="bg-white/90 backdrop-blur shadow-md sticky top-0 z-50 px-6 py-4 flex items-center justify-between">
        <div class="flex items-center space-x-4">
            <a href="{{ url('/') }}">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-14 w-auto" onerror="this.src='https://via.placeholder.com/100x80?text=Logo';">
            </a>
            <span class="text-xl font-bold text-blue-700">Admin Dashboard</span>
        </div>
        <div class="space-x-4">
            <a href="{{ route('admin.dashboard') }}" class="text-blue-600 hover:bg-blue-600 hover:text-white px-3 py-2 rounded transition"><i class="fas fa-tachometer-alt mr-1"></i> Dashboard</a>
            <a href="{{ route('admin.swimmingpools.index') }}" class="text-blue-600 hover:bg-blue-600 hover:text-white px-3 py-2 rounded transition"><i class="fas fa-swimming-pool mr-1"></i> Pools</a>
            <a href="{{ route('admin.allotments.index') }}" class="text-blue-600 hover:bg-blue-600 hover:text-white px-3 py-2 rounded transition"><i class="fas fa-ticket-alt mr-1"></i> Allotments</a>
            <a href="{{ route('admin.bookings.index') }}" class="text-blue-600 hover:bg-blue-600 hover:text-white px-3 py-2 rounded transition"><i class="far fa-calendar-check mr-1"></i> Bookings</a>
            <a href="{{ route('admin.payments.index') }}" class="text-blue-600 hover:bg-blue-600 hover:text-white px-3 py-2 rounded transition"><i class="fas fa-money-bill-wave mr-1"></i> Payments</a>
            <a href="#" onclick="confirmLogout(event)" class="text-red-600 hover:bg-red-600 hover:text-white px-3 py-2 rounded transition"><i class="fas fa-sign-out-alt mr-1"></i> Logout</a>
        </div>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
            @csrf
        </form>
    </nav>

    <!-- Main Content -->
    <main class="p-8">
        @yield('content')
    </main>

    <script>
        function confirmLogout(event) {
            event.preventDefault();
            if (confirm("Yakin ingin logout?")) {
                document.getElementById('logout-form').submit();
            }
        }
    </script>

</body>
</html>
