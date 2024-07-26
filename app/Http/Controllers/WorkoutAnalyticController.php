<?php
namespace App\Http\Controllers;
use App\Models\Equipment;
use App\Models\GymUser;
use App\Models\Workout;
use App\Models\Goal;
use App\Models\OverallGoal;
use App\Models\StrengthEquipmentGoal;
use App\Models\StrengthWorkoutHabit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class WorkoutAnalyticController extends Controller
{

    public function getGymUserId(){
        $gymUser = GymUser::where('user_id', Auth::user()->user_id)->first();
        return $gymUser->gym_user_id;
    }

    public function index()
    {
        $allEquipments = Equipment::where('is_deleted', false)->get();
        $gymUserId = $this->getGymUserId();
        $strengthGoals = StrengthEquipmentGoal::with('equipment')->whereHas('goal', function($query) use ($gymUserId){
            $query->where('gym_user_id', $gymUserId)
            ->where('status', 'active');
        })->get();
        $overallGoal = OverallGoal::whereHas('goal', function($query) use ($gymUserId){
            $query->where('gym_user_id', $gymUserId)
            ->where('status', 'active')
            ->orWhere('status', 'completed');
        })->first();
         // Ensure these are Carbon instances
        $overallGoal->updated_at = Carbon::parse($overallGoal->updated_at);
        $overallGoal->target_date = Carbon::parse($overallGoal->target_date);
        $completedStrengthGoals = StrengthEquipmentGoal::with('equipment')->whereHas('goal', function($query) use ($gymUserId){
            $query->where('gym_user_id', $gymUserId)
            ->where('status', 'completed');
        })->get();

        return view('workout-analytic.index', compact('allEquipments','strengthGoals','overallGoal','completedStrengthGoals'));
    }

    public function setGoal()
    {
        $gymUserId = $this->getGymUserId();
        $allEquipment = Equipment::where('is_deleted', false)
        ->where('has_weight',1)
        ->get();
        // $goals = Goal::with(['overallGoal','strengthEquipmentGoal'])
        // ->where('gym_user_id', $gymUserId)
        // ->where('status', 'active')
        // ->get();
        $strengthGoal = StrengthEquipmentGoal::with('equipment')->whereHas('goal', function($query) use ($gymUserId){
            $query->where('gym_user_id', $gymUserId);
        })->get();
        $overallGoal = OverallGoal::whereHas('goal', function($query) use ($gymUserId){
            $query->where('gym_user_id', $gymUserId)
            ->where('status', 'active')
            ->orWhere('status', 'completed');
        })->first();
        // $
        // $strengthGoal = $goals->pluck('strengthEquipmentGoal')->flatten();
        // $strengthGoal =$strengthGoal->filter();
        return view('workout-analytic.set-goal', compact('allEquipment','overallGoal','strengthGoal'));
    }

    public function storeStrengthGoal(Request $request){
        $gymUserId = $this->getGymUserId();
        $data = request()->validate([
            'equipment_ids' => 'sometimes|array',
            'equipment_ids.*' => 'required|integer',
            'goalValues' => 'sometimes|array',
            'goalValues.*' => 'required|integer|min:5|max:100',
        ]);
        $oldGoals = Goal::whereHas('strengthEquipmentGoal', function($query) use ($gymUserId) {
            $query->where('gym_user_id', $gymUserId);
        })->get();
    
        // Delete the associated strength equipment goals first
        foreach ($oldGoals as $goal) {
            $goal->strengthEquipmentGoal()->delete();
        }
    
        // Delete the old goals
        Goal::whereHas('strengthEquipmentGoal', function($query) use ($gymUserId) {
            $query->where('gym_user_id', $gymUserId);
        })->delete();

        if ($request->has('equipment_ids') && $request->has('goalValues')) {
            foreach($request->equipment_ids as $index => $equipmentId){
                $newGoal = Goal::create([
                    'gym_user_id' => $this->getGymUserId(),
                    'start_date' => now()->toDateString(),
                    'status' => "active",
                ]);
                $maxWeight = Workout::with('equipmentMachine.equipment')
                ->where('gym_user_id', $this->getGymUserId())
                ->where('status', 'completed')
                ->whereHas('equipmentMachine', function($query) use ($equipmentId) {
                    $query->where('equipment_id', $equipmentId);
                })
                ->max('weight');

                
                $newGoal->strengthEquipmentGoal()->create([
                    'equipment_id' => $equipmentId,
                    'weight' => $data['goalValues'][$index],
                    'progress' => $maxWeight??0,
                ]);
            }
        }
        return redirect()->route('analytic-report')->with("success", "Strength workout goal(s) added successfully.");
    }

    public function storeOverallGoal(Request $request,$goalId){
        $gymUserId = $this->getGymUserId();
        $data = $request->validate([
            'workout_hour' => 'required|int|min:1|max:80',
            'per' => 'required|in:week,month',
        ]);
        if($data['per'] == 'week'){
            $target_date = now()->addWeeks(1)->toDateString();
        }elseif($data['per'] == 'month'){
            $target_date = now()->addMonths(1)->toDateString();
        }

        $progress =  Workout::where('gym_user_id', $gymUserId)
        ->where('status', 'completed')
        ->whereDate('date', now()->toDateString())
        ->get()
        ->sum('duration');
        $progress = round($progress / 60);

        if(empty($goalId)){
            $goal = Goal::create(
                [
                'gym_user_id' => $gymUserId,
                'start_date' => now()->toDateString(),
                'per' => $data['per'],
                'status' => "active",
                ]
            );

            $overallGoal = OverallGoal::create(
                [
                'goal_id' => $goal->goal_id,
                'workout_hour' => $data['workout_hour'],
                'target_date' => $target_date,
                'progress' => $progress,
                ]
            );
        }else{
            $goal = Goal::find($goalId);
            $goal->update(
                [
                'start_date' => now()->toDateString(),
                'status' => "active",
                ]
            );

            $overallGoal = OverallGoal::where('goal_id', $goalId)->first();
            $overallGoal->update(
                [
                'workout_hour' => $data['workout_hour'],
                'target_date' => $target_date,
                'per' => $data['per'],
                'progress' => $progress,
                ]
            );
        
        }
        return redirect()->route('analytic-report')->with("success", "Overall workout hour goal added successfully.");
    }

    public function record()
    {
        $allEquipment = Equipment::where('is_deleted', false)->get();
        return view('workout-analytic.record', compact('allEquipment'));
    }

    public function recordDetails($workoutId)
    {
        $workout = Workout::with('equipmentMachine.equipment')->find($workoutId);
        $intDuration = intval($workout->duration);
        $hours = round($intDuration / 60);
        $minutes = $intDuration % 60;
        $seconds = 0;
        $duration = sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);

        return view('workout-analytic.record-details', compact('workout', 'duration'));
    }

    public function workoutRecord($date){
        $gymUserId = $this->getGymUserId();

        $sevenDaysAgo = now()->subDays(7)->startOfDay();
        $today = now()->endOfDay();

        $workoutRecord = Workout::with('equipment')
            ->where('gym_user_id', $gymUserId)
            ->where('status', 'completed')
            ->whereBetween('date', [$sevenDaysAgo, $today])
            ->groupBy('date')
            ->get();

        if(!empty($date)){
            $workoutRecord = Workout::with('equipment')
        ->where('gym_user_id', $gymUserId)
        ->where('status', 'completed')
        ->where('date', $date)
        ->get();
        }
        return $workoutRecord;
    }
}
?>