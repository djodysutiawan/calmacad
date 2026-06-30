<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin manual
        User::updateOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Admin Sistem Pakar',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'email_verified_at' => now(),
            ]
        );

        $this->call([
            UserSeeder::class,
            TingkatStresSeeder::class,
            GejalaSeeder::class,
            RekomendasiSeeder::class,
            PlaylistSeeder::class,
        ]);
    }
}