<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookingRequest;
use App\Models\Service;
use App\Services\BookingService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BookingController extends Controller
{
    public function create(Request $request, BookingService $bookings): View
    {
        return view('booking.create', [
            'services' => Service::active()->orderBy('name')->get(),
            'slots' => $bookings->slots(),
            'selectedService' => $request->integer('layanan'),
            'minDate' => today()->toDateString(),
            'maxDate' => today()->addDays(config('salon.max_advance_days'))->toDateString(),
        ]);
    }

    public function store(BookingRequest $request, BookingService $bookings): RedirectResponse
    {
        $booking = $bookings->create($request->validated());

        return redirect()->route('booking.create')->with('booking_summary', [
            'name' => $booking->customer_name,
            'service' => $booking->service->name,
            'date' => $booking->booking_date->translatedFormat('l, j F Y'),
            'time' => $booking->timeLabel(),
        ]);
    }
}
