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
        // Add id_pembimbing to users table
        Schema::table('users', function (Blueprint $table) {
            $table->string('id_pembimbing')->nullable()->unique()->after('instansi_id');
        });

        // Create pivot table for Pembimbing (users) and Mitra DUDI
        Schema::create('pembimbing_mitra_dudi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pembimbing_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('mitra_dudi_id')->constrained('mitra_dudi')->cascadeOnDelete();
            $table->timestamps();

            // Prevent duplicate records
            $table->unique(['pembimbing_id', 'mitra_dudi_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembimbing_mitra_dudi');

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('id_pembimbing');
        });
    }
};
