<?php

namespace Tecactus\Skeleton\Foundation\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;

trait ThrottlesLogins
{
    /**
     * Redirect the user after determining they are locked out.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function sendLockoutResponse(Request $request)
    {
        $seconds = $this->limiter()->availableIn(
            $this->throttleKey($request)
        );

        $message = Lang::get('auth.throttle', ['seconds' => $seconds]);

        if ($request->expectsJson()) {
            return response()->json([$this->username() => $message], 429);
        }

        return redirect()->back()
            ->withInput($request->only($this->username(), 'remember'))
            ->withErrors([$this->username() => $message]);
    }
}
