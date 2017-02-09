<?php

namespace Tecactus\Skeleton\Observers;

use Illuminate\Database\Eloquent\Model;

class UserObserver
{
    /**
     * Listen to the User creating event.
     *
     * @param  Model  $user
     * @return void
     */
    public function creating(Model $user)
    {
        if (in_array('api_token', $user->getFillable())) {
            $user->api_token = str_random(60);
        }
    }
}