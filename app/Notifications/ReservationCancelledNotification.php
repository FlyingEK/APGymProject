<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ReservationCancelledNotification extends Notification
{
    use Queueable;
    public $equipment;
    /**
     * Create a new notification instance.
     */
    public function __construct($equipment)
    {
        $this->equipment = $equipment;
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
        if (empty($this->equipment)) {
            $title = 'Gym Check-In Reservation Cancelled';
            $message = 'Your gym check-in reservation has expired after two minutes. Please queue or check in again if you wish to use the facility.';
        } else {
            $title = 'Equipment Reservation Cancelled';
            $message = 'Your reservation for ' . $this->equipment . ' has expired after two minutes. Please queue again if you still want to use this equipment.';
        }
        return [
            'title' => $title,
            'message' => $message,
            'datetime' => now()->toDateTimeString()
        ];
    }

    public function toBroadcast($notifiable)
    {
        if (empty($this->equipment)) {
            $title = 'Gym Check-In Reservation Cancelled';
            $message = 'Your gym check-in reservation has expired after two minutes. Please queue or check in again if you wish to use the facility.';
        } else {
            $title = 'Equipment Reservation Cancelled';
            $message = 'Your reservation for ' . $this->equipment . ' has expired after two minutes. Please queue again if you still want to use this equipment.';
        }
        return new BroadcastMessage([
            'title' => $title,
            'message' => $message,
            'datetime' => now()->toDateTimeString()
        ]);
    }
}
