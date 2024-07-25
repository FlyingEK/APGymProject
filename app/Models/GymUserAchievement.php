<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GymUserAchievement extends Model
{
    use HasFactory;
    protected $table = 'gym_user_achievement';

    protected $fillable = [
        'achievement_id',
        'gym_user_id',
    ];

    public function achievement()
    {
        return $this->belongsTo(Achievement::class, 'achievement_id', 'achievement_id');
    }

    public function gymUser()
    {
        return $this->belongsTo(GymUser::class, 'gym_user_id', 'gym_user_id');
    }
}
