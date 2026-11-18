<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $password = config('salon.admin.password');

        if (! $password || (app()->isProduction() && $password === 'ganti-password-ini')) {
            $this->command->error('Isi ADMIN_PASSWORD di .env dengan password sendiri, admin tidak dibuat.');

            return;
        }

        // forceFill karena is_admin sengaja tidak masuk $fillable
        User::firstOrNew(['email' => config('salon.admin.email')])
            ->forceFill([
                'name' => config('salon.admin.name'),
                'password' => $password,
                'is_admin' => true,
            ])
            ->save();
    }
}
