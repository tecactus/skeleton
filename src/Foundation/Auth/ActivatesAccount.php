<?php

namespace Tecactus\Skeleton\Foundation\Auth;

use Illuminate\Http\Request;
use Tecactus\Skeleton\Support\Facades\ActivationToken;
use Tecactus\Skeleton\Events\UserRequestActivationEmail as UserRequestActivationEmailEvent;

trait ActivatesAccount
{
    use RedirectsUsers;

    /**
     * Send an activation link to the given user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
	public function sendActivationLink(Request $request)
	{
        event(new UserRequestActivationEmailEvent($request->user()));
		return redirect()->back()->with('status', trans('skeleton::activation.send_success'));
	}

    /**
     * Handle an account activation request from the user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function activate(Request $request)
    {
    	$token = $request->token;
    	$email = $request->email;

    	$user = User::where('email', $email)->first();

        $status = 'status';
        $message = '';
        $redirect = $this->guestRedirectPath();        

        if (auth()->check()) {
            $redirect = $this->redirectPath(); 
        }

    	if (is_null($user)) {
            $message = 'skeleton::activation.user_not_found';
    	}
    	elseif ($user->active) {
            $message = 'skeleton::activation.already_activated';
    	}
    	elseif (ActivationToken::exists($token, $email)) {
			$user->active = true;
            $user->save();
            ActivationToken::delete($token);
            $message = 'skeleton::activation.activation_success';
    	} else {            
            $message = 'skeleton::activation.invalid_data';
            $status = 'error';
        }

		return redirect($redirect)->with($status, trans($message));
    }
}
