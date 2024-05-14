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
        Schema::create('coaches_schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('coache_id')->references('id')->on('coaches');
            $table->foreignId('branch_id')->references('id')->on('branches');
            $table->foreignId('court_id')->references('id')->on('courts');
            $table->enum('week_day', ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday']);
            $table->time('from');
            $table->time('to');
            $table->timestamps();
            $table->softDeletes();
            $table->unique(['coache_id', 'branch_id', 'court_id', 'week_day', 'from', 'to', 'deleted_at'], 'unique_coache_schedule');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coaches_schedules');
    }
};
