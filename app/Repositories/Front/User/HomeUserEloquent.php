<?php

namespace App\Repositories\Front\User;

use App\Models\Balances;
use App\Models\Category;
use App\Models\Coupons;
use App\Models\Courses;
use App\Models\PrivateLessons;
use App\Models\User;
use App\Models\UserCompetition;
use App\Models\RequestJoinMarketer;
use App\Models\SocialMediaRequestsMarketers;
use App\Repositories\Front\User\HelperEloquent;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Repositories\Front\User\Lecturer\CoursesEloquent as LecturerCoursesEloquent;
use Kreait\Firebase\Http\Requests;
use App\Models\UserCourse;
use App\Models\UserPackages;
use App\Repositories\Front\User\CoursesEloquent as StudentCoursesEloquent;
use App\Repositories\Front\LecturerProfileEloquent;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use App\Models\JoinAsTeacherRequests;
use App\Models\PrivateLessonMeeting;
use App\Models\PrivateLessonMeetingParticipants;

class HomeUserEloquent extends HelperEloquent
{
    private $lecture_courses;
    private $student_courses;

    private $lecturer_profile;

    public function __construct(
        LecturerCoursesEloquent $lecture_courses_eloquent,
        StudentCoursesEloquent $student_courses_eloquent,
        LecturerProfileEloquent $lecturer_profile_eloquent
    ) {
        $this->lecture_courses = $lecture_courses_eloquent;
        $this->student_courses = $student_courses_eloquent;
        $this->lecturer_profile = $lecturer_profile_eloquent;

    }

    public function index($request, $role, $is_web=true)
    {
        $data['user']=$this->getUser($is_web);

        if ($role==User::STUDENTS) {

            // $data['available_points']=$data['user']->getAvailablePoints();

            // $data['user_competitions_count']=UserCompetition::where('user_id', $data['user']->id)->count();

            $data['upcoming_private_lessons_count'] = PrivateLessons::getStudentPrivateLessons($data['user']->id)->where(function ($query) {
                $query->where('meeting_date', '>', now()->toDateString())
                    ->orWhere(function ($query) {
                        $query->whereDate('meeting_date', now())
                            ->where('time_form', '>=', now()->format('H:i:s'));
                    });
            })->count();

            $data['user_courses_end_count'] = UserCourse::where([['user_id', $data['user']->id], ['is_end', 1]])->count();

            $data['my_packages_count'] = UserPackages::where([['user_id', $data['user']->id]])->count();

            $data['courses'] = $this->student_courses->myCourses($request, true, 6, false)['courses'];

        } elseif($role==User::LECTURER) {

            // $data = $this->lecture_courses->myCourses($request, true, 8, false);
            $user = $this->getUser($is_web);
            $totalEarningsLastMonth  = Balances::where('user_id', "=", $user->id)->where('type', "=", 'deposit')->whereDate('created_at', '>=', Carbon::now()->subMonth())->sum('amount');
            if($data['user']->country) {
                $data['totalEarningsLastMonth'] = ceil($data['user']->country->currency_exchange_rate * $totalEarningsLastMonth) . " ".__('currency');
            } else {
                $data['totalEarningsLastMonth'] = $totalEarningsLastMonth . ' $';
            }

            $data['students'] = $data['user']->RelatedStudents()
                ->select('id', 'name', 'image', 'email', 'created_at')
                ->take(4)->get();

            $data['private_lessons'] = PrivateLessons::where('teacher_id', $data['user']->id)->latest()->take(4)->get();

        } elseif($role==User::MARKETER) {

            $data['count_customers']=User::where('market_id', $data['user']->id)->count();

            $data['last_customers']=User::where('market_id', $data['user']->id)
            ->orderBy('id', 'desc')->get();

            $user_id=$data['user']->id;

            $data['profits']=Balances::select('user_id', 'type', 'amount')
            ->where('user_id', $user_id)
            ->where('type', 'deposit')
            ->where('user_type', $role)
            ->sum('amount');

            $data['withdrawable_amounts']=abs(
                (Balances::select('user_id', 'type', 'amount')->where('user_id', $user_id)
            ->where('type', 'deposit')
            ->where('user_type', $role)
            ->whereRaw(("case WHEN becomes_retractable_at IS  NOT NULL THEN becomes_retractable_at < now()  END"))
            ->sum('amount'))
                -
                (Balances::select('user_id', 'type', 'amount')
                ->where('user_id', $user_id)->where('type', 'withdrow')
                ->where('user_type', $role)
                ->sum('amount'))
            );
            ;

            $user_id=$data['user']->id;

            $data['coupon']=Coupons::whereHas('allMarketers', function (Builder $query) use ($user_id) {
                $query->where('user_id', $user_id);
            })->first();


        }
        return $data;
    }



    public function joinAsMarketRequest($request)
    {
        DB::beginTransaction();
        try {

            //check is marketer

            $user=User::where('email',$request->email)
            ->whereHas('userRoles', function (Builder $query) {
                $query->where('role', User::MARKETER);
            })->first();

            if($user){
                $message = __('message.the_email_is_linked_to_a_marketer_account');
                $status = false;
                $response = [
                    'message' => $message,
                    'status' => $status,
                ];
                return $response;
            }

            $data = $request->all();

            $item = RequestJoinMarketer::updateOrCreate(['id' => 0], $data);

            // save socal_media
            $socal_media_id=$request->get('socal_media_id');
            $link=$request->get('link');
            $num_followers=$request->get('num_followers');
            if($socal_media_id) {
                if(is_array($socal_media_id)) {
                    $length=count($socal_media_id);
                    for($i=0;$i<$length;++$i) {
                        SocialMediaRequestsMarketers::create([
                            'request_id'=>$item->id,
                            'socal_media_id'=>$socal_media_id[$i],
                            'link'=>$link[$i],
                            'num_followers'=>$num_followers[$i],
                        ]);
                    }
                }
            }

            //sendNotification
            $title = 'طلبات الانضمام كمسوق';
            $text = "طلب  جديد من $request->name ";
            $action_type = 'join_as_market_request';
            $action_data = $item->id;
            $permation = 'show_marketers_joining_requests';
            $user_type = 'admin';
            sendNotifications($title, $text, $action_type, $action_data, $permation, $user_type);


            $message = __('message.your_request_has_been_submitted_successfully_and_will_be_reviewed_soon');
            $status = true;

            $response = [
                'message' => $message,
                'status' => $status,
            ];

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            $message = __('message.unexpected_error');
            $status = false;
            $response = [
                'message' => $message,
                'status' => $status,
            ];
        }


        return $response;
    }

    function meetingFinished($meeting_id , $user_id ) {

        $participant = PrivateLessonMeetingParticipants::where('user_id' , $user_id)
        ->whereHas('meeting' , function($meeting) use($meeting_id){
            $meeting->where('app_id' , $meeting_id);
        })->first();
        if($participant)
        {
            $participant->update(['lefting_at' => now()->toTimeString()]);
            $private_lesson = $participant->private_lesson;
            $user           = $participant->user;
            $teacher_name  = $private_lesson->teacher?->name;
            if($user && $user->email){
                $text_msg    = "<p>تم انتهاء الطالب : <b>$user?->name</b> من الدرس $private_lesson->title </p>";
                $text_msg   .= "<p>مع المدرس : <b>$teacher_name</b> </p>";
                $text_msg   .= "<p>موعد بتاريخ : <b>$private_lesson->meeting_date</b> </p>";
                $text_msg   .= "<p>الساعة من <b>$private_lesson->time_form إلي $private_lesson->time_to </b> </p>";
                sendEmail('حضور الدرس', $text_msg,  $user->email);
            }
        }
        if(!$user_id){
            $meeting        = PrivateLessonMeeting::where('app_id' , $meeting_id);
            $private_lesson = $meeting->private_lesson;
            if($private_lesson){
                if(!$meeting->participants->where('user_id' ,$private_lesson->student_id )->first()){
                    $student           = $private_lesson->student;
                    $teacher_name  = $private_lesson->teacher?->name;
                    if($student && $student->email){
                        $text_msg    = "<p>تم انتهاء الدرس $private_lesson->title </p>";
                        $text_msg    = "<p>دون حضور الطالب : <b>$student?->name</b> </p>";
                        $text_msg   .= "<p>مع المدرس : <b>$teacher_name</b> </p>";
                        $text_msg   .= "<p>موعد بتاريخ : <b>$private_lesson->meeting_date</b> </p>";
                        $text_msg   .= "<p>الساعة من <b>$private_lesson->time_form إلي $private_lesson->time_to </b> </p>";
                        sendEmail('حضور الدرس', $text_msg,  $student->email);
                    }
                }
            }
        }



        return true;
    }
}
