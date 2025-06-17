<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Princess Private Pools</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gradient-to-br from-pink-300 via-blue-300 to-white min-h-screen flex flex-col items-center justify-center text-gray-800 p-6">
    <div class="container mx-auto px-4 py-8 text-center">
        <h1 class="text-5xl font-extrabold text-gray-900 mb-12 drop-shadow-lg">Princess Private Pools</h1>

        {{-- Add Button for Admin Only --}}
        @if(Auth::check() && auth()->user()->role === 'admin')
            <div class="mb-10">
                <a href="{{ route('customer.swimmingpools.create') }}" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-full shadow-lg text-white bg-pink-600 hover:bg-pink-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pink-500 transition duration-300 ease-in-out transform hover:scale-105">
                    <svg class="-ml-1 mr-3 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                    </svg>
                    Create New Pool
                </a>
            </div>
        @endif

        {{-- Display list of swimming pools --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10 justify-items-center">
            @if(isset($swimmingpools) && $swimmingpools->isNotEmpty())
                @foreach($swimmingpools as $swimmingpool)
                    <div class="bg-white rounded-xl shadow-xl overflow-hidden transform transition duration-500 hover:scale-105 hover:shadow-2xl max-w-sm w-full">
                        <img src="{{ Storage::url($swimmingpool->image) }}" alt="{{ $swimmingpool->name }}" class="w-full h-52 object-cover object-center rounded-t-xl">
                        <div class="p-6">
                            <h2 class="text-3xl font-bold text-blue-600 mb-3">{{ $swimmingpool->name }}</h2>
                            <p class="text-gray-700 text-base leading-relaxed mb-6">{{ $swimmingpool->description }}</p>
                            <div class="flex justify-between items-center">
                                @if(Auth::check() && auth()->user()->role === 'admin')
                                    <a href="{{ route('customer.swimmingpools.show', $swimmingpool->id) }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        View
                                    </a>
                                    {{-- <a href="{{ route('customer.swimmingpools.edit', $swimmingpool->id) }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                        Edit
                                    </a> --}}
                                    {{-- <form action="{{ route('customer.swimmingpools.destroy', $swimmingpool->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this pool?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                            Delete
                                        </button>
                                    </form> --}}
                                @elseif(Auth::check() && auth()->user()->role === 'customer')
                                    <a href="{{ route('customer.swimmingpools.show', $swimmingpool->id) }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                        View Details
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <p class="text-lg text-gray-600 col-span-full">No swimming pools available at the moment. Please check back later!</p>
            @endif
        </div>
    </div>
</body>
</html>