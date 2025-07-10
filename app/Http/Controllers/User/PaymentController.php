<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Midtrans\Config;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;

class PaymentController extends Controller
{
    public function index()
    {
        // Hanya ambil pembayaran milik user yang login
        $payments = Payment::with('booking')
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('customer.payments.index', compact('payments'));
    }

    public function create()
    {
        // Ambil booking milik user yang belum dibayar
        $bookings = Booking::where('user_id', auth()->id())
            ->where('status', 'pending')
            ->get();

        return view('customer.payments.create', compact('bookings'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'booking_id' => 'required|exists:bookings,id',
            'payment_method' => 'required|string|in:cash,midtrans',
        ]);

        $booking = Booking::where('user_id', auth()->id())->findOrFail($request->booking_id);
        $total = $booking->total_payments;
        $orderId = 'ORDER-' . Str::uuid();
        $snapToken = null;
        $redirectUrl = null;

        if ($request->payment_method === 'midtrans') {
            // Konfigurasi Midtrans
            Config::$serverKey = config('midtrans.server_key');
            Config::$isProduction = config('midtrans.is_production');
            Config::$isSanitized = true;
            Config::$is3ds = true;

            // Buat data transaksi Midtrans
            $transaction = [
                'transaction_details' => [
                    'order_id' => $orderId,
                    'gross_amount' => (int) $total,
                ],
                'customer_details' => [
                    'first_name' => auth()->user()->name,
                    'email' => auth()->user()->email,
                ],
                'enabled_payments' => ['gopay', 'bank_transfer'],
            ];

            // Kirim request ke Midtrans Snap
            $client = new Client();

            try {
                $response = $client->post('https://app.sandbox.midtrans.com/snap/v1/transactions', [
                    'headers' => [
                        'Accept' => 'application/json',
                        'Content-Type' => 'application/json',
                        'Authorization' => 'Basic ' . base64_encode(config('midtrans.server_key') . ':'),
                    ],
                    'json' => $transaction,
                ]);

                $body = json_decode($response->getBody(), true);
                $snapToken = $body['token'];
                $redirectUrl = $body['redirect_url'];

            } catch (\Exception $e) {
                return back()->with('error', 'Gagal membuat transaksi Midtrans: ' . $e->getMessage());
            }
        }

        // Simpan data pembayaran
        Payment::create([
            'booking_id' => $booking->id,
            'user_id' => auth()->id(), // ⬅️ Tambahkan ini
            'slug' => Str::uuid(),
            'order_id' => $orderId,
            'transaction_status' => 'pending',
            'payment_type' => $request->payment_method,
            'snap_token' => $snapToken,
            'snap_url' => $redirectUrl,
            'amount' => $total,
            'status' => 'pending',
            'expired_at' => now()->addHours(3),
        ]);

        return redirect()->route('customer.payments.index')->with('success', 'Pembayaran berhasil dibuat!');
    }

    public function show(Payment $payment)
    {
        // Cek apakah user yang melihat adalah pemilik pembayaran
        if ($payment->user_id !== auth()->id()) {
            abort(403);
        }

        return view('customer.payments.show', compact('payment'));
    }

    public function edit(Payment $payment)
    {
        if ($payment->user_id !== auth()->id()) {
            abort(403);
        }

        return view('customer.payments.edit', compact('payment'));
    }

    public function update(Request $request, Payment $payment)
    {
        if ($payment->user_id !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'status' => 'required|in:pending,paid,canceled',
        ]);

        $payment->update(['status' => $request->status]);

        return redirect()->route('customer.payments.index')->with('success', 'Status pembayaran diperbarui!');
    }

    public function destroy(Payment $payment)
    {
        if ($payment->user_id !== auth()->id()) {
            abort(403);
        }

        $payment->delete();

        return redirect()->route('customer.payments.index')->with('success', 'Data pembayaran dihapus.');
    }

    public function checkStatus(Payment $payment)
    {
        if ($payment->user_id !== auth()->id()) {
            abort(403);
        }

        $serverKey = config('midtrans.server_key');
        $orderId = $payment->order_id;

        $response = Http::withBasicAuth($serverKey, '')
            ->get("https://api.sandbox.midtrans.com/v2/{$orderId}/status");

        $status = $response->json();

        return view('customer.payments.status', compact('status', 'payment'));
    }
}
