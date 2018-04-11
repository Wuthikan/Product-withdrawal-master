<?php

namespace DurianSoftware\Http\Controllers\Auth;

use DurianSoftware\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Session;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails
    {
        sendResetLinkEmail as protected originSendResetLinkEmail;
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $this->validateEmail($request);
        $response = $this->broker()->sendResetLink(
            //array('hashed_email' => hash('sha512', $request->email))
            $request->only('email')
        );
        if ($response == Password::RESET_LINK_SENT) {
            Session::flash('reset_status', 'Success!');
        }
        return $response == Password::RESET_LINK_SENT
                    ? $this->sendResetLinkResponse($response)
                    : $this->sendResetLinkFailedResponse($request, $response);
    }
}
