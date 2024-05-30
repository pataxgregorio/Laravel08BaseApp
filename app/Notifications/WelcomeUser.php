<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class WelcomeUser extends Notification implements ShouldQueue
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
                    ->subject('Mensaje de Bienvenida HORUS')                    
                    ->line('Estimado(a). '.$notifiable->name)
                    ->line('Bienvenido a HORUS Venezuela,')
                    ->line('Esperamos que sea de su agrado la presente aplicación')
                    ->line('y que pueda ahorrar tiempo en su trabajo de desarrollo.')
                    ->line('Gracias por utilizar la aplicación HORUS')
                    ->line('Att, Tarsicio Carrizales telecom.com.ve@gmail.com');
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
