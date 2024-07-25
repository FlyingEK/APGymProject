<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Notification;
use App\Models\EquipmentMachine;
use App\Models\WorkoutQueue;
use App\Notifications\EquipmentReserved;
use App\Notifications\ReservationCancelledNotification;

class ReleaseEquipmentReservation implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    protected $equipmentMachine;
    protected $nextInQueue;
    public function __construct(EquipmentMachine $equipmentMachine, WorkoutQueue $nextInQueue)
    {
        $this->equipmentMachine = $equipmentMachine;
        $this->nextInQueue = $nextInQueue;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        //release the equipment
        if ($this->nextInQueue->status === 'reserved') {
            $this->nextInQueue->status = 'reservation_expired';
            $this->nextInQueue->save();

            $this->equipmentMachine->status = 'available';
            $this->equipmentMachine->save();

            // Call the next in queue
            Notification::send($this->nextInQueue->gymUser->user, new ReservationCancelledNotification($this->equipmentMachine->equipment->name));
            $this->callNextInQueue($this->equipmentMachine->equipment->equipment_id);

        }
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
                $nextInQueue->status = 'reserved';
                $nextInQueue->equipment_machine_id = $equipmentMachine->equipment_machine_id;
                $nextInQueue->save();
                //send notification
                Notification::send($nextInQueue->gymUser->user, new EquipmentReserved($equipmentMachine->label, $equipmentMachine->equipment->name));
                $this->setReservationTimer($equipmentMachine, $nextInQueue);
    
            }
        }
       
    }

    protected function setReservationTimer(EquipmentMachine $equipmentMachine, WorkoutQueue $nextInQueue)
    {
        $job = (new \App\Jobs\ReleaseEquipmentReservation($equipmentMachine, $nextInQueue))
            ->delay(now()->addMinutes(2));

        dispatch($job);
    }
}
