<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Princess Private Pools</title>
    {{-- We no longer need the following as they are in admin.blade.php --}}
    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"> --}}
    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" /> --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        /* Remove redundant styles that are already in admin.blade.php if they are identical */
        /* For example, the gradient background and font-family should be controlled by admin.blade.php */
        /* Only keep styles specific to the dashboard content here */

        .dashboard-title {
            font-size: 2.5rem;
            font-weight: bold;
            text-align: center;
            margin-bottom: 30px;
            color: #2c3e50;
        }
        .btn-group-custom {
            display: flex;
            justify-content: center;
            gap: 20px;
            flex-wrap: wrap;
            margin-bottom: 40px;
        }
        .btn-group-custom .btn {
            padding: 12px 20px;
            font-size: 1rem;
            border-radius: 8px;
        }
        .section-title {
            font-size: 1.75rem;
            font-weight: bold;
            margin-top: 40px;
            margin-bottom: 20px;
            color: #34495e;
            border-bottom: 2px solid #eee;
            padding-bottom: 10px;
        }
        .data-card {
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            padding: 20px;
        }
        .list-group-item {
            background-color: transparent;
            border: none;
            padding: 8px 0;
        }
        .list-group-item a {
            text-decoration: none;
            color: #007bff;
            margin-left: 10px;
        }
        .list-group-item a:hover {
            text-decoration: underline;
        }
        .no-data {
            color: #777;
            font-style: italic;
        }
        .chart-container {
            position: relative;
            margin: auto;
            height: 300px;
            width: 80%;
            margin-bottom: 30px;
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }
        .chart-title {
            font-size: 1.5rem;
            font-weight: bold;
            color: #34495e;
            margin-bottom: 15px;
            text-align: center;
        }
    </style>
</head>
<body>

@extends('admin') {{-- This line tells Blade to extend the 'admin.blade.php' layout --}}

@section('content') 
    <div class="container"> {{-- You can still wrap your specific dashboard content in a container here if needed for more granular control --}}
        <h1 class="dashboard-title"><i class="fas fa-tachometer-alt me-2"></i> Admin Dashboard - Princess Private Pools</h1>

        <div class="btn-group-custom">
            <a href="{{ route('admin.swimmingpools.index') }}" class="btn btn-primary"><i class="fas fa-swimming-pool me-2"></i> Swimming Pools</a>
            <a href="{{ route('admin.allotments.index') }}" class="btn btn-success"><i class="fas fa-th-large me-2"></i> Allotments</a>
            <a href="{{ route('admin.bookings.index') }}" class="btn btn-warning text-white"><i class="far fa-calendar-check me-2"></i> Bookings</a>
            <a href="{{ route('admin.payments.index') }}" class="btn btn-secondary"><i class="fas fa-money-bill-wave me-2"></i> Payments</a>
        </div>

        <div class="chart-container">
            <h2 class="chart-title"><i class="fas fa-chart-bar me-2"></i> Jumlah Pemesanan Bulanan</h2>
            <canvas id="bookingsChart"></canvas>
        </div>

        <div class="data-card">
            <h3 class="section-title"><i class="fas fa-water me-2"></i> Data Swimming Pools</h3>
            @if($swimmingpools->isEmpty())
                <p class="no-data">Tidak ada data kolam renang.</p>
            @else
                <ul class="list-group">
                    @foreach ($swimmingpools as $swimmingpool)
                        <li class="list-group-item">
                            <i class="fas fa-tint me-2"></i> {{ $swimmingpool->name }}
                            <a href="{{ route('admin.swimmingpools.show', $swimmingpool->id) }}">[Lihat]</a>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>

        <div class="data-card">
            <h3 class="section-title"><i class="fas fa-calendar-alt me-2"></i> Data Allotments</h3>
            @if($allotments->isEmpty())
                <p class="no-data">Tidak ada data alokasi.</p>
            @else
                <ul class="list-group">
                    @foreach ($allotments as $allotment)
                        <li class="list-group-item">
                            <i class="far fa-calendar me-2"></i> {{ $allotment->date }}
                            <a href="{{ route('admin.allotments.show', $allotment->id) }}">[Lihat]</a>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>

        <div class="data-card">
            <h3 class="section-title"><i class="far fa-bookmark me-2"></i> Data Bookings</h3>
            @if($bookings->isEmpty())
                <p class="no-data">Tidak ada data pemesanan.</p>
            @else
                <ul class="list-group">
                    @foreach ($bookings as $booking)
                        <li class="list-group-item">
                            <i class="fas fa-user me-2"></i> {{ $booking->user->name }} - {{ $booking->total_person }} person
                            <a href="{{ route('admin.bookings.show', $booking->id) }}">[Lihat]</a>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>

        <div class="data-card">
            <h3 class="section-title"><i class="fas fa-money-bill-alt me-2"></i> Data Payments</h3>
            @if($payments->isEmpty())
                <p class="no-data">Tidak ada data pembayaran.</p>
            @else
                <ul class="list-group">
                    @foreach ($payments as $payment)
                        <li class="list-group-item">
                            <i class="fas fa-hand-holding-usd me-2"></i> {{ $payment->user->name }} - Rp{{ number_format($payment->total_payments, 0, ',', '.') }}
                            <a href="{{ route('admin.payments.show', $payment->id) }}">[Lihat]</a>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>

    <script>
        // Contoh data untuk grafik (ganti dengan data sebenarnya dari backend Anda)
        const bookingsData = {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun'],
            datasets: [{
                label: 'Jumlah Pemesanan',
                data: [5, 12, 8, 15, 9, 18],
                backgroundColor: 'rgba(54, 162, 235, 0.7)', // Blue
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        };

        const bookingsChartCanvas = document.getElementById('bookingsChart');
        if (bookingsChartCanvas) {
            new Chart(bookingsChartCanvas, {
                type: 'bar',
                data: bookingsData,
                options: {
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Jumlah Pemesanan'
                            }
                        },
                        x: {
                            title: {
                                display: true,
                                text: 'Bulan'
                            }
                        }
                    },
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: true,
                            position: 'bottom',
                        },
                        title: {
                            display: false,
                        }
                    }
                }
            });
        }
    </script>
    {{-- We no longer need this as it's included in admin.blade.php --}}
    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script> --}}

@endsection

</body>
</html>