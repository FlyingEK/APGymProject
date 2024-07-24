<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EquipmentReserved extends Notification
{
    use Queueable;
    public $equipmentLabel;
    public $equipmentName;
    /**
     * Create a new notification instance.
     */
    public function __construct($equipmentLabel,$equipmentName)
    {
        $this->equipmentLabel = $equipmentLabel;
        $this->equipmentName = $equipmentName;
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
            'title' => "It's your turn to use ".$this->equipmentName,
            'message' => $this->equipmentName.' #'.$this->equipmentLabel .' has been reserved for you. Please check it in the Workout tab and use it within the next 2 minutes.',
            'datetime' => now()->toDateTimeString()
        ];
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'title' => "It's your turn to use ".$this->equipmentName,
            'message' => $this->equipmentName.' #'.$this->equipmentLabel .' has been reserved for you. Please check it in the Workout tab and use it within the next 2 minutes.',
            'datetime' => now()->toDateTimeString()

        ]);
    }
}
