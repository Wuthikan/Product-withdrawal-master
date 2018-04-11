<?php
namespace DurianSoftware\Services;

use Illuminate\Auth\Passwords\PasswordBroker;

class CustomPasswordBroker extends PasswordBroker
{
    public function sendResetLink(array $credentials)
    {
        // First we will check to see if we found a user at the given credentials and
        // if we did not we will redirect back to this current URI with a piece of
        // "flash" data in the session to indicate to the developers the errors.
        $email = '';
        $hashed_email = '';
        if (!empty($credentials['email'])) {
            $email = $credentials['email'];
            $hashed_email = hash('sha512', $email);
        }
        $user = $this->getUser(array('hashed_email' => $hashed_email));
        if (is_null($user)) {
            return static::INVALID_USER;
        }
        if (!hash_equals($user->email, $email)) {
            return static::INVALID_USER;
        }
        // Once we have the reset token, we are ready to send the message out to this
        // user with a link to reset their password. We will then redirect back to
        // the current URI having nothing set in the session to indicate errors.
        $user->sendPasswordResetNotification(
            $this->tokens->create($user)
        );
        return static::RESET_LINK_SENT;
    }

     /**
     * Validate a password reset for the given credentials.
     *
     * @param  array  $credentials
     * @return \Illuminate\Contracts\Auth\CanResetPassword|string
     */
    protected function validateReset(array $credentials)
    {
        $hashed_email = hash('sha512', $credentials['email']);
        if (is_null($user = $this->getUser(['hashed_email' => $hashed_email]))) {
            return static::INVALID_USER;
        }

        if (! $this->validateNewPassword($credentials)) {
            return static::INVALID_PASSWORD;
        }

        if (! $this->tokens->exists($user, $credentials['token'])) {
            return static::INVALID_TOKEN;
        }

        return $user;
    }
}
