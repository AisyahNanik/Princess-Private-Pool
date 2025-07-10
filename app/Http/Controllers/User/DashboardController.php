<?php

namespace App\Http\Controllers\Admin;

use App\Models\SwimmingPool;
use App\Models\Allotment;
use App\Models\Booking;
use App\Models\Payment;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        $swimmingpools = SwimmingPool::all();
        $bookings = Booking::with('user')->get(); // lebih aman pakai with agar tidak error saat akses user
        $payments = Payment::with('user')->get();

        return view('customer.dashboard', compact('swimmingpools', 'bookings', 'payments'));
    }
}
