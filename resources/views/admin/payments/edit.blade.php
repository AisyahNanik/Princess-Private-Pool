@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Pembayaran</h1>

    <form action="{{ route('admin.payments.update', $payment->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="payment_method" class="form-label">Metode Pembayaran</label>
            <input type="text" name="payment_method" id="payment_method" class="form-control" value="{{ old('payment_method', $payment->payment_method) }}" required>
            @error('payment_method')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="status" class="form-label">Status Pembayaran</label>
            <select name="status" id="status" class="form-control">
                <option value="pending" {{ $payment->status === 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="paid" {{ $payment->status === 'paid' ? 'selected' : '' }}>Paid</option>
                <option value="canceled" {{ $payment->status === 'canceled' ? 'selected' : '' }}>Canceled</option>
            </select>
            @error('status')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="{{ route('admin.payments.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
