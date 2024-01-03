<?php

namespace App\Http\Controllers;

use App\Helper\JWTToken;
use App\Mail\OTPmail;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    public function UserRegistration(Request $request)
    {
        try {
            User::create([
                'firstname' => $request->input('firstname'),
                'lastname' => $request->input('lastname'),
                'mobile' => $request->input('mobile'),
                'email' => $request->input('email'),
                'password' => $request->input('password'),
            ]);
            return response()->json(
                [
                    'status' => 'Success',
                    'message' => 'User Registration Successfull',
                ],
                200,
            );
        } catch (Exception $e) {
            return response()->json(
                [
                    'status' => 'Failed',
                    'message' => $e->getMessage(),
                ],
                200,
            );
        }
    }
    public function UserLogin(Request $request)
    {
      $count =  User::where('email','=',$request->input('email'))
             ->where('password','=',$request->input('password'))
             ->count();

        if($count == 1){
            // login perform
            $token = JWTToken::CreateToken($request->input('email'));
            return response()->json(
                [
                    'status' => 'Success',
                    'message' => 'Login Successfull',
                    'token'=>$token
                ],
                200,
            );
        }else{
            return response()->json(
                [
                    'status' => 'Failed',
                    'message' => 'Unauthorized',
                ],
                200,
            );
        }
    }

    public function SendOtpCode(Request $request){
        $email = $request->input('email');
        $otp = rand(1000,9999);
        $count =  User::where('email','=',$email)->count();

        if($count == 1){
            // otp perform

            Mail::to($email)->send(new OTPmail($otp));

            // otp update
            User::where('email','=',$email)->update(['otp'=>$otp]);

            return response()->json(
                [
                    'status' => 'Success',
                    'message' => '4 digit OTP code has been send to your mail',
                ],
                200,
            );
        }else{
            return response()->json(
                [
                    'status' => 'Failed',
                    'message' => 'Unauthorized',
                ],
                200,
            );
        }
    }
}
