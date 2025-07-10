@extends('layouts.customer')

@section('title', 'Customer Dashboard')

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Welcome Header -->
    <div class="text-center mb-10">
        <h1 class="text-4xl font-bold text-gray-800 mb-3">
            Welcome, {{ auth()->user()->name }} <span class="text-pink-500">🌸</span>
        </h1>
        <p class="text-xl text-gray-600 font-medium">Princess Private Pools - Customer Portal</p>
    </div>

    <!-- Quick Access Buttons -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-12">
        <a href="{{ route('customer.bookings.index') }}" class="bg-white p-6 rounded-xl shadow-md hover:shadow-lg transition-all transform hover:-translate-y-1 text-center border-l-4 border-purple-500">
            <div class="text-purple-500 mb-4">
                <i class="far fa-calendar-check text-3xl"></i>
            </div>
            <h3 class="font-bold text-xl text-gray-800 mb-2">My Bookings</h3>
            <p class="text-lg text-gray-600">View all your reservations</p>
        </a>
        
        <a href="{{ route('customer.payments.index') }}" class="bg-white p-6 rounded-xl shadow-md hover:shadow-lg transition-all transform hover:-translate-y-1 text-center border-l-4 border-green-500">
            <div class="text-green-500 mb-4">
                <i class="fas fa-receipt text-3xl"></i>
            </div>
            <h3 class="font-bold text-xl text-gray-800 mb-2">My Payments</h3>
            <p class="text-lg text-gray-600">View payment history</p>
        </a>
    </div>

    <!-- Recent Bookings -->
    <div class="bg-white rounded-xl shadow-md overflow-hidden mb-8">
        <div class="bg-gradient-to-r from-blue-50 to-purple-50 px-6 py-5 border-b">
            <h3 class="font-bold text-xl text-gray-800">
                <i class="far fa-calendar-check text-purple-500 mr-3 text-2xl"></i>
                Recent Bookings
            </h3>
        </div>
        <div class="p-6">
            @if($bookings->isEmpty())
                <div class="text-center py-10 text-gray-500">
                    <i class="far fa-calendar-times text-4xl mb-4 text-purple-500"></i>
                    <p class="text-xl">No bookings yet</p>
                    <a href="{{ route('customer.bookings.create') }}" class="mt-4 inline-block px-6 py-2 bg-purple-500 text-white rounded-lg hover:bg-purple-600 transition">
                        Make Your First Booking
                    </a>
                </div>
            @else
                <ul class="divide-y divide-gray-200">
                    @foreach ($bookings as $booking)
                        <li class="py-5 flex justify-between items-center hover:bg-gray-50 px-4 rounded-lg transition">
                            <div>
                                <p class="font-semibold text-lg text-gray-800">{{ $booking->swimmingpool->name }}</p>
                                <p class="text-base text-gray-600 mt-1">
                                    {{ $booking->total_person }} people • 
                                    {{ $booking->created_at->format('d M Y') }}
                                </p>
                            </div>
                            <a href="{{ route('customer.bookings.show', $booking->id) }}" 
                               class="text-lg bg-purple-50 text-purple-600 px-4 py-2 rounded-lg hover:bg-purple-100 transition font-medium">
                                View
                            </a>
                        </li>
                    @endforeach
                </ul>
                <div class="mt-4 text-center">
                    <a href="{{ route('customer.bookings.index') }}" class="text-purple-600 hover:text-purple-800 font-medium">
                        View All Bookings <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>
            @endif
        </div>
    </div>

    <!-- Recent Payments -->
    <div class="bg-white rounded-xl shadow-md overflow-hidden">
        <div class="bg-gradient-to-r from-blue-50 to-green-50 px-6 py-5 border-b">
            <h3 class="font-bold text-xl text-gray-800">
                <i class="fas fa-receipt text-green-500 mr-3 text-2xl"></i>
                Recent Payments
            </h3>
        </div>
        <div class="p-6">
            @if($payments->isEmpty())
                <div class="text-center py-10 text-gray-500">
                    <i class="fas fa-money-bill-wave text-4xl mb-4 text-green-500"></i>
                    <p class="text-xl">No payments yet</p>
                </div>
            @else
                <ul class="divide-y divide-gray-200">
                    @foreach ($payments as $payment)
                        <li class="py-5 flex justify-between items-center hover:bg-gray-50 px-4 rounded-lg transition">
                            <div>
                                <p class="font-semibold text-lg text-gray-800">Payment #{{ $payment->id }}</p>
                                <p class="text-base text-gray-600 mt-1">
                                    Rp{{ number_format($payment->total_payments, 0, ',', '.') }} • 
                                    {{ $payment->created_at->format('d M Y') }}
                                </p>
                            </div>
                            <a href="{{ route('customer.payments.show', $payment->id) }}" 
                               class="text-lg bg-green-50 text-green-600 px-4 py-2 rounded-lg hover:bg-green-100 transition font-medium">
                                View
                            </a>
                        </li>
                    @endforeach
                </ul>
                <div class="mt-4 text-center">
                    <a href="{{ route('customer.payments.index') }}" class="text-green-600 hover:text-green-800 font-medium">
                        View All Payments <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection