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
        Schema::create('goal', function (Blueprint $table) {
            $table->id('goal_id');
            $table->foreignId('gym_user_id')->constrained('gym_user', 'gym_user_id'); // Specify the primary key column of gym_users
            $table->date('start_date');
            $table->enum('status',['active','completed','failed']);
            $table->timestamps();
        });

        Schema::create('overall_goal', function (Blueprint $table) {
            $table->foreignId('goal_id')->constrained('goal','goal_id')->onDelete('cascade')->onDelete('cascade')->primary();
            $table->integer('workout_hour');
            $table->date('target_date');
            $table->timestamps();
        });

        Schema::create('strength_equipment_goal', function (Blueprint $table) {
            $table->foreignId('goal_id')->constrained('goal','goal_id')->onDelete('cascade')->onDelete('cascade')->primary();
            $table->foreignId('equipment_id')->constrained('equipment','equipment_id');
            $table->integer('weight');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('overall_goal');
        Schema::dropIfExists('strength_equipment_goal');
        Schema::dropIfExists('goal');


    }
};
