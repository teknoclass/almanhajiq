<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
   /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @param  string|null  ...$guards
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {

            if (Auth::guard($guard)->check()) {
                switch ($guard) {
                    case 'admin':
                        return redirect('/admin');
                        break;
                    case 'web':
                        $user= auth('web')->user();
                        if($user->role=='student'){
                            return redirect()->route('user.home.index');
                        }elseif($user->role=='lecturer'){
                            return redirect()->route('user.lecturer.home.index');
                        }
                        elseif ($user->checkRole(User::MARKETER)) {
                            return redirect()->route('user.marketer.home.index');
                        }

                        break;
                    default:
                        return redirect('/panel');
                }
            }


        }

        return $next($request);
    }
}
