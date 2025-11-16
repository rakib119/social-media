<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Notifications\SendOtpNotification;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Crypt;

class ForgotPasswordController extends Controller
{
    public function showLinkRequestForm()
    {
        return view('auth.passwords.email');
    }

    public function sendResetOtp(Request $request)
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
            $otp = rand(100000, 999999);
            session(['reset_otp' => $otp, 'reset_user_id' => $user->id]);
            // Send notification to email
            Notification::route('mail', $login) ->notify(new SendOtpNotification($otp));
            return redirect()->route('password.verify-otp')
                ->with('status', 'An OTP has been sent to your mobile number.');

        } elseif (preg_match('/^[0-9]{10,15}$/', $login)) {
            $user = User::where('phone_number', $login)->first();
            if (!$user) {
                return back()->withErrors(['login' => 'We could not find a user with that mobile number.']);
            }

            $otp = rand(100000, 999999);
            session(['reset_otp' => $otp, 'reset_user_id' => $user->id]);

            send_sms($user->phone_number, "AscentaMedia: Your password reset code is {$otp}.Do not share it with anyone. If you did not request this, please contact support at support@ascentaflow.com.");

            return redirect()->route('password.verify-otp')
                ->with('status', 'An OTP has been sent to your mobile number.');
        } else {
            return back()->withErrors(['login' => 'Enter a valid email address or mobile number.']);
        }
    }

    public function showOtpForm()
    {
        $reset_otp = session('reset_otp');
        if($reset_otp){
            return view('auth.passwords.verify-otp');
        }else{
            return redirect()->route('login')->with(['error_message' => 'No user found with that email or mobile number.']);
        }
    }

    public function verifyOtp(Request $request)
    {
        $request->validate(['otp' => 'required|digits:6']);

        if ($request->otp == session('reset_otp')) {
            $userId = session('reset_user_id');
            session()->forget(['reset_otp', 'reset_user_id']);
            return redirect()->route('reset.password.form', ['id' => Crypt::encrypt($userId)]);
        }

        return back()->withErrors(['otp' => 'Invalid OTP. Please try again.']);
    }

    public function showResetForm($id)
    {
        return view('auth.passwords.reset-mobile', ['userId' => $id]);
    }

    /*  public function resetPassword(Request $request, $id)
    {
        $request->validate([
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::findOrFail($id);
        $user->update(['password' => bcrypt($request->password)]);

        return redirect()->route('login')->with('status', 'Password reset successful. You can now log in.');
    } */
    public function resetPassword(Request $request, $id = null)
    {
        try {
            $id = Crypt::decrypt($id);
        } catch (\Throwable $th) {
            abort(404,'Not Found');
        }

        $request->validate([
            'login' => 'required|string',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $login = $request->input('login');
        $user  = null;

        // Detect email or mobile
        if (filter_var($login, FILTER_VALIDATE_EMAIL)) {
            $user = User::where('email', $login)->first();
        } elseif (preg_match('/^[0-9]{10,15}$/', $login)) {
            $user = User::where('phone_number', $login)->first();
        }

        if (!$user && $id) {
            $user = User::find($id);
        }

        if (!$user) {
            return back()->withErrors(['login' => 'No user found with that email or mobile number.']);
        }

        $user->password = bcrypt($request->password);
        $user->save();

        return redirect()->route('login')->with('status', 'Password reset successfully. You can now log in.');
    }


}
