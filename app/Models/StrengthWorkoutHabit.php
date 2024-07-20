<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StrengthWorkoutHabit extends Model
{
    use HasFactory;
    protected $table = 'strength_workout_habit';
    protected $primaryKey = 'strength_workout_habit_id';

    protected $fillable = [
        'workout_habit_id',
        'set',
        'repetition',
        'weight',
        'allow_sharing'
    ];

    public function workoutHabit()
    {
        return $this->belongsTo(WorkoutHabit::class, 'workout_habit_id');
    }
}
