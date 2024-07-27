<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GymUserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $gymUsers = [];

        for ($i = 19; $i < 29; $i++) {
            $gymUsers[] = [
                'gym_user_id' => $i,
                'user_id' => $i
            ];
        }

        DB::table('gym_user')->insert($gymUsers);
    }
}
