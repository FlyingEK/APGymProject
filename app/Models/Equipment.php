<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Equipment extends Model
{
    use HasFactory;

    // Define the table name if it's not the default "equipments"
    protected $table = 'equipment';

    // Define the primary key if it's not the default "id"
    protected $primaryKey = 'equipment_id';

    // Define the fillable fields
    protected $fillable = [
        'name',
        'description',
        'has_weight',
        'image',
        'tutorial_youtube',
        'quantity',
        'category',
    ];

    // If there are any relationships, define them here
    public function equipmentMachines()
    {
        return $this->hasMany(EquipmentMachine::class, 'equipment_id', 'equipment_id');
    }

    public function tutorials()
    {
        return $this->hasMany(Tutorial::class, 'equipment_id', 'equipment_id');
    }

    public function workoutHabits()
    {
        return $this->hasMany(WorkoutHabit::class, 'equipment_id', 'equipment_id');
    }

    public function strengthWorkoutHabits()
    {
        return $this->hasManyThrough(StrengthWorkoutHabit::class, WorkoutHabit::class, 'equipment_id', 'workout_habit_id', 'equipment_id', 'id');
    }

    public function cardioWorkoutHabits()
    {
        return $this->hasManyThrough(CardioWorkoutHabit::class, WorkoutHabit::class, 'equipment_id', 'workout_habit_id', 'equipment_id', 'id');
    }

    public function workoutQueue()
    {
        return $this->hasMany(WorkoutQueue::class, 'equipment_id', 'equipment_id');
    }

    public static function getAllowSharingEquipment()
    {
        $query = "
        SELECT 
            equipment.*,
            equipment_machine.*
        FROM 
            equipment
        JOIN 
            equipment_machine ON equipment.equipment_id = equipment_machine.equipment_id
        WHERE 
            NOT EXISTS (
                SELECT 1
                FROM equipment_machine em
                WHERE equipment.equipment_id = em.equipment_id
                AND em.status = 'available'
            )
        AND 
            EXISTS (
                SELECT 1
                FROM equipment_machine em
                WHERE equipment.equipment_id = em.equipment_id
                AND em.status = 'in use'
                AND EXISTS (
                    SELECT 1
                    FROM workout w
                    WHERE em.equipment_machine_id = w.equipment_machine_id
                    AND w.status IN ('in_progress', 'in_use')
                    AND EXISTS (
                        SELECT 1
                        FROM workout_queue wq
                        WHERE w.workout_queue_id = wq.workout_queue_id
                        AND wq.allow_sharing = 1
                    )
                )
                AND (
                    SELECT COUNT(*)
                    FROM workout w
                    WHERE em.equipment_machine_id = w.equipment_machine_id
                    AND w.status = 'in_progress'
                ) < 2
            )
        AND
            EXISTS (
                SELECT 1
                FROM equipment_machine em
                WHERE equipment.equipment_id = em.equipment_id
                AND em.status = 'in use'
                AND EXISTS (
                    SELECT 1
                    FROM workout_queue wq
                    WHERE em.equipment_machine_id = wq.equipment_machine_id
                    AND wq.allow_sharing = 1
                )
            )
        ";
    

        $equipments = DB::select($query);

        return $equipments;
    }
}
