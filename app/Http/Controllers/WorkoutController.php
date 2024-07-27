<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Log;
use App\Models\WorkoutHabit;
use App\Models\GymUser;
use App\Models\Equipment;
use App\Models\GymConstraint;
use App\Models\Workout;
use App\Models\EquipmentMachine;
use App\Models\WorkoutQueue;
use App\Models\StrengthEquipmentGoal;
use App\Models\OverallGoal;
use App\Models\Achievement;
use App\Models\User;
use App\Notifications\GoalCompleted;
use App\Notifications\AchievementUnlocked;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use App\Notifications\EquipmentReserved;
use App\Models\GymUserAchievement;

use Exception;


class WorkoutController extends Controller
{
    public function getGymUserId(){
        $userId = Auth::user()->user_id;
        $gymUser = GymUser::where('user_id', $userId)->first();
        if (!$gymUser) {
            return redirect()->back()->with('error', 'Gym user not found.');
        }
        $gymUserId = $gymUser->gym_user_id;
        return $gymUserId;
    }

    public function callNextInQueue($equipmentId){
        //call next in queue
        $nextInQueue = WorkoutQueue::with(['gymUser.user', 'workout'])
        ->where('status', 'queueing')
        ->where('equipment_id', $equipmentId)
        ->whereDoesntHave('gymUser.queue', function ($query) {
            $query->where('status', 'reserved');
        })
        ->whereDoesntHave('gymUser.workout', function ($query) {
            $query->where('status', 'in_progress');
        })
        ->orderBy('created_at', 'asc')
        ->first();

        if($nextInQueue){
    
            //assign equipment to user
            $equipmentMachine = EquipmentMachine::with('equipment')
            ->where('equipment_id', $equipmentId)
            ->where('status', 'available')
            ->first();
    
            if ($equipmentMachine && $equipmentMachine->status == 'available') {
                $equipmentMachine->status = 'reserved';
                $equipmentMachine->save();
                //send notification
                $nextInQueue->status = 'reserved';
                $nextInQueue->equipment_machine_id = $equipmentMachine->equipment_machine_id;
                $nextInQueue->save();
                Notification::send($nextInQueue->gymUser->user, new EquipmentReserved($equipmentMachine->label, $equipmentMachine->equipment->name));
                $this->setReservationTimer($equipmentMachine, $nextInQueue);
    
            }
        }
       
    }

    protected function setReservationTimer(EquipmentMachine $equipmentMachine, WorkoutQueue $nextInQueue)
    {
        // Use a delayed job to change the status back after 2 minutes
        $job = (new \App\Jobs\ReleaseEquipmentReservation($equipmentMachine,$nextInQueue))
            ->delay(now()->addMinutes(2));

        dispatch($job);
    }

    public function startWorkout(Request $request)
    {
        try {
            $gymUserId = $this->getGymUserId();
            $workoutId = $request->input('workoutId');
            
            // Find the workout queue entry
            $workoutQueue = WorkoutQueue::with('equipmentMachine.equipment')
                ->findOrFail($workoutId);
    
            if ($workoutQueue->status === 'reserved') {
                $workoutQueue->status = 'inuse';
                $workoutQueue->save();
    
                $equipmentMachine = $workoutQueue->equipmentMachine;
                if ($equipmentMachine) {
                    $equipmentMachine->status = 'in use';
                    $equipmentMachine->save();
    
                    $timeLimitConstraint = $equipmentMachine->equipment->has_weight == 1 ?
                        GymConstraint::where('constraint_name', 'max_weight_equipment_usage_time')->first() :
                        GymConstraint::where('constraint_name', 'max_cardio_equipment_usage_time')->first();
    
                    if ($timeLimitConstraint) {
                        $workout = Workout::create([
                            'gym_user_id' => $gymUserId,
                            'equipment_machine_id' => $equipmentMachine->equipment_machine_id,
                            'start_time' => now(),
                            'estimated_end_time' => now()->addMinutes(intval($workoutQueue->duration)),
                            'status' => 'in_progress',
                            'date' => now()->toDateString(),
                            'exceeded_time' => now()->addMinutes(intval($timeLimitConstraint->constraint_value)),
                            'workout_queue_id' => $workoutQueue->workout_queue_id,
                        ]);
    
                        return response()->json(['success' => true, 'message' => 'Workout started successfully!']);
                    } else {
                        return response()->json(['success' => false, 'message' => 'Time limit constraint not found!']);
                    }
                } else {
                    return response()->json(['success' => false, 'message' => 'Equipment machine not found!']);
                }
            } else if ($workoutQueue->status === 'queueing') {
                $equipmentMachine = EquipmentMachine::with('equipment')->where('equipment_id', $workoutQueue->equipment_id)
                    ->where('status', 'available')
                    ->first();
        
                if ($equipmentMachine && $equipmentMachine->status == 'available') {
                    $equipmentMachine->status = 'in use';
                    $equipmentMachine->save();
                    $estimatedEndTime = now()->addMinutes(intval($workoutQueue->duration));
                    $workoutQueue->status = 'inuse';
                    $workoutQueue->equipment_machine_id = $equipmentMachine->equipment_machine_id;
                    $workoutQueue->save();
                    $timeLimitConstraint = $equipmentMachine->equipment->has_weight == 1 ?
                    GymConstraint::where('constraint_name', 'max_weight_equipment_usage_time')->first() :
                    GymConstraint::where('constraint_name', 'max_cardio_equipment_usage_time')->first();
                    // Record the equipment assignment for the user
                    $workout = Workout::create(
                        ['gym_user_id' => $gymUserId, 
                        'equipment_machine_id' => $equipmentMachine->equipment_machine_id,
                        'start_time' => now(),
                        'estimated_end_time' => $estimatedEndTime,
                        'status' => 'in_progress',
                        'date' => now()->toDateString(),
                        'workout_queue_id' => $workoutQueue->workout_queue_id,
                        'exceeded_time' => now()->addMinutes(intval($timeLimitConstraint->constraint_value)),
                    ],
                    );
        
                    return response()->json(['success' => true, 'message' => 'Workout started successfully!']);
                }
            }
        } catch (\Exception $e) {
            // Log the error message for debugging
            Log::error($e->getMessage());
    
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }
    
    public function index()
    {
        $gymUserId = $this->getGymUserId();
        //workout
        $workout = Workout::with('equipmentMachine.equipment')->where('gym_user_id', $gymUserId)->with(['workoutQueue','equipmentMachine.equipment'])
        ->where('status', 'in_progress')
        ->first();
        //get equipment to populate in workout index
        // $queuedEquipments = WorkoutQueue::where('gym_user_id', $gymUserId)->with('equipment')
        // ->where('status', 'queueing')
        // ->get();
        $queuedEquipments = WorkoutQueue::where('gym_user_id', $gymUserId)
        ->with(['equipment' => function($query) {
            $query->withCount(['equipmentMachines as available_machines_count' => function ($query) {
                $query->where('status', 'available');
            }]);
        }])
        ->where('status', 'queueing')
        ->get();
        // Apply status logic to queueEquipments
        $queuedEquipments->each(function ($queue) {
            $queue->status = $queue->equipment->available_machines_count > 1 ? 'Available' : 'Not available';
        });

        $reservedEquipments = WorkoutQueue::where('gym_user_id', $gymUserId)->with(['equipment', 'equipmentMachine'])
        ->where('status', 'reserved')
        ->first();

        return view('workout.index', compact('workout', 'queuedEquipments', 'reservedEquipments'));
    }

    public function addWorkoutHabit(){
        $allEquipment = Equipment::where('is_deleted', false)->get();
        return view('workout.addWorkoutHabit', compact('allEquipment'));
    }

    public function store(Request $request){
        $gymUserId = $this->getGymUserId();
        $durationConstraint = GymConstraint::where('constraint_name', 'max_cardio_equipment_usage_time')->first();

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

    public function setPlanAndGetEquipment(Request $request, $saveHabit)
    {
        $gymUserId = $this->getGymUserId();

        $durationConstraint = GymConstraint::where('constraint_name', 'max_cardio_equipment_usage_time')->first();
        // Validate the request data
        $data = $request->validate([
            'equipment_id' => 'required',
            'workout_habit_id'=>'nullable',
            'has_weight' => 'required|boolean',
            'set' => 'nullable|required_if:has_weight,1|integer|min:1|max:5', 
            'rep' => 'nullable|required_if:has_weight,1|integer|min:1|max:40', 
            'weight' => 'nullable|required_if:has_weight,1|integer|min:5|max:500',
            'duration' => 'nullable|required_if:has_weight,0|integer|min:10|max:'.$durationConstraint->constraint_value??60,
            'allow_sharing' => 'nullable|boolean',
            'share' => 'nullable|boolean',
            'machine_id' => 'nullable',
        ], [
            'set.required_if' => 'The sets field is required.',
            'rep.required_if' => 'The reps field is required.',
            'weight.required_if' => 'The weights field is required.',
            'duration.required_if' => 'The duration field is required.',
            'duration.min' => 'The duration must be at least 10 minutes.',
            'duration.max' => 'The duration may not be greater than ' .$durationConstraint->constraint_value??60 .' minutes.',
        ]);
        if($data['has_weight'] == 1){
            $data['duration'] =  intval(round($data['set'] * $data['rep'] * 10 / 60 * (5 * ($data['set'] - 1))));
        }

        $queueEquipmentCount = WorkoutQueue::where('gym_user_id', $gymUserId)
        ->where('status', 'queueing')
        ->count();

        $existedEquipmentQueue = WorkoutQueue::where('gym_user_id', $gymUserId)
        ->where('equipment_id', $request->equipment_id)
        ->where('status', 'queueing')
        ->orWhere('status', 'reserved')
        ->orWhere('status', 'inuse')
        ->exists();

        // queue constraint
        if($existedEquipmentQueue){
            return redirect()->back()->with('error', 'You have already queued for this equipment.');
        }

        if($queueEquipmentCount < 2){
            $queueEquipment = WorkoutQueue::create([
                'gym_user_id' => $gymUserId,
                'equipment_id' => $request->equipment_id,
                'status' => 'queueing',
                'duration' => $data['duration'],
                'sets' => $data['set'] ?? null,
                'repetitions' => $data['rep'] ?? null,
                'weight' => $data['weight'] ?? null,
                'allow_sharing' => $data['allow_sharing'] ?? null,
            ]);
        }else{
            return redirect()->back()->with('error', 'You can only queue for 2 equipment at a time.');
        }

        $startTime = now();
        if($saveHabit == 1){
            $workoutHabit = WorkoutHabit::updateOrCreate(
                ['gym_user_id' => $gymUserId, 'equipment_id' => $request->equipment_id],
                ['gym_user_id' => $gymUserId, 'equipment_id' => $request->equipment_id]
            );
            // Update related strength or cardio workout habits
            if ($data['has_weight']  && $data['has_weight'] == 1) {
                $workoutHabit->strengthWorkoutHabits()->updateOrCreate([
                    'workout_habit_id' => $data['workout_habit_id']
                ],
                [    'set' => $data['set'],
                    'repetition' => $data['rep'],
                    'weight' => $data['weight'],
                    'allow_sharing' =>$data['allow_sharing'],
                ]);
            } else {
                $workoutHabit->cardioWorkoutHabits()->updateOrCreate([
                    'workout_habit_id' => $data['workout_habit_id']
                ],
                [
                    'duration' => $data['duration'],
                ]);
            }   
        }

        if($data['share']){
            $equipmentMachine = EquipmentMachine::with('equipment')->find($data['machine_id']);
        }else{
            // Add the equipment machine to the user if available
            $equipmentMachine = EquipmentMachine::with('equipment')->where('equipment_id', $data['equipment_id'])
            ->where('status', 'available')
            ->first();
        }

        if ($equipmentMachine->equipment_machine_id) {
            $equipmentMachine->status = 'in use';
            $equipmentMachine->save();
            $estimatedEndTime = now()->addMinutes(intval($data['duration']));
            $queueEquipment->status = 'inuse';
            $queueEquipment->equipment_machine_id = $equipmentMachine->equipment_machine_id;
            $queueEquipment->save();
            $timeLimitConstraint = $equipmentMachine->equipment->has_weight == 1 ?
            GymConstraint::where('constraint_name', 'max_weight_equipment_usage_time')->first() :
            GymConstraint::where('constraint_name', 'max_cardio_equipment_usage_time')->first();
            // Record the equipment assignment for the user
            $workout = Workout::create(
                ['gym_user_id' => $gymUserId, 
                'equipment_machine_id' => $equipmentMachine->equipment_machine_id,
                'start_time' => $startTime,
                'estimated_end_time' => $estimatedEndTime,
                'status' => 'in_progress',
                'date' => now()->toDateString(),
                'workout_queue_id' => $queueEquipment->workout_queue_id,
                'exceeded_time' => now()->addMinutes(intval($timeLimitConstraint->constraint_value)),
            ],
            );

            return redirect()->route('workout-index');
        }
        return redirect()->route('workout-index')->with('success', 'Workout habit updated successfully!');
    }

    public function endWorkout(Request $request){

        $data = $request->validate([
            'set' => 'nullable|required_if:has_weight,1|integer', 
            'rep' => 'nullable|integer|min:1|max:40', 
            'weight' => 'nullable|required_if:has_weight,1|integer|min:5|max:500',
            'duration' => 'nullable|required_if:has_weight,0|integer',
        ], [
            'set.required_if' => 'The sets field is required.',
            'weight.required_if' => 'The weights field is required.',
            'duration.required_if' => 'The duration field is required.',
        ]);

        $workout = Workout::with('gymUser.user')->find($request->workout_id);

        if (!$workout) {
            return redirect()->back()->with('error', 'No workout in progress.');
        }
        if($workout->equipmentMachine->equipment->has_weight == 1){
            $workout->weight = $data['weight'] ?? null;
            $workout->set = $data['set'] ?? null;
            $workout->repetition = $data['rep'] ?? null;
        }
       
        $workout->duration = $data['duration'] ?? null;  
        $workout->end_time = now();
        $workout->status = 'completed';
        $workout->save();

        $workoutQueue = WorkoutQueue::find($workout->workout_queue_id);
        $workoutQueue->status = 'completed';
        $workoutQueue->save();

        $equipmentMachine = EquipmentMachine::with('equipment')->find($workout->equipment_machine_id);
        $equipmentMachine->status = 'available';
        $equipmentMachine->save();

        // Update goal progress
        $strengthGoal = StrengthEquipmentGoal::with(['goal','equipment'])
        ->where('equipment_id', $equipmentMachine->equipment_id)
        ->whereHas('goal', function($query) use($workoutQueue) {
            $query->where('status', 'active');
            $query->where('gym_user_id', $workoutQueue->gym_user_id);
        })
        ->first();

        // $user = User::with('gymUser')->whereHas('gymUser', function($query) use($workoutQueue) {
        //     $query->where('gym_user_id', $workoutQueue->gym_user_id);
        // })->first();

        if ($strengthGoal) {
            $strengthGoal->progress = $data['weight'] > $strengthGoal->progress ? $data['weight'] : $strengthGoal->progress;
            if ($strengthGoal->progress >= $strengthGoal->weight) {
                $strengthGoal->goal->status = 'completed';
                $strengthGoal->goal->save();
                Notification::send(User::find($workout->gymUser->user->user_id), new GoalCompleted($strengthGoal));
            }
            $strengthGoal->save();
        }
        $overallGoal = OverallGoal::with('goal')
        ->whereHas('goal', function($query) use($workoutQueue) {
            $query->where('status', 'active')
            ->where('gym_user_id', $workoutQueue->gym_user_id);
        })
        ->first();
    
        if ($overallGoal) {
            $overallGoal->progress = intval($data['duration']) / 60 + $overallGoal->progress;
            if ($overallGoal->progress >= $overallGoal->workout_hour) {
                $overallGoal->goal->status = 'completed';
                $overallGoal->goal->save();
                Notification::send(User::find($workout->gymUser->user->user_id), new GoalCompleted($overallGoal));
            }
            $overallGoal->save();
        }
        $gymUser = GymUser::with('gymUserAchievement')->where('gym_user_id',$workout->gym_user_id )->firstOrFail();

        // check if achievement is unlocked
        $totalHours = Workout::where('gym_user_id', $workout->gym_user_id)
                             ->where('status', 'completed')
                             ->sum('duration') / 60;
            $achievements = [
            6 => 10,  // Achievement ID 6 for 10 hours
            7 => 50,  
            8 => 100, 
        ];

        foreach ($achievements as $achievementId => $requiredHours) {
            // Check if the user already has this achievement
            if (!$gymUser->gymUserAchievement()->where('achievement_id', $achievementId)->exists()) {
                // Check if the user meets the condition for this achievement
                if ($totalHours >= $requiredHours) {
                    // Unlock the achievement
                    GymUserAchievement::create([
                        'gym_user_id' => $gymUser->gym_user_id,
                        'achievement_id' => $achievementId,
                    ]);
                    $condition = Achievement::find($achievementId)->condition;
                    Notification::send(User::find($gymUser->user_id), new AchievementUnlocked(lcfirst($condition)));

                }
            }
        }

        $this->callNextInQueue($equipmentMachine->equipment->equipment_id);
        return redirect()->route('workout-index')->with('workoutSuccess', 'Workout ended successfully!');
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