<?php

namespace App\Http\Controllers;

use Auth;
use JWTAuth;
use App\User;
use App\Http\Requests\RegisterFormRequest;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    // public function register(RegisterFormRequest $request)
    public function register(RegisterFormRequest $request)
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

        if ($result->score > 0.4) {
            $user = new User;
            $user->email = $request->email;
            if (strlen($request->referred_by) > 0) {
                $user->referred_by = $request->referred_by;
            }
            $user->password = bcrypt($request->password);
            $user->referral_id = bin2hex(openssl_random_pseudo_bytes(5));
            $user->save();
            return response([
                'status' => 'success',
                'data' => $user
            ], 200);
        }
        else {
            return response([
                'status' => 'error',
                'msg' => 'Captcha error. Are you a robot?'
            ], 400);
        }
        
    }

    public function login(Request $request)
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

        if ($result->score > 0.4) {
            $credentials = $request->only('email', 'password');
            if ( ! $token = JWTAuth::attempt($credentials)) {
                return response([
                    'status' => 'error',
                    'error' => 'invalid.credentials',
                    'msg' => 'Invalid Credentials.'
                ], 400);
            }
            return response([
                'status' => 'success'
            ])
            ->header('Authorization', $token);
        }
        else {
            return response([
                'status' => 'error',
                'msg' => 'Captcha error. Are you a robot?'
            ], 400);
        }
    }

    public function user(Request $request)
    {
        $user = User::find(Auth::user()->id);
        return response([
            'status' => 'success',
            'data' => $user
        ]);
    }

    public function refresh()
    {
        return response([
            'status' => 'success'
        ]);
    }

    public function logout()
    {
        JWTAuth::invalidate();
        return response([
            'status' => 'success',
            'msg' => 'Logged out Successfully.'
        ], 200);
    }
    
}

