<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller; 
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Allotment;
use App\Models\User;
use App\Models\Swimmingpool;
use Illuminate\Support\Str;

class BookingController extends Controller
{
    // public function __construct()
    // {
    //     // Pastikan middleware admin sudah benar
    //     $this->middleware(['auth', 'role:admin']);
    // }

    public function index() {
        $bookings = Booking::with('user', 'swimmingpool', 'allotment')->get();
        return view('admin.bookings.index', compact('bookings'));
    }

    public function create() {
        return view('admin.bookings.create');
    }

    public function store(Request $request) {
        $request->validate([
            'user_id'           => 'required|exists:users,id',
            'swimmingpool_id'   => 'required|exists:swimmingpools,id',
            'allotment_id'      => 'required|exists:allotments,id',
            'total_person'      => 'required|integer|min:1',
            'payment_method'    => 'required|string',
        ]);

        // Menemukan allotment berdasarkan ID
        $allotment = Allotment::findOrFail($request->allotment_id);
        $total_payments = $request->total_person * $allotment->price_per_person;

        // Mengecek jumlah booking sebelumnya untuk allotment tersebut
        $jumlahBookingSebelumnya = Booking::where('allotment_id', $request->allotment_id)->sum('total_person');

        // Mengecek apakah kuota melebihi batas
        if ($jumlahBookingSebelumnya + $request->total_person > $allotment->total_person) {
            return back()->withErrors(['total_person' => 'Kuota sudah penuh atau melebihi kapasitas.']);
        }
        
        // Menyimpan data booking
        $booking = Booking::create([
            'user_id'               => $request->user_id,
            'swimmingpool_id'       => $request->swimmingpool_id,
            'allotment_id'          => $request->allotment_id,
            'slug'                  => Str::random(40),
            'total_person'          => $request->total_person,
            'total_payments'        => $total_payments,
            'payment_method'        => $request->payment_method,
            'status'                => 'pending',  // Status default
            // 'expired_time_payments' => now()->addHours(3), // Expired dalam 3 jam
        ]);

        // Redirect ke halaman daftar booking dengan pesan sukses
        return redirect()->route('admin.bookings.index')->with('success', 'Booking berhasil dibuat!');
    }

    public function show(Booking $booking) {
        return view('admin.bookings.show', compact('booking'));
    }

    public function edit(Booking $booking) {
        return view('admin.bookings.edit', compact('booking'));
    }

    public function update(Request $request, Booking $booking) {
        $request->validate([
            'status' => 'required|in:pending,paid,canceled', // Memastikan status valid
        ]);

        // Update status booking
        $booking->update(['status' => $request->status]);

        return redirect()->route('admin.bookings.index')->with('success', 'Status booking diperbarui!');
    }

    public function destroy(Booking $booking) {
        // Hapus booking
        $booking->delete();
        return redirect()->route('admin.bookings.index')->with('success', 'Booking dihapus.');
    }

    // Untuk menampilkan bookingan customer
    public function indexCustomer() {
        $bookings = Booking::where('user_id', auth()->id())->get();
        return view('customer.bookings', compact('bookings'));
    }
}
