<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Equipment;
use App\Models\EquipmentMachine;

class EquipmentSearch extends Component
{
    public $searchTerm = '';
    public $isCheckIn;
    public $category;

    public function mount($isCheckIn, $category)
    {
        $this->isCheckIn = $isCheckIn;
        $this->category = $category;
    }

    public function render()
    {
        if($this->category !=""){
            $equipments = Equipment::where('is_deleted', false)
            ->where('name', 'like', '%' . $this->searchTerm . '%')
            ->where('category', $this->category)
            ->withCount(['equipmentMachines as available_machines_count' => function ($query) {
                $query->where('status', 'available');
            }])
            ->get();
        }else{
            $equipments = Equipment::where('is_deleted', false)
            ->where('name', 'like', '%' . $this->searchTerm . '%')
            ->withCount(['equipmentMachines as available_machines_count' => function ($query) {
                $query->where('status', 'available');
            }])
            ->get();
        }

        $equipments->each(function ($item) {
            $item->status = $item->available_machines_count > 1 ? 'Available' : 'Not available';
        });

    return view('livewire.equipment-search', [
        'equipments' => $equipments,
    ]);
    }

    public function updateSearch(){
        $this->render();
    }
}
