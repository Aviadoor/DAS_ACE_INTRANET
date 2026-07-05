<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendMfaCode extends Notification
{
    use Queueable;

    protected $code;

    public function __construct($code)
    {
        $this -> code = $code;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    -> subject('Tu codigo de verificacion de inicio de sesion')
                    -> greeting('Hola!')
                    -> line('Estas intentado iniciar sesion en nuestra plataforma')
                    -> line('Para completar el acceso, utiliza el siguiente codigo de verificacion de un solo uso:')
                    -> action($this -> code, url('/'))
                    -> line('Este codigo expirara en 10 minutos')
                    -> line('Si tu no solicitaste este acceso, por favor ignorar este correo.');
    }
    

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
