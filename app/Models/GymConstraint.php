<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GymConstraint extends Model
{
    use HasFactory;
    protected $table = 'gym_constraint';

    // Define the primary key if it's not the default "id"
    protected $primaryKey = 'constraint_id';
    protected $fillable = [
        'constraint_name',
        'constraint_value',
    ];
}
