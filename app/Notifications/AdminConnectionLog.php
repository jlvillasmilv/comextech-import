<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Carbon\Carbon;

class AdminConnectionLog extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
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
                    ->line('Limite maximo de conexiónes alcanzado')
                    ->action('Notification Action', url('/'))
                    ->line('Se ah alcanzado el limete Dirario de conexion para la plataforma libreDTE');
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
            'title'       => 'Limite maximo de conexiónes alcanzado',
            'description' => 'Se ah alcanzado el limete Dirario de conexion para la plataforma libreDTE',
            'time'        => Carbon::now()->diffForHumans(),
            'route'       => route('admin.disbursements.index'),
        ];
    }
}
