<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\PersonalAccessToken;

class CheckSanctumToken
{
    public function handle(Request $request, Closure $next)
    {

        if ($request->bearerToken()) {
            $userT = PersonalAccessToken::findToken($request->bearerToken());

            if($userT){
                $user =  PersonalAccessToken::findToken($request->bearerToken())->tokenable;
                if ($user) {
                    $request->attributes->set('user', $user);
                    Auth::login($user);
                }


            }
        }

        return $next($request);
    }
}
