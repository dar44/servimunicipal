<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class WelcomeRegisteredUser extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * El usuario recién registrado
     *
     * @var \App\Models\User
     */
    public $user;

    /**
     * Crea una nueva instancia del Mailable.
     *
     * @param  \App\Models\User  $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Construye el mensaje.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->subject('¡Bienvenido a nuestra aplicación!')
            ->markdown('emails.users.registered');
    }
}
