<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminGalleryTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_dapat_mengunggah_dan_menghapus_foto(): void
    {
        Storage::fake('public');
        $admin = User::factory()->admin()->create();
        $photo = UploadedFile::fake()->image('hasil-rias.jpg');

        $this->actingAs($admin)
            ->post(route('admin.gallery.store'), [
                'title' => 'Hasil rias pengantin',
                'photo' => $photo,
            ])
            ->assertRedirect(route('admin.gallery.index'))
            ->assertSessionHas('success');

        $this->assertDatabaseHas('gallery_photos', ['title' => 'Hasil rias pengantin']);

        $galleryPhoto = \App\Models\GalleryPhoto::first();
        Storage::disk('public')->assertExists($galleryPhoto->path);

        $this->actingAs($admin)
            ->delete(route('admin.gallery.destroy', $galleryPhoto))
            ->assertRedirect(route('admin.gallery.index'));

        $this->assertDatabaseMissing('gallery_photos', ['id' => $galleryPhoto->id]);
        Storage::disk('public')->assertMissing($galleryPhoto->path);
    }

    public function test_user_biasa_tidak_bisa_mengunggah_foto(): void
    {
        Storage::fake('public');

        $this->actingAs(User::factory()->create())
            ->post(route('admin.gallery.store'), [
                'title' => 'Foto',
                'photo' => UploadedFile::fake()->image('foto.jpg'),
            ])
            ->assertForbidden();

        $this->assertDatabaseCount('gallery_photos', 0);
    }
}
