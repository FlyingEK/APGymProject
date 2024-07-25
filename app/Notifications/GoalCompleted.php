<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

class GoalCompleted extends Notification
{
    use Queueable;
    protected $goal;

    /**
     * Create a new notification instance.
     */
    public function __construct($goal)
    {
        $this->goal = $goal;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['broadcast','database'];
    }

    protected function getMessage()
    {
        if ($this->goal instanceof \App\Models\StrengthEquipmentGoal) {
            return 'You have achieved '+$this->goal->weight+' kg on '+$this->goal->equipment->name;
        }

        if ($this->goal instanceof \App\Models\OverallGoal) {
            return 'You have completed your workout goal of ' + $this->goal->workout_hour + ' hours per '
            +$this->goal->per;
        }

        return 'You have completed a goal!';
    }
    /**
     * Get the mail representation of the notification.
     */
    // public function toMail(object $notifiable): MailMessage
    // {
    //     return (new MailMessage)
    //                 ->line('The introduction to the notification.')
    //                 ->action('Notification Action', url('/'))
    //                 ->line('Thank you for using our application!');
    // }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'title' => "Goal completed!",
            'message' => $this->getMessage(),
            'datetime' => now()->toDateTimeString()
        ];
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'title' => "Goal completed!",
            'message' => $this->getMessage(),
            'datetime' => now()->toDateTimeString()
        ]);
    }


}
