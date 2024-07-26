<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('achievement', function (Blueprint $table) {
            $table->dropColumn('condition_type');
            $table->dropColumn('condition_value');

        });
    }

    public function down(): void
    {
        Schema::table('achievement', function (Blueprint $table) {
            $table->string('condition_type');
            $table->string('condition_value')->nullable();
        });
    }
};
