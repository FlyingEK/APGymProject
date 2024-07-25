<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Achievement extends Model
{
    use HasFactory;
    protected $table = 'achievement';
    protected $primaryKey = 'achievement_id';

    protected $fillable = [
        'condition',
        'image',
    ];
    public function gymUserAchievement()
    {
        return $this->hasMany(GymUserAchievement::class, 'achievement_id', 'achievement_id');
    }

}
