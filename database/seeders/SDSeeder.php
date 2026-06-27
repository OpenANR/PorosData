<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Instansi;
use App\Models\User;
use App\Models\Kelas;
use App\Models\Siswa;
use Illuminate\Support\Facades\Hash;

class SDSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Create SD Instansi
        $sd = Instansi::create([
            'nama_sekolah' => 'SD Negeri 01 Poros Data',
            'tingkat' => 'SD'
        ]);

        // 2. Create Teachers (Guru and Wali Kelas)
        $teachersData = [
            [
                'name' => 'Budi Santoso',
                'username' => '20072047',
                'duk' => '20072047',
                'password' => Hash::make('password123'),
                'role' => 'wali_kelas',
                'instansi_id' => $sd->id
            ],
            [
                'name' => 'Siti Aminah',
                'username' => '20091513',
                'duk' => '20091513',
                'password' => Hash::make('password123'),
                'role' => 'wali_kelas',
                'instansi_id' => $sd->id
            ],
            [
                'name' => 'Rudi Hermawan',
                'username' => '20092049',
                'duk' => '20092049',
                'password' => Hash::make('password123'),
                'role' => 'wali_kelas',
                'instansi_id' => $sd->id
            ],
            [
                'name' => 'Dewi Lestari',
                'username' => 'dewi',
                'duk' => '20112061',
                'password' => Hash::make('password123'),
                'role' => 'guru',
                'instansi_id' => $sd->id
            ]
        ];

        $teachers = [];
        foreach ($teachersData as $data) {
            $teachers[] = User::create($data);
        }

        // 3. Create Classes (Kelas 1 to Kelas 6)
        $classes = [];
        for ($i = 1; $i <= 6; $i++) {
            // Assign wali_kelas user_id if available (using first 3 teachers for classes 1-3)
            $waliKelasId = ($i <= 3) ? $teachers[$i - 1]->id : null;
            
            $classes[] = Kelas::create([
                'instansi_id' => $sd->id,
                'nama_kelas' => 'Kelas ' . $i,
                'user_id' => $waliKelasId
            ]);
        }

        // 4. Create Students (Siswa)
        $studentsData = [
            // Kelas 1
            ['name' => 'Adit Pratama', 'username' => 'adit', 'nisn' => '1000000001', 'class_index' => 0],
            ['name' => 'Bella Safitri', 'username' => 'bella', 'nisn' => '1000000002', 'class_index' => 0],
            // Kelas 2
            ['name' => 'Candra Wijaya', 'username' => 'candra', 'nisn' => '1000000003', 'class_index' => 1],
            ['name' => 'Dina Marlina', 'username' => 'dina', 'nisn' => '1000000004', 'class_index' => 1],
            // Kelas 3
            ['name' => 'Eko Prasetyo', 'username' => 'eko', 'nisn' => '1000000005', 'class_index' => 2],
            ['name' => 'Fitri Handayani', 'username' => 'fitri', 'nisn' => '1000000006', 'class_index' => 2],
            // Kelas 4
            ['name' => 'Gilang Ramadhan', 'username' => 'gilang', 'nisn' => '1000000007', 'class_index' => 3],
            ['name' => 'Hana Pertiwi', 'username' => 'hana', 'nisn' => '1000000008', 'class_index' => 3],
            // Kelas 5
            ['name' => 'Indra Lesmana', 'username' => 'indra', 'nisn' => '1000000009', 'class_index' => 4],
            ['name' => 'Julia Perez', 'username' => 'julia', 'nisn' => '1000000010', 'class_index' => 4],
            // Kelas 6
            ['name' => 'Kevin Sanjaya', 'username' => 'kevin', 'nisn' => '1000000011', 'class_index' => 5],
            ['name' => 'Larasati Wulandari', 'username' => 'laras', 'nisn' => '1000000012', 'class_index' => 5],
        ];

        foreach ($studentsData as $data) {
            // Create user
            $user = User::create([
                'name' => $data['name'],
                'username' => $data['username'],
                'password' => Hash::make('password123'),
                'role' => 'siswa',
                'instansi_id' => $sd->id
            ]);

            // Create student detail
            Siswa::create([
                'user_id' => $user->id,
                'kelas_id' => $classes[$data['class_index']]->id,
                'nisn' => $data['nisn'],
                'status' => 'aktif'
            ]);
        }
    }
}
