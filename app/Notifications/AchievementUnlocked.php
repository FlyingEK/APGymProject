<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;

class AchievementUnlocked extends Notification
{
    use Queueable;
    protected $condition;
    /**
     * Create a new notification instance.
     */
    public function __construct($condition)
    {
        $this->condition = $condition;
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

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'title' => 'Achievement Unlocked',
            'message' => 'You have unlocked a new achievement on '+$this->condition+'!',
            'datetime' => now()->toDateString(),
        ];
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'title' => 'Achievement Unlocked',
            'message' => 'You have unlocked a new achievement on '+$this->condition+'!',
            'datetime' => now()->toDateString(),

        ]);
    }
}
