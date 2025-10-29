<?
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Crypt;
use App\Mail\OTPVerificationMail;

class EmailVerificationController extends Controller
{
    // Send OTP to the email
    public function sendOTP(Request $request)
    {
        $email = $request->input('email');

        // Validate the email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return response()->json(['success' => false, 'message' => 'Invalid email address.']);
        }

        // Generate a 6-digit OTP
        $otp = rand(100000, 999999);

        // Save the OTP to the database or send as plain text (for demo purposes we are sending OTP directly to email)
        // Here you could also save the OTP to a database and associate it with the email for later validation

        // Send OTP to email using Mail class
        try {
            Mail::to($email)->send(new OTPVerificationMail($otp));

            // Optionally, save the OTP in the database for later validation
            // User::where('email', $email)->update(['otp' => Crypt::encryptString($otp)]);

            return response()->json(['success' => true, 'message' => 'OTP sent successfully.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to send OTP.']);
        }
    }
}
