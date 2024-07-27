<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class EquipmentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $equipments = [];

        $equipmentDetails = [
            ['name' => 'Shoulder Press Machine', 'category' => 'upper body machines'],
            ['name' => 'Bicep Curl Machine', 'category' => 'upper body machines'],
            ['name' => 'Chest Press Machine', 'category' => 'upper body machines'],
            ['name' => 'Leg Extension Machine', 'category' => 'leg machines'],
            ['name' => 'Tricep Dip Machine', 'category' => 'upper body machines'],
            ['name' => 'Multi-Purpose Machine', 'category' => 'upper body machines'],
            ['name' => 'Seated Row Machine', 'category' => 'upper body machines'],
            ['name' => 'Pec Deck Machine', 'category' => 'upper body machines'],
            ['name' => 'Smith Machine', 'category' => 'free weights'],
            ['name' => 'Hack Squat Machine', 'category' => 'leg machines']
        ];

        for ($i = 11; $i <= 20; $i++) {
            
            $equipments[] = [
                'equipment_id' => $i,
                'name' => $equipmentDetails[$i-11]['name'],
                'description' => $this->generateDescription($equipmentDetails[$i-11]['name']),
                'has_weight' => in_array($equipmentDetails[$i-11]['category'], ['free weights', 'upper body machines', 'leg machines']) ? 1 : 0,
                'category' => $equipmentDetails[$i-11]['category'],
                'image' => 'img/equipment/unQY8xGLsQ1HwcOLLz77ku0mlPl8Q926o2ijvbNQ.jpg',
                'tutorial_youtube' => 'https://www.youtube.com/watch?v=' . Str::random(10),
                'quantity' => 1,
                'created_at' => now()->subDays(rand(1, 1000)),
                'is_deleted' => 0,
                'updated_at' => now()->subDays(rand(1, 1000))
            ];
        }

        DB::table('equipment')->insert($equipments);
    }

    private function generateDescription($name)
    {
        $descriptions = [
            'Shoulder Press Machine' => 'Targets the deltoid muscles for upper body strength training.',
            'Bicep Curl Machine' => 'Focuses on the biceps for arm muscle development.',
            'Chest Press Machine' => 'Works the pectoral muscles for chest strength.',
            'Leg Extension Machine' => 'Strengthens the quadriceps for leg muscle building.',
            'Tricep Dip Machine' => 'Isolates the triceps for upper arm workouts.',
            'Multi-Purpose Machine' => 'A versatile machine designed for a variety of workouts, targeting multiple muscle groups.',
            'Seated Row Machine' => 'Targets the back muscles for upper body conditioning.',
            'Pec Deck Machine' => 'Focuses on the chest muscles for muscle toning.',
            'Smith Machine' => 'Versatile equipment for various strength training exercises.',
            'Hack Squat Machine' => 'Works the leg muscles, particularly the quadriceps and glutes.'
        ];
        return $descriptions[$name];
    }
}
