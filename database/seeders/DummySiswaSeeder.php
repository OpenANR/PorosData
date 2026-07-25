<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Siswa;
use App\Models\Kelas;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Hash;

class DummySiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('id_ID');
        $kelases = Kelas::with('jurusan')->get();

        $agamas = ['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu'];

        foreach ($kelases as $kelas) {
            // Kita buat 10-15 siswa per kelas untuk random
            $jumlahSiswa = rand(10, 15);

            // Tentukan angkatan berdasarkan tingkat kelas (X, XI, XII)
            $tingkat = explode(' - ', $kelas->nama_kelas)[0];
            $angkatan = match($tingkat) {
                'X' => '2026',
                'XI' => '2025',
                'XII' => '2024',
                default => '2026'
            };

            for ($i = 0; $i < $jumlahSiswa; $i++) {
                $jenisKelamin = $faker->randomElement(['Laki-laki', 'perempuan']);
                $firstName = $jenisKelamin == 'Laki-laki' ? $faker->firstNameMale : $faker->firstNameFemale;
                $lastName = $jenisKelamin == 'Laki-laki' ? $faker->lastNameMale : $faker->lastNameFemale;
                $fullName = $firstName . ' ' . $lastName;
                
                $nisn = $faker->unique()->numerify('##########');

                // Create User first
                $user = User::create([
                    'instansi_id' => $kelas->instansi_id ?? 1,
                    'name' => $fullName,
                    'username' => $nisn,
                    'password' => Hash::make('password123'), // Default password
                    'role' => 'siswa',
                ]);

                // Update users with password_plain if it exists (from migration 2026_07_04_121500_add_password_plain_to_users_table)
                // We'll just try to update if it's there, but to be safe we can use query builder or just check schema
                try {
                    $user->password_plain = 'password123';
                    $user->save();
                } catch (\Exception $e) {
                    // Ignore if column doesn't exist
                }

                // Create Siswa
                Siswa::create([
                    'user_id' => $user->id,
                    'kelas_id' => $kelas->id,
                    'nisn' => $nisn,
                    'status' => 'aktif',
                    'angkatan' => $angkatan,
                    'jurusan' => $kelas->jurusan ? $kelas->jurusan->nama_jurusan : null,
                    'nama_panggilan' => $firstName,
                    'jenis_kelamin' => $jenisKelamin,
                    'tempat_lahir' => $faker->city,
                    'tanggal_lahir' => $faker->dateTimeBetween('-18 years', '-15 years')->format('Y-m-d'),
                    'agama' => $faker->randomElement($agamas),
                    'kewarganegaraan' => 'WNI',
                    'alamat_lengkap' => $faker->address,
                    'nomor_telepon' => $faker->phoneNumber,
                    'tinggi_badan' => $faker->numberBetween(150, 180),
                    'berat_badan' => $faker->numberBetween(40, 80),
                    'anak_ke' => (string) $faker->numberBetween(1, 4),
                    'jumlah_saudara_kandung' => $faker->numberBetween(0, 5),
                    'status_yatim_piatu' => 'Lengkap',
                    'tinggal_dengan' => 'Orang Tua',
                    'nama_ayah' => $faker->name('male'),
                    'pekerjaan_ayah' => $faker->jobTitle,
                    'nomor_hp_ayah' => $faker->phoneNumber,
                    'nama_ibu' => $faker->name('female'),
                    'pekerjaan_ibu' => $faker->jobTitle,
                    'nomor_hp_ibu' => $faker->phoneNumber,
                ]);
            }
        }
    }
}
