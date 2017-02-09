<?php

namespace Tecactus\Skeleton\Foundation\Auth;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails as IlluminateSendsPasswordResetEmails;

trait SendsPasswordResetEmails
{
    use IlluminateSendsPasswordResetEmails;
    
    /**
     * Get the response for a successful password reset link.
     *
     * @param  string  $response
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function sendResetLinkResponse($response)
    {	
    	$status = ['status' => trans($response)];
        if (request()->expectsJson()) {
            return response()->json($status);
        }
        return back()->with($status);
    }

    /**
     * Get the response for a failed password reset link.
     *
     * @param  \Illuminate\Http\Request
     * @param  string  $response
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function sendResetLinkFailedResponse(Request $request, $response)
    {
    	$errors = ['email' => trans($response)];    	
        if ($request->expectsJson()) {
            return response()->json($errors, 422);
        }
        return back()->withErrors($errors);
    }
}
