<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\User;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;

class CheckIsMarketer
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user=auth()->user();


        if ($user!='') {

            if (!($user->checkRole(User::MARKETER) &&
               $user->hasCoupon())
            ) {
                abort(403);
            }

        }


        return $next($request);
    }
}
