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
    public function up()
    {
        Schema::table('equipment_machine', function (Blueprint $table) {
            // Using raw SQL to modify the ENUM type to add 'maintenance'
            DB::statement("ALTER TABLE equipment_machine MODIFY COLUMN status ENUM('available', 'in use', 'maintenance') DEFAULT 'available'");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('equipment_machine', function (Blueprint $table) {
            // Revert the ENUM type change if rolling back
            DB::statement("ALTER TABLE equipment_machine MODIFY COLUMN status ENUM('available', 'in use') DEFAULT 'available'");
        });
    }
};
