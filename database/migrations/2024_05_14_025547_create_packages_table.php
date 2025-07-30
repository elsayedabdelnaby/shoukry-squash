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
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('breif');
            $table->smallInteger('sessions_per_week');
            $table->decimal('price_egyptian', 8, 2);
            $table->decimal('price_other', 8, 2);
            $table->enum('type', ['Team', 'Academy', 'Pre-Team']);
            $table->decimal('one_month_price', 8, 2);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('packages');
    }
};
