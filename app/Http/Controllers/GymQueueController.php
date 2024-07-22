<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\GymQueue;
use App\Events\QueueUpdated;
use App\Models\GymConstraint;
use App\Models\GymUser;
use App\Notifications\TurnNotification;
use App\Notifications\ReservationCancelledNotification;
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
                GymQueue::create([
                    'gym_user_id' => $gymUserId,
                    'status' => 'reserved',
                    'check_in_code' => $code,
                    'reserved_until' => now()->addMinutes(2),
                ]);
                $user = Auth::user();
                Notification::sendNow($user, new TurnNotification(true, $code)); // Queue the notification
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

            // Reserve the next user in the queue
            if($gymIsFull){
                $this->reserveNextUser();

            }
        }
        return redirect()->back()->with('success', 'You have left the gym.');
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

        $user = GymQueue::where('check_in_code', $request->check_in_code)
                    ->where('status', 'reserved')
                    ->first();

        if ($user) {
            $user->status = 'entered';
            $user->entered_at = now();
            $user->check_in_code = null; // Clear the check-in code
            $user->reserved_until = null;
            $user->save();
            //send notification
            return redirect()->back()->with('success', 'User successfully checked in.');
        }

        return redirect()->back()->with('error', 'Invalid check-in code or the reservation has expired.');
    }


}
?>