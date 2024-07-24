<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EquipmentMachine extends Model
{
    use HasFactory;

    protected $table = 'equipment_machine';
    protected $primaryKey = 'equipment_machine_id';

    protected $fillable = [
        'label',
        'status',
        'equipment_id',
    ];

    public function equipment()
    {
        return $this->belongsTo(Equipment::class, 'equipment_id', 'equipment_id');
    }

    public function workout()
    {
        return $this->hasMany(Workout::class, 'equipment_machine_id', 'equipment_machine_id');
    }

    public function workoutQueues()
    {
        return $this->hasMany(WorkoutQueue::class, 'equipment_machine_id', 'equipment_machine_id');
    }
}
