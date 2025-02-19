<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\User;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;

class CheckActiveUser
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

        if(!$user){
            return Redirect::to('/login');
        }
        if ($user!='') {
            if ($user->is_block==1) {
                Auth::guard('web')->logout();
                return Redirect::to('/login');
            }


            if ($user->role==User::STUDENTS) {
                $url=route('user.auth.verify.user');

                if (getSeting('is_account_confirmation_required')==1) {
                    if ($user->is_validation==0) {
                        return Redirect::to($url);
                    }
                }

            } elseif ($user->role==User::LECTURER) {
                $url=route('user.auth.verify.lecturer');
                if ($user->is_validation==0) {
                    return Redirect::to($url);
                }
            }
            elseif ($user->role==User::MARKETER) {
                $url=route('user.auth.verify.marketer');
                if ($user->is_validation==0) {
                    return Redirect::to($url);
                }
            }
        }



        return $next($request);
    }
}
