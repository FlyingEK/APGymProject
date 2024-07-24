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
        DB::statement("ALTER TABLE equipment_machine MODIFY COLUMN status ENUM('available', 'reserved', 'in use','maintenance')");

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE equipment_machine MODIFY COLUMN status ENUM('available', 'in use','maintenance')");

    }
};
