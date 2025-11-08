<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'otp' => ['required']
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {

        $session    = session('signup_payload');
        $name       = isset($session['first_name']) ? $session['first_name']: null;
        $surname    = isset($session['surname'])    ? $session['surname']   : null;
        $gender     = isset($session['gender'])     ? $session['gender']    : null;
        $day        = isset($session['day'])        ? $session['day']       : null;
        $month      = isset($session['month'])      ? $session['month']     : null;
        $year       = isset($session['year'])       ? $session['year']      : null;
        $email      = isset($session['email'])      ? $session['email']     : null;
        $password   = isset($session['password'])   ? $session['password']  : null;
        $phone_number  = isset($session['phone_number']) ? $session['phone_number'] : null;
        $date_of_birth = $day . '-' . $month . '-' . $year;
        $date_of_birth = date('Y-m-d', strtotime($date_of_birth));
        return User::create([
            'name'          => $name,
            'surname'       => $surname,
            'gender'        => $gender,
            'date_of_birth' => $date_of_birth,
            'email'         => $email,
            'phone_number'  => $phone_number ,
            'password'      => Hash::make($password),
            'email_verified_at'  => $email ? now() : null,
            'phone_number_verified_at'  =>  $phone_number ? now() : null ,
        ]);
    }
}
