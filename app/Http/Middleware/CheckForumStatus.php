<?php

namespace App\Http\Middleware;

use App\Models\Setting;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckForumStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $settings = new Setting();

        $forumStatus = @$settings->valueOf('forum_status');

        if ($forumStatus)
            return $next($request);
        else
            return response('Sorry, the Forum is not active for now.', 403);

        return $next($request);
    }
}
