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
        Schema::create('achievement', function (Blueprint $table) {
            $table->id('achievement_id');
            $table->string('condition');
            $table->string('image');
            $table->timestamps();
        });

        Schema::create('gym_user_achievement', function (Blueprint $table) {
            $table->unsignedBigInteger('achievement_id');
            $table->unsignedBigInteger('gym_user_id');
            $table->timestamps();

            $table->primary(['achievement_id', 'gym_user_id']);
            $table->foreign('achievement_id')->references('achievement_id')->on('achievement')->onDelete('cascade');
            $table->foreign('gym_user_id')->references('gym_user_id')->on('gym_user')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('achievement');
        Schema::dropIfExists('gym_user_achievement');

    }
};
