<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Equipment;
use App\Models\EquipmentMachine;

class SearchEquipmentMachine extends Component
{
    public $searchTerm1 = '';
    public $category;

    public function mount(){
        $this->category = "";
    }

    public function render()
    {
        if($this->category !=""){
            $equipments = EquipmentMachine::with('equipment')
                ->whereHas('equipment', function($query) {
                    $query->where('name', 'like', '%' . $this->searchTerm1 . '%')
                        ->where('is_deleted', false)
                        ->where('category', $this->category);
                })
                ->get();
        }else{
            $equipments = EquipmentMachine::with('equipment')
                ->whereHas('equipment', function($query) {
                    $query->where('name', 'like', '%' . $this->searchTerm1 . '%')
                        ->where('is_deleted', false);
                })
                ->get();
        }
        return view('livewire.search-equipment-machine',[
            'equipments' => $equipments,
        ]);
    }

    public function updateSearch(){
        $this->render();
    }
}
