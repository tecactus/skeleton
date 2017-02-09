<?php

namespace Tecactus\Skeleton\Listeners;

use Illuminate\Auth\Events\Registered;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Tecactus\Skeleton\Support\Facades\ActivationToken;

class UserRegisteredListener implements ShouldQueue
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
    public function handle(Registered $event)
    {
        // here define all the process to create an account confirmation token
        // and send a notification to the user
        $user = $event->user;
        \Log::info($user);
        $user->sendAccountActivationNotification(
            ActivationToken::create($user)
        );
    }
}
