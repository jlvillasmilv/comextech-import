<?php

namespace App\Notifications\Admin;

use App\Models\FreightQuote;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class FreightQuotesNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(FreightQuote $freight_quote)
    {
        $this->freight_quote =$freight_quote;
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
                    ->line("Solicitud de Cotización")
                    ->line("Cliente: {$this->freight_quote->customer->name}")
                    ->line("Telfono: {$this->freight_quote->customer->phone_number}")
                    ->line("Correo Electrónico: {$this->freight_quote->customer->email}")
                    // ->action('Revisar', url('/'))
                    ->line("Ah Solicitado una Cotización N° {$this->freight_quote->code} ");
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
            'application' => $this->freight_quote->id,
            'title'       => 'Cotización N° '. $this->freight_quote->code,
            'description' => 'Se ah generado una Cotización N° '. $this->freight_quote->code,
            'time'        => Carbon::now()->diffForHumans(),
            'route'       => '',
        ];
    }
}
