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
        Schema::create('workout_queue', function (Blueprint $table) {
            $table->id('workout_queue_id');
            $table->unsignedBigInteger('equipment_id');
            $table->unsignedBigInteger('gym_user_id');
            $table->integer('duration')->nullable();
            $table->integer('repetitions')->nullable();
            $table->integer('sets')->nullable();
            $table->boolean('allow_sharing')->default(false);
            $table->integer('weight')->nullable();
            $table->enum('status', ['queueing', 'reserved', 'inuse', 'completed'])->default('queueing');
            $table->timestamps();

            $table->foreign('equipment_id')->references('equipment_id')->on('equipment')->onDelete('cascade');
            $table->foreign('gym_user_id')->references('gym_user_id')->on('gym_user')->onDelete('cascade');
        });

        Schema::table('workout', function (Blueprint $table) {
            $table->unsignedBigInteger('workout_queue_id');

            // Add foreign key constraint
            $table->foreign('workout_queue_id')->references('workout_queue_id')->on('workout_queue')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('workout_queue');
        Schema::table('workout', function (Blueprint $table) {
            $table->dropForeign(['workout_queue_id']);
            $table->dropColumn('workout_queue_id');
        });
    }
};
