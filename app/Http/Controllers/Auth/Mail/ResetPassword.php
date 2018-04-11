<?php
namespace DurianSoftware\Http\Controllers\Auth\Mail;

use Illuminate\Auth\Notifications\ResetPassword as BaseResetPassword;
use Illuminate\Notifications\Messages\MailMessage;

class ResetPassword extends BaseResetPassword
{
    public function __construct($email, $token)
    {
        $this->email = $email;
        $this->token = $token;
    }
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->line('We are sending this email because we recieved a forgot password request.')
            ->action(
                'Reset Password',
                route('password.reset', ['token' => $this->token, 'email' => $this->email])
            )
            ->line('If you did not request a password reset, no further action is required.'.
                ' Please contact us if you did not submit this request.');
    }
}
