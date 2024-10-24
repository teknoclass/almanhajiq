<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\LiveSessionService;

class LiveSessionsController  extends Controller
{
    public LiveSessionService $liveSessionService;

    public function __construct(LiveSessionService $liveSessionService)
    {
        $this->liveSessionService = $liveSessionService;
    }

    public function getCourseSessionsGroups(){
        $this->liveSessionService->getCourseSessionsGroups();
    }

}
