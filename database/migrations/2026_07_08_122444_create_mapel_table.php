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
        Schema::create('mapel', function (Blueprint $table) {
            $table->id();
            $table->string('kode_mapel');
            $table->string('nama_mapel');
            $table->unsignedBigInteger('kategori_mapel_id');
            $table->unsignedBigInteger('instansi_id')->nullable();
            $table->timestamps();

            $table->foreign('kategori_mapel_id')->references('id')->on('kategori_mapel')->onDelete('cascade');
            $table->foreign('instansi_id')->references('id')->on('instansi')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mapel');
    }
};
