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
        Schema::create('workout_habit', function (Blueprint $table) {
            $table->id('workout_habit_id');
            $table->unsignedBigInteger('gym_user_id');
            $table->unsignedBigInteger('equipment_id');
            
            $table->unique(['gym_user_id', 'equipment_id']);
            $table->foreign('gym_user_id')->references('gym_user_id')->on('gym_user')->onDelete('cascade');
            $table->foreign('equipment_id')->references('equipment_id')->on('equipment')->onDelete('cascade');
        });

        Schema::create('strength_workout_habit', function (Blueprint $table) {
            $table->id('strength_workout_habit_id');
            $table->unsignedBigInteger('workout_habit_id');
            $table->integer('set');
            $table->integer('repetition');
            $table->float('weight');
            $table->timestamps();

            $table->foreign('workout_habit_id')->references('workout_habit_id')->on('workout_habit')->onDelete('cascade');
        });

        Schema::create('cardio_workout_habit', function (Blueprint $table) {
            $table->id('cardio_workout_habit_id');
            $table->unsignedBigInteger('workout_habit_id');
            $table->integer('duration');
            $table->timestamps();

            $table->foreign('workout_habit_id')->references('workout_habit_id')->on('workout_habit')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cardio_workout_habit');
        Schema::dropIfExists('strength_workout_habit');
        Schema::dropIfExists('workout_habit');    }
};
