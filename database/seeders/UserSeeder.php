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
            'password_plain' => 'superadmin123',
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
            'password_plain' => 'admin123',
            'role' => 'admin',
            'instansi_id' => $sekolah->id
        ]);

        // Dummy Class for SMK
        $kelas = \App\Models\Kelas::create([
            'instansi_id' => $sekolah->id,
            'nama_kelas' => 'XII TKJ 1',
            'user_id' => null
        ]);

        // Dummy Siswa
        $siswaUser = User::create([
            'name' => 'Siswa PKL Dummy',
            'username' => 'siswa',
            'password' => Hash::make('siswa123'),
            'password_plain' => 'siswa123',
            'role' => 'siswa',
            'instansi_id' => $sekolah->id
        ]);

        \App\Models\Siswa::create([
            'user_id' => $siswaUser->id,
            'kelas_id' => $kelas->id,
            'nisn' => '1234567890',
            'status' => 'aktif'
        ]);

        // Dummy Pembimbing
        User::create([
            'name' => 'Pembimbing PKL Dummy',
            'username' => 'pembimbing',
            'password' => Hash::make('pembimbing123'),
            'password_plain' => 'pembimbing123',
            'role' => 'pembimbing',
            'instansi_id' => $sekolah->id
        ]);
    }
}
