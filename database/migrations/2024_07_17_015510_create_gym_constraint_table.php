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
        // Create gym_constraint table
        Schema::create('gym_constraint', function (Blueprint $table) {
            $table->id('constraint_id');
            $table->string('constraint_name');
            $table->string('constraint_value');
            $table->timestamps();
        });

        DB::table('gym_constraint')->insert([
            [
                'constraint_name' => 'max_in_gym_users',
                'constraint_value' => '15'
            ],
            [
                'constraint_name' => 'max_weight_equipment_usage_time',
                'constraint_value' => '30'
            ],
            [
                'constraint_name' => 'max_cardio_equipment_usage_time',
                'constraint_value' => '60'
            ],
            [
                'constraint_name' => 'opening_time',
                'constraint_value' => '09:00'
            ],
            [
                'constraint_name' => 'closing_time',
                'constraint_value' => '21:00'
            ]
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gym_constraint');
    }
};
