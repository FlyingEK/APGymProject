<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Notifications\Messages\BroadcastMessage;

class TurnNotification extends Notification implements ShouldBroadcast
{
    use Queueable;
    public $checkInCode;
    public $directCheckIn;

    /**
     * Create a new notification instance.
     */
    public function __construct($directCheckIn, $checkInCode)
    {
        $this->checkInCode = $checkInCode;
        $this->directCheckIn = $directCheckIn;

    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database','broadcast'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        if($this->directCheckIn){
            $msg = 'Please enter the gym within the next 2 minutes.';
        }else{
            $msg = 'It is your turn now. Please enter the gym within the next 2 minutes.';
        }

        return (new MailMessage)
        ->line('Your check-in code is: ' . $this->checkInCode)
        ->line($msg)
        ->line('Thank you for using our application!');

    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable):array
    {
        if($this->directCheckIn){
            return [
                'title'=>'Check In Verification Code',
                'message' => 'Your check-in code is:  ' . $this->checkInCode . '.  Please enter the gym within the next 2 minutes.',
                'check_in_code' => $this->checkInCode,
                'datetime' => now()->toDateTimeString()
            ];
        }
        return [
            'title'=>'Gym Queue Notification',
            'message' => 'It is your turn now. Your check-in code is:  ' . $this->checkInCode . '.  Please enter the gym within the next 2 minutes.',
            'check_in_code' => $this->checkInCode,
            'datetime' => now()->toDateTimeString()

        ];

    }

    public function toBroadcast($notifiable)
    {
        if($this->directCheckIn){
            return new BroadcastMessage([
                'title'=>'Check In Verification Code',
                'message' => 'Your check-in code is: <span style="color: #C12323;">' . $this->checkInCode . '</span><br>Please enter the gym within the next 2 minutes.',
                'check_in_code' => $this->checkInCode,
                'datetime' => now()->toDateTimeString()
            ]);
        }
        return new BroadcastMessage([
            'title'=>'Gym Queue Notification',
            'message' => 'It is your turn now. Your check-in code is: <span style="color: #C12323;">' . $this->checkInCode . '</span><br>Please enter the gym within the next 2 minutes.',
            'check_in_code' => $this->checkInCode,
            'datetime' => now()->toDateTimeString()

        ]);
    }
}
