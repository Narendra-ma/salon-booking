<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    // Data awal. Ubah nama, durasi, dan harga lewat panel admin.
    public function run(): void
    {
        $services = [
            ['Rias Wedding', 'Tata rias pengantin untuk tampil cantik dan percaya diri di hari bahagia.', 180, 1500000],
            ['Creambath', 'Perawatan rambut dengan krim dan pijat kepala untuk merawat dan menenangkan.', 60, 120000],
            ['Facial', 'Perawatan wajah untuk membersihkan dan menyegarkan kulit.', 60, 150000],
            ['Nail Gel', 'Perawatan kuku dengan hasil kuku gel yang rapi dan tahan lama.', 90, 200000],
            ['Eyelash Extension', 'Pemasangan bulu mata ekstensi untuk tampilan mata yang lebih cantik.', 90, 250000],
        ];

        foreach ($services as [$name, $description, $duration, $price]) {
            Service::updateOrCreate(
                ['name' => $name],
                ['description' => $description, 'duration_minutes' => $duration, 'price' => $price, 'is_active' => true],
            );
        }

        Service::whereNotIn('name', array_column($services, 0))->update(['is_active' => false]);
    }
}
