<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('portal_nilai_settings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('instansi_id')->nullable();
            $table->dateTime('tugas_buka')->nullable();
            $table->dateTime('tugas_tutup')->nullable();
            $table->dateTime('asas_buka')->nullable();
            $table->dateTime('asas_tutup')->nullable();
            $table->timestamps();

            $table->foreign('instansi_id')->references('id')->on('instansi')->onDelete('cascade');
        });

        // Insert initial global default settings
        DB::table('portal_nilai_settings')->insert([
            'instansi_id' => null,
            'tugas_buka' => '2024-01-01 00:00:00',
            'tugas_tutup' => '2030-12-31 23:59:00',
            'asas_buka' => '2024-01-01 00:00:00',
            'asas_tutup' => '2030-12-31 23:59:00',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Insert settings for each existing instansi
        $instansiIds = DB::table('instansi')->pluck('id');
        foreach ($instansiIds as $id) {
            DB::table('portal_nilai_settings')->insert([
                'instansi_id' => $id,
                'tugas_buka' => '2024-01-01 00:00:00',
                'tugas_tutup' => '2030-12-31 23:59:00',
                'asas_buka' => '2024-01-01 00:00:00',
                'asas_tutup' => '2030-12-31 23:59:00',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('portal_nilai_settings');
    }
};
