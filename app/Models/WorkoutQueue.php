<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkoutQueue extends Model
{
    use HasFactory;
    protected $table = 'workout_queue';
    protected $primaryKey = 'workout_queue_id';

    protected $fillable = [
        'equipment_id',
        'gym_user_id',
        'duration',
        'repetitions',
        'sets',
        'allow_sharing',
        'weight',
        'status',
        'created_at',
        'equipment_machine_id',
    ];

    public function equipment()
    {
        return $this->belongsTo(Equipment::class, 'equipment_id', 'equipment_id');
    }

    public function gymUser()
    {
        return $this->belongsTo(GymUser::class, 'gym_user_id', 'gym_user_id');
    }

    public function workout()
    {
        return $this->hasOne(Workout::class, 'workout_queue_id', 'workout_queue_id');
    }

    public function equipmentMachine()
    {
        return $this->belongsTo(EquipmentMachine::class, 'equipment_id', 'equipment_id');
    }
}

