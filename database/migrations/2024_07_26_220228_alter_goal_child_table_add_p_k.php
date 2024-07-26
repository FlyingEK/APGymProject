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
            // Add a composite primary key to 'column1' and 'column2'
            $table->primary('goal_id');
        });

        Schema::table('strength_equipment_goal', function (Blueprint $table) {
            // Add a composite primary key to 'column1' and 'column2'
            $table->primary('goal_id');
        });

        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('overall_goal', function (Blueprint $table) {
            // Drop the primary key
            $table->dropPrimary(['goal_id']);
        });
        Schema::table('strength_equipment_goal', function (Blueprint $table) {
            // Drop the primary key
            $table->dropPrimary(['goal_id']);
        });
    }
};
