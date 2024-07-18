<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    use HasFactory;

    // Define the table name if it's not the default "equipments"
    protected $table = 'equipment';

    // Define the primary key if it's not the default "id"
    protected $primaryKey = 'equipment_id';

    // Define the fillable fields
    protected $fillable = [
        'name',
        'description',
        'has_weight',
        'image',
        'tutorial_youtube',
        'quantity',
        'category',
    ];

    // If there are any relationships, define them here
    public function equipmentMachines()
    {
        return $this->hasMany(EquipmentMachine::class, 'equipment_id', 'equipment_id');
    }

    public function tutorials()
    {
        return $this->hasMany(Tutorial::class, 'equipment_id', 'equipment_id');
    }
}
