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
        Schema::create('equipment', function (Blueprint $table) {
            $table->id('equipment_id');
            $table->string('name');
            $table->text('description')->nullable();
            $table->boolean('has_weight');
            $table->string('image')->nullable();
            $table->string('tutorial_youtube', 2083)->nullable();
            $table->integer('quantity');
            $table->timestamps();
        });

        Schema::create('equipment_machine', function (Blueprint $table) {
            $table->id('equipment_machine_id');
            $table->string('label');
            $table->enum('status', ['available', 'in use'])->default('available');
            $table->unsignedBigInteger('equipment_id');
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('equipment_id')->references('equipment_id')->on('equipment')->onDelete('cascade');
        });

        Schema::create('tutorial', function (Blueprint $table) {
            $table->id('tutorial_id');
            $table->string('instruction', 500);
            $table->unsignedBigInteger('equipment_id');
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('equipment_id')->references('equipment_id')->on('equipment')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tutorial');
        Schema::dropIfExists('equipment_machine');
        Schema::dropIfExists('equipment');
    }
};
