<?php

namespace App\Notifications\CLient;

use App\Models\Application;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

use App\Channels\Messages\WhatsAppMessage;
use App\Channels\WhatsAppChannel;

class ValidationCodeNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Application $application)
    {
        $this->application =$application;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                 ->line("Codigo de Validacion Para solicitud #: {$this->application->code}")
                 ->line("Codigo: {$this->application->authorization_code}");
    }

    public function toWhatsApp($notifiable)
    {
       
        return (new WhatsAppMessage)
            ->content("Codigo de Validacion Para solicitud #: {$this->application->code}. Codigo: {$this->application->authorization_code}");
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
