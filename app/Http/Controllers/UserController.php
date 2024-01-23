<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use App\Helper\JWTHelper;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function userRegistration(Request $request)
    {

        try {

            User::create($request->input());
            return response()->json(['status' => 'success', 'message' => 'User created successfully'], 200);

        } catch (Exception $exception) {

            return response()->json(['status' => 'error', 'message' => $exception->getMessage()], 500);

        }
    }
    public function userLogin(Request $request)
    {
        try {

            $user = User::where($request->input())->select('id')->first();
            $userID = $user->id;
            if ($userID > 0) {

                $token = JWTHelper::CreateToken($request->input('email'), $userID);

                return response()->json(['status' => 'success', 'message' => 'User logged in successfully'], 200)
                    ->cookie('token', $token, 60 * 60);

            } else {
                return response()->json(['status' => 'failed', 'message' => 'No User Found'], 200);

            }

        } catch (Exception $exception) {

            return response()->json(['status' => 'error', 'message' => $exception->getMessage()], 500);

        }
    }
    public function userProfile(Request $request){
       $userID = $request->header('userID');
       return User::where('id',$userID)->first();

    }
   function  userLogout(){
     
     return redirect('/login')->cookie('token','',time()-60*60);
    
   }
}
