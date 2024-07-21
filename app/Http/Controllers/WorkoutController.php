<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Log;
use App\Models\WorkoutHabit;
use App\Models\GymUser;
use App\Models\Equipment;
use App\Models\GymConstraint;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;


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

    public function store(Request $request){
        $durationConstraint = GymConstraint::where('constraint_name', 'max_cardio_equipment_usage_time')->first();
        $userId = Auth::user()->user_id;
        $gymUser = GymUser::where('user_id', $userId)->first();
        if (!$gymUser) {
            return redirect()->back()->with('error', 'Gym user not found.');
        }
        $gymUserId = $gymUser->gym_user_id;
        $data = $request->validate([
            'has_weight' => 'required|boolean',
            'equipment_id' => 'required',
            'set' => 'nullable|required_if:has_weight,1|integer|min:1|max:5', 
            'rep' => 'nullable|required_if:has_weight,1|integer|min:1|max:40', 
            'weight' => 'nullable|required_if:has_weight,1|integer|min:5|max:500',
            'duration' => 'nullable|required_if:has_weight,0|integer|min:10|max:'.$durationConstraint->constraint_value??60,
            'allow_sharing' => 'nullable|boolean',
        ], [
            'set.required_if' => 'The sets field is required.',
            'rep.required_if' => 'The reps field is required.',
            'weight.required_if' => 'The weights field is required.',
            'duration.required_if' => 'The duration field is required.',
            'duration.min' => 'The duration must be at least 10 minutes.',
            'duration.max' => 'The duration may not be greater than ' .$durationConstraint->constraint_value??60 .' minutes.',
        ]);

        $existingHabit = WorkoutHabit::where('gym_user_id', $gymUserId)
                                ->where('equipment_id', $data['equipment_id'])
                                ->first();

        if ($existingHabit) {
            return redirect()->back()->with('error', "Can't create duplicate workout habit for one equipment.");
        }
        DB::beginTransaction();
        $workoutHabit = WorkoutHabit::create([
            'equipment_id' => $data['equipment_id'],
            'gym_user_id' => $gymUserId,
        ]);
        if($data['has_weight'] == 1){
            $workoutHabit->strengthWorkoutHabits()->create([
                'set' => $data['set'],
                'repetition' => $data['rep'],
                'weight' => $data['weight'],
                'allow_sharing' => $data['allow_sharing'],
            ]);
        } else {
            $workoutHabit->cardioWorkoutHabits()->create([
                'duration' => $data['duration'],
            ]);
        }
        DB::commit();
        return redirect()->back()->with('success', 'Workout habit created successfully!');
    }

    public function workoutHabit()
    {
        $userId = Auth::user()->user_id;
        $gymUser = GymUser::where('user_id', $userId)->first();

        if (!$gymUser) {
            return redirect()->back()->with('error', 'Gym user not found.');
        }
        $equipmentsWithHabit = DB::table('equipment')
        ->join('workout_habit', 'equipment.equipment_id', '=', 'workout_habit.equipment_id')
        ->leftJoin('strength_workout_habit', 'workout_habit.workout_habit_id', '=', 'strength_workout_habit.workout_habit_id')
        ->leftJoin('cardio_workout_habit', 'workout_habit.workout_habit_id', '=', 'cardio_workout_habit.workout_habit_id')
        ->where('equipment.is_deleted', false)
        ->where('workout_habit.gym_user_id', $gymUser->gym_user_id)
        ->select(
            'equipment.*',
            'workout_habit.*',
            'strength_workout_habit.set as set',
            'strength_workout_habit.repetition as repetition',
            'strength_workout_habit.weight as weight',
            'strength_workout_habit.allow_sharing as allowSharing',
            'cardio_workout_habit.duration as duration'
        )
        ->get();

        return view('workout.workoutHabit', compact('equipmentsWithHabit'));
    }

    public function getWorkoutHabit(Request $request)
    {
        $equipmentId = $request->get('id');

        $userId = Auth::user()->user_id;
        $gymUser = GymUser::where('user_id', $userId)->first();

        if (!$gymUser) {
            return redirect()->back()->with('error', 'Gym user not found.');
        }

        $equipmentWithHabit = DB::table('equipment')
        ->leftJoin('workout_habit', 'equipment.equipment_id', '=', 'workout_habit.equipment_id')
        ->leftJoin('strength_workout_habit', 'workout_habit.workout_habit_id', '=', 'strength_workout_habit.workout_habit_id')
        ->leftJoin('cardio_workout_habit', 'workout_habit.workout_habit_id', '=', 'cardio_workout_habit.workout_habit_id')
        ->where('equipment.is_deleted', false)
        ->where('equipment.equipment_id', $equipmentId)
        ->where(function ($query) use ($gymUser) {
            $query->where('workout_habit.gym_user_id', $gymUser->gym_user_id)
                  ->orWhereNull('workout_habit.gym_user_id');
        })
        ->select(
            'equipment.*',
            'workout_habit.*',
            'strength_workout_habit.set as set',
            'strength_workout_habit.repetition as repetition',
            'strength_workout_habit.weight as weight',
            'strength_workout_habit.allow_sharing as allowSharing',
            'cardio_workout_habit.duration as duration'
        )
        ->first();
        $equipmentWithHabit->equipment_id=  $equipmentId;
        if (!$equipmentWithHabit) {
            return response()->json(['success' => false, 'error' => 'Equipment with workout habit not found.'], 404);
        }
        return response()->json(['success' => true, 'equipment' => $equipmentWithHabit]);
    }       

    public function updateWorkoutHabit(Request $request, $id)
    {
        // Find the workout habit by ID
        $workoutHabit = WorkoutHabit::findOrFail($id);

        $durationConstraint = GymConstraint::where('constraint_name', 'max_cardio_equipment_usage_time')->first();
        // Validate the request data
        $data = $request->validate([
            'has_weight' => 'required|boolean',
            'set' => 'nullable|required_if:has_weight,1|integer|min:1|max:5', 
            'rep' => 'nullable|required_if:has_weight,1|integer|min:1|max:40', 
            'weight' => 'nullable|required_if:has_weight,1|integer|min:5|max:500',
            'duration' => 'nullable|required_if:has_weight,0|integer|min:10|max:'.$durationConstraint->constraint_value??60,
            'allow_sharing' => 'nullable|boolean',
        ], [
            'set.required_if' => 'The sets field is required.',
            'rep.required_if' => 'The reps field is required.',
            'weight.required_if' => 'The weights field is required.',
            'duration.required_if' => 'The duration field is required.',
            'duration.min' => 'The duration must be at least 10 minutes.',
            'duration.max' => 'The duration may not be greater than ' .$durationConstraint->constraint_value??60 .' minutes.',
        ]);
        // Update related strength or cardio workout habits
        if ($data['has_weight']  && $data['has_weight'] == 1) {
            $workoutHabit->strengthWorkoutHabits()->update([
                'set' => $data['set'],
                'repetition' => $data['rep'],
                'weight' => $data['weight'],
                'allow_sharing' =>$data['allow_sharing'],
            ]);
        } else {
            $workoutHabit->cardioWorkoutHabits()->update([
                'duration' => $data['duration'],
            ]);
        }

        return redirect()->back()->with('success', 'Workout habit updated successfully!');
    }

    public function deleteWorkoutHabit($id){
        try {
            // Find the workout habit by ID
            $workoutHabit = WorkoutHabit::findOrFail($id);
    
            // Delete related strength or cardio workout habits
            $workoutHabit->strengthWorkoutHabits()->delete();
            $workoutHabit->cardioWorkoutHabits()->delete();
    
            // Delete the workout habit
            $workoutHabit->delete();
    
            return redirect()->route('workout-habit', ['userId' => $workoutHabit->gym_user_id])->with('success', 'Workout habit deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while deleting the workout habit.');
        }
    }
}
?>