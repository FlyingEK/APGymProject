<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OverallGoal extends Model
{
    use HasFactory;
    protected $table = 'overall_goal';
    protected $primaryKey = 'goal_id';
    protected $fillable = ['goal_id','workout_hour', 'target_date'];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    public function goal()
    {
        return $this->belongsTo(Goal::class, 'goal_id', 'goal_id');
    }
}
