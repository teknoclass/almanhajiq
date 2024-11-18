<?php

namespace App\Repositories;

use App\Models\Courses;
use App\Models\JoinAsTeacherRequests;
use App\Models\User;

class TeacherRepository extends MainRepository
{
    public function __construct()
    {
        parent::__construct(new User());
    }

    public function getTeacherByEmail($email)
    {
        return User::where('email', $email)
                   ->where('role', User::LECTURER)
                   ->first();
    }

    function getTeacherByTitle($title){
        return User::where('role' , User::LECTURER)
                    ->filterByTitle($title)
                    ->with([
                        'lecturerSetting' => function($query) {
                            $query->select(
                                'id',
                                'user_id',
                                'video_thumbnail',
                                'video_type',
                                'video',
                                'exp_years',
                                'twitter',
                                'facebook',
                                'instagram',
                                'youtube'
                            )->with('translations:lecturer_setting_id,abstract,description,position,locale');
                        }
                    ])->get();

    }
    public function getTeachersByFilter($teacher_id)
    {
        return Courses::active()
                      ->select(
            'id',
            'image',
            'start_date',
            'duration',
            'type',
            'category_id',
            'is_active',
            'user_id'
        )

                      ->where('user_id', $teacher_id)
                      ->where('type', 'live')
                      ->with('translations:courses_id,title,locale,description')
                      ->withCount('lecturers')
                      ->withCount('items')
                      ->orderBy('id', 'desc')
                      ->get();
    }
    public function createOrUpdateTeacherRequest($id, $data, $request)
    {
        return JoinAsTeacherRequests::updateOrCreate(['id' => $id], $data);
    }

}
