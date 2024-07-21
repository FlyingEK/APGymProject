<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Equipment;
use App\Models\EquipmentMachine;

class EquipmentSearch extends Component
{
    public $searchTerm = '';

    public function render()
    {
        $equipments = Equipment::where('is_deleted', false)
        ->where('name', 'like', '%' . $this->searchTerm . '%')
        ->get();

    return view('livewire.equipment-search', [
        'equipments' => $equipments,
    ]);
    }
}
