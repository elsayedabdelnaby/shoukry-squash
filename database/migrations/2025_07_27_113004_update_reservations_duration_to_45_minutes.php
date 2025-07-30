<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Update all existing reservations to have 45-minute duration
        DB::table('reservations')->update([
            'duration_minutes' => 45
        ]);

        // Update end times to be exactly 45 minutes after start time
        $reservations = DB::table('reservations')->get();
        
        foreach ($reservations as $reservation) {
            $startTime = Carbon::parse($reservation->start_time);
            $endTime = $startTime->copy()->addMinutes(45);
            
            DB::table('reservations')
                ->where('id', $reservation->id)
                ->update([
                    'end_time' => $endTime->format('H:i:s')
                ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // This migration is not reversible as we don't store the original values
        // In a real scenario, you might want to add a backup column before making changes
    }
};
