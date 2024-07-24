<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Workout extends Model
{
    use HasFactory;
    protected $table = 'workout';
    protected $primaryKey = 'workout_id';

    protected $fillable = [
        'equipment_machine_id',
        'gym_user_id',
        'duration',
        'weight',
        'date',
        'status',
        'start_time',
        'estimated_end_time',
        'end_time',
        'workout_queue_id',
        'exceeded_time'
    ];

    public function equipmentMachine()
    {
        return $this->belongsTo(EquipmentMachine::class, 'equipment_machine_id', 'equipment_machine_id');
    }

    public function gymUser()
    {
        return $this->belongsTo(GymUser::class, 'gym_user_id', 'gym_user_id');
    }

    public function workoutQueue()
    {
        return $this->belongsTo(WorkoutQueue::class, 'workout_queue_id', 'workout_queue_id');
    }
}
