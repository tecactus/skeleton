<?php

namespace Tecactus\Skeleton\Foundation\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Illuminate\Foundation\Auth\AuthenticatesUsers as IlluminateAuthenticatesUsers;

trait AuthenticatesUsers
{
    use IlluminateAuthenticatesUsers;

    /**
     * Attempt to log the user into the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function attemptLogin(Request $request)
    {
        if ($request->expectsJson()) {
            return $this->guard()->once(
                $this->credentials($request)
            );
        }

        return $this->guard()->attempt(
            $this->credentials($request), $request->has('remember')
        );
    }

    /**
     * Send the response after the user was authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    protected function sendLoginResponse(Request $request)
    {
        // if (! $request->is('api/*')) {
            $request->session()->regenerate();
        // }

        $this->clearLoginAttempts($request);

        if ($request->expectsJson()) {
            return $this->authenticated($request, $this->guard()->user())
                ?: response()->json($this->guard()->user());
        }

        return $this->authenticated($request, $this->guard()->user())
                ?: redirect()->intended($this->redirectPath());
    }
}
