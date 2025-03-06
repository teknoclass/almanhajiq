<?php

namespace App\Repositories\Front\User;

use App\Http\Resources\ApiItemCommentCollection;
use App\Models\Balances;
use App\Models\CourseSession;
use Illuminate\Support\Facades\DB;
use App\Models\Courses;
use App\Models\CertificateTemplates;
use App\Models\CertificateTemplateTexts;
use App\Models\Category;
use App\Models\CourseAssignmentResults;
use App\Models\CourseAssignments;
use App\Models\CourseComments;
use App\Models\CourseCurriculum;
use App\Models\CourseLessons;
use App\Models\CourseLessonsLearning;
use App\Models\CourseQuizzes;
use App\Models\CourseQuizzesResults;
use App\Models\CourseSectionItems;
use App\Models\CourseSections;
use App\Models\Notifications;
use Carbon\Carbon;
use App\Models\PrivateLessons;
use App\Models\SessionAttendance;
use App\Models\Transactios;
use Illuminate\Database\Eloquent\Builder;
use App\Models\User;
use App\Models\UserCourse;
use App\Repositories\Front\CouponsEloquent;
use App\Repositories\Common\CertificateIssuanceEloquent;

class CoursesEloquent extends HelperEloquent
{
    private $certificate_issuance;

    public function __construct(CertificateIssuanceEloquent $certificate_issuance_eloquent)
    {

        $this->certificate_issuance = $certificate_issuance_eloquent;
    }


    public function completedCourses($request, $is_web = true)
    {
        $data['user'] = $this->getUser($is_web);
        $data['certTempsCats'] = CertificateTemplates::pluck('course_category_id')->toArray();
        $data['user_courses'] = UserCourse::where([['user_id', $data['user']->id], ['is_end', 1]])
        ->with(['course' => function ($query) {
            $query->select('id', 'type', 'category_id', 'certificate_template_id', 'is_active', 'created_at','material_id')
                ->active()->accepted()
                ->with('translations:courses_id,title,locale,description');
        }
        ])
        ->paginate(10);

        return $data;
    }

    public function certificateIssuance($id, $is_web = true)
    {
        $data['user'] = $this->getUser($is_web);

        try {

            $item = UserCourse::where([['id',$id],['user_id',$data['user']->id],['is_end',1]])
            ->with(['course' => function ($query) {
                $query->select('id', 'category_id','material_id')->active()
                    ->with('translations:courses_id,title,locale');
            }
            ])
            ->first();


            $lecturer = User::where('id', $item->lecturer_id)->first();
            $course = Courses::find($item->course->id);
            if($course->certificate_template_id!=null){
                $certificate_templates = CertificateTemplates::where('id', $course->certificate_template_id)->first();
            } else {
                $certificate_templates = CertificateTemplates::where('course_category_id', $item->course->category_id)->first();
            }

            $name = time() . ".jpeg";

            $user_data['name']= auth()->user()->name;
            $user_data['courseTitle']= $course->title;
            $user_data['date']=date('Y-m-d');
            $user_data['lecturerName']=$course->lecturer->name??'';

            $path = storage_path("app/certificates/test/" . $certificate_templates->id);
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }
            $this->certificate_issuance->generate( $certificate_templates->id,$user_data,$path . '/' . $name);
            return response()->download($path . '/' . $name);

        } catch (\Exception $e) {
            // dd($e->getMessage());
            return back();
        }
    }

    public function myCourses($request, $is_web = true, $count_itmes = 9, $use_filters = true, $only_is_end = false)
    {
        $data['user'] = $this->getUser($is_web);
        if($is_web)$type = 'web';
        else $type = 'api';

        $user_id = $data['user']->id;
        $course_type = $request->get('course_type');

        $data['courses'] = Courses::active()->accepted()
            ->select('id', 'image', 'start_date', 'duration', 'type', 'category_id', 'is_active', 'is_delete','material_id',
            'level_id','grade_level_id','grade_sub_level','end_date','user_id')
            ->with('translations:courses_id,title,locale,description')
            ->with(['category' => function ($query) {
                $query->select('id', 'value', 'parent')
                    ->with('translations:category_id,name,locale');
            }
             ])
             ->with(['material' => function ($query) {
                $query->select('id', 'value', 'parent')
                    ->with('translations:category_id,name,locale');
            }
             ])
        ->where(function($query)  use ($user_id, $only_is_end,$type) {
            $query->where('id',studentSubscriptionCoursessIds($type));
            $query->orWhere('id',studentInstallmentsCoursessIds($type));

            $query->orWhereHas('students', function (Builder $query) use ($user_id, $only_is_end) {
                $query->where('user_id', $user_id)
                ->where(function ($query) {
                    $query ->where('is_complete_payment', 1)
                    ->orWhere('is_free_trial', 1);
                })
                ->when($only_is_end, function ($q) {
                    return $q->where('is_end', '1');
                });
            });
        })

            // to show the ongoing courses at first
            ->selectSub('SELECT MAX(user_courses.is_end) FROM user_courses WHERE user_courses.course_id = courses.id', 'is_end')
            ->addSelect([
                'progress' => UserCourse::select('progress')
                    ->whereColumn('course_id', 'courses.id')
                    ->where('user_id', $user_id)->limit(1),

                'is_rating' => UserCourse::select('is_rating')
                    ->whereColumn('course_id', 'courses.id')
                    ->where('user_id', $user_id)->limit(1),
            ])
            ->withCount('items')
            ->orderBy('is_end', 'asc')
            ->orderBy('id', 'desc');

        if ($use_filters) {
            if ($course_type == '' || $course_type == Courses::RECORDED) {
                $data['courses'] = $data['courses']->where('type', Courses::RECORDED);
            } else {
                $data['courses'] = $data['courses']->where('type', Courses::LIVE);
            }
        }

        $data['courses_count'] = $data['courses']->count();

        $data['courses'] = $data['courses']->paginate($count_itmes);
        // dd($data['courses']);
        return $data;
    }

    public function getCourse($course_id)
    {
        $course = Courses::withTrashed()->active()->accepted()
        ->select('id', 'image', 'start_date', 'duration', 'type', 'category_id', 'is_active', 'is_delete','material_id',
        'level_id','grade_level_id','grade_sub_level','end_date')
        ->with('translations:courses_id,title,locale,description')
        ->where('id', $course_id)
        ->addSelect([
            'is_end' => UserCourse::select('is_end')
                ->whereColumn('course_id', 'courses.id')
                ->where('user_id', auth()->id())->limit(1),

            'is_rating' => UserCourse::select('is_rating')
                ->whereColumn('course_id', 'courses.id')
                ->where('user_id', auth()->id())->limit(1),
        ])
        ->first();
        return $course;
    }


    public function register($request, $is_web=true)
    {
        if (checkUser('lecturer')) {
            $message = "As a teacher you can't register in the course";
            $status = false;
            $response = [
                'message' => $message,
                'status' => $status,
            ];
            return $response;
        }

        $user = $this->getUser($is_web);
        $data['course_id'] = $request->id;

        $course = Courses::where('id', $data['course_id'])->active()->accepted()->first();

        if (!$course) {
            $message = __('message.unexpected_error');
            $status = false;
            $response = [
                'message' => $message,
                'status' => $status,
            ];
            return $response;
        }


        $is_registered = UserCourse::where([['user_id', $user->id], ['course_id', $data['course_id']]])->first();

        if ($is_registered && !$is_registered->is_paid) {
            if($pay_transaction = $is_registered->course?->transaction->where('user_id' , $user->id)->where('is_paid' , 0)->latest()->first()){
                $message = __('message.operation_accomplished_successfully');
                $status = true;

                return [
                    'message'        => $message,
                    'transaction_id' => $pay_transaction->id,
                    'redirect_url'   => route('user.payment.checkout' , $pay_transaction->id),
                    'status'         => $status,
                ];
            }
        }else if ($is_registered) {
            $message = "أنت مسجل بالفعل بهذه الدورة";
            $status = false;
            $response = [
                'message' => $message,
                'status'  => $status,
            ];
            return $response;
        }

        try {
            $price          = @$course->cost();
            $transaction_id = 0;
            $redirect_url   = null;
            // If the course is Free
            if(!$price || $price == '' || $price == NULL)
            {
                $data['user_id']             = $user->id;
                $data['lecturer_id']         = $course->user_id;
                $data['subscription_token']  = md5(quickRandom(). time());
                $data['is_complete_payment'] = 1;
                $data['is_paid']             = 1;

                UserCourse::updateorCreate(['id' => 0], $data);

            }
            else {

                /**
                 * save user base Transaction first
                 * that user will pay on
                */
                $params_transactios=[
                    'description'            => $course->title,
                    'user_id'                => $user->id,
                    'user_type'              => Transactios::LECTURER,
                    'payment_id'             => null,//uniqid(),
                    'amount'                 => $price,
                    'amount_before_discount' => $price,
                    'type'                   => Transactios::DEPOSIT,
                    'transactionable_id'     => $course->id,
                    'transactionable_type'   => get_class($course),
                    'coupon'                 => '',
                ];

                $transaction_to_be_paid = $this->saveTransactios($params_transactios);
                $transaction_id         = $transaction_to_be_paid->id;

                $redirect_url           = route('user.payment.checkout' , $transaction_id);

                // Marketer Coupon
                $coupon = $request->get('marketer_coupon');
                if ($coupon) {
                    $course_eloquent = new CouponsEloquent();

                    $check_coupon = $course_eloquent->check($coupon, $price);
                    $amount_before_discount = $price;
                    if ($check_coupon['status']) {
                        $amount_before_discount = $check_coupon['items']['amount_after_discount_2'];
                    }

                    //Transfer the balance to the marketer


                    $marketer_percentage_check = $course_eloquent->marketerPercentageCheck($coupon, $price);
                    if ($marketer_percentage_check['status']) {

                        //discount_amount not percentage
                        $discount_percentage = $marketer_percentage_check['items']['discount_amount not percentagepercentage'];
                        $marketer_id         = $marketer_percentage_check['items']['marketer_id'];
                        $marketer_name       = $marketer_percentage_check['items']['marketer_name'];

                        // deposite marketer discount percentage
                        // save Transactios
                        $params_transactios = [
                            'description'            => "نسبة المسوق $marketer_name من الاشتراك بالدورة $course->title",
                            'user_id'                => $marketer_id,
                            'user_type'              => Transactios::MARKETER,
                            'payment_id'             => uniqid(),
                            'amount'                 => $discount_percentage,
                            'amount_before_discount' => 0,
                            'type'                   => Transactios::DEPOSIT,
                            'transactionable_id'     => $course->id,
                            'transactionable_type'   => get_class($course),
                            'coupon'                 => $coupon,
                            'pay_transaction_id'     => $transaction_id,
                        ];


                        $this->saveTransactios($params_transactios);

                        // add balance (discount_percentage) to marketer bacause his user register
                        $student_name = auth()->user()->name;
                        $params_balance = [
                            'description'              => "إشتراك الطالب $student_name بالدورة $course->title",
                            'user_id'                  => $marketer_id,
                            'user_type'                => Transactios::MARKETER,
                            'transaction_id'           => $course->id,
                            'transaction_type'         => get_class($course),
                            'amount'                   => $discount_percentage, //discount_amount
                            'system_commission'        => 0,
                            'amount_before_commission' => $price,
                            'becomes_retractable_at'   => Carbon::now(),
                            'is_retractable'           => 1,
                            'pay_transaction_id'       => $transaction_id,
                        ];

                        $this->addBalance($params_balance);
                    }
                }


                $system_commission = getSystemCommission($course->user_id);
                if ($system_commission == "") $system_commission = 0;

                //amount_before_commission
                $amount_after_commission = $price;
                if ($system_commission!=0) {
                    $amount_after_commission = $price - (($system_commission/100)* $price);
                }

                // add balance to user
                $params_balance=[
                    'description'              => $course->title,
                    'user_id'                  => $course->user_id,
                    'user_type'                => Balances::LECTURER,
                    'transaction_id'           => $course->id,
                    'transaction_type'         => get_class($course),
                    'amount'                   => $amount_after_commission,
                    'system_commission'        => $system_commission ?? 0,
                    'amount_before_commission' => $price,
                    'becomes_retractable_at'   => Carbon::now(),
                    'is_retractable'           => 1,
                    'pay_transaction_id'       => $transaction_id,
                ];
                $this->addBalance($params_balance);

                $course_total_sales = Balances::where('transaction_id', $course->id)
                    ->where('transaction_type', get_class($course))
                    ->where('type', 'deposit')
                    ->sum('amount');

                $course->update(['total_sales' => $course_total_sales]);

                $data['user_id']             = $user->id;
                $data['lecturer_id']         = $course->user_id;
                $data['subscription_token']  = md5(quickRandom(). time());
                $data['pay_transaction_id']  = $transaction_id;

                $data['is_complete_payment'] = $price ? 0 : 1;
                $data['is_paid']             = $price ? 0 : 1;

                UserCourse::updateorCreate(['id' => 0], $data);
            }

            // if paid
            // $this->notify_lecturer_after_pay($transaction_id); // test here in this function  expexted to be in success pament

            $message = __('message.operation_accomplished_successfully');
            $status = true;

            $response = [
                'message'        => $message,
                'transaction_id' => $transaction_id,
                'redirect_url'   => $redirect_url,
                'status'         => $status,
            ];

        } catch (\Exception $e) {
            dd($e);
            $message = __('message.unexpected_error');
            $status = false;
            $response = [
                'message' => $message,
                'status'  => $status,
            ];
        }


        return $response;
    }

    function notify_lecturer_after_pay($transaction_id)
    {
        $transaction = Transactios::find($transaction_id);
        if(!$transaction) return false;

        $course = $transaction->transactionable;

        $user   = $transaction->user;
        //send email to student
        $title_msg  = "الاشتراك بدورة";
        $text_msg   = "<p>تهانينا ! تم الاشتراك بدورة $course->title بنجاح</p>";
        $text_msg  .= "<a href='".route('courses.single', ['id'=>$course->id, 'title' =>mergeString(@$course->title, '')])."'>رابط الدورة</a>";
        sendEmail($title_msg, $text_msg, $user->email);


        //sendNotification
        $title                       = 'تسجيل في دورة ';
        $text                        = "قام " . $user->name . " بالتسجيل في دورتك: " . $course->title;
        $notification['title']       = $title;
        $notification['text']        = $text;
        $notification['user_type']   = 'user';
        $notification['action_type'] = 'course_registeration';
        $notification['action_id']   = $course->id;
        $notification['created_at']  = \Carbon\Carbon::now();

        $teacher_id              = $course->user_id;
        $notification['user_id'] = $teacher_id;

        Notifications::insert($notification);
        sendWebNotification($teacher_id, 'user', $title, $text);

        return true;
    }

    function pay_realated($transaction_id)
    {
        $transaction = Transactios::find($transaction_id);
        if(!$transaction) return false;
        try {
            $transaction->related_transactions()->update(['is_paid' => 1]);
            $transaction->related_balances()->update(['is_paid' => 1]);
            $transaction->related_userCourses()->update(['is_paid' => 1 , 'is_complete_payment' => 1]);

            // Notify
            $this->notify_lecturer_after_pay($transaction_id);

            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }
    public function saveTransactios(array $params)
    {
        return Transactios::create([
            'description'            => $params['description'],
            'user_id'                => $params['user_id'],
            'user_type'              => $params['user_type'],
            'payment_id'             => $params['payment_id'],
            'amount'                 => $params['amount'],
            'amount_before_discount' => $params['amount_before_discount'],
            'type'                   => $params['type'],
            'transactionable_id'     => $params['transactionable_id'],
            'transactionable_type'   => $params['transactionable_type'],
            'coupon'                 => isset($params['coupon']) ? $params['coupon'] : '',
            'pay_transaction_id'     => @$params['pay_transaction_id'],
        ]);

        return '';
    }

    public function addBalance(array $params)
    {
        Balances::create([
            'description'              => $params['description'],
            'user_id'                  => $params['user_id'],
            'user_type'                => $params['user_type'],
            'type'                     => Balances::DEPOSIT,
            'transaction_id'           => $params['transaction_id'],
            'transaction_type'         => $params['transaction_type'],
            'amount'                   => $params['amount'],
            'system_commission'        => $params['system_commission'],
            'amount_before_commission' => $params['amount_before_commission'],
            'becomes_retractable_at'   => $params['becomes_retractable_at'],
            'is_retractable'           => $params['is_retractable'],
            'pay_transaction_id'       => @$params['pay_transaction_id'],
        ]);

        return true;
    }

    public function myActivity($id, $is_web = true)
    {
        $user_id = auth()->id();

        $data['course'] = $this->getCourse($id);

        if ($data['course'] == '')
            abort(404);
        if (!$data['course']->isSubscriber())
            abort(403);


        $course_id=$data['course']->id;

        $data['completed_lessons'] =CourseLessons::where('course_id',$course_id)

        ->whereHas('learningStatus', function (Builder $query) use ($user_id) {
            $query->where('user_id',$user_id);
        })->get();

        $data['uncompleted_lessons'] =CourseLessons::where('course_id',$course_id)

        ->WhereDoesntHave('learningStatus', function (Builder $query) use ($user_id) {
            $query->where('user_id',$user_id);
        })->get();

        // quizzes
        $data['completed_quizzes'] =CourseQuizzes::where('course_id',$course_id)
        ->whereHas('quizResults', function ($query) use ($user_id) {
            $query->where('user_id', $user_id)
                ->where('status', '!=', CourseQuizzesResults::$waiting);
        })->get();

        $data['uncompleted_quizzes'] =CourseQuizzes::where('course_id',$course_id)
        ->whereDoesntHave('quizResults', function ($query) use ($user_id) {
            $query->where('user_id', $user_id);
        })->get();

        //assignments

        $data['completed_assignments'] = CourseAssignments::where('course_id',$course_id)
        ->whereHas('assignmentResults', function ($query) use ($user_id) {
            $query->where('student_id', $user_id)
                ->where('status', '!=', CourseAssignmentResults::$notSubmitted);
        })->get();



        $data['uncompleted_assignments'] = CourseAssignments::where('course_id',$course_id)
        ->whereDoesntHave('assignmentResults', function ($query) use ($user_id) {
            $query->where('student_id', $user_id);
        })->get();

        $data['completed_lessons_count'] = count($data['completed_lessons']);
        $data['completed_quizzes_count'] = count($data['completed_quizzes']);
        $data['completed_assignments_count'] = count($data['completed_assignments']);
        $data['uncompleted_lessons_count'] = count($data['uncompleted_lessons']);
        $data['uncompleted_quizzes_count'] = count($data['uncompleted_quizzes']);
        $data['uncompleted_assignments_count'] = count($data['uncompleted_assignments']);


        // dd($data);
        return $data;
    }


    public function olmyActivity($id, $is_web = true)
    {
        $user_id = auth()->id();

        $data['course'] = $this->getCourse($id);

        if ($data['course'] =='') abort(404);
        if (!$data['course']->isSubscriber()) abort(403);


        function getCurriculumQuery($courseId) {
            return CourseCurriculum::active()->where('course_id', $courseId)->select(['itemable_type', 'itemable_id', 'order'])->with('itemable')->orderBy('id','asc');
        }

        function getSectionItemsQuery($courseId) {
            return CourseSectionItems::active()->where('course_id', $courseId)->select(['itemable_type', 'itemable_id', 'order'])->with('itemable')->orderBy('id','asc');
        }

    //     $data['completed_lessons'] = getCurriculumQuery($data['course']->id)->completedItems(['lesson'])
    //         ->union( getSectionItemsQuery($data['course']->id)->completedItems(['lesson']) )
    //         ->get();

    //     $data['completed_quizzes'] = getCurriculumQuery($data['course']->id)->completedItems(['quiz'])
    //         ->union( getSectionItemsQuery($data['course']->id)->completedItems(['quiz']) )
    //         ->get();

    //     $data['completed_assignments'] = getCurriculumQuery($data['course']->id)->completedItems(['assignment'])
    //         ->union( getSectionItemsQuery($data['course']->id)->completedItems(['assignment']) )
    //         ->get();

    //    $data['uncompleted_lessons'] = getCurriculumQuery($data['course']->id)->uncompletedItems(['lesson'])
    //         ->union( getSectionItemsQuery($data['course']->id)->uncompletedItems(['lesson']) )
    //         ->get();



    //     $data['uncompleted_quizzes'] = getCurriculumQuery($data['course']->id)->uncompletedItems(['quiz'])
    //         ->union( getSectionItemsQuery($data['course']->id)->uncompletedItems(['quiz']) )
    //         ->get();


    //     $data['uncompleted_assignments'] = getCurriculumQuery($data['course']->id)->uncompletedItems(['assignment'])
    //         ->union( getSectionItemsQuery($data['course']->id)->uncompletedItems(['assignment']) )
    //         ->get();

    // Fetch all items
            $data['all_lessons'] = getCurriculumQuery($data['course']->id)
            ->union(getSectionItemsQuery($data['course']->id))
            ->where('itemable_type', 'lesson')
            ->get();

            $data['all_quizzes'] = getCurriculumQuery($data['course']->id)
            ->union(getSectionItemsQuery($data['course']->id))
            ->where('itemable_type', 'quiz')
            ->get();

            $data['all_assignments'] = getCurriculumQuery($data['course']->id)
            ->union(getSectionItemsQuery($data['course']->id))
            ->where('itemable_type', 'assignment')
            ->get();

            // Fetch completed items
            $data['completed_lessons'] = getCurriculumQuery($data['course']->id)
            ->completedItems(['lesson'])
            ->union(getSectionItemsQuery($data['course']->id)->completedItems(['lesson']))
            ->get();

            $data['completed_quizzes'] = getCurriculumQuery($data['course']->id)
            ->completedItems(['quiz'])
            ->union(getSectionItemsQuery($data['course']->id)->completedItems(['quiz']))
            ->get();

            $data['completed_assignments'] = getCurriculumQuery($data['course']->id)
            ->completedItems(['assignment'])
            ->union(getSectionItemsQuery($data['course']->id)->completedItems(['assignment']))
            ->get();

            // Calculate uncompleted items
            // $data['completed_lessons'] = $data['all_lessons'];
            $data['uncompleted_lessons'] = $data['all_lessons']->diff($data['completed_lessons']);
            $data['uncompleted_quizzes'] = $data['all_quizzes']->diff($data['completed_quizzes']);
            $data['uncompleted_assignments'] = $data['all_assignments']->diff($data['completed_assignments']);


        $data['completed_lessons_count']        = count($data['completed_lessons']);
        $data['completed_quizzes_count']        = count($data['completed_quizzes']);
        $data['completed_assignments_count']    = count($data['completed_assignments']);
        $data['uncompleted_lessons_count']      = count($data['uncompleted_lessons']);
        $data['uncompleted_quizzes_count']      = count($data['uncompleted_quizzes']);
        $data['uncompleted_assignments_count']  = count($data['uncompleted_assignments']);

        // dd($data);
        return $data;
    }

    public function joinLiveSession($request)
    {       /** @var CourseSession $session***/
        $session = CourseSession::find($request->id);
        $attendance = SessionAttendance::firstOrCreate(['user_id' => auth('api')->id(),
                                          'session_id' => $request->id]);
        return $session->joinLiveSessionV2('api');
    }

    function endLessons($request,$is_web = true)
    {
        $user = $this->getUser($is_web);

        CourseLessonsLearning::create([
            'user_id' => $user->id,
            'lesson_id' => $request->get('lesson_id'),
            'lesson_type' => 'normal'
        ]);

        $lesson = CourseLessons::where('id',$request->get('lesson_id'))->first();
        $course = $lesson->course;
        $course->updateProgress('api');

    }

    function getComments($itemId ,$itemType, $is_web = true)
    {
        $comments = CourseComments::where('item_id',$itemId)
        ->where('item_type',$itemType)
        ->whereNull('parent_id')->with('user')->paginate(10);

        return new ApiItemCommentCollection($comments);

    }

    function getReplys($commentId , $is_web = true){
        $reply = CourseComments::where('parent_id',$commentId)->paginate(10);
        return new ApiItemCommentCollection($reply);
    }


}
