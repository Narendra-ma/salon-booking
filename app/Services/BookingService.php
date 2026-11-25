<?php

namespace App\Services;

use App\Enums\BookingStatus;
use App\Models\Booking;
use App\Models\Employee;
use App\Models\Service;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class BookingService
{
    // Jam mulai yang boleh dipilih: dari jam buka sampai satu slot sebelum tutup
    public function slots(): array
    {
        $step = config('salon.slot_minutes');
        $time = Carbon::createFromFormat('H:i', config('salon.open'));
        $last = Carbon::createFromFormat('H:i', config('salon.close'))->subMinutes($step);

        $slots = [];
        while ($time->lte($last)) {
            $slots[] = $time->format('H:i');
            $time->addMinutes($step);
        }

        return $slots;
    }

    // Status tiap jam untuk tanggal dan layanan tertentu: true kalau masih bisa dipesan.
    // Aturannya sama dengan create(): jam sudah lewat, selesai setelah tutup, atau
    // semua pegawai aktif sibuk di rentang itu berarti penuh.
    public function availability(string $date, Service $service): array
    {
        $ids = Employee::active()->pluck('id');
        $close = Carbon::parse("$date ".config('salon.close'));
        $result = [];

        foreach ($this->slots() as $slot) {
            $start = Carbon::parse("$date $slot");
            $end = $start->copy()->addMinutes($service->duration_minutes);

            $busy = Booking::active()
                ->overlapping($date, $start->format('H:i:s'), $end->format('H:i:s'))
                ->whereIn('employee_id', $ids)
                ->distinct()
                ->count('employee_id');

            $result[$slot] = $start->gt(now()) && $end->lte($close) && $busy < $ids->count();
        }

        return $result;
    }

    public function create(array $data): Booking
    {
        $service = Service::active()->findOrFail($data['service_id']);
        $date = $data['booking_date'];
        $start = Carbon::parse("$date {$data['start_time']}");
        $end = $start->copy()->addMinutes($service->duration_minutes);

        if ($start->lte(now())) {
            $this->fail('Jam tersebut sudah lewat, silakan pilih jam lain.');
        }

        if ($end->gt(Carbon::parse("$date ".config('salon.close')))) {
            $this->fail('Layanan ini selesai setelah salon tutup, silakan pilih jam yang lebih awal.');
        }

        return DB::transaction(function () use ($data, $service, $date, $start, $end) {
            $employee = $this->freeEmployee($date, $start->format('H:i:s'), $end->format('H:i:s'));

            if (! $employee) {
                $this->fail('Jadwal pada jam tersebut sudah penuh, silakan pilih jam lain.');
            }

            return Booking::create([
                'service_id' => $service->id,
                'employee_id' => $employee->id,
                'customer_name' => $data['customer_name'],
                'customer_phone' => $data['customer_phone'],
                'booking_date' => $date,
                'start_time' => $start->format('H:i:s'),
                'end_time' => $end->format('H:i:s'),
                'status' => BookingStatus::Menunggu,
            ]);
        });
    }

    // Kunci baris pegawai dulu supaya dua booking yang masuk bersamaan diproses
    // satu per satu, bukan sama-sama lolos cek lalu bentrok.
    private function freeEmployee(string $date, string $start, string $end): ?Employee
    {
        $employees = Employee::active()->lockForUpdate()->get();

        $busy = Booking::active()
            ->overlapping($date, $start, $end)
            ->pluck('employee_id');

        return $employees->first(fn (Employee $employee) => ! $busy->contains($employee->id));
    }

    private function fail(string $message): never
    {
        throw ValidationException::withMessages(['start_time' => $message]);
    }
}
