<?php

namespace App\Services;


use App\Models\CourseSession;
use App\Models\CourseSessionsGroup;
use App\Models\CourseSessionSubscription;
use App\Repositories\LiveSessionRepository;

class LiveSessionService extends MainService
{
    public LiveSessionRepository $liveSessionRepository;

    public function __construct(LiveSessionRepository $liveSessionRepository)
    {
        $this->liveSessionRepository = $liveSessionRepository;
    }

    public function getCourseSessionsGroups($request, $id)
    {

        $user = $request->attributes->get('user');


        $groups = $this->liveSessionRepository->getCourseSessionsGroups($id,$user);

        return $this->createResponse(
            __('message.success'),
            true,
            $groups
        );
    }

    public function getCourseSessions($request, $id)
    {

        $user = $request->attributes->get('user');

        $sessions = $this->liveSessionRepository->getCourseSessions($id,$user);


        return $this->createResponse(
            __('message.success'),
            true,
            $sessions
        );
    }
}
