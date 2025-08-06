<?php

namespace App\Services;

use App\Mail\WelcomeRegisteredUser;
use Illuminate\Support\Facades\Mail;
use App\Models\User;

class EmailService
{
    /**
     * Sends email to registered user.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function sendWelcomeEmail(User $user)
    {
        Mail::to($user->email)->send(new WelcomeRegisteredUser($user));
    }
}
