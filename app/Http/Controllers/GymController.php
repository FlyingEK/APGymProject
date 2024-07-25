<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GymQueue;
use App\Models\GymConstraint;
use App\Models\GymUser;
use App\Models\Equipment;
use App\Models\Workout;
use App\Models\EquipmentMachine;


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
                            ->where('estimated_end_time', '<', $timeNow)
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


        // Optionally, flatten the collection if you have nested collections
       // $exceededEquipments = $exceededEquipments->flatten();
        $currentUserCount = GymQueue::where('status', 'entered')->count();

        $userLimit = GymConstraint::where('constraint_name','max_in_gym_users')->first();
        $userLimit = (int) $userLimit->constraint_value;
        $currentQueueCount = GymQueue::where('status', 'queueing')->count();
        $gymIsFull = $currentQueueCount >= $userLimit;
        return view('gym.index', compact('exceededEquipments', 'currentUserCount', 'currentQueueCount', 'gymIsFull'));
    }


    


}
?>