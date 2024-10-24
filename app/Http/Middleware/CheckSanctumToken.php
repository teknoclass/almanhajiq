<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;

class CheckSanctumToken
{
    public function handle(Request $request, Closure $next)
    {

        if ($request->bearerToken()) {
            $user = PersonalAccessToken::findToken($request->bearerToken())->tokenable;

            if ($user) {
                $request->attributes->set('user', $user);
            }
        }

        return $next($request);
    }
}
