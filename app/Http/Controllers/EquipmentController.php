<?php
namespace App\Http\Controllers;
use App\Models\Equipment;
use App\Models\EquipmentMachine;
use App\Models\GymConstraint;
use App\Models\GymQueue;
use App\Models\Workout;
use App\Models\GymUser;
use App\Models\WorkoutQueue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\StrengthEquipmentGoal;
use App\Models\OverallGoal;
use App\Models\GymUserAchievement;
use App\Models\Achievement;
use App\Models\User;
use App\Notifications\GoalCompleted;
use App\Notifications\AchievementUnlocked;
use App\Http\Controllers\WorkoutController;
use Illuminate\Support\Facades\Notification;


class EquipmentController extends Controller
{
    public function isUserCheckedIn(){
        $user = Auth::user();
        $gymUserId = $user->gymUser->gym_user_id;
        return GymQueue::where('gym_user_id', $gymUserId)
        ->where('status', 'entered')
        ->exists();
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
    $a = $totalEstimatedTime;
        // Calculate total waiting time for users in the queue
        foreach ($queueWorkouts as $index => $queueWorkout) {
            $currentPersonInQueue++;
            if ($queueWorkout->gym_user_id == $userId) {
                $currentUserQueuePosition = $index + 1;
                break;
            }
            $totalEstimatedTime += $queueWorkout->duration;

        }
        // $timeUntilUserTurn = 0;
        // if (!is_null($currentUserQueuePosition)) {
        //     $timeUntilUserTurn = $totalEstimatedTime;
        // }
        return [
            'totalEstimatedTime' => round($totalEstimatedTime),
            'currentPersonInQueue' => $currentPersonInQueue,
            'currentUserQueuePosition' => $currentUserQueuePosition,
        ];
    }

    public function index()
    {
        $user = Auth::user();
        $gymUser = GymUser::where('user_id', $user->user_id)->first();
        $gymUserId = $gymUser->gym_user_id;
        $isCheckIn = $this->isUserCheckedIn();
        $userLimit = GymConstraint::where('constraint_name','max_in_gym_users')->first();
        $userLimit = (int) $userLimit->constraint_value;
        $isQueue = GymQueue::where('status', 'queueing')
        ->where('gym_user_id', Auth::user()->gymUser->gym_user_id)->exists();
        $isReserved = GymQueue::where('status', 'reserved')       
        ->where('gym_user_id', Auth::user()->gymUser->gym_user_id)->exists();

        $currentQueueCount = GymQueue::where('status', 'entered')->count();
        $gymIsFull = $currentQueueCount >= $userLimit;

        $topUsedEquipmentMachineIds = Workout::where('gym_user_id', $gymUserId)
        ->select('equipment_machine_id', DB::raw('count(*) as usage_count'))
        ->groupBy('equipment_machine_id')
        ->orderByDesc('usage_count')
        ->pluck('equipment_machine_id');

        $topUsedEquipment = Equipment::where('is_deleted', false)
        ->whereHas('equipmentMachines', function ($query) use ($topUsedEquipmentMachineIds) {
            $query->whereIn('equipment_machine_id', $topUsedEquipmentMachineIds)
                ->where('status', 'available');
        })
        ->limit(5)
        ->get();

        $topUsedEquipmentCount = $topUsedEquipment->count();

        if ($topUsedEquipmentCount < 5) {
            $needed = 5 - $topUsedEquipmentCount;
    
            $additionalEquipment = Equipment::where('is_deleted', false)
                ->whereDoesntHave('equipmentMachines', function ($query) use ($topUsedEquipmentMachineIds) {
                    $query->whereIn('equipment_machine_id', $topUsedEquipmentMachineIds)
                          ->where('status', 'available');
                })
                ->whereHas('equipmentMachines', function ($query) {
                    $query->where('status', 'available');
                })
                ->limit($needed)
                ->get();
    
            // Merge the additional equipment with the top used equipment
            $topUsedEquipment = $topUsedEquipment->merge($additionalEquipment);
        }

        // $availableEquipment = Equipment::where('is_deleted', false)
        // ->whereHas('equipmentMachines', function ($query) {
        //     $query->where('status', 'available');
        // })
        // ->withCount(['equipmentMachines as available_machines_count' => function ($query) {
        //     $query->where('status', 'available');
        // }])
        // ->having('available_machines_count', '>', 1)
        // ->get();

        $maintenanceEquipment = Equipment::with('equipmentMachines')
        ->where('is_deleted', false)
        ->whereHas('equipmentMachines', function ($query) {
            $query->where('status', 'maintenance');
        })
        ->get();
        return view('equipment.index', compact('currentQueueCount','isReserved' ,'isQueue','isCheckIn','gymIsFull','topUsedEquipment', 'maintenanceEquipment'));

    }

    public function categoryEquipment($category){
        $userId = Auth::id();
        $gymUser = GymUser::where('user_id', $userId)->first();
        $gymUserId = $gymUser->gym_user_id;
        $isCheckIn = $this->isUserCheckedIn();
        $equipment = Equipment::where('is_deleted', false)
        ->where('category', $category)
        ->withCount(['equipmentMachines as available_machines_count' => function ($query) {
            $query->where('status', 'available');
        }])
        ->get();

        $allowSharing = collect(Equipment::getAllowSharingEquipment());
        $allowSharing = $allowSharing->filter(function ($item) {
            return $item->status !== 'available';
        });
        // Adding status to each equipment
        $gymUserId = Auth::user()->gymUser->gym_user_id;
        $equipment->each(function ($item) use ($gymUserId) {
            $item->status = $item->available_machines_count > 1 ? 'Available' : 'Not available';
            $item->statusDetail = $this->getInUseStatus($item->equipment_id, $gymUserId);
        });

        return view('equipment.category', compact('isCheckIn','allowSharing','equipment', 'category'));
    }

    public function trainerCategoryEquipment($category){
        $equipment = EquipmentMachine::with('equipment')
        ->whereHas('equipment', function($query) use ($category){
            $query->where('category', $category)
            ->where('is_deleted', false);
        })
        ->get();

        return view('equipment.trainer.category', compact('equipment','category'));
    }
    // public function allEquipment()
    // {
    //     // Fetch all equipment data
    //     $equipment = Equipment::where('is_deleted', false)->get();
    //     // Pass the data to the view
    //     return view('equipment.all', compact('equipment'));
    // }

    public function viewEquipment($id)
    {
        $isCheckIn = $this->isUserCheckedIn();
        $equipment = Equipment::with(['tutorials', 'equipmentMachines'])
        ->where('is_deleted', false)
        ->withCount(['equipmentMachines as available_machines_count' => function ($query) {
            $query->where('status', 'available');
        }])
        ->findOrFail($id);
        $equipment->status = $equipment->available_machines_count > 1 ? 'Available' : 'Not available';

        return view('equipment.view', compact('isCheckIn','equipment'));
    }

    public function deleteEquipment(Request $request)
    {
        $equipmentId = $request->input('id');

        $equipment = Equipment::find($equipmentId);

        if ($equipment) {
            $equipment->is_deleted = true;
            $equipment->save();
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false]);
        }
    }

    public function addEquipment()
    {
        return view('equipment.admin.add');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
            'category' => 'required|in:upper body machines,leg machines,cardio machines,free weightss',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'quantity' => 'nullable|integer',
            'tutorial_youtube' => 'nullable|url|max:2083',
            'instructions' => 'sometimes|array',
            'instructions.*' => 'nullable|string|max:500',
            'machineLabels' => [
            'sometimes',
            'array',
            function ($attribute, $value, $fail) {
                $uniqueLabels = array_unique($value);
                if (count($uniqueLabels) < count($value)) {
                    $fail('Each machine label must be unique.');
                }
            }
        ],
            'machineLabels.*' => 'nullable|string|max:255',
        ]);
        $directory = '/img/equipment';
        if (!Storage::exists($directory)) {
            Storage::makeDirectory($directory);
        }
        $imagePath = $request->file('image')->store($directory, 'public');

        $equipment = Equipment::create([
            'name' => $request->name,
            'description' => $request->description,
            'category'=> $request->category,
            'has_weight' => $request->category == 'cardio machines'? false : true,
            'image' => $imagePath,
            'quantity' => $request->quantity,
            'tutorial_youtube' => $request->tutorial_youtube,
        ]);

        // Check if instructions are provided
        if ($request->has('instructions')) {
            $instructions = $request->instructions;

            // Check if all items in the instructions array are not null or empty
            $instructions = array_filter($instructions, fn($value) => !empty(trim($value)));

            // Insert instructions if any valid instructions are present
            if (!empty($instructions)) {
                foreach ($instructions as $instruction) {
                    $equipment->tutorials()->create(['instruction' => trim($instruction)]);
                }
            }
        }

         // Save the equipment labels
         if ($request->has('machineLabels')) {
            foreach ($request->machineLabels as $label) {
                $equipment->equipmentMachines()->create(['label' => $label]);
            }
        }

        return redirect()->route('equipment-all')->with('success', 'Equipment added successfully.');
    }

    public function viewAllEquipment()
    {
        $equipment = Equipment::where('is_deleted', false)->get();
        return view('equipment.admin.all', compact('equipment'));
    }

    public function adminViewEquipment($id)
    {
        $equipment = Equipment::with(['tutorials', 'equipmentMachines'])->findOrFail($id);
        return view('equipment.admin.view', compact('equipment'));
    }

    public function editEquipment($id)
    {
        $equipment = Equipment::with(['tutorials', 'equipmentMachines'])->findOrFail($id);
        return view('equipment.admin.edit', compact('equipment'));
    }

    public function updateEquipment(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
            'category' => 'required|in:upper body machines,leg machines,free weights,cardio machines',
            'quantity' => 'required|integer|min:1|max:10',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'tutorial_youtube' => 'nullable|url|max:2083',
            'instructions' => 'sometimes|array',
            'instructions.*' => 'nullable|string|max:500',
            'machineLabels' => [
            'sometimes',
            'array',
            function ($attribute, $value, $fail) {
                $uniqueLabels = array_unique($value);
                if (count($uniqueLabels) < count($value)) {
                    $fail('Each machine label must be unique.');
                }
            }
        ],
            'machineLabels.*' => 'nullable|string|max:255',
        ]);

        $equipment = Equipment::findOrFail($id);

        // Check if the image is updated
        if ($request->hasFile('image')) {
            $directory = '/img/equipment';
            if (!Storage::exists($directory)) {
                Storage::makeDirectory($directory);
            }

            // Delete the old image
            if ($equipment->image && Storage::exists($equipment->image)) {
                Storage::delete($equipment->image);
            }

            $imagePath = $request->file('image')->store($directory, 'public');
        } else {
            $imagePath = $equipment->image;
        }

        $equipment->update([
            'name' => $request->name,
            'description' => $request->description,
            'category' => $request->category,
            'quantity' => $request->quantity,
            'image' => $imagePath,
            'has_weight' => $request->category == 'cardio machines'? false : true,
            'tutorial_youtube' => $request->tutorial_youtube,
        ]);
        // Update instructions
        $equipment->tutorials()->delete();

        // Check if instructions are provided
        if ($request->has('instructions')) {
            $instructions = $request->instructions;

            // Check if all items in the instructions array are not null or empty
            $instructions = array_filter($instructions, fn($value) => !empty(trim($value)));

            // Insert instructions if any valid instructions are present
            if (!empty($instructions)) {
                foreach ($instructions as $instruction) {
                    $equipment->tutorials()->create(['instruction' => trim($instruction)]);
                }
            }
        }


        // Update equipment machines
        $equipment->equipmentMachines()->delete();
        if ($request->has('machineLabels')) {
            foreach ($request->machineLabels as $label) {
                $equipment->equipmentMachines()->create(['label' => $label]);
            }
        }

        return redirect()->route('equipment-admin-view',$equipment->equipment_id)->with('success', 'Equipment updated successfully.');
    }

    public function trainerEquipments()
    {
        $availableEquipments = EquipmentMachine::with('equipment')
        ->where('status', 'available')
        ->orderBy('equipment_id')
        ->get();
        $inUseEquipments = EquipmentMachine::with('equipment')
        ->where('status', 'in use')
        ->orderBy('equipment_id')
        ->get();
        return view('equipment.trainer.all', compact('availableEquipments', 'inUseEquipments'));
    }

    public function statusUpdate($id)
    {
        $equipmentMachine = EquipmentMachine::findOrFail($id);
        $status = $equipmentMachine->status;
        if($status == 'in use'){
            $equipmentMachine->update(['status' => 'available']);
            $workout = Workout::where('equipment_machine_id', $id)
            ->where('status', 'in_progress')
            ->first();
            $workout??$workout->update(['status' => 'completed']);
            $queue = WorkoutQueue::where('equipment_machine_id', $id)
            ->where('status', 'inuse')
            ->first();
            $queue??$queue->update(['status' => 'completed']);

            // update workout status of the equipment machine
            $workout = Workout::with('gymUser.user')
                    ->where('equipment_machine_id', $id)
                    ->where('status', 'in_progress')
                    ->first();

    
            if (!$workout) {
                return redirect()->back()->with('error', 'No workout in progress.');
            }

            $workout->end_time = now();
            $workout->status = 'completed';
            $workout->save();
    
            $workoutQueue = WorkoutQueue::find($workout->workout_queue_id);
            $workoutQueue->status = 'completed';
            $workoutQueue->save();
    
            // For sharing workout
            // Find the EquipmentMachine and its related Equipment
            $equipmentMachine = EquipmentMachine::with('equipment')->find($workout->equipment_machine_id);
    
            //  Check if there are other 'in_progress' or 'in_use' workouts for the same EquipmentMachine
            $otherWorkoutsCount = Workout::where('equipment_machine_id', $equipmentMachine->equipment_machine_id)
                ->whereIn('status', ['in_progress', 'in_use'])
                ->where('workout_id', '!=', $workout->workout_id) // Exclude the current workout if it's still 'in_progress' or 'in_use'
                ->count();
    
            //  Update the status if no other workouts exist
            if ($otherWorkoutsCount === 0) {
                $equipmentMachine->status = 'available';
                $equipmentMachine->save();
            }
            
            $workoutController = new WorkoutController();
            $workoutController->callNextInQueue($equipmentMachine->equipment->equipment_id);
        }else{
            return redirect()->back()->with('error', 'Equipment is not in used.');
        }
        return redirect()->back()->with('success', 'Equipment status updated successfully.');
    }

    public function getEquipmentMachines(Request $request)
    {
        $equipmentId = $request->get('equipment_id');
        $machines = EquipmentMachine::where('equipment_id', $equipmentId)
        ->where('status', '!=', 'maintenance')
        ->get();

        return response()->json($machines);
    }

    
}
?>