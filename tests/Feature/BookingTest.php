<?php

namespace Tests\Feature;

use App\Enums\BookingStatus;
use App\Models\Booking;
use App\Models\Employee;
use App\Models\Service;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class BookingTest extends TestCase
{
    use RefreshDatabase;

    private Service $service;

    private Employee $employee;

    protected function setUp(): void
    {
        parent::setUp();

        // Rabu pagi, supaya "besok" (2026-11-19) selalu jelas dan jam 10:00 hari ini belum lewat
        $this->travelTo(Carbon::parse('2026-11-18 08:00:00'));

        $this->service = Service::factory()->create(['duration_minutes' => 60]);
        $this->employee = Employee::factory()->create();
    }

    private function payload(array $override = []): array
    {
        return array_merge([
            'customer_name' => 'Ani',
            'customer_phone' => '0812-3456-7890',
            'service_id' => $this->service->id,
            'booking_date' => '2026-11-19',
            'start_time' => '10:00',
        ], $override);
    }

    private function existingBooking(array $override = []): Booking
    {
        return Booking::factory()->create(array_merge([
            'service_id' => $this->service->id,
            'employee_id' => $this->employee->id,
            'booking_date' => '2026-11-19',
            'start_time' => '10:00:00',
            'end_time' => '11:00:00',
        ], $override));
    }

    public function test_form_booking_menampilkan_layanan(): void
    {
        $this->get(route('booking.create'))
            ->assertOk()
            ->assertSee($this->service->name);
    }

    public function test_booking_tersimpan_dengan_status_menunggu(): void
    {
        $this->post(route('booking.store'), $this->payload())
            ->assertRedirect(route('booking.create'))
            ->assertSessionHas('booking_summary');

        $this->assertDatabaseHas('bookings', [
            'customer_name' => 'Ani',
            'customer_phone' => '6281234567890',
            'booking_date' => '2026-11-19',
            'start_time' => '10:00:00',
            'end_time' => '11:00:00',
            'status' => 'menunggu',
            'employee_id' => $this->employee->id,
        ]);
    }

    public function test_jadwal_bentrok_ditolak(): void
    {
        $this->existingBooking();

        $this->post(route('booking.store'), $this->payload(['start_time' => '10:30']))
            ->assertSessionHasErrors('start_time');

        $this->assertDatabaseCount('bookings', 1);
    }

    public function test_jam_yang_berurutan_tidak_dianggap_bentrok(): void
    {
        $this->existingBooking();

        $this->post(route('booking.store'), $this->payload(['start_time' => '11:00']))
            ->assertSessionHasNoErrors();

        $this->assertDatabaseCount('bookings', 2);
    }

    public function test_pegawai_lain_dipakai_saat_pegawai_pertama_sibuk(): void
    {
        $this->existingBooking();
        $second = Employee::factory()->create();

        $this->post(route('booking.store'), $this->payload())->assertSessionHasNoErrors();

        $this->assertDatabaseHas('bookings', ['employee_id' => $second->id, 'customer_name' => 'Ani']);
    }

    public function test_pegawai_nonaktif_tidak_dihitung(): void
    {
        $this->employee->update(['is_active' => false]);

        $this->post(route('booking.store'), $this->payload())
            ->assertSessionHasErrors('start_time');
    }

    public function test_booking_yang_dibatalkan_membebaskan_jadwal(): void
    {
        $this->existingBooking(['status' => BookingStatus::Dibatalkan]);

        $this->post(route('booking.store'), $this->payload())->assertSessionHasNoErrors();

        $this->assertDatabaseCount('bookings', 2);
    }

    public function test_jam_yang_sudah_lewat_hari_ini_ditolak(): void
    {
        $this->travelTo(Carbon::parse('2026-11-18 14:00:00'));

        $this->post(route('booking.store'), $this->payload(['booking_date' => '2026-11-18', 'start_time' => '10:00']))
            ->assertSessionHasErrors('start_time');
    }

    public function test_layanan_yang_selesai_setelah_tutup_ditolak(): void
    {
        $long = Service::factory()->create(['duration_minutes' => 180]);

        $this->post(route('booking.store'), $this->payload(['service_id' => $long->id, 'start_time' => '19:00']))
            ->assertSessionHasErrors('start_time');
    }

    public function test_nomor_whatsapp_tidak_valid_ditolak(): void
    {
        $this->post(route('booking.store'), $this->payload(['customer_phone' => 'abc']))
            ->assertSessionHasErrors('customer_phone');
    }

    public function test_layanan_nonaktif_ditolak(): void
    {
        $inactive = Service::factory()->inactive()->create();

        $this->post(route('booking.store'), $this->payload(['service_id' => $inactive->id]))
            ->assertSessionHasErrors('service_id');
    }

    public function test_tanggal_terlalu_jauh_ditolak(): void
    {
        $this->post(route('booking.store'), $this->payload(['booking_date' => '2027-02-01']))
            ->assertSessionHasErrors('booking_date');
    }

    public function test_jam_di_luar_slot_ditolak(): void
    {
        $this->post(route('booking.store'), $this->payload(['start_time' => '10:15']))
            ->assertSessionHasErrors('start_time');
    }

    public function test_semua_field_wajib_diisi(): void
    {
        $this->post(route('booking.store'), [])
            ->assertSessionHasErrors(['customer_name', 'customer_phone', 'service_id', 'booking_date', 'start_time']);
    }
}
