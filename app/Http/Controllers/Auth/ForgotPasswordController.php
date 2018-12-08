<?php

namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use App\Transformers\Json;
use App\User;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Mail;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
     */
    use SendsPasswordResetEmails;
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
     * Send a reset link to the given user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getResetToken(Request $request)
    {   
        // CAPTCHA TOKEN CHECK
        $captcha_token = $request->captcha;
        $verifyURL = 'https://www.google.com/recaptcha/api/siteverify';
        $post_data = http_build_query(
            array(
            'secret' => env('CAPTCHA'),
            'response' => $captcha_token,
            'remoteip' => (isset($_SERVER["HTTP_CF_CONNECTING_IP"]) ? $_SERVER["HTTP_CF_CONNECTING_IP"] : $_SERVER['REMOTE_ADDR'])
            )
        );
        $ch = curl_init($verifyURL);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/json', 'Content-type: application/x-www-form-urlencoded'));
        $response = curl_exec($ch);
        curl_close($ch);
        if($response) {
            $result = json_decode($response);
        }

        if ($result->score < 0.5) {
            return "error-captcha";
        }

        $this->validate($request, ['email' => 'required|email']);
        if ($request->wantsJson()) {
            $user = User::where('email', $request->input('email'))->first();
            if (!$user) {
                return response()->json(Json::response(null, trans('passwords.user')), 400);
            }
            $token = $this->broker()->createToken($user);
            $email_address = $request->email;
            $reset_link = "https://nimipet.com/reset/".$token."/".$email_address;

            $email_body = "Hello!
            
You asked us to reset your password for your account using the email address: ".$email_address."

To reset your password, visit the following address:
".$reset_link."

If this was a mistake, or you didn't ask for a password reset, just ignore this email and nothing will happen.

Thanks!";

            echo "success";

            $GLOBALS['email_address'] = $email_address;

            Mail::raw($email_body, function ($message) {
                $message->to($GLOBALS['email_address'])->subject('Password reset link');
            });

            $GLOBALS['email_address'] = "";
            exit;

        }
    }
}
