<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EquipmentMachineTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $machines = [];

        $equipmentDetails = [
            ['name' => 'Shoulder Press Machine', 'category' => 'upper body machines'],
            ['name' => 'Bicep Curl Machine', 'category' => 'upper body machines'],
            ['name' => 'Chest Press Machine', 'category' => 'upper body machines'],
            ['name' => 'Leg Extension Machine', 'category' => 'leg machines'],
            ['name' => 'Tricep Dip Machine', 'category' => 'upper body machines'],
            ['name' => 'Multiple Purpose', 'category' => 'upper body machines'],
            ['name' => 'Seated Row Machine', 'category' => 'upper body machines'],
            ['name' => 'Pec Deck Machine', 'category' => 'upper body machines'],
            ['name' => 'Smith Machine', 'category' => 'free weights'],
            ['name' => 'Hack Squat Machine', 'category' => 'leg machines']
        ];

        for ($i = 11; $i <= 20; $i++) {
            $labelPrefix = $this->generateLabelPrefix($equipmentDetails[$i-1-10]['name']);

            $machines[] = [
                'equipment_machine_id' => ($i - 1) * 3, // Ensuring unique ID for each machine
                'label' => $labelPrefix . 01,
                'status' => 'available',
                'equipment_id' => $i,
                'created_at' => now()->subDays(rand(1, 1000)),
                'updated_at' => now()->subDays(rand(1, 1000))
            ];
            
        }

        DB::table('equipment_machine')->insert($machines);

    }

    private function generateLabelPrefix($name)
    {
        $abbreviation = '';
        foreach (explode(' ', $name) as $word) {
            $abbreviation .= strtoupper($word[0]);
        }
        return $abbreviation;
    }
}
