<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;


return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('workout_queue', function (Blueprint $table) {
            $table->unsignedBigInteger('equipment_machine_id')->nullable();

            // Set the foreign key constraint
            $table->foreign('equipment_machine_id')
                  ->references('equipment_machine_id')
                  ->on('equipment_machine')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('workout_queue', function (Blueprint $table) {
            // Drop the foreign key constraint
            $table->dropForeign(['equipment_machine_id']);

            // Drop the column
            $table->dropColumn('equipment_machine_id');
        });
    }
};
