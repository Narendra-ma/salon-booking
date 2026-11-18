<?php

namespace Tests\Feature;

use App\Enums\BookingStatus;
use App\Models\Booking;
use App\Models\Service;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminBookingTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->admin()->create();
    }

    public function test_tamu_diarahkan_ke_halaman_login(): void
    {
        $this->get(route('admin.dashboard'))->assertRedirect(route('login'));
        $this->get(route('admin.bookings.index'))->assertRedirect(route('login'));
    }

    public function test_user_biasa_tidak_boleh_masuk_panel_admin(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->get(route('admin.dashboard'))->assertForbidden();
        $this->actingAs($user)->get(route('admin.bookings.index'))->assertForbidden();
    }

    public function test_user_biasa_tidak_bisa_menyetujui_booking(): void
    {
        $booking = Booking::factory()->create();

        $this->actingAs(User::factory()->create())
            ->patch(route('admin.bookings.approve', $booking))
            ->assertForbidden();

        $this->assertSame(BookingStatus::Menunggu, $booking->fresh()->status);
    }

    public function test_admin_bisa_login_dan_masuk_dashboard(): void
    {
        $this->post(route('login'), ['email' => $this->admin->email, 'password' => 'password'])
            ->assertRedirect(route('admin.dashboard'));

        $this->assertAuthenticatedAs($this->admin);
        $this->get(route('admin.dashboard'))->assertOk();
    }

    public function test_login_dengan_password_salah_gagal(): void
    {
        $this->post(route('login'), ['email' => $this->admin->email, 'password' => 'salah'])
            ->assertSessionHasErrors('email');

        $this->assertGuest();
    }

    public function test_admin_melihat_daftar_booking(): void
    {
        Booking::factory()->create(['customer_name' => 'Budi Santoso']);

        $this->actingAs($this->admin)
            ->get(route('admin.bookings.index'))
            ->assertOk()
            ->assertSee('Budi Santoso');
    }

    public function test_filter_status_booking(): void
    {
        Booking::factory()->create(['customer_name' => 'Masih Menunggu']);
        Booking::factory()->status(BookingStatus::Disetujui)->create(['customer_name' => 'Sudah Disetujui']);

        $this->actingAs($this->admin)
            ->get(route('admin.bookings.index', ['status' => 'disetujui']))
            ->assertSee('Sudah Disetujui')
            ->assertDontSee('Masih Menunggu');
    }

    public function test_admin_menyetujui_booking(): void
    {
        $booking = Booking::factory()->create();

        $this->actingAs($this->admin)
            ->patch(route('admin.bookings.approve', $booking))
            ->assertRedirect()
            ->assertSessionHas('success');

        $this->assertSame(BookingStatus::Disetujui, $booking->fresh()->status);
    }

    public function test_booking_yang_sudah_disetujui_tidak_bisa_disetujui_lagi(): void
    {
        $booking = Booking::factory()->status(BookingStatus::Disetujui)->create();

        $this->actingAs($this->admin)
            ->patch(route('admin.bookings.approve', $booking))
            ->assertForbidden();
    }

    public function test_admin_membatalkan_booking(): void
    {
        $booking = Booking::factory()->status(BookingStatus::Disetujui)->create();

        $this->actingAs($this->admin)
            ->patch(route('admin.bookings.cancel', $booking))
            ->assertRedirect();

        $this->assertSame(BookingStatus::Dibatalkan, $booking->fresh()->status);
    }

    public function test_booking_yang_sudah_dibatalkan_tidak_bisa_dibatalkan_lagi(): void
    {
        $booking = Booking::factory()->status(BookingStatus::Dibatalkan)->create();

        $this->actingAs($this->admin)
            ->patch(route('admin.bookings.cancel', $booking))
            ->assertForbidden();
    }

    public function test_tombol_whatsapp_hanya_muncul_untuk_booking_disetujui(): void
    {
        Booking::factory()->create(['customer_phone' => '6281111111111']);
        Booking::factory()->status(BookingStatus::Disetujui)->create(['customer_phone' => '6282222222222']);

        $this->actingAs($this->admin)
            ->get(route('admin.bookings.index'))
            ->assertSee('https://wa.me/6282222222222?text=', false)
            ->assertDontSee('https://wa.me/6281111111111', false);
    }

    public function test_link_whatsapp_berisi_pesan_konfirmasi(): void
    {
        $service = Service::factory()->create(['name' => 'Creambath']);
        $booking = Booking::factory()->create([
            'service_id' => $service->id,
            'customer_name' => 'Ani',
            'customer_phone' => '6281234567890',
            'booking_date' => '2026-11-19',
            'start_time' => '10:00:00',
            'end_time' => '11:00:00',
        ]);

        $url = $booking->whatsappUrl();

        $this->assertStringStartsWith('https://wa.me/6281234567890?text=', $url);
        $this->assertStringNotContainsString(' ', $url);
        $this->assertStringContainsString('%0A', $url);

        $pesan = urldecode(substr($url, strpos($url, 'text=') + 5));
        $this->assertStringContainsString('Halo Kak Ani', $pesan);
        $this->assertStringContainsString('Creambath', $pesan);
        $this->assertStringContainsString('19 November 2026', $pesan);
        $this->assertStringContainsString('10:00', $pesan);
    }
}
