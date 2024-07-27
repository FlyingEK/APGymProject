<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\GymQueue;
use App\Models\GymConstraint;
use App\Notifications\ReservationCancelledNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use App\Notifications\TurnNotification;


class NotificationController extends Controller
{
    public function index()
    {
        return view('notification.index');
    }

    public function test(){
        $gymQueue = GymQueue::find(19);
        $gymQueue = GymQueue::with('gymUser.user')->where('id', $gymQueue->id)->first();

        try {
            Notification::send($gymQueue->gymUser->user, new ReservationCancelledNotification(""))  ;
    
            return "Notification sent.";
        } catch (\Exception $e) {
            return redirect()->back()->with('error', "Failed to send notification: " . $e->getMessage());
        }
        return view('equipment.any');
    }


}
?>