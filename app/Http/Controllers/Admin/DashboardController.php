<?php

namespace App\Http\Controllers\Admin;

use App\Enums\BookingStatus;
use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Service;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        return view('admin.dashboard', [
            'pendingCount' => Booking::where('status', BookingStatus::Menunggu)->count(),
            'todayCount' => Booking::active()->where('booking_date', today()->toDateString())->count(),
            'serviceCount' => Service::active()->count(),
            'pending' => Booking::with('service')
                ->where('status', BookingStatus::Menunggu)
                ->orderBy('booking_date')
                ->orderBy('start_time')
                ->take(5)
                ->get(),
        ]);
    }
}
