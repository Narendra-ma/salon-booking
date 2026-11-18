<?php

namespace Tests\Feature;

use App\Models\Service;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicPagesTest extends TestCase
{
    use RefreshDatabase;

    public function test_halaman_publik_bisa_dibuka(): void
    {
        foreach (['/', '/layanan', '/galeri', '/kontak', '/booking'] as $url) {
            $this->get($url)->assertOk();
        }
    }

    public function test_daftar_layanan_menampilkan_harga_dan_menyembunyikan_yang_nonaktif(): void
    {
        Service::factory()->create(['name' => 'Creambath', 'price' => 120000, 'duration_minutes' => 90]);
        Service::factory()->inactive()->create(['name' => 'Layanan Tersembunyi']);

        $this->get('/layanan')
            ->assertSee('Creambath')
            ->assertSee('Rp 120.000')
            ->assertSee('1 jam 30 menit')
            ->assertDontSee('Layanan Tersembunyi');
    }

    public function test_galeri_menampilkan_foto_dari_folder(): void
    {
        $this->get('/galeri')->assertSee('images/gallery/contoh-1.svg', false);
    }
}
