<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GymQueue;
use App\Models\GymConstraint;

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
        return view('gym.index');
    }


    


}
?>