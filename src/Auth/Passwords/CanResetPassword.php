<?php

namespace Tecactus\Skeleton\Auth\Passwords;

use Illuminate\Auth\Passwords\CanResetPassword as IlluminateCanResetPassword;
use Tecactus\Skeleton\Auth\Notifications\ResetPassword as ResetPasswordNotification;

trait CanResetPassword
{
    use IlluminateCanResetPassword;

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }
}
