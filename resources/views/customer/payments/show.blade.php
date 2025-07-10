@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Detail Pembayaran</h1>
    
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Pembayaran #{{ $payment->id }}</h5>
            <p><strong>Booking ID:</strong> {{ $payment->booking_id }}</p>
            <p><strong>Total Bayar:</strong> Rp {{ number_format($payment->amount) }}</p>
            <p><strong>Status:</strong> 
                @if($payment->transaction_status === 'settlement')
                    <span class="badge bg-success text-white">Lunas</span>
                @elseif($payment->transaction_status === 'pending')
                    <span class="badge bg-warning text-dark">Menunggu</span>
                @elseif($payment->transaction_status === 'expire')
                    <span class="badge bg-danger text-white">Kadaluarsa</span>
                @else
                    <span class="badge bg-secondary text-white">{{ ucfirst($payment->transaction_status) }}</span>
                @endif
            </p>
            <p><strong>Metode Pembayaran:</strong> {{ ucfirst($payment->payment_type) }}</p>

            <a href="{{ route('customer.payments.index') }}" class="btn btn-secondary mt-3">Kembali</a>

            @if ($payment->payment_type === 'midtrans' && $payment->transaction_status === 'pending' && $payment->snap_token)
                <button class="btn btn-success mt-3" onclick="payWithSnap('{{ $payment->snap_token }}')">
                    Bayar Sekarang
                </button>
            @endif
        </div>
    </div>
</div>
@endsection

@section('scripts')
@if ($payment->payment_type === 'midtrans' && $payment->transaction_status === 'pending' && $payment->snap_token)
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
<script>
    function payWithSnap(snapToken) {
        window.snap.pay(snapToken, {
            onSuccess: function(result) {
                alert("Pembayaran berhasil!");
                location.reload();
            },
            onPending: function(result) {
                alert("Menunggu konfirmasi pembayaran...");
                location.reload();
            },
            onError: function(result) {
                alert("Terjadi kesalahan pembayaran.");
            },
            onClose: function() {
                alert("Pembayaran dibatalkan.");
            }
        });
    }
</script>
@endif
@endsection
