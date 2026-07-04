<?php

use Illuminate\Database\Migrations\Migration;
use App\Models\User;
use App\Models\MitraDudi;
use App\Models\Siswa;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Get or create Instansi (if none exists, or use first)
        $instansiId = DB::table('instansi')->first()?->id;

        // 2. Create the pembimbing "nuzulurrozaq"
        $pembimbing = User::updateOrCreate(
            ['username' => 'nuzulurrozaq'],
            [
                'name' => 'Nuzulur Rozaq',
                'password' => Hash::make('password123'),
                'role' => 'pembimbing',
                'id_pembimbing' => 'CIVIL23',
                'instansi_id' => $instansiId,
            ]
        );

        // 3. Create the Mitra DU/DI "CV. Mekar Sejahtera"
        $mitra = MitraDudi::updateOrCreate(
            ['nama_perusahaan' => 'CV. Mekar Sejahtera'],
            [
                'alamat' => 'Jl. Raya Mekar Indah No. 45, Balung',
                'koordinat' => '-8.26789, 113.62345',
            ]
        );

        // 4. Connect Pembimbing to Mitra
        DB::table('pembimbing_mitra_dudi')->updateOrInsert(
            [
                'pembimbing_id' => $pembimbing->id,
                'mitra_dudi_id' => $mitra->id,
            ],
            [
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        // 5. Connect Kevin Sanjaya (NISN: 1000000011) to the Mitra
        $kevin = Siswa::where('nisn', '1000000011')->first();
        if ($kevin) {
            $kevin->update(['mitra_dudi_id' => $mitra->id]);
        }

        // 6. Connect Larasati Wulandari (NISN: 1000000012) to the Mitra
        $laras = Siswa::where('nisn', '1000000012')->first();
        if ($laras) {
            $laras->update(['mitra_dudi_id' => $mitra->id]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $mitra = MitraDudi::where('nama_perusahaan', 'CV. Mekar Sejahtera')->first();
        if ($mitra) {
            Siswa::where('mitra_dudi_id', $mitra->id)->update(['mitra_dudi_id' => null]);
            DB::table('pembimbing_mitra_dudi')->where('mitra_dudi_id', $mitra->id)->delete();
            $mitra->delete();
        }
        User::where('username', 'nuzulurrozaq')->delete();
    }
};
