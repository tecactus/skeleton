<?php

namespace Tecactus\Skeleton\Auth\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class AccountActivation extends Notification
{
    use Queueable;
    
    /**
     * The password activation token.
     *
     * @var string
     */
    public $token;
    
    /**
     * The user email address.
     *
     * @var string
     */
    public $email;

    /**
     * Create a notification instance.
     *
     * @param  string  $token
     * @return void
     */
    public function __construct($token, $email)
    {
        $this->token = $token;
        $this->email = $email;
    }

    /**
     * Get the notification's channels.
     *
     * @param  mixed  $notifiable
     * @return array|string
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Build the mail representation of the notification.
     *
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail()
    {
        return (new MailMessage)
            ->subject('Activa tu Cuenta - ' . config('app.name'))
            ->line([
                'Estas recibiendo este email porque necesitas activar tu cuenta para poder usar por completo nuestro servicio.',
                'Has click en el botón de abajo para activar tu cuenta:',
            ])
            ->action('Activar mi Cuenta', route('activation', ['token' => $this->token ,'email' => $this->email]));
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
