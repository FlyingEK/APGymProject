<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [];

        for ($i = 18; $i <= 28; $i++) {
            $users[] = [
                'username' => 'user' . $i,
                'first_name' => $this->randomFirstName(),
                'last_name' => $this->randomLastName(),
                'email' => 'user' . $i . '@mail.apu.edu.my',
                'email_verified_at' => now(),
                'password' => Hash::make('Abc1234,'),
                'gender' => $i % 2 == 0 ? 'female' : 'male',
                'role' => 'user',
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now()
            ];
        }

        DB::table('users')->insert($users);
    }

    private function randomFirstName()
    {
        $firstNames = ['John', 'Jane', 'Jim', 'Jill', 'Jack', 'Jenny', 'Jeff', 'Julie', 'Joe', 'Jessica'];
        return $firstNames[array_rand($firstNames)];
    }

    private function randomLastName()
    {
        $lastNames = ['Doe', 'Smith', 'Brown', 'Johnson', 'Williams', 'Jones', 'Davis', 'Garcia', 'Martinez', 'Wilson'];
        return $lastNames[array_rand($lastNames)];
    }
    
}
