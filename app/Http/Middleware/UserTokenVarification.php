<?php

namespace App\Http\Middleware;

use Closure;
use App\Helper\JWTHelper;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserTokenVarification
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->cookie('token');
        $result = JWTHelper::DecodeToken($token);
        if($result == 'Unathorized'){
            return redirect('/login');
        }else{
            $request->headers->set('userEmail',$result->userEmail);
           return $next($request);

        }
    }
}
