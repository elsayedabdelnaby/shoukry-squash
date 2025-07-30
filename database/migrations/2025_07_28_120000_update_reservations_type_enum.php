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
        Schema::table('reservations', function (Blueprint $table) {
            // Drop the existing enum and recreate it with new values
            $table->enum('type', [
                'private_session', 
                'team_training', 
                'match_play', 
                'court_rent',
                'package_session' // Generic package session type
            ])->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reservations', function (Blueprint $table) {
            $table->enum('type', [
                'private_session', 
                'team_training', 
                'match_play', 
                'court_rent'
            ])->change();
        });
    }
}; 