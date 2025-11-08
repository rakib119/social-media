<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class ForgotPasswordController extends Controller
{
    public function showLinkRequestForm()
    {
        return view('auth.passwords.email');
    }

    public function sendResetLinkEmail(Request $request)
    {
        // Validate input
        $validator = Validator::make($request->all(), [
            'login' => 'required|string',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $login = $request->input('login');

        // Detect email or mobile
        if (filter_var($login, FILTER_VALIDATE_EMAIL)) {
            $user = User::where('email', $login)->first();
            if (!$user) {
                return back()->withErrors(['login' => 'We could not find a user with that email address.']);
            }

            // Use Laravel's built-in email reset system
            $status = Password::sendResetLink(['email' => $login]);

            return $status === Password::RESET_LINK_SENT
                ? back()->with(['status' => __($status)])
                : back()->withErrors(['login' => __($status)]);
        } elseif (preg_match('/^[0-9]{10,15}$/', $login)) {
            $user = User::where('phone_number', $login)->first();
            if (!$user) {
                return back()->withErrors(['login' => 'We could not find a user with that mobile number.']);
            }

            $otp = rand(100000, 999999);
            session(['reset_otp' => $otp, 'reset_user_id' => $user->id]);

            // send_sms($user->phone_number, "Your password reset OTP is $otp");

            return redirect()->route('password.verify-otp')
                ->with('status', 'An OTP has been sent to your mobile number.');
        } else {
            return back()->withErrors(['login' => 'Enter a valid email address or mobile number.']);
        }
    }

    public function showOtpForm()
    {
        return view('auth.passwords.verify-otp');
    }

    public function verifyOtp(Request $request)
    {
        $request->validate(['otp' => 'required|digits:6']);

        if ($request->otp == session('reset_otp')) {
            $userId = session('reset_user_id');
            session()->forget(['reset_otp', 'reset_user_id']);
            return redirect()->route('password.reset.form', ['id' => $userId]);
        }

        return back()->withErrors(['otp' => 'Invalid OTP. Please try again.']);
    }

    public function showResetForm($id)
    {
        return view('auth.passwords.reset-mobile', ['userId' => $id]);
    }

    public function resetPassword(Request $request, $id)
    {
        $request->validate([
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::findOrFail($id);
        $user->update(['password' => bcrypt($request->password)]);

        return redirect()->route('login')->with('status', 'Password reset successful. You can now log in.');
    }


}
