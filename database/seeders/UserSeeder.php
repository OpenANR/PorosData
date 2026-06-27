<?php

namespace Database\Seeders;

use App\Models\Instansi;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Super Administrator',
            'username' => 'superadmin',
            'password' => Hash::make('superadmin123'),
            'role' => 'superadmin',
            'instansi_id' => null
        ]);

        $sekolah = Instansi::create([
            'nama_sekolah' => 'SMK Teknologli Balung',
            'tingkat' => 'SMK'
        ]);

        User::create([
            'name' => 'Admin',
            'username' => 'admin',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'instansi_id' => $sekolah->id
        ]);
    }
}
