<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Goal extends Model
{
    use HasFactory;
    protected $table = 'goal';
    protected $primaryKey = 'goal_id';
    protected $fillable = ['gym_user_id', 'start_date', 'status','start_date'];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    public function gymUser()
    {
        return $this->belongsTo(GymUser::class, 'gym_user_id', 'gym_user_id');
    }

    public function overallGoal()
    {
        return $this->hasOne(OverallGoal::class, 'goal_id', 'goal_id');
    }

    public function strengthEquipmentGoal()
    {
        return $this->hasOne(StrengthEquipmentGoal::class, 'goal_id', 'goal_id');
    }

}
