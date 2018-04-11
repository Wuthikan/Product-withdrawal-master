<?php

namespace DurianSoftware\Http\Controllers\Auth;

use DurianSoftware\Http\Controllers\Controller;
use DurianSoftware\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Socialite;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/back-office/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * The user has been authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function authenticated(Request $request, $user)
    {
        if (!empty($user->client_id)) {
            Session::put('client_id', $user->client_id);
        }
        return redirect($this->redirectTo);
    }

    public function attemptLogin(Request $request)
    {
        $credential = $this->credentials($request);
        $hashed_email = hash('sha512', $credential['email']);
        return $this->guard()->attempt(
            ['hashed_email' => $hashed_email, 'password' => $credential['password']],
            $request->filled('remember_me')
        );
    }

    /**
     * Redirect the user to the Google authentication page.
     *
     * @return Response
     */
    public function redirectToProvider()
    {
        return view('auth.login');
    }
 
    /**
     * Obtain the user information from Google.
     *
     * @return Response
     */
    public function handleProviderCallback()
    {
        $user = Socialite::driver('google')->user();
        $domain = str_after($user->email, '@');
        
        if (str_is('durian.software', $domain) || str_is('ngin.co.th', $domain)) {
            return redirect()->action('BackOffice\HomeController@index');//->intended();
        } else {
            return redirect('https://www.ngin.co.th');
        }
    }
}
