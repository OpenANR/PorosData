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
        Schema::create('kategori_mapel', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kategori');
            $table->unsignedBigInteger('instansi_id')->nullable();
            $table->timestamps();

            $table->foreign('instansi_id')->references('id')->on('instansi')->onDelete('cascade');
        });

        // Seed default categories
        $instansiIds = DB::table('instansi')->pluck('id');
        
        // Seed globally
        DB::table('kategori_mapel')->insert([
            ['nama_kategori' => 'Umum', 'instansi_id' => null, 'created_at' => now(), 'updated_at' => now()],
            ['nama_kategori' => 'Matematika', 'instansi_id' => null, 'created_at' => now(), 'updated_at' => now()],
            ['nama_kategori' => 'Praktik', 'instansi_id' => null, 'created_at' => now(), 'updated_at' => now()],
        ]);
        
        // Seed for each existing instansi
        foreach ($instansiIds as $id) {
            DB::table('kategori_mapel')->insert([
                ['nama_kategori' => 'Umum', 'instansi_id' => $id, 'created_at' => now(), 'updated_at' => now()],
                ['nama_kategori' => 'Matematika', 'instansi_id' => $id, 'created_at' => now(), 'updated_at' => now()],
                ['nama_kategori' => 'Praktik', 'instansi_id' => $id, 'created_at' => now(), 'updated_at' => now()],
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kategori_mapel');
    }
};
