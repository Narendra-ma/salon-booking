<?php

namespace App\Http\Controllers\Admin;

use App\Enums\BookingStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\BookingFilterRequest;
use App\Models\Booking;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class BookingController extends Controller
{
    public function index(BookingFilterRequest $request): View
    {
        $filters = $request->validated();

        $bookings = Booking::with(['service', 'employee'])
            ->when($filters['status'] ?? null, fn ($query, $status) => $query->where('status', $status))
            ->when(
                $filters['tanggal'] ?? null,
                fn ($query, $date) => $query->where('booking_date', $date),
                fn ($query) => $request->boolean('riwayat')
                    ? $query
                    : $query->where('booking_date', '>=', today()->toDateString()),
            )
            ->orderBy('booking_date')
            ->orderBy('start_time')
            ->paginate(15)
            ->withQueryString();

        return view('admin.bookings.index', [
            'bookings' => $bookings,
            'statuses' => BookingStatus::cases(),
        ]);
    }

    public function approve(Booking $booking): RedirectResponse
    {
        Gate::authorize('approve', $booking);

        $booking->update(['status' => BookingStatus::Disetujui]);

        return back()->with('success', 'Booking atas nama '.$booking->customer_name.' disetujui.');
    }

    public function cancel(Booking $booking): RedirectResponse
    {
        Gate::authorize('cancel', $booking);

        $booking->update(['status' => BookingStatus::Dibatalkan]);

        return back()->with('success', 'Booking atas nama '.$booking->customer_name.' dibatalkan.');
    }
}
