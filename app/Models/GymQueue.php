<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GymQueue extends Model
{
    use HasFactory;
    protected $table = 'gym_queue';
    protected $primaryKey = 'id';
    protected $fillable = ['gym_user_id', 'status', 'check_in_code', 'entered_at','reserved_until'];

    protected $cast = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    public function gymUser()
    {
        return $this->belongsTo(GymUser::class, 'gym_user_id', 'gym_user_id');
    }

}
