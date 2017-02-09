<?php

namespace Tecactus\Skeleton\Auth\Activation;

use Tecactus\Skeleton\Auth\Notifications\AccountActivation as AccountActivationNotification;

trait CanActivateAccount
{
    /**
     * Get the e-mail address where account activation links are sent.
     *
     * @return string
     */
    public function getEmailForAccountActivation()
    {
        return $this->email;
    }

    /**
     * Send the account activation notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendAccountActivationNotification($token)
    {
        $this->notify(new AccountActivationNotification($token, $this->email));
    }
}