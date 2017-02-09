<?php

namespace Tecactus\Skeleton\Listeners;

use Tecactus\Skeleton\Events\UserRequestActivationEmail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Tecactus\Skeleton\Support\Facades\ActivationToken;

class UserRequestActivationEmailListener implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  Registered  $event
     * @return void
     */
    public function handle(UserRequestActivationEmail $event)
    {
        // here define all the process to create an account confirmation token
        // and send a notification to the user
        $user = $event->user;
        $user->sendAccountActivationNotification(
            ActivationToken::create($user)
        );
    }
}
