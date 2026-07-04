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
        // Add password_plain column to users table
        Schema::table('users', function (Blueprint $table) {
            $table->string('password_plain')->nullable()->after('password');
        });

        // Backfill plain-text passwords for existing users
        DB::table('users')->where('username', 'superadmin')->update(['password_plain' => 'superadmin123']);
        DB::table('users')->where('username', 'admin')->update(['password_plain' => 'admin123']);
        DB::table('users')->where('username', 'siswa')->update(['password_plain' => 'siswa123']);
        DB::table('users')->where('username', 'pembimbing')->update(['password_plain' => 'pembimbing123']);
        
        // All other users (teachers, students, pembimbing nuzulurrozaq) default to 'password123'
        DB::table('users')->whereNull('password_plain')->update(['password_plain' => 'password123']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('password_plain');
        });
    }
};
