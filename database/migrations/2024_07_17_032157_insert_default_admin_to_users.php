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
        DB::table('users')->insert([
            [
                'username' => 'admin',
                'first_name' => 'Admin',
                'last_name' => 'User',
                'email' => 'admin.apgym@mail.apu.edu.my',
                'password' => bcrypt('Admin1234!'), 
                'gender' => 'male',
                'role' => 'admin',
                'status' => 'active',
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'username' => 'trainerJenny',
                'first_name' => 'Jenny',
                'last_name' => 'Chew',
                'email' => 'tp001122@mail.apu.edu.my',
                'password' => bcrypt('Abc1234,'), // Make sure to hash the password
                'gender' => 'female',
                'role' => 'trainer',
                'status' => 'active',
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'username' => 'user',
                'first_name' => 'Neong',
                'last_name' => 'User',
                'email' => 'tp112233@mail.apu.edu.my',
                'password' => bcrypt('Abc1234,'), // Make sure to hash the password
                'gender' => 'female',
                'role' => 'user',
                'status' => 'active',
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('users')->whereIn('email', ['admin.apgym@mail.apu.edu.my', 'tp001122@mail.apu.edu.my', 'tp112233@mail.apu.edu.my'])->delete();
    }
};
