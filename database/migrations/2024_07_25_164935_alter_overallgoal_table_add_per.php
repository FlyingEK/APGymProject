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
        Schema::table('overall_goal', function (Blueprint $table) {
            $table->string('per'); // Adding the 'per' column with a default value
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('overall_goal', function (Blueprint $table) {
            $table->dropColumn('per');
        });
    }
};
