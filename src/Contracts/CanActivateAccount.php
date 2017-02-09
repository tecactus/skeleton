<?php

namespace Tecactus\Skeleton\Contracts;

interface CanActivateAccount
{
    /**
     * Get the e-mail address where account activation links are sent.
     *
     * @return string
     */
    public function getEmailForAccountActivation();

    /**
     * Send the account activation notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendAccountActivationNotification($token);
}
