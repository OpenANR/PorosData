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
        Schema::table('siswa', function (Blueprint $table) {
            // Data Pribadi Akademik
            $table->string('angkatan')->nullable();
            $table->string('jurusan')->nullable();
            $table->string('nama_panggilan')->nullable();
            $table->enum('jenis_kelamin', ['Laki-laki', 'perempuan'])->nullable();
            $table->string('tempat_lahir')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->string('agama')->nullable();
            $table->string('kewarganegaraan')->nullable();
            $table->text('alamat_lengkap')->nullable();
            $table->string('nomor_telepon')->nullable();
            $table->integer('tinggi_badan')->nullable();
            $table->integer('berat_badan')->nullable();

            // Data Keluarga
            $table->string('anak_ke')->nullable();
            $table->integer('jumlah_saudara_kandung')->nullable();
            $table->enum('status_yatim_piatu', ['Lengkap', 'Yatim', 'Piatu', 'Yatim Piatu'])->nullable();
            $table->string('tinggal_dengan')->nullable();
            $table->string('nama_ayah')->nullable();
            $table->string('pekerjaan_ayah')->nullable();
            $table->string('nomor_hp_ayah')->nullable();
            $table->string('nama_ibu')->nullable();
            $table->string('pekerjaan_ibu')->nullable();
            $table->string('nomor_hp_ibu')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('siswa', function (Blueprint $table) {
            $table->dropColumn([
                'angkatan',
                'jurusan',
                'nama_panggilan',
                'jenis_kelamin',
                'tempat_lahir',
                'tanggal_lahir',
                'agama',
                'kewarganegaraan',
                'alamat_lengkap',
                'nomor_telepon',
                'tinggi_badan',
                'berat_badan',
                'anak_ke',
                'jumlah_saudara_kandung',
                'status_yatim_piatu',
                'tinggal_dengan',
                'nama_ayah',
                'pekerjaan_ayah',
                'nomor_hp_ayah',
                'nama_ibu',
                'pekerjaan_ibu',
                'nomor_hp_ibu',
            ]);
        });
    }
};
