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
        Schema::create('portal_nilai_nilai', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable(); // Inputting teacher (null if admin dummy or not logged user)
            $table->unsignedBigInteger('kelas_id');
            $table->unsignedBigInteger('mapel_id');
            $table->unsignedBigInteger('siswa_id');
            
            // Grades
            $table->float('tugas_1')->nullable();
            $table->float('tugas_2')->nullable();
            $table->float('asts')->nullable();
            $table->float('tugas_4')->nullable();
            $table->float('tugas_5')->nullable();
            
            // ASAS Genap
            $table->string('mode_asas')->nullable(); // 'Benar', 'Salah', 'FastTrack'
            $table->text('pg_asas')->nullable(); // '1,2,5' or 'benar semua'
            $table->string('essai_asas')->nullable(); // '8,4,8,0,2'
            $table->float('murni_asas')->nullable();
            $table->float('perbaikan')->nullable();
            
            // Final results
            $table->string('ketuntasan')->nullable(); // 'TUNTAS', 'TIDAK TUNTAS'
            $table->float('nilai_akhir')->nullable();
            
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('kelas_id')->references('id')->on('kelas')->onDelete('cascade');
            $table->foreign('mapel_id')->references('id')->on('mapel')->onDelete('cascade');
            $table->foreign('siswa_id')->references('id')->on('siswa')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('portal_nilai_nilai');
    }
};
