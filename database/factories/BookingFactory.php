<?php

namespace Database\Factories;

use App\Enums\BookingStatus;
use App\Models\Booking;
use App\Models\Employee;
use App\Models\Service;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<Booking> */
class BookingFactory extends Factory
{
    public function definition(): array
    {
        return [
            'service_id' => Service::factory(),
            'employee_id' => Employee::factory(),
            'customer_name' => fake()->name(),
            'customer_phone' => '62812'.fake()->numerify('########'),
            'booking_date' => now()->addDay()->toDateString(),
            'start_time' => '10:00:00',
            'end_time' => '11:00:00',
            'status' => BookingStatus::Menunggu,
        ];
    }

    public function status(BookingStatus $status): static
    {
        return $this->state(fn () => ['status' => $status]);
    }
}
