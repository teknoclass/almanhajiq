<?php

namespace App\Repositories\Front;

use App\Models\Category;
use App\Models\CourseAssignmentResults;
use App\Models\CourseQuizzesResults;
use App\Models\Courses;
use App\Models\HomePageSettings;
use App\Models\OurPartners;
use App\Models\OurServices;
use App\Models\OurMessages;
use App\Models\OurTeams;
use App\Models\Sliders;
use App\Models\Statistics;
use App\Models\StudentsOpinions;
use App\Models\User;
use App\Models\WorkSteps;
use App\Models\RequestJoinMarketer;
use App\Models\SocialMediaRequestsMarketers;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;


class HomeEloquent extends HelperEloquent
{

    public function index($is_web=true)
    {
        $data['section_settings'] = HomePageSettings::select('id', 'section_key', 'is_active')->orderBy('order_num')->get();

        $data['main_headers'] = Sliders::whereName('header')->select('id', 'image', 'background', 'link')
            ->with('translations:sliders_id,title,text,locale,title_btn')
            ->get();

        $data['statistics'] = Statistics::select('id', 'image', 'count')
            ->with('translations:statistics_id,title,locale')
            ->get();

        $data['services'] = OurServices::select('id', 'image')
            ->with('translations:our_services_id,title,text,locale')
            ->get();

        $data['partners'] = OurPartners::select('id', 'image', 'link')
            ->get();

        $data['work_steps'] = WorkSteps::select('id')
            ->with('translations:work_steps_id,text,locale')
            ->get();

        $data['testimonials'] = StudentsOpinions::select('id', 'rate','image','created_at')
            ->with('translations:students_opinions_id,name,text,locale')
            ->get();

        $data['testimonial_header'] = Sliders::whereName('student_opinions')->select('id', 'image','link')
            ->with('translations:sliders_id,title,text,locale,title_btn')
            ->first();


        $data['lecturers'] = User::select('id','name','image','country_id','mother_lang_id','belongs_to_awael')->where('role', 'lecturer')->where('belongs_to_awael', 1)
            ->with('motherLang')->orderBy('id', 'desc')->take(10)->get();

        $data['latest_courses'] = Courses::select('id','image','type','category_id','duration','grade_sub_level')->active()->accepted()
            ->with('translations:courses_id,title,description,locale',)->take(10)->get();

        $data['featured_courses'] = Courses::select('id','image','type','category_id','duration','grade_sub_level')->active()->accepted()
        ->where('is_feature',1)->with('translations:courses_id,title,description,locale',)->get();
        // Get the parent category 'grade_levels'
        $data['grade_levels']      = Category::where('key', 'grade_levels')->get();


        $data['messages'] = OurMessages::select('id', 'image')
            ->with('translations:our_messages_id,title,description,locale')->get();

        $data['teams'] = OurTeams::select('id', 'image')
            ->with('translations:our_teams_id,name,job,description,locale')->get();


        // dd($data);
        return $data;
    }

    public function showQuizResult($result_token)
    {
        $data['quiz'] = CourseQuizzesResults::where('result_token', $result_token)
            ->with('quiz', function ($q) {
                $q->select('id', 'grade')->with('translations:course_quizzes_id,title,locale');
            })
            ->with('course', function ($q) {
                $q->select('id', 'image')->with('translations:courses_id,title,locale');
            })
            ->with('user', function ($q) {
                $q->select('id', 'name');
            })
            ->first();

        if($data['quiz']=='') {
            abort(404);
        }

        return $data;
    }

    public function showAssignmentResult($result_token)
    {
        $data['assignment'] = CourseAssignmentResults::where('result_token', $result_token)
            ->with('assignment', function ($q) {
                $q->select('id', 'grad')->with('translations:course_assignments_id,title,locale');
            })
            ->with('course', function ($q) {
                $q->select('id', 'image')->with('translations:courses_id,title,locale');
            })
            ->with('student', function ($q) {
                $q->select('id', 'name');
            })
            ->first();

        if($data['assignment']=='') {
            abort(404);
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

}
