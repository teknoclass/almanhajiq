<?php

namespace App\Http\Middleware;

use App\Models\Setting;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckBlogStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $settings = new Setting();

        $forumStatus = @$settings->valueOf('blog_status');

        if ($forumStatus)
            return $next($request);
        else
            return response('Sorry, the Blog is not active for now.', 403);

        return $next($request);
    }
}
