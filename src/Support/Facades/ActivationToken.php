<?php

namespace Tecactus\Skeleton\Support\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Tecactus\Repositores\ActivationTokenRepository
 */
class ActivationToken extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'activations.repository';
    }
}
