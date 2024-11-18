<?php

namespace App\Services;

use App\Repositories\TeacherRepository;

class TeacherService extends MainService
{

    public TeacherRepository $teacherRepository;

    public function __construct(TeacherRepository $teacherRepository)
    {
        $this->teacherRepository = $teacherRepository;
    }

    public function getTeacherCoursesCount($teacher)
    {
        return $teacher->LecturerRelatedCoursesCount($teacher->id);
    }

    public function getById($id)
    {
        $teacher = $this->teacherRepository->findByIdWith($id,['lecturerSetting.translations','lecturerExpertise.translations']);
        if (!$teacher) {
            return $this->createResponse(
                __('message.not_found'),
                false,
                null
            );
        }

        return $this->createResponse(
            __('message.success'),
            true,
            $teacher
        );
    }

    public function getTeacherCoursesById($id)
    {
        $teacherCourses = $this->teacherRepository->getTeachersByFilter($id);
        if (!$teacherCourses) {
            return $this->createResponse(
                __('message.not_found'),
                false,
                null
            );
        }

        return $this->createResponse(
            __('message.success'),
            true,
            $teacherCourses
        );
    }

    function getTeachersByName($title){
        return $this->teacherRepository->getTeacherByTitle($title);
    }
}
