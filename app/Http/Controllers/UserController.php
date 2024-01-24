<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use App\Mail\OTPMail;
use App\Helper\JWTHelper;
use Illuminate\Http\Request;
use App\Helper\ResponseHelper;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    public function UserLogin(Request $request)
    {

        try {
            $userEmail = $request->UserEmail;
            $OTP = rand(100000, 999999);
            $details = [
                'code' => $OTP,
            ];
            Mail::to($userEmail)->send(new OTPMail($details));
            User::updateOrCreate(['email' => $userEmail], ['email' => $userEmail, 'otp' => $OTP]);
            return ResponseHelper::Out('success', "A 6 Digit OTP has been send to your email address", 200);
        } catch (Exception $e) {
            return ResponseHelper::Out('error', $e->getMessage(), 500);
        }
    }

    public function VarifyUser(Request $request)
    {
        try {
            $userEmail = $request->UserEmail;
            $otp = $request->VarificationCode;
            $varificationUser = User::where('email', $userEmail)->where('otp', $otp)->first();
            if ($varificationUser) {
                if ($varificationUser->otp === "0") {
                    return ResponseHelper::Out('error', "User Varification Failed", 500);
                } else {
                    User::where('email', $userEmail)->where('otp', $otp)->update(['otp' => 0]);
                    $token  = JWTHelper::CreateToken($userEmail,$varificationUser->id);
                    return ResponseHelper::Out('success', "User Varification Successfull", 200)->cookie('token', $token, 60*24*60);
                }

            } else {
                return ResponseHelper::Out('error', "User Varification Failed", 500);
            }

        } catch (Exception $e) {
            return ResponseHelper::Out('error', $e->getMessage(), 500);
        }
    }

    function UserLogut(Request $request){
        try{
            return redirect('/UserLoginPage')->cookie('token', '', -1);
            
        }catch(Exception $e){
            return ResponseHelper::Out('error', $e->getMessage(), 500);
            
        }
    }
}
