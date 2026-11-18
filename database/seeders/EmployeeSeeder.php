<?php

namespace Database\Seeders;

use App\Models\Employee;
use Illuminate\Database\Seeder;

class EmployeeSeeder extends Seeder
{
    // Nama contoh, ganti dengan pegawai salon yang sebenarnya.
    public function run(): void
    {
        foreach (['Rina', 'Dewi', 'Sari'] as $name) {
            Employee::firstOrCreate(['name' => $name]);
        }
    }
}
