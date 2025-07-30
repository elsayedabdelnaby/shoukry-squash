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
            // Add indexes to improve performance for availability checks
            $table->index(['date', 'coach_id'], 'idx_reservations_date_coach');
            $table->index(['date', 'court_id'], 'idx_reservations_date_court');
            $table->index(['date', 'player_id'], 'idx_reservations_date_player');
            $table->index(['date', 'start_time', 'end_time'], 'idx_reservations_time_slot');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reservations', function (Blueprint $table) {
            $table->dropIndex('idx_reservations_date_coach');
            $table->dropIndex('idx_reservations_date_court');
            $table->dropIndex('idx_reservations_date_player');
            $table->dropIndex('idx_reservations_time_slot');
        });
    }
};
