<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $kevin = \App\Models\Siswa::where('nisn', '1000000011')->first();
        $laras = \App\Models\Siswa::where('nisn', '1000000012')->first();

        if ($kevin) {
            // Seed attendance for Kevin
            \App\Models\PklAttendance::create([
                'siswa_id' => $kevin->id,
                'tanggal' => now()->subDays(2)->toDateString(),
                'status' => 'Hadir',
                'koordinat' => '-8.26780, 113.62340',
                'journal_kegiatan' => 'Belajar membuat routing API di Laravel dan memahami Controller.',
                'created_at' => now()->subDays(2)->setHour(8)->setMinute(15),
                'updated_at' => now()->subDays(2)->setHour(8)->setMinute(15),
            ]);

            \App\Models\PklAttendance::create([
                'siswa_id' => $kevin->id,
                'tanggal' => now()->subDays(1)->toDateString(),
                'status' => 'Hadir',
                'koordinat' => '-8.26785, 113.62342',
                'journal_kegiatan' => 'Membuat database migration, controller, dan view untuk data master.',
                'created_at' => now()->subDays(1)->setHour(7)->setMinute(45),
                'updated_at' => now()->subDays(1)->setHour(7)->setMinute(45),
            ]);

            \App\Models\PklAttendance::create([
                'siswa_id' => $kevin->id,
                'tanggal' => now()->toDateString(),
                'status' => 'Hadir',
                'koordinat' => '-8.26789, 113.62345',
                'journal_kegiatan' => 'Membuat fitur halaman presensi kehadiran khusus untuk role siswa.',
                'created_at' => now()->setHour(8)->setMinute(02),
                'updated_at' => now()->setHour(8)->setMinute(02),
            ]);
        }

        if ($laras) {
            // Seed attendance for Laras
            \App\Models\PklAttendance::create([
                'siswa_id' => $laras->id,
                'tanggal' => now()->subDays(2)->toDateString(),
                'status' => 'Hadir',
                'koordinat' => '-8.26792, 113.62348',
                'journal_kegiatan' => 'Melakukan setup project git repository dan kolaborasi tim.',
                'created_at' => now()->subDays(2)->setHour(8)->setMinute(30),
                'updated_at' => now()->subDays(2)->setHour(8)->setMinute(30),
            ]);

            \App\Models\PklAttendance::create([
                'siswa_id' => $laras->id,
                'tanggal' => now()->subDays(1)->toDateString(),
                'status' => 'Sakit',
                'keterangan' => 'Mengalami demam tinggi dan disarankan dokter istirahat selama 1 hari.',
                'created_at' => now()->subDays(1)->setHour(9)->setMinute(10),
                'updated_at' => now()->subDays(1)->setHour(9)->setMinute(10),
            ]);

            \App\Models\PklAttendance::create([
                'siswa_id' => $laras->id,
                'tanggal' => now()->toDateString(),
                'status' => 'Izin',
                'keterangan' => 'Izin mengurus dokumen administrasi pendaftaran beasiswa kuliah.',
                'created_at' => now()->setHour(8)->setMinute(40),
                'updated_at' => now()->setHour(8)->setMinute(40),
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $kevin = \App\Models\Siswa::where('nisn', '1000000011')->first();
        $laras = \App\Models\Siswa::where('nisn', '1000000012')->first();
        
        if ($kevin) {
            \App\Models\PklAttendance::where('siswa_id', $kevin->id)->delete();
        }
        if ($laras) {
            \App\Models\PklAttendance::where('siswa_id', $laras->id)->delete();
        }
    }
};
