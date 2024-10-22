<?php

namespace App\Repositories\Front;

use App\Models\User;
use App\Models\CourseLecturers;
use App\Models\Courses;
use Illuminate\Support\Facades\View;
use App\Models\Ratings;
use App\Models\UserCourse;
use App\Models\PrivateLessons;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class LecturerProfileEloquent
{
    public function index($id, $request, $is_web=true)
    {
        $data['lecturer'] = User::select(
            'id',
            'name',
            'image',
            'gender',
            'hour_price',
            'hour_price',
            'city',
            'country_id',
            'belongs_to_awael',
            'mother_lang_id',
            'min_student_no',
            'max_student_no',
            'can_add_half_hour',
        )
            ->with([
                'reviews' => function ($query) {
                    $query->select(
                        'id',
                        'sourse_type',
                        'sourse_id',
                        'user_id',
                        'rate',
                        'comment_text',
                        'is_active',
                        'created_at'
                    )->active()
                        ->with([
                            'user' => function ($query) {
                                $query->select('id', 'name', 'image', 'gender', 'city', 'country_id');
                            }
                        ])->latest()->take(6);
                }
            ])
            ->with([
                'lecturerSetting' => function ($query) {
                    $query->select('id', 'user_id', 'video_thumbnail', 'video_type', 'video', 'exp_years', 'twitter', 'facebook', 'instagram', 'youtube')
                        ->with('translations:lecturer_setting_id,abstract,description,position,locale');
                }
            ])
            ->with([
                'lecturerExpertise' => function ($query) {
                    $query->select('id', 'user_id', 'start_date', 'end_date')
                        ->with('translations:lecturer_expertise_id,name,description,locale');
                }
            ])
            ->with([
                'lecturerCourses' => function ($query) {
                    $query->select(
                        'id',
                        'user_id',
                        'image',
                        'start_date',
                        'type',
                        'category_id',
                        'is_active'
                    )->active()->accepted()
                    ->with('translations:courses_id,title,locale,description')
                    ->latest()->take(6);
                }
        ])
        ->with('materials', 'languages', 'motherLang', 'timeTable')
        ->withCount(['lecturerCourses' => function ($query) {
                $query->active()->accepted();
            }])
        ->withCount('reviews')
        ->where('id', $id)
        ->first();

        if ($data['lecturer']=='') {
            abort(404);
        }
        // dd($data['lecturer']);

        $time_now = now()->toTimeString();
        $date_now = now()->toDateString();

        $data['teacherPrivateLessons'] = PrivateLessons::where('teacher_id',$id)
            // ->where('student_id', null)
            ->whereIn('status', ['pending', 'acceptable'])
            ->where(function ($query) {
                $query->where('meeting_date', '>', now()->toDateString())
                    ->orWhere(function ($query) {
                        $query->whereDate('meeting_date', now())
                            ->where('time_form', '>=', now()->format('H:i:s'));
                    });
            })
        ->with('category.prices')
        ->select("id" , 'meeting_date' , 'time_form' , DB::Raw("WEEKDAY(meeting_date) as day_index"))
        ->get()
        // ->map->format()
        ;

        $data['single_times']   =  $data['teacherPrivateLessons'];

        // dd($data['teacherPrivateLessons'] , $id , now()->toDateString());

        $data['count_students'] = $this->getCountStudents($id);

        $data['count_graduates'] = $this->getCountStudents($id, true);

        $data['user_remain_hours'] = auth('web')->user()?->user_remain_hours;

        return $data;
    }

    public function courses($id)
    {
        $data['lecturer'] = User::select('id','name')->where('id', $id)->first();

        $data['courses'] = Courses::where('user_id', $id)->active()->accepted()
            ->select(
                'id',
                'image',
                'start_date',
                'duration',
                'type',
                'category_id',
                'is_active',
            )
            ->with('translations:courses_id,title,locale,description')
            ->with([
                'category' => function ($query) {
                    $query->select('id', 'value', 'parent')
                        ->with('translations:category_id,name,locale');
                }
            ])
            ->addSelect([
                'progress' => UserCourse::select('progress')
                    ->whereColumn('course_id', 'courses.id')
                    ->where('user_id', auth()->id())
            ])
            ->withCount('items')
            ->orderBy('id', 'desc')->paginate(12);

        return $data;
    }


    public function getLectureRating($id)
    {
        $lectureRate = Ratings::select("ratings")->where('sourse_id', $id)->where('sourse_type', 'user')->sum('rate');

        return $lectureRate;
    }

    // public function getMoreCourses($id, $request)
    // {
    //     $skip = $request->get('count');

    //     $data['lecturerCourses'] = CourseLecturers::where('user_id', $id)
    //         ->with([
    //             'course' => function ($query) use ($skip) {
    //                 $query->select(
    //                     'id',
    //                     'image',
    //                     'start_date',
    //                     'type',
    //                     'category_id',
    //                     'is_active'
    //                 )->active()->accepted()
    //                     ->with('translations:courses_id,title,locale,description');
    //             }
    //         ]);

    //     $count_all_courses = $data['lecturerCourses']->count();

    //     $data['lecturerCourses']=$data['lecturerCourses']->skip($skip)->take(6)->get();

    //     $html = '';

    //     $html= View::make('front.lecturer_profile.partials.courses', $data)->render();

    //     $is_show_button_view_more = false;
    //     if ($count_all_courses > $skip + 6) {
    //         $is_show_button_view_more = true;
    //     }
    //     return [
    //         'status'=>true,
    //         'message'=>'done',
    //         'items'=>[
    //             'html'=>$html,
    //             'is_show_button_view_more'=>$is_show_button_view_more
    //         ]
    //     ];
    // }

    // public function getMoreReviews($id, $request)
    // {
    //     $skip = $request->get('count');

    //     $data['reviews'] = Ratings::where('sourse_id', $id)->where('sourse_type', Ratings::USER)
    //         ->select(
    //             'id',
    //             'sourse_type',
    //             'sourse_id',
    //             'user_id',
    //             'rate',
    //             'comment_text',
    //             'is_active',
    //             'created_at'
    //         )->active()
    //         ->with([
    //             'user' => function ($query) {
    //                 $query->select('id', 'name', 'image');
    //             }
    //         ]);

    //     $count_all_reviews = $data['reviews']->count();

    //     $data['reviews']=$data['reviews']->skip($skip)->take(6)->get();

    //     $html = '';

    //     $html= View::make('front.lecturer_profile.partials.reviews', $data)->render();

    //     $is_show_button_view_more = false;

    //     if ($count_all_reviews > $skip + 6) {
    //         $is_show_button_view_more = true;
    //     }

    //     return [
    //         'status'=>true,
    //         'message'=>'done',
    //         'items'=>[
    //             'html'=>$html,
    //             'is_show_button_view_more'=>$is_show_button_view_more
    //         ]
    //     ];
    // }

    public function getCountStudents($user_id, $only_graduates = false)
    {
        $count_students = UserCourse::whereHas('course.lecturers', function (Builder $query) use ($user_id, $only_graduates) {
            $query->where('user_id', $user_id)
                ->when(
                    $only_graduates,
                    function ($q) {
                        return $q->where('is_end', '1');
                    }
                );
        })->count();

        return $count_students;
    }
}
