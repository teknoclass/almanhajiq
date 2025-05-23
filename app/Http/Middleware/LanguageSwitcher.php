<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
class LanguageSwitcher
{
    /**
     * Handle an incoming request.
     *
     * @param  Request $request
     * @param Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!$request->header('locale'))
        {
            App::setLocale(Config::get('app.locale'));

        }
        App::setLocale($request->header('locale') ?? 'ar');
        $request->headers->set('locale',App::getLocale());
        return $next($request);
    }
}
