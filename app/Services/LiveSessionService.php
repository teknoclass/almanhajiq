<?php

namespace App\Services;


use App\Repositories\LiveSessionRepository;

class LiveSessionService extends MainService
{
    public LiveSessionRepository $liveSessionRepository;

    public function __construct(LiveSessionRepository $liveSessionRepository)
    {
        $this->liveSessionRepository = $liveSessionRepository;
    }

    public function getCourseSessionsGroups(){
        dd($this->liveSessionRepository->getCourseSessionsGroups());
    }
}
