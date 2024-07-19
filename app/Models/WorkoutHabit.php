<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkoutHabit extends Model
{
    use HasFactory;
    protected $table = 'workout_habit';
    protected $primaryKey = 'workout_habit_id';

    protected $fillable = [
        'gym_user_id',
        'equipment_id',
    ];

    public function gymUser()
    {
        return $this->belongsTo(GymUser::class, 'gym_user_id');
    }

    public function equipment()
    {
        return $this->belongsTo(Equipment::class, 'equipment_id');
    }

    public function strengthWorkoutHabits()
    {
        return $this->hasMany(StrengthWorkoutHabit::class, 'workout_habit_id');
    }

    public function cardioWorkoutHabits()
    {
        return $this->hasMany(CardioWorkoutHabit::class, 'workout_habit_id');
    }
}
