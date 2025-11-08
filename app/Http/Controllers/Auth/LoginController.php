<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Override the username method to allow login via email or mobile.
     */
    public function username()
    {
        $login = request()->input('email_or_mobile');

        // Check if input is email or mobile
        $field = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'phone_number';

        // Merge it into the request, so Auth::attempt() works properly
        request()->merge([$field => $login]);

        return $field;
    }
}
