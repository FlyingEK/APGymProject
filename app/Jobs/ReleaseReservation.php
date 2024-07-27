<?php
namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\GymQueue;
use App\Notifications\TurnNotification;
use App\Notifications\ReservationCancelledNotification;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;

class ReleaseReservation implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $gymQueue;

    /**
     * Create a new job instance.
     */
    public function __construct(GymQueue $gymQueue)
    {
        $this->gymQueue = $gymQueue;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Log::info('ReleaseReservation job started', ['gymQueue_id' => $this->gymQueue->id]);

        if ($this->gymQueue->status === 'reserved') {
            $this->gymQueue->status = 'left';
            $this->gymQueue->save();

                Notification::send($this->gymQueue->gymUser->user, new ReservationCancelledNotification(""))  ;
        
            $this->callNextInQueue();
        } else {
            Log::info('GymQueue status is not reserved', ['gymQueue_id' => $this->gymQueue->id, 'status' => $this->gymQueue->status]);
        }
    }

    public function generateUniqueCheckInCode()
    {
        do {
            $code = Str::random(4);
        } while (GymQueue::where('check_in_code', $code)->exists());

        return $code;
    }

    public function callNextInQueue()
    {
        $nextUser = GymQueue::with('gymUser.user')
            ->where('status', 'queueing')
            ->orderBy('created_at')
            ->first();

        if ($nextUser) {
            $nextUser->status = 'reserved';
            $nextUser->reserved_until = now()->addMinutes(2);
            $nextUser->check_in_code = $this->generateUniqueCheckInCode();

            // Send TurnNotification
            Notification::send($nextUser->gymUser->user, new TurnNotification(false, $nextUser->check_in_code))  ;

            $nextUser->save();

            Log::info('Next user reserved', ['gymQueue_id' => $nextUser->id, 'check_in_code' => $nextUser->check_in_code]);

            $this->setGymReservationTimer($nextUser);
        } else {
            Log::info('No users in the queue');
        }
    }

    protected function setGymReservationTimer(GymQueue $queue)
    {
        $job = (new \App\Jobs\ReleaseReservation($queue))
            ->delay(now()->addMinutes(2));

        dispatch($job);
    }
}
