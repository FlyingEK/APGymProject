<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StrengthEquipmentGoal extends Model
{
    use HasFactory;
    protected $table = 'strength_equipment_goal';
    protected $primaryKey = 'goal_id';
    protected $fillable = ['goal_id', 'equipment_id','weight'];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    public function goal()
    {
        return $this->belongsTo(Goal::class, 'goal_id', 'goal_id');
    }

    public function equipment()
    {
        return $this->belongsTo(Equipment::class, 'equipment_id', 'equipment_id');
    }

}
