<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Issue extends Model
{
    use HasFactory;
    protected $table = 'issue';
    protected $primaryKey = 'issue_id';

    protected $fillable = [
        'title',
        'type',
        'equipment_machine_id',
        'description',
        'image',
        'status',
        'created_by',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function equipmentMachine()
    {
        return $this->belongsTo(EquipmentMachine::class, 'equipment_machine_id', 'equipment_machine_id');
    }

    public function gymUser()
    {
        return $this->belongsTo(GymUser::class, 'gym_user_id', 'gym_user_id');
    }
}
