<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed Super Administrator
        User::updateOrCreate(
            ['username' => 'superadmin'],
            [
                'name' => 'Super Administrator',
                'password' => Hash::make('superadmin123'),
                'password_plain' => 'superadmin123',
                'role' => 'superadmin',
                'instansi_id' => null
            ]
        );

        // Seed Admin
        User::updateOrCreate(
            ['username' => 'admin'],
            [
                'name' => 'Admin',
                'password' => Hash::make('admin123'),
                'password_plain' => 'admin123',
                'role' => 'admin',
                'instansi_id' => null
            ]
        );
    }
}
