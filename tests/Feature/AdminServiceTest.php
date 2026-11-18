<?php

namespace Tests\Feature;

use App\Models\Booking;
use App\Models\Service;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminServiceTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->admin()->create();
    }

    private function payload(array $override = []): array
    {
        return array_merge([
            'name' => 'Hair Spa',
            'description' => 'Perawatan rambut.',
            'duration_minutes' => 75,
            'price' => 175000,
            'is_active' => '1',
        ], $override);
    }

    public function test_user_biasa_tidak_bisa_mengelola_layanan(): void
    {
        $this->actingAs(User::factory()->create())
            ->post(route('admin.services.store'), $this->payload())
            ->assertForbidden();

        $this->assertDatabaseCount('services', 0);
    }

    public function test_admin_menambah_layanan(): void
    {
        $this->actingAs($this->admin)
            ->post(route('admin.services.store'), $this->payload())
            ->assertRedirect(route('admin.services.index'));

        $this->assertDatabaseHas('services', ['name' => 'Hair Spa', 'price' => 175000, 'is_active' => true]);
    }

    public function test_checkbox_kosong_berarti_nonaktif(): void
    {
        $this->actingAs($this->admin)
            ->post(route('admin.services.store'), $this->payload(['is_active' => null]));

        $this->assertDatabaseHas('services', ['name' => 'Hair Spa', 'is_active' => false]);
    }

    public function test_validasi_layanan(): void
    {
        $this->actingAs($this->admin)
            ->post(route('admin.services.store'), $this->payload(['name' => '', 'duration_minutes' => 20, 'price' => -1]))
            ->assertSessionHasErrors(['name', 'duration_minutes', 'price']);
    }

    public function test_nama_layanan_harus_unik_tapi_boleh_sama_dengan_dirinya_sendiri(): void
    {
        $service = Service::factory()->create(['name' => 'Hair Spa']);
        Service::factory()->create(['name' => 'Facial']);

        $this->actingAs($this->admin)
            ->put(route('admin.services.update', $service), $this->payload(['name' => 'Facial']))
            ->assertSessionHasErrors('name');

        $this->actingAs($this->admin)
            ->put(route('admin.services.update', $service), $this->payload(['name' => 'Hair Spa', 'price' => 200000]))
            ->assertSessionHasNoErrors();

        $this->assertSame(200000, $service->fresh()->price);
    }

    public function test_admin_menghapus_layanan_tanpa_booking(): void
    {
        $service = Service::factory()->create();

        $this->actingAs($this->admin)
            ->delete(route('admin.services.destroy', $service))
            ->assertRedirect(route('admin.services.index'));

        $this->assertModelMissing($service);
    }

    public function test_layanan_yang_punya_booking_tidak_bisa_dihapus(): void
    {
        $booking = Booking::factory()->create();

        $this->actingAs($this->admin)
            ->delete(route('admin.services.destroy', $booking->service))
            ->assertSessionHas('error');

        $this->assertModelExists($booking->service);
    }
}
