<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GymUser extends Model
{
    use HasFactory;
    protected $table = 'gym_user';
    protected $primaryKey = 'gym_user_id';

    protected $fillable = [
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function issues()
    {
        return $this->hasMany(Issue::class, 'gym_user_id', 'gym_user_id');
    }

    public function queue()
    {
        return $this->hasMany(GymQueue::class, 'gym_user_id', 'gym_user_id');
    }

    public function workout(){
        return $this->hasMany(Workout::class, 'gym_user_id', 'gym_user_id');
    }

    public function goal(){
        return $this->hasMany(Goal::class, 'gym_user_id', 'gym_user_id');
    }

    public function gymUserAchievement(){
        return $this->hasMany(GymUserAchievement::class, 'gym_user_id', 'gym_user_id');

    }
}
