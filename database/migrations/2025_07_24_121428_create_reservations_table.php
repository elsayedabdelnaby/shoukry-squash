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
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('player_id')->constrained('players')->onDelete('cascade');
            $table->foreignId('coach_id')->nullable()->constrained('coaches')->onDelete('set null');
            $table->foreignId('court_id')->nullable()->constrained('courts')->onDelete('set null');
            $table->foreignId('branch_id')->nullable()->constrained('branches')->onDelete('set null');
            $table->foreignId('package_id')->nullable()->constrained('packages')->onDelete('set null');
            $table->enum('type', ['private_session', 'team_training', 'match_play', 'court_rent']);
            $table->date('date');
            $table->time('start_time');
            $table->time('end_time');
            $table->integer('duration_minutes')->nullable();
            $table->decimal('price', 8, 2)->nullable();
            $table->enum('payment_method', ['visa', 'fawry', 'cash', 'transfer'])->nullable();
            $table->string('payment_document')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
