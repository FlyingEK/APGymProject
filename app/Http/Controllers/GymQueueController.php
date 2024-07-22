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
                return response()->json(['gymsuccess'=>true,'message' => 'You have been added to the queue.']);
            }else{
                $code = $this->generateUniqueCheckInCode();
                GymQueue::create([
                    'gym_user_id' => $gymUserId,
                    'status' => 'reserved',
                    'check_in_code' => $code,
                    'reserved_until' => now()->addMinutes(2),
                ]);
                $user = Auth::user();
                Notification::send($user, new TurnNotification(true, $code));

                return response()->json(['gymsuccess'=>true,'message' => 'Check the verification code sent to your notification and enter it on trainer device.']);

            // if ($user instanceof \Illuminate\Notifications\Notifiable) {
            //     $user->notify(new TurnNotification(true, $code));
            // } else {
            //     // Handle the case when $user is not an instance of Notifiable
            //     // For example, you can log an error or throw an exception
            // }

            }
        }else{
            return response()->json(['gymsuccess'=>false, 'message' => 'Already in queue.']);

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
        $user = GymQueue::where('gym_user_id', $gymUserId)->first();

        if ($user) {

            $user->update([
                $user->status = 'left',
            ]);

            // Reserve the next user in the queue
            $this->reserveNextUser();
        }
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
            return redirect()->route('gym.checkin')->with('status', 'You have successfully checked in.');
        }

        return redirect()->route('gym.checkin')->with('status', 'Invalid check-in code or your reservation has expired.');
    }


}
?>