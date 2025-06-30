@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="container py-4">
    <h1 class="dashboard-title text-center"><i class="fas fa-tachometer-alt me-3"></i> Admin Dashboard - Princess Private Pools</h1>

    <div class="btn-group-custom text-center mb-4">
        <a href="{{ route('admin.swimmingpools.index') }}" class="btn btn-primary"><i class="fas fa-swimming-pool me-2"></i> Swimming Pools</a>
        <a href="{{ route('admin.allotments.index') }}" class="btn btn-success"><i class="fas fa-th-large me-2"></i> Allotments</a>
        <a href="{{ route('admin.bookings.index') }}" class="btn btn-warning text-white"><i class="far fa-calendar-check me-2"></i> Bookings</a>
        <a href="{{ route('admin.payments.index') }}" class="btn btn-secondary"><i class="fas fa-money-bill-wave me-2"></i> Payments</a>
    </div>

    <div class="chart-container mb-5">
        <h2 class="chart-title"><i class="fas fa-chart-bar"></i> Jumlah Pemesanan Bulanan</h2>
        <canvas id="bookingsChart" height="100"></canvas>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header bg-light">
                    <h3 class="section-title"><i class="fas fa-water"></i> Data Swimming Pools</h3>
                </div>
                <div class="card-body">
                    @if($swimmingpools->isEmpty())
                        <p class="no-data">Tidak ada data kolam renang.</p>
                    @else
                        <ul class="list-group">
                            @foreach ($swimmingpools as $swimmingpool)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    {{ $swimmingpool->name }}
                                    <a href="{{ route('admin.swimmingpools.show', $swimmingpool->id) }}">Lihat</a>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header bg-light">
                    <h3 class="section-title"><i class="fas fa-calendar-alt"></i> Data Allotments</h3>
                </div>
                <div class="card-body">
                    @if($allotments->isEmpty())
                        <p class="no-data">Tidak ada data alokasi.</p>
                    @else
                        <ul class="list-group">
                            @foreach ($allotments as $allotment)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    {{ $allotment->date }}
                                    <a href="{{ route('admin.allotments.show', $allotment->id) }}">Lihat</a>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header bg-light">
                    <h3 class="section-title"><i class="far fa-bookmark"></i> Data Bookings</h3>
                </div>
                <div class="card-body">
                    @if($bookings->isEmpty())
                        <p class="no-data">Tidak ada data pemesanan.</p>
                    @else
                        <ul class="list-group">
                            @foreach ($bookings as $booking)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    {{ $booking->user->name }} - {{ $booking->total_person }} orang
                                    <a href="{{ route('admin.bookings.show', $booking->id) }}">Lihat</a>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header bg-light">
                    <h3 class="section-title"><i class="fas fa-money-bill-alt"></i> Data Payments</h3>
                </div>
                <div class="card-body">
                    @if($payments->isEmpty())
                        <p class="no-data">Tidak ada data pembayaran.</p>
                    @else
                        <ul class="list-group">
                            @foreach ($payments as $payment)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    {{ $payment->user->name }} - Rp{{ number_format($payment->total_payments, 0, ',', '.') }}
                                    <a href="{{ route('admin.payments.show', $payment->id) }}">Lihat</a>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script>
const bookingsData = {
    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun'],
    datasets: [{
        label: 'Jumlah Pemesanan',
        data: [5, 12, 8, 15, 9, 18],
        backgroundColor: 'rgba(54, 162, 235, 0.8)',
        borderColor: 'rgba(54, 162, 235, 1)',
        borderWidth: 1
    }]
};

const bookingsChart = document.getElementById('bookingsChart');
if (bookingsChart) {
    new Chart(bookingsChart, {
        type: 'bar',
        data: bookingsData,
        options: {
            responsive: true,
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
            }
        }
    });
}
</script>
@endsection
