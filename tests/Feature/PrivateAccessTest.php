<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PrivateAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_situs_publik_kalau_token_kosong(): void
    {
        config(['app.access_token' => null]);

        $this->get('/')->assertOk();
    }

    public function test_tanpa_token_ditolak(): void
    {
        config(['app.access_token' => 'rahasia-panjang-123']);

        $this->get('/')->assertForbidden();
        $this->get('/?akses=salah')->assertForbidden();
    }

    public function test_token_benar_membuka_situs_dan_token_dibuang_dari_url(): void
    {
        config(['app.access_token' => 'rahasia-panjang-123']);

        $this->get('/?akses=rahasia-panjang-123')->assertRedirect(url('/'));
        $this->get('/')->assertOk()->assertHeader('X-Robots-Tag', 'noindex, nofollow');
    }
}
