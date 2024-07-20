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
        Schema::table('strength_workout_habit', function (Blueprint $table) {
            $table->boolean('allow_sharing'); // Add your column definition here
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('strength_workout_habit', function (Blueprint $table) {
            $table->dropColumn('allow_sharing'); // Drop the column if rolling back
        });
    }
};
