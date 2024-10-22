<?php

namespace App\Http\Middleware;

use App\Models\Pages;
use App\Models\PagesText;
use App\Models\Setting;
use App\Models\SocialMedia;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class ShareGeneralSettings
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {

        $settings = new Setting();

        $social_media =  SocialMedia::get();

        $pages = Pages::get();

        View::share('settings', $settings);
        View::share('social_media', $social_media);
        View::share('pages', $pages);

        return $next($request);
    }
}
