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
            // Add unique constraint to prevent double bookings
            // A coach cannot be booked at the same time on the same date
            // Note: This only prevents exact time matches, overlapping times are handled by application logic
            $table->unique(['date', 'start_time', 'end_time', 'coach_id'], 'unique_coach_time_slot');
            
            // A court cannot be booked at the same time on the same date
            $table->unique(['date', 'start_time', 'end_time', 'court_id'], 'unique_court_time_slot');
            
            // A player cannot be booked at the same time on the same date
            $table->unique(['date', 'start_time', 'end_time', 'player_id'], 'unique_player_time_slot');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reservations', function (Blueprint $table) {
            $table->dropUnique('unique_coach_time_slot');
            $table->dropUnique('unique_court_time_slot');
            $table->dropUnique('unique_player_time_slot');
        });
    }
};
