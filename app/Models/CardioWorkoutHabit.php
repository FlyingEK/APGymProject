<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CardioWorkoutHabit extends Model
{
    use HasFactory;
    protected $table = 'cardio_workout_habit';
    protected $fillable = [
        'workout_habit_id',
        'duration',
    ];

    public function workoutHabit()
    {
        return $this->belongsTo(WorkoutHabit::class, 'workout_habit_id');
    }
}
