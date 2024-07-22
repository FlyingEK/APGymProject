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
        Schema::create('gym_queue', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('gym_user_id')->constrained();
            $table->enum('status', ['queueing', 'reserved', 'entered']);
            $table->string('check_in_code')->nullable()->unique();
            $table->timestamp('entered_at')->nullable();
            $table->timestamp('reserved_until')->nullable();
            $table->timestamps();

            $table->foreign('gym_user_id')->references('gym_user_id')->on('gym_user')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gym_queue');
    }
};
