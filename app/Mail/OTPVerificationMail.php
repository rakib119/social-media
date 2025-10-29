<?
namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OTPVerificationMail extends Mailable
{
    use SerializesModels;

    public $otp;

    public function __construct($otp)
    {
        $this->otp = $otp;
    }

    public function build()
    {
        return $this->view('emails.otp')
                    ->subject('Your Email Verification OTP')
                    ->with([
                        'otp' => $this->otp,
                    ]);
    }
}
