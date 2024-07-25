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
            $table->integer('progress')->default(0)->after('target_date');
        });

        Schema::table('strength_equipment_goal', function (Blueprint $table) {
            $table->integer('progress')->default(0)->after('weight');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('overall_goal', function (Blueprint $table) {
            $table->dropColumn('progress');
        });

        Schema::table('strength_equipment_goal', function (Blueprint $table) {
            $table->dropColumn('progress');
        });
    }
};
