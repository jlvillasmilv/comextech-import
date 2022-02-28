<?php

namespace App\Notifications\Admin;

use App\Models\{User,Application};
use Illuminate\Bus\Queueable;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ApplicationStatusNotification extends Notification
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
        return ['mail','database'];
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
            ->line("Cliente: {$this->application->user->name}")
            ->line("Ah cambiado el status de la Solicitud: {$this->application->code}")
            ->line("ah cambiado a: {$this->application->status->name}");
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
            'application' => $this->application->id,
            'title'       => 'Cotización N° '. $this->application->code,
            'description' => 'Se ah cambiado de status a: '. $this->application->status->name,
            'time'        => Carbon::now()->diffForHumans(),
            'route'       => route('admin.applications.index'),
        ];
    }
}
