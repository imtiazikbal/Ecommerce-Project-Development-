<?php

namespace App\Helper;

use Exception;
use Firebase\JWT\JWK;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JWTHelper
{

    public static function CreateToken($userEmail,$userID){
        $key = '123-abc-ABC';
        $payload = [
            'iss' => 'laravel-demo',
            'iat' => time(),
            'exp' => time() + 60*60,
            'userEmail' => $userEmail,
            'userID' => $userID
        ];
        return JWT::encode($payload,$key,'HS256');
        

    }

    public static function DecodeToken($token){
        
       try{
       if($token==null){
        return "Unathorized";
        
       }else{
        $key = '123-abc-ABC';
        return JWT::decode($token,new Key($key,'HS256'));
       }
       }catch(Exception $exception){
        return "Unathorized";
       }

    }

}
