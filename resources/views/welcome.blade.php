<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Welcome to Princess Private Pools</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gradient-to-br from-pink-300 via-blue-300 to-white min-h-screen flex flex-col items-center justify-center text-gray-800 p-6">
    <div class="relative min-h-screen flex flex-col items-center justify-center selection:bg-pink-300 selection:text-white w-full">
        <div class="relative w-full max-w-7xl px-6 lg:px-8">
            <header class="flex justify-between items-center py-10">
                <div class="flex-shrink-0">
                    {{-- Replace with your own logo or brand name --}}
                    <h1 class="text-4xl font-extrabold text-white drop-shadow-md">Princess Pools</h1>
                </div>

                @if (Route::has('login'))
                    <nav class="-mx-3 flex flex-1 justify-end">
                        @auth
                            <a
                                href="{{ url('/dashboard') }}"
                                class="rounded-md px-3 py-2 text-white ring-1 ring-transparent transition hover:text-pink-100 focus:outline-none focus-visible:ring-pink-500 dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                            >
                                Dashboard
                            </a>
                        @else
                            <a
                                href="{{ route('login') }}"
                                class="rounded-md px-3 py-2 text-white ring-1 ring-transparent transition hover:text-pink-100 focus:outline-none focus-visible:ring-pink-500 dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                            >
                                Log in
                            </a>

                            @if (Route::has('register'))
                                <a
                                    href="{{ route('register') }}"
                                    class="rounded-md px-3 py-2 text-white ring-1 ring-transparent transition hover:text-pink-100 focus:outline-none focus-visible:ring-pink-500 dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                                >
                                    Register
                                </a>
                            @endif
                        @endauth
                    </nav>
                @endif
            </header>

            <main class="mt-12">
                <h2 class="text-5xl font-extrabold text-white mb-16 text-center drop-shadow-lg">Discover Our Luxurious Private Pools</h2>

                {{-- Add Button for Admin Only --}}
                @if(Auth::check() && auth()->user()->role === 'admin')
                    <div class="mb-14 text-center">
                        <a href="{{ route('customer.swimmingpools.create') }}" class="inline-flex items-center px-8 py-4 border border-transparent text-xl font-semibold rounded-full shadow-lg text-white bg-pink-600 hover:bg-pink-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pink-500 transition duration-300 ease-in-out transform hover:scale-105">
                            <svg class="-ml-1 mr-3 h-7 w-7" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                            </svg>
                            Add New Private Pool
                        </a>
                    </div>
                @endif

                {{-- Display list of swimming pools --}}
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-12 justify-items-center">
                    @if(isset($swimmingpools) && $swimmingpools->isNotEmpty())
                        @foreach($swimmingpools as $swimmingpool)
                            <div class="bg-white rounded-2xl shadow-2xl overflow-hidden transform transition duration-500 hover:scale-105 hover:shadow-3xl max-w-sm w-full border-4 border-pink-200">
                                <img src="{{ Storage::url($swimmingpool->image) }}" alt="{{ $swimmingpool->name }}" class="w-full h-64 object-cover object-center rounded-t-xl">
                                <div class="p-8">
                                    <h3 class="text-4xl font-extrabold text-blue-700 mb-4">{{ $swimmingpool->name }}</h3>
                                    <p class="text-gray-700 text-lg leading-relaxed mb-8">{{ $swimmingpool->description }}</p>
                                    <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
                                        @if(Auth::check() && auth()->user()->role === 'admin')
                                            <a href="{{ route('customer.swimmingpools.show', $swimmingpool->id) }}" class="flex-1 w-full text-center px-6 py-3 border border-transparent text-base font-medium rounded-lg shadow-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-200">
                                                View
                                            </a>
                                            <a href="{{ route('customer.swimmingpools.edit', $swimmingpool->id) }}" class="flex-1 w-full text-center px-6 py-3 border border-transparent text-base font-medium rounded-lg shadow-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition duration-200">
                                                Edit
                                            </a>
                                            <form action="{{ route('customer.swimmingpools.destroy', $swimmingpool->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this pool?');" class="flex-1 w-full">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="w-full px-6 py-3 border border-transparent text-base font-medium rounded-lg shadow-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition duration-200">
                                                    Delete
                                                </button>
                                            </form>
                                        @elseif(Auth::check() && auth()->user()->role === 'customer')
                                            <a href="{{ route('customer.swimmingpools.show', $swimmingpool->id) }}" class="flex-1 w-full text-center px-6 py-3 border border-transparent text-base font-medium rounded-lg shadow-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-200">
                                                View Details
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <p class="text-3xl text-white font-semibold col-span-full mt-10">No private pools are listed right now. Check back soon for new additions!</p>
                    @endif
                </div>
            </main>

            <footer class="py-16 text-center text-sm text-white/80">
                Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})
            </footer>
        </div>
    </div>
</body>
</html>