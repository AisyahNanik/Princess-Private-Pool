<!DOCTYPE html>
<html>
<head>
    <title>Swimming Pool - Admin</title>
    @viteReactRefresh
    @vite('resources/css/app.css', ['https://princess-private-pool-aisyahnanik95-gmailcoms-projects.vercel.app'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        html, body {
            height: 100%;
            margin: 0;
        }
        body {
            font-family: 'Arial', sans-serif;
            font-size: 20px; 
            line-height: 1.6;
            background: linear-gradient(135deg, #FFB6C1, #87CEFA, #FFFFFF);
            background-size: 400% 400%;
            animation: gradientAnimation 8s ease infinite;
            position: relative;
            overflow-x: hidden;
            color: #333;
        }
        @keyframes gradientAnimation {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        nav {
            background-color: rgba(255, 255, 255, 0.8);
            padding: 15px 20px;
            display: flex;
            align-items: center;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 0;
            z-index: 100;
        }
        nav .logo {
            margin-right: 20px;
        }
        nav .logo img {
            height: auto;
            max-height: 100px; /* Logo diperbesar */
            width: auto;
        }
        nav .links {
            flex-grow: 1;
            text-align: left;
        }
        nav .links a {
            font-size: 1.3rem;
            color: #007BFF;
            text-decoration: none;
            padding: 10px 20px;
            margin-right: 10px;
            border-radius: 5px;
            transition: background-color 0.3s ease, color 0.3s ease;
            display: inline-block;
        }
        nav .links a i {
            margin-right: 8px;
        }
        nav .links a:hover {
            background-color: #007BFF;
            color: white;
        }
        .container {
            padding-top: 70px;
            text-align: center;
        }
        .pool-list-title {
            font-size: 4rem;
            font-weight: bold;
            margin-bottom: 3rem;
            color: #2c3e50;
        }
        .pool-card-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
        }
        .pool-card {
            width: 300px;
            border-radius: 12px;
            box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
            background-color: #f8f9fa;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .pool-card img {
            border-top-left-radius: 12px;
            border-top-right-radius: 12px;
            object-fit: cover;
            height: 200px;
            width: 100%;
        }
        .pool-card-body {
            padding: 20px;
        }
        .pool-card-title {
            font-size: 2rem;
            font-weight: bold;
            color: #3498db;
        }
        .pool-card-text {
            font-size: 1.3rem;
            color: #555;
            margin-bottom: 15px;
        }
        .pool-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
        }
        #logout-form {
            display: none;
        }
    </style>
</head>
<body>
    <nav>
        <div class="logo">
            <a href="{{ url('/') }}">
                <img src="{{ asset('images/logo.png') }}" alt="{{ config('app.name') }} Logo">
            </a>
        </div>
        <div class="links">
            <a href="{{ route('admin.dashboard') }}"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
            <a href="{{ route('admin.swimmingpools.index') }}"><i class="fas fa-swimming-pool"></i> Swimming Pools</a>
            <a href="{{ route('admin.allotments.index') }}"><i class="fas fa-ticket-alt"></i> Allotments</a>
            <a href="{{ route('admin.bookings.index') }}"><i class="far fa-calendar-check"></i> Bookings</a>
            <a href="{{ route('admin.payments.index') }}"><i class="fas fa-money-bill-wave"></i> Payments</a>
            <a href="#" onclick="confirmLogout(event)"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </div>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
            @csrf
        </form>
    </nav>

    <div class="container mt-4">
        @yield('content')
    </div>

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
