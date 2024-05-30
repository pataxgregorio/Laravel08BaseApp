<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RegisterConfirm extends Notification implements ShouldQueue
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
                    ->subject('Confirme el registro de HORUS')
                    ->line('Estimado(a). '.$notifiable->name)
                    ->line('Bienvenido a HORUS Venezuela,')
                    ->action('Confirme para culminar el registro',url('register/confirm/'.$notifiable->confirmation_code))
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
