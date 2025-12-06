<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Notifications\SendOtpNotification;
use Illuminate\Support\Facades\Notification;
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

     public function step1(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:50',
            'surname'    => 'required|string|max:50',
        ]);

        $data = $request->only(['first_name', 'surname']);
        Session::put('signup_payload', $data);

        return response()->json(['success' => true]);
    }

    public function step2(Request $request)
    {
        $validated = $request->validate([
            'date_of_birth' => 'required|date|before:-13 years',
        ],
        [
            'date_of_birth.before' => 'You must be at least 13 years old to sign up.',
        ]);

        $data   = Session::get('signup_payload', []);
        $dob    = $validated['date_of_birth'];
        $ts     = strtotime($dob);

        $data['day']    = date('d', $ts);
        $data['month']  = date('m', $ts);
        $data['year']   = date('Y', $ts);
        $data['date_of_birth'] = date('Y-m-d', $ts);
        Session::put('signup_payload', $data);

        session(['reg.date_of_birth' => $validated['date_of_birth']]);

        return response()->json(['success' => true]);
    }



    public function step3(Request $request)
    {
        $validated = $request->validate([
            'gender' => 'required|in:male,female,custom',
        ]);

        $data = Session::get('signup_payload', []);
        $data['gender'] = $validated['gender'];
        Session::put('signup_payload', $data);

        return response()->json(['success' => true]);
    }


    public function step4(Request $request)
    {
        $field_label = $request->contact_type; // "Mobile number" OR "Email Address"

        $validated = $request->validate([
            'email_or_mobile' => ['required',
                function ($attribute, $value, $fail) use ($field_label) {
                    if(strtolower($field_label) == 'email address'){
                        // Email validation
                        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
                            $fail("The Email Address format is invalid.");
                            return;
                        }
                        if (User::where('email', $value)->exists()) {
                            $fail("This Email Address has already been taken.");
                        }
                        return;
                    }
                    if(strtolower($field_label) == 'mobile number'){
                        // Phone number validation
                        if (!preg_match('/^[0-9]{10,15}$/', $value)) {
                            $fail("The Mobile Number format is invalid.");
                            return;
                        }
                        if (User::where('phone_number', $value)->exists()) {
                            $fail("This Mobile Number has already been taken.");
                        }
                        return;
                    }
                }
            ],
            'password' => ['required', 'string', 'min:6']
        ], [
            'email_or_mobile.required'   => "The {$field_label} field is required."
        ]);

        $data = Session::get('signup_payload', []);

        // send OTP depending on contact type
        if (filter_var($request->email_or_mobile, FILTER_VALIDATE_EMAIL))
        {
            try {
                $email = $request->email_or_mobile;
                $otp = rand(100000, 999999);
                Notification::route('mail', $email)->notify(new SendOtpNotification($otp));
                $data['verify_otp']     = $otp;
                $data['contact_type']   = 'Email Address';
                $data['email_address']  = $email;

            } catch (\Throwable $th) {
                return response()->json(['status' => 'error', 'email_or_mobile' => 'Failed to send OTP to email. Please try again.'], 422);
            }


        } elseif (preg_match('/^[0-9]{10,15}$/', $request->email_or_mobile)) {

            try {
                $phone = $request->email_or_mobile;
                $otp = rand(100000, 999999);
                $msg = "Your OTP for Registration is: $otp. (" . env('APP_NAME') . ")";
                send_sms($phone,$msg);

                $data['verify_otp']     = $otp;
                $data['contact_type']   = 'Mobile Number';
                $data['phone_number']   = $phone;

            } catch (\Throwable $th) {
                return response()->json(['status' => 'error', 'email_or_mobile' => 'Failed to send OTP to mobile. Please try again.'], 422);
            }

        }
        $data['otp_created_at'] = now();
        $data['email']          = null;
        $data['phone_number']   = null;

        if (filter_var($request->email_or_mobile, FILTER_VALIDATE_EMAIL))
        {
            $data['contact_type'] = 'Email Address';
            $data['email']        = $request->email_or_mobile;
        }
        elseif (preg_match('/^[0-9]{10,15}$/', $request->email_or_mobile))
        {
            $data['contact_type']  = 'Mobile Number';
            $data['phone_number']  = $request->email_or_mobile;
        }

        Session::put('signup_payload', $data);

        return response()->json(['success' => true]);
    }
}
