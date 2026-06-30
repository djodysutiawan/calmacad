<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Akun admin
        User::updateOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Admin Sistem Pakar',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'email_verified_at' => now(),
            ]
        );

        // 30 nama mahasiswa Indonesia
        $names = [
            'Ahmad Fauzi',
            'Siti Nurhaliza',
            'Muhammad Rizky Pratama',
            'Dewi Lestari',
            'Bayu Setiawan',
            'Putri Ayu Wulandari',
            'Andi Saputra',
            'Rina Marlina',
            'Fajar Ramadhan',
            'Indah Permatasari',
            'Dimas Aditya',
            'Wulan Sari',
            'Eko Prasetyo',
            'Nadia Anggraini',
            'Rian Hidayat',
            'Lestari Wulandari',
            'Agus Salim',
            'Yuni Kartika',
            'Hendra Gunawan',
            'Sri Wahyuni',
            'Taufik Hidayat',
            'Mega Puspita',
            'Arif Budiman',
            'Citra Dewi',
            'Yoga Pratama',
            'Fitriani Anggraeni',
            'Doni Setiawan',
            'Maya Sari Dewi',
            'Irfan Maulana',
            'Anisa Rahmawati',
        ];

        foreach ($names as $index => $name) {
            $emailSlug = Str::slug($name, '.');
            $email = $emailSlug.($index + 1).'@gmail.com';

            User::updateOrCreate(
                ['email' => $email],
                [
                    'name' => $name,
                    'password' => Hash::make('password'),
                    'role' => 'user',
                    'email_verified_at' => now(),
                ]
            );
        }
    }
}