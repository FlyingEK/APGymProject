<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('gym_user', function (Blueprint $table) {
            $table->id('gym_user_id');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');
        });

        Schema::create('issue', function (Blueprint $table) {
            $table->id('issue_id');
            $table->string('title');
            $table->enum('type', ['equipment', 'gym', 'other']);
            $table->unsignedBigInteger('equipment_machine_id')->nullable();
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->enum('status', ['pending', 'reported', 'rejected', 'resolved','cancelled'])->default('pending');
            $table->timestamps();
            $table->unsignedBigInteger('created_by');

            // Foreign key constraints
            $table->foreign('equipment_machine_id')->references('equipment_machine_id')->on('equipment_machine')->onDelete('cascade');
            $table->foreign('created_by')->references('gym_user_id')->on('gym_user')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('issues');
        Schema::dropIfExists('gym_users');
    }
};
