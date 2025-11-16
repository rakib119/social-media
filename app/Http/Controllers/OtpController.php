<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Notifications\SendOtpNotification;
use Carbon\Carbon;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class OtpController extends Controller
{

    public function validate_signup(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => ['required', 'string', 'max:70'],
            'surname' => ['required', 'string', 'max:70'],
            'day' => ['required'],
            'month' => ['required'],
            'year' => ['required'],
            'gender' => ['required'],
            'email_or_mobile' => ['required', 'string', function ($attribute, $value, $fail) {
                if (filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    if (User::where('email', $value)->exists()) {
                        $fail('This email address has already been taken.');
                    }
                } elseif (preg_match('/^[0-9]{10,15}$/', $value)) {
                    if (User::where('phone_number', $value)->exists()) {
                        $fail('This phone number has already been taken.');
                    }
                } else {
                    $fail('The '.$attribute.' must be a valid email address or mobile number.');
                }
            }],
            'password' => ['required', 'string', 'min:6'],
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'errors' => $validator->errors()], 422);
        }
        else
        {
            $data = $request->only(['first_name', 'surname', 'day', 'month', 'year', 'gender', 'email_or_mobile', 'password']);

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
                    // send_sms($phone,$msg);

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
                $data['email']  = $request->email_or_mobile;
            }
            elseif (preg_match('/^[0-9]{10,15}$/', $request->email_or_mobile))
            {
                $data['contact_type'] = 'Mobile Number';
                $data['phone_number']  = $request->email_or_mobile;
            }

            // store everything under a specific session key
            Session::put('signup_payload', $data);

        }
        // return response()->json(['status' => 'success', 'message' => 'Validation passed.']);
        return redirect()->route('verify.otp');
    }

    public function verify_otp_post(Request $request)
    {
        return redirect()->route('verify.otp');
    }
    public function verify_otp()
    {
        return view('auth.otp_validation');
    }
    public function validate_otp(Request $request)
    {
        $enteredOtp = $request->otp;

        // Retrieve OTP and timestamp from session
        $session      = session('signup_payload');
        $sessionOtp   = isset($session['verify_otp'])     ? $session['verify_otp']     : null;
        $otpCreatedAt = isset($session['otp_created_at']) ? $session['otp_created_at'] : null;

        // Check if OTP exists
        if (!$sessionOtp || !$otpCreatedAt) {
            return response()->json([
                'status'=> 'error',
                'otp'   => 'OTP expired or not found.',
            ]);
        }

        // Check if OTP is within 5 minutes window
        if (now()->diffInMinutes($otpCreatedAt) > 5) {
            // Clean up session data

            return response()->json([
                'status'=> 'error',
                'otp'   => 'OTP has expired.',
            ]);
        }

        // Validate OTP
        if ($enteredOtp == $sessionOtp)
        {
            return response()->json([
                'status'=> 'success',
                'otp'   => 'Phone number verified successfully!',
            ]);
        }

        return response()->json([
            'status'=> 'error',
            'otp'   => 'Invalid OTP.',
        ]);
    }

    /**
     * Send OTP to the provided email address.
     */
    public function sendEmailOtp(Request $request)
    {
        // Validate email format
        $request->validate([
            'email' => 'required', 'string', 'email', 'max:255', 'unique:users',
        ]);

        $email = $request->email; // Email to send OTP to
        $otp   = rand(100000, 999999); // Generate random 6-digit OTP

        // Store OTP and timestamp in session
        Session::put('email_otp', $otp);
        Session::put('email_address', $email);
        Session::put('email_otp_created_at', now());

        // Send notification to email
        Notification::route('mail', $email)
            ->notify(new SendOtpNotification($otp));

        return response()->json([
            'success' => true,
            'message' => 'OTP sent successfully!',
            'otp' => $otp,
        ]);
    }

    /**
     * Verify entered OTP.
     */
    public function verifyEmailOtp(Request $request)
    {
        $enteredOtp = $request->otp;

        // Retrieve OTP and timestamp from session
        $sessionOtp    = Session::get('email_otp');
        $email_address = Session::get('email_address');
        $otpCreatedAt  = Session::get('email_otp_created_at');

        // Check if OTP exists
        if (!$sessionOtp || !$otpCreatedAt) {
            return response()->json([
                'success' => false,
                'message' => 'OTP expired or not found.',
            ]);
        }

        // Check if OTP is within 5 minutes window
        if (now()->diffInMinutes($otpCreatedAt) > 5) {
            // Clean up session data
            Session::forget(['otp', 'otp_email', 'otp_created_at']);

            return response()->json([
                'success' => false,
                'message' => 'OTP has expired.',
            ]);
        }

        // Validate OTP
        if ($enteredOtp == $sessionOtp) {
            Session::put('verified_email_address', $email_address);
            Session::put('email_verified_at', Carbon::now());
            // Clean up session after successful verification
            Session::forget(['email_otp', 'email_address', 'otp_created_at']);

            return response()->json([
                'success' => true,
                'message' => 'Email address verified successfully!',
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Invalid OTP.',
        ]);
    }
    /**
     * Send OTP to the provided Mobile.
     */
    public function sendPhoneOtp(Request $request)
    {
        // Validate email format
        $request->validate([
            'phone' => 'required',
        ]);

        $phone = $request->phone;
        $otp   = rand(100000, 999999);

        // Store OTP and timestamp in session
        Session::put('phone_otp', $otp);
        Session::put('phone_number', $phone);
        Session::put('phone_otp_created_at', now());

        $msg = "Your OTP for Registration is:$otp. (". env('APP_NAME').")";
        // Send OTP via SMS
        // $sms_response = send_sms($phone,$msg);

        return response()->json([
            'success' => true,
            'message' => 'OTP sent successfully!',
            'otp' => $otp,
            // 'sms_response' => $sms_response,
        ]);
    }

    /**
     * Verify entered OTP.
     */
    public function verifyPhoneOtp(Request $request)
    {
        $enteredOtp = $request->otp;

        // Retrieve OTP and timestamp from session
        $phone_number  = Session::get('phone_number');
        $sessionOtp    = Session::get('phone_otp');
        $otpCreatedAt  = Session::get('phone_otp_created_at');

        // Check if OTP exists
        if (!$sessionOtp || !$otpCreatedAt) {
            return response()->json([
                'success' => false,
                'message' => 'OTP expired or not found.',
            ]);
        }

        // Check if OTP is within 5 minutes window
        if (now()->diffInMinutes($otpCreatedAt) > 5) {
            // Clean up session data
            Session::forget(['phone_otp', 'phone_number', 'phone_otp_created_at']);

            return response()->json([
                'success' => false,
                'message' => 'OTP has expired.',
            ]);
        }

        // Validate OTP
        if ($enteredOtp == $sessionOtp) {
            Session::put('verified_phone_number', $phone_number);
            Session::put('phone_number_verified_at', Carbon::now());
            // Clean up session after successful verification
            Session::forget(['phone_otp', 'phone_number', 'phone_otp_created_at']);

            return response()->json([
                'success' => true,
                'message' => 'Phone number verified successfully!',
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Invalid OTP.',
        ]);
    }



}
