<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Equipment;
use App\Models\EquipmentMachine;

class EquipmentSearch extends Component
{
    public $searchTerm = '';
    public $isCheckIn;

    public function mount($isCheckIn)
    {
        $this->isCheckIn = $isCheckIn;
    }

    public function render()
    {
        $equipments = Equipment::where('is_deleted', false)
        ->where('name', 'like', '%' . $this->searchTerm . '%')
        ->withCount(['equipmentMachines as available_machines_count' => function ($query) {
            $query->where('status', 'available');
        }])
        ->get();

        $equipments->each(function ($item) {
            $item->status = $item->available_machines_count > 1 ? 'Available' : 'In use';
        });

    return view('livewire.equipment-search', [
        'equipments' => $equipments,
    ]);
    }

    public function updateSearch(){
        $this->render();
    }
}
