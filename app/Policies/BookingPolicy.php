<?php

namespace App\Policies;

use App\Enums\BookingStatus;
use App\Models\Booking;
use App\Models\User;

class BookingPolicy
{
    public function approve(User $user, Booking $booking): bool
    {
        return $user->is_admin && $booking->status === BookingStatus::Menunggu;
    }

    public function cancel(User $user, Booking $booking): bool
    {
        return $user->is_admin && $booking->status !== BookingStatus::Dibatalkan;
    }
}
