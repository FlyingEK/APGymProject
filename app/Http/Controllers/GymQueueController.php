<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\GymQueue;
use App\Events\QueueUpdated;
use App\Models\GymConstraint;
use App\Models\GymUser;
use App\Models\WorkoutQueue;
use App\Models\EquipmentMachine;
use App\Models\Achievement;
use App\Models\User;
use App\Notifications\AchievementUnlocked;
use App\Notifications\TurnNotification;
use App\Notifications\CheckInSuccess;
use App\Notifications\ReservationCancelledNotification;
use App\Notifications\EquipmentReserved;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;


class GymQueueController extends Controller
{
    public function getNextUserInQueue()
    {
        return GymQueue::with('gymUser.user')
                    ->where('status', 'queueing')
                   ->orderBy('created_at')
                   ->first();
                   
    }

    public function generateUniqueCheckInCode()
    {
        do {
            $code = Str::random(4);
        } while (GymQueue::where('check_in_code', $code)->exists());

        return $code;
    }

    public function gymIsFull(){
        $userLimit = GymConstraint::where('constraint_name','max_in_gym_users')->first();
        $userLimit = (int) $userLimit->constraint_value;
    
        $currentQueueCount = GymQueue::where('status', 'entered')->count();
        return $currentQueueCount >= $userLimit;
    }

    public function getGymUserId(){
        $userId = Auth::id();
        $gymUser = GymUser::where('user_id', $userId)->first();
        return $gymUser->gym_user_id;
    }

    public function userEntersGym()
    {
        $gymUserId = $this->getGymUserId();
        $gymIsFull = $this->gymIsFull();
        $isUserInQueue = GymQueue::where('gym_user_id', $gymUserId)
        ->where('status', '!=', 'left')
        ->exists();
       
        if(!$isUserInQueue){
            if ($gymIsFull) {
                GymQueue::create([
                    'gym_user_id' => $gymUserId,
                    'status' => 'queueing',
                ]);
                return redirect()->back()->with('success', 'You have been added to the queue.');
            }else{
                $code = $this->generateUniqueCheckInCode();
                $queue = GymQueue::create([
                    'gym_user_id' => $gymUserId,
                    'status' => 'reserved',
                    'check_in_code' => $code,
                    'reserved_until' => now()->addMinutes(2),
                ]);
                $user = Auth::user();
                Notification::sendNow($user, new TurnNotification(true, $code)); // Queue the notification
                $this->setGymReservationTimer($queue);
                return redirect()->back()->with('success', 'Check the verification code sent to your notification and enter it on trainer device.');
            }
        }else{
            return redirect()->back()->with('error', 'Already in queue.');

        }
    }

    public function reserveNextUser()
    {
        $gymIsFull = $this->gymIsFull();
        $nextUser = $this->getNextUserInQueue();
        if ($nextUser) {
            $nextUser->status = 'reserved';
            $nextUser->reserved_until = now()->addMinutes(2);
            $nextUser->check_in_code = $this->generateUniqueCheckInCode(); 
            
            // Send TurnNotification
            $nextUser->gymUser()->user()->notify(new TurnNotification(false, $nextUser->check_in_code));
            $nextUser->save();
            $this->setGymReservationTimer($nextUser);
            broadcast(new QueueUpdated($nextUser));
        }
    }

    public function userLeavesGym()
    {
        $gymUserId = $this->getGymUserId();
        $gymIsFull = $this->gymIsFull();
        $user = GymQueue::where('gym_user_id', $gymUserId)
        ->where('status', 'entered')
        ->first();

        if ($user) {

            $user->update([
                $user->status = 'left',
            ]);

            //clear all queued gym workout
            $workoutQueue = WorkoutQueue::with(['equipment.equipmentMachine'])
            ->where('gym_user_id', $gymUserId)
            ->where('status', 'queueing')
            ->orWhere('status', 'reserved')
            ->orWhere('status', 'inuse')
            ->get();
                //actual workout also need to stop

            foreach($workoutQueue as $workout){
                $workout->update(['status' => 'completed']);
                $workout->save();

                //call the next user in the queue for workout
                if($workout->equipment->equipmentMachine){
                    $workout->equipment->equipmentMachine->status = 'available';
                    $workout->equipment->equipmentMachine->save();
                    $this->callNextInEquipmentQueue($workout->equipment_id);
                }
               // $workout->equipment->equipmentMachine->status = 'available';
            }
            // Reserve the next user in the queue
            if($gymIsFull){
                $this->reserveNextUser();

            }
        }
        return redirect()->back()->with('success', 'You have left the gym.');
    }

    public function callNextInEquipmentQueue($equipmentId){
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

    protected function setGymReservationTimer(GymQueue $queue)
    {
        // Use a delayed job to change the status back after 2 minutes
        $job = (new \App\Jobs\ReleaseReservation($queue))
            ->delay(now()->addMinutes(2));

        dispatch($job);
    }


    public function showCheckInForm()
    {
        return view('gym.checkin');
    }

    public function checkIn(Request $request)
    {
        $request->validate([
            'check_in_code' => 'required|string',
        ]);

        $user = GymQueue::with('gymUser')->where('check_in_code', $request->check_in_code)
                    ->where('status', 'reserved')
                    ->first();

        if ($user) {
            $user->status = 'entered';
            $user->entered_at = now();
            $user->check_in_code = null; // Clear the check-in code
            $user->reserved_until = null;
            $user->save();
            Notification::send($user->gymUser->user, new CheckInSuccess());

            // check in achievement for user
            $gymUser = GymUser::with('gymUserAchievement')->where('gym_user_id', $user->gym_user_id)->firstOrFail();

            // Calculate total days checked in
            $totalDaysCheckedIn = GymQueue::where('gym_user_id', $gymUser->gym_user_id)
            ->where('entered_at', 'NOT NULL')
            ->distinct()
            ->count('entered_at'); 

            // Define the achievements with their conditions
            $achievements = [
            2 => 7,  // Achievement ID 2 for 7 days
            3 => 30,  
            4 => 100,  
            ];

            foreach ($achievements as $achievementId => $requiredDays) {
                // Check if the user already has this achievement
                if (!$gymUser->gymUserAchievement()->where('achievement_id', $achievementId)->exists()) {
                    // Check if the user meets the condition for this achievement
                    if ($totalDaysCheckedIn >= $requiredDays) {
                    // Unlock the achievement
                        $gymUser->gymUserAchievement()->attach($achievementId);
                        $condition = Achievement::find($achievementId)->condition;
                        Notification::send(User::find($gymUser->user_id), new AchievementUnlocked($achievementId, lcfirst($condition)));

                    }
                }
            }

            return redirect()->back()->with('success', 'User successfully checked in.');
        }

        return redirect()->back()->with('error', 'Invalid check-in code or the reservation has expired.');
    }


}
?>