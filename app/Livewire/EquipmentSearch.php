<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Equipment;
use App\Models\EquipmentMachine;
use App\Models\Workout;
use App\Models\WorkoutQueue;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\GymUser;

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
        $userId = Auth::id();
        $gymUser = GymUser::where('user_id', $userId)->first();
        $gymUserId = $gymUser->gym_user_id;

        $allowSharing = collect(Equipment::getAllowSharingEquipment());
        $allowSharing = $allowSharing->filter(function ($item) {
            return stripos($item->name, $this->searchTerm) !== false;
        });

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

        $equipments->each(function ($item)  use ($gymUserId){
            $item->status = $item->available_machines_count >= 1 ? 'Available' : 'Not available';
            $item->statusDetail = $this->getInUseStatus($item->equipment_id, $gymUserId);

        });

    return view('livewire.equipment-search', [
        'equipments' => $equipments,
        'allowSharing' => $allowSharing,
    ]);
    }

    public function getInUseStatus($equipmentId, $userId){
        $currentTime = now();

         // Fetch all equipment machines related to the equipment
        $equipmentMachines = EquipmentMachine::where('equipment_id', $equipmentId)->pluck('equipment_machine_id');

         // Fetch ongoing workouts for the equipment machines
        $equipmentWorkouts = Workout::whereIn('equipment_machine_id', $equipmentMachines)
                        ->whereIn('status', ['in_progress', 'in_use'])
                        ->get();
    
        $queueWorkouts = WorkoutQueue::where('equipment_id', $equipmentId)
                                     ->where('status', 'queueing')
                                     ->orWhere('status', 'reserved')
                                     ->orderBy('created_at')
                                     ->get();
    
        $currentUserQueuePosition = null;
        $totalEstimatedTime = 0;
        $currentPersonInQueue = 0;
    
        // Calculate remaining workout time for current users
        foreach ($equipmentWorkouts as $workout) {
            $estimatedEndTime = Carbon::parse($workout->estimated_end_time);
            if ($currentTime->lt($estimatedEndTime)) {
                $remainingTime = abs($estimatedEndTime->diffInMinutes($currentTime));
                $totalEstimatedTime += $remainingTime;
            }
        }
        // Calculate total waiting time for users in the queue
        foreach ($queueWorkouts as $index => $queueWorkout) {
            $currentPersonInQueue++;
            if ($queueWorkout->gym_user_id == $userId) {
                $currentUserQueuePosition = $index + 1;
                break;
            }
            $totalEstimatedTime += $queueWorkout->duration;

        }

        return [
            'totalEstimatedTime' => round($totalEstimatedTime),
            'currentPersonInQueue' => $currentPersonInQueue,
            'currentUserQueuePosition' => $currentUserQueuePosition,
        ];
    }

    public function updateSearch(){
        $this->render();
    }
}
