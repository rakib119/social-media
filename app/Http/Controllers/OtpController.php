<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Notifications\SendOtpNotification;
use Carbon\Carbon;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Session;

class OtpController extends Controller
{
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
