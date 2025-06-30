@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Dashboard Header -->
    <div class="text-center mb-10">
        <h1 class="text-4xl font-bold text-gray-800 mb-3">
            <i class="fas fa-tachometer-alt text-pink-500 mr-4"></i>
            <span class="bg-gradient-to-r from-pink-500 to-blue-600 bg-clip-text text-transparent">Admin Dashboard</span>
        </h1>
        <p class="text-xl text-gray-600 font-medium">Princess Private Pools Management System</p>
    </div>

    <!-- Quick Access Buttons -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mb-12">
        <a href="{{ route('admin.swimmingpools.index') }}" class="bg-white p-6 rounded-xl shadow-md hover:shadow-lg transition-all transform hover:-translate-y-1 text-center border-l-4 border-blue-500">
            <div class="text-blue-500 mb-4">
                <i class="fas fa-swimming-pool text-3xl"></i>
            </div>
            <h3 class="font-bold text-xl text-gray-800 mb-2">Swimming Pools</h3>
            <p class="text-lg text-gray-600">Manage pools</p>
        </a>
        
        <a href="{{ route('admin.allotments.index') }}" class="bg-white p-6 rounded-xl shadow-md hover:shadow-lg transition-all transform hover:-translate-y-1 text-center border-l-4 border-red-500">
            <div class="text-red-500 mb-4">
                <i class="fas fa-th-large text-3xl"></i>
            </div>
            <h3 class="font-bold text-xl text-gray-800 mb-2">Allotments</h3>
            <p class="text-lg text-gray-600">Manage schedules</p>
        </a>
        
        <a href="{{ route('admin.bookings.index') }}" class="bg-white p-6 rounded-xl shadow-md hover:shadow-lg transition-all transform hover:-translate-y-1 text-center border-l-4 border-yellow-500">
            <div class="text-yellow-500 mb-4">
                <i class="far fa-calendar-check text-3xl"></i>
            </div>
            <h3 class="font-bold text-xl text-gray-800 mb-2">Bookings</h3>
            <p class="text-lg text-gray-600">View reservations</p>
        </a>
        
        <a href="{{ route('admin.payments.index') }}" class="bg-white p-6 rounded-xl shadow-md hover:shadow-lg transition-all transform hover:-translate-y-1 text-center border-l-4 border-green-500">
            <div class="text-green-500 mb-4">
                <i class="fas fa-money-bill-wave text-3xl"></i>
            </div>
            <h3 class="font-bold text-xl text-gray-800 mb-2">Payments</h3>
            <p class="text-lg text-gray-600">Track transactions</p>
        </a>
    </div>

    <!-- Booking Chart -->
    <div class="bg-white rounded-xl shadow-md p-8 mb-12">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800 mb-3 md:mb-0">
                <i class="fas fa-chart-bar text-pink-500 mr-3"></i>
                Monthly Booking Statistics
            </h2>
            <select class="bg-gray-100 border-0 rounded-lg px-4 py-2 text-lg focus:ring-2 focus:ring-pink-500 w-full md:w-auto">
                <option>Last 6 Months</option>
                <option>This Year</option>
                <option>Last Year</option>
            </select>
        </div>
        <div class="h-96">
            <canvas id="bookingsChart" height="400"></canvas>
        </div>
    </div>

    <!-- Data Overview -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Swimming Pools -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <div class="bg-gradient-to-r from-pink-50 to-blue-50 px-6 py-5 border-b">
                <h3 class="font-bold text-xl text-gray-800">
                    <i class="fas fa-water text-blue-500 mr-3 text-2xl"></i>
                    Swimming Pools
                </h3>
            </div>
            <div class="p-6">
                @if($swimmingpools->isEmpty())
                    <div class="text-center py-10 text-gray-500">
                        <i class="fas fa-swimming-pool text-4xl mb-4 text-blue-500"></i>
                        <p class="text-xl">No swimming pools data available</p>
                    </div>
                @else
                    <ul class="divide-y divide-gray-200">
                        @foreach ($swimmingpools as $swimmingpool)
                            <li class="py-5 flex justify-between items-center hover:bg-gray-50 px-4 rounded-lg transition">
                                <div>
                                    <p class="font-semibold text-lg text-gray-800">{{ $swimmingpool->name }}</p>
                                    <p class="text-base text-gray-600 mt-1">{{ $swimmingpool->location }}</p>
                                </div>
                                <a href="{{ route('admin.swimmingpools.show', $swimmingpool->id) }}" 
                                   class="text-lg bg-blue-50 text-blue-600 px-4 py-2 rounded-lg hover:bg-blue-100 transition font-medium">
                                    View
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>

        <!-- Allotments -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <div class="bg-gradient-to-r from-pink-50 to-blue-50 px-6 py-5 border-b">
                <h3 class="font-bold text-xl text-gray-800">
                    <i class="fas fa-calendar-alt text-red-500 mr-3 text-2xl"></i>
                    Allotments
                </h3>
            </div>
            <div class="p-6">
                @if($allotments->isEmpty())
                    <div class="text-center py-10 text-gray-500">
                        <i class="fas fa-calendar-times text-4xl mb-4 text-red-500"></i>
                        <p class="text-xl">No allotments data available</p>
                    </div>
                @else
                    <ul class="divide-y divide-gray-200">
                        @foreach ($allotments as $allotment)
                            <li class="py-5 flex justify-between items-center hover:bg-gray-50 px-4 rounded-lg transition">
                                <div>
                                    <p class="font-semibold text-lg text-gray-800">{{ $allotment->date->format('d M Y') }}</p>
                                    <p class="text-base text-gray-600 mt-1">{{ $allotment->time_slot }}</p>
                                </div>
                                <a href="{{ route('admin.allotments.show', $allotment->id) }}" 
                                   class="text-lg bg-red-50 text-red-600 px-4 py-2 rounded-lg hover:bg-red-100 transition font-medium">
                                    View
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>

        <!-- Bookings -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <div class="bg-gradient-to-r from-pink-50 to-blue-50 px-6 py-5 border-b">
                <h3 class="font-bold text-xl text-gray-800">
                    <i class="far fa-bookmark text-yellow-500 mr-3 text-2xl"></i>
                    Recent Bookings
                </h3>
            </div>
            <div class="p-6">
                @if($bookings->isEmpty())
                    <div class="text-center py-10 text-gray-500">
                        <i class="far fa-calendar-minus text-4xl mb-4 text-yellow-500"></i>
                        <p class="text-xl">No bookings data available</p>
                    </div>
                @else
                    <ul class="divide-y divide-gray-200">
                        @foreach ($bookings as $booking)
                            <li class="py-5 flex justify-between items-center hover:bg-gray-50 px-4 rounded-lg transition">
                                <div>
                                    <p class="font-semibold text-lg text-gray-800">{{ $booking->user->name }}</p>
                                    <p class="text-base text-gray-600 mt-1">{{ $booking->total_person }} person • {{ $booking->created_at->format('d M') }}</p>
                                </div>
                                <a href="{{ route('admin.bookings.show', $booking->id) }}" 
                                   class="text-lg bg-yellow-50 text-yellow-600 px-4 py-2 rounded-lg hover:bg-yellow-100 transition font-medium">
                                    View
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>

        <!-- Payments -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <div class="bg-gradient-to-r from-pink-50 to-blue-50 px-6 py-5 border-b">
                <h3 class="font-bold text-xl text-gray-800">
                    <i class="fas fa-money-bill-alt text-green-500 mr-3 text-2xl"></i>
                    Recent Payments
                </h3>
            </div>
            <div class="p-6">
                @if($payments->isEmpty())
                    <div class="text-center py-10 text-gray-500">
                        <i class="fas fa-money-bill-wave text-4xl mb-4 text-green-500"></i>
                        <p class="text-xl">No payments data available</p>
                    </div>
                @else
                    <ul class="divide-y divide-gray-200">
                        @foreach ($payments as $payment)
                            <li class="py-5 flex justify-between items-center hover:bg-gray-50 px-4 rounded-lg transition">
                                <div>
                                    <p class="font-semibold text-lg text-gray-800">{{ $payment->user->name }}</p>
                                    <p class="text-base text-gray-600 mt-1">Rp{{ number_format($payment->total_payments, 0, ',', '.') }} • {{ $payment->created_at->format('d M') }}</p>
                                </div>
                                <a href="{{ route('admin.payments.show', $payment->id) }}" 
                                   class="text-lg bg-green-50 text-green-600 px-4 py-2 rounded-lg hover:bg-green-100 transition font-medium">
                                    View
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
const bookingsData = {
    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun'],
    datasets: [{
        label: 'Total Bookings',
        data: [5, 12, 8, 15, 9, 18],
        backgroundColor: 'rgba(161, 200, 217, 0.8)',
        borderColor: 'rgba(161, 200, 217, 1)',
        borderWidth: 1,
        borderRadius: 8,
        hoverBackgroundColor: 'rgba(228, 181, 187, 0.8)'
    }]
};

const bookingsChart = document.getElementById('bookingsChart');
if (bookingsChart) {
    new Chart(bookingsChart, {
        type: 'bar',
        data: bookingsData,
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: 'rgba(0,0,0,0.8)',
                    padding: 16,
                    cornerRadius: 8,
                    bodyFont: {
                        size: 14
                    },
                    titleFont: {
                        size: 16
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        drawBorder: false
                    },
                    ticks: {
                        stepSize: 5,
                        font: {
                            size: 14
                        }
                    }
                },
                x: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        font: {
                            size: 14
                        }
                    }
                }
            }
        }
    });
}
</script>
@endsection