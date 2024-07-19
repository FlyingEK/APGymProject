<?php
namespace App\Http\Controllers;
use App\Models\Equipment;

use Illuminate\Http\Request;

class WorkoutController extends Controller
{
    public function index()
    {
        return view('workout.index');
    }

    public function addWorkoutHabit(){
        $allEquipment = Equipment::where('is_deleted', false)->get();
        return view('workout.addWorkoutHabit', compact('allEquipment'));
    }

    public function workoutHabit($userId)
    {
        $equipmentWithHabits = Equipment::with(['workoutHabits.strengthWorkoutHabit', 'workoutHabits.cardioWorkoutHabit'])
        ->where('is_deleted', false)
        ->whereHas('workoutHabits', function($query) use ($userId) {
            $query->where('gym_user_id', $userId);
        })
        ->get();

        $allEquipment = Equipment::all()
                        ->where('is_deleted', false);

        return view('workout.workoutHabit', [
            'equipmentWithHabits' => $equipmentWithHabits,
            'allEquipment' => $allEquipment,
        ]);
        }

}
?>