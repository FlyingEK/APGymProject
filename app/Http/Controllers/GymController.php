<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GymQueue;
use App\Models\GymConstraint;
use App\Models\GymUser;
use App\Models\Equipment;
use App\Models\Workout;
use App\Models\EquipmentMachine;
use App\Models\WorkoutQueue;


class GymController extends Controller
{
    public function gymIsFull(){
        $userLimit = GymConstraint::where('constraint_name','max_in_gym_users')->first();
        $userLimit = (int) $userLimit->constraint_value;
        $currentQueueCount = GymQueue::where('status', 'entered')->count();
        return $currentQueueCount >= $userLimit;
    }

    public function gymUser()
    {
        $currentUserCount = GymQueue::where('status', 'entered')->count();
        $gymIsFull = $this->gymIsFull();
        $currentUsers = GymQueue::with('gymUser.user')
                    ->where('status', 'entered')
                    ->orderBy('created_at')
                    ->get();
        return view('gym.gym-users', compact('currentUsers', 'currentUserCount', 'gymIsFull'));
    }
    public function gymIndex()
    {
        $timeNow = now();
        $exceededWorkout = Workout::with('equipmentMachine.equipment')
                            ->where('exceeded_time', '<', $timeNow)
                            ->where('status', 'in_progress')
                            ->get();
                // Create a collection to hold the exceeded equipments
        $exceededEquipments = collect();

        foreach ($exceededWorkout as $workout) {
            $exceededEquipments->push([
                'equipmentMachine' => $workout->equipmentMachine,
                'equipment' => $workout->equipmentMachine->equipment,
                'exceededTime' => round(abs($timeNow->diffInMinutes($workout->exceeded_time))),
            ]);
        }
        $maintenanceEquipment = Equipment::with('equipmentMachines')
        ->where('is_deleted', false)
        ->whereHas('equipmentMachines', function ($query) {
            $query->where('status', 'maintenance');
        })
        ->get();

        // Optionally, flatten the collection if you have nested collections
       // $exceededEquipments = $exceededEquipments->flatten();
        $currentUserCount = GymQueue::where('status', 'entered')->count();

        $userLimit = GymConstraint::where('constraint_name','max_in_gym_users')->first();
        $userLimit = (int) $userLimit->constraint_value;
        $currentQueueCount = GymQueue::where('status', 'queueing')->count();
        $gymIsFull = $currentUserCount >= $userLimit;
        return view('gym.index', compact('maintenanceEquipment','exceededEquipments', 'currentUserCount', 'currentQueueCount', 'gymIsFull'));
    }


    public function getGymUserLog(){
        return GymQueue::with('gymUser.user')
        ->whereNotNull('entered_at')
        ->where('status', 'left')
        ->orderBy('entered_at', 'desc');
    }

    public function adminViewLog(){
        $users = $this->getGymUserLog()->get();
        return view('gym.adminViewLog', compact('users'));
    }

    public function trainerViewLog(){
        $users = $this->getGymUserLog()->get();
        return view('gym.trainerViewLog', compact('users'));
    }

}
?>