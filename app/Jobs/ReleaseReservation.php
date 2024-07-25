<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\GymQueue;
use App\Notifications\TurnNotification;
use Illuminate\Support\Str;

class ReleaseReservation implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    protected $gymQueue;
    public function __construct(GymQueue $gymQueue)
    {
        $gymQueue = $gymQueue;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        if($this->gymQueue->status === 'reserved'){
            $this->gymQueue->status = 'left';
            $this->gymQueue->save();
            $this->callNextInQueue();
        }

    }
    public function generateUniqueCheckInCode()
    {
        do {
            $code = Str::random(4);
        } while (GymQueue::where('check_in_code', $code)->exists());

        return $code;
    }

    public function callNextInQueue(){
        $nextUser = GymQueue::with('gymUser.user')
        ->where('status', 'queueing')
       ->orderBy('created_at')
       ->first();

        if ($nextUser) {
            $nextUser->status = 'reserved';
            $nextUser->reserved_until = now()->addMinutes(2);
            $nextUser->check_in_code = $this->generateUniqueCheckInCode(); 
            
            // Send TurnNotification
            $nextUser->gymUser()->user()->notify(new TurnNotification(false, $nextUser->check_in_code));
            $nextUser->save();
            $this->setGymReservationTimer($nextUser);

        }
    }
    
    protected function setGymReservationTimer(GymQueue $queue)
    {
        // Use a delayed job to change the status back after 2 minutes
        $job = (new \App\Jobs\ReleaseReservation($queue))
            ->delay(now()->addMinutes(2));

        dispatch($job);
    }

}
