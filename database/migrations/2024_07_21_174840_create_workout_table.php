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
        Schema::create('workout', function (Blueprint $table) {
            $table->id('workout_id');
            $table->unsignedBigInteger('equipment_machine_id');
            $table->unsignedBigInteger('gym_user_id');
            $table->integer('duration')->nullable();
            $table->integer('set')->nullable();
            $table->integer('repetition')->nullable();
            $table->float('weight')->nullable();
            $table->date('date');
            $table->enum('status', ['in_progress', 'rest','completed', 'cancelled']); 
            $table->time('start_time');
            $table->time('estimated_end_time');
            $table->time('end_time')->nullable();
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('equipment_machine_id')->references('equipment_machine_id')->on('equipment_machine')->onDelete('cascade');
            $table->foreign('gym_user_id')->references('gym_user_id')->on('gym_user')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('workout');
    }
};
