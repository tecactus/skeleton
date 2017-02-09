<?php

namespace Tecactus\Skeleton\Foundation\Auth;

trait RedirectsUsers
{
    /**
     * Get the post action redirect path.
     *
     * @return string
     */
    public function redirectPath()
    {
        if (method_exists($this, 'redirectTo')) {
            return $this->redirectTo();
        }

        return property_exists($this, 'redirectTo') ? $this->redirectTo : '/home';
    }

    /**
     * Get the post action redirect path for guests.
     *
     * @return string
     */
    public function guestRedirectPath()
    {
        if (method_exists($this, 'redirectGuest')) {
            return $this->redirectTo();
        }

        return property_exists($this, 'redirectGuest') ? $this->redirectTo : '/login';
    }
}
