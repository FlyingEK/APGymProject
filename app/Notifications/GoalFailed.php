<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;

class GoalFailed extends Notification
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
        return ['mail','broadcast','database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                ->line('You have failed to meet your workout goal.')
                ->line('Goal: ' . $this->goal->workout_hour . ' hours')
                ->line('Target Date: ' . $this->goal->target_date)
                ->line('Don’t get discouraged! Keep pushing forward and you’ll reach your goals.')
                ->line('Keep moving!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'title' => "Goal Failed",
            'message' => 'You have failed to meet your workout goal of ' . $this->goal->workout_hour . ' hours before the target date.',
            'datetime' => now()->toDateString(),
        ];
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'title' => "Goal Failed",
            'message' => 'You have failed to meet your workout goal of ' . $this->goal->workout_hour . ' hours before the target date.',
            'datetime' => now()->toDateString(),
        ]);
    }
}
