<?php

namespace App\Repositories\Front\User;

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
use App\Models\Transactios;
use Illuminate\Database\Eloquent\Builder;
use App\Models\User;
use App\Models\UserCourse;
use App\Repositories\Front\CouponsEloquent;

class CoursesEloquent extends HelperEloquent
{
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
            $template_texts = $certificate_templates->texts;
            $user_id=$data['user']->id;

            $Arabic = new \I18N_Arabic('Glyphs');

            $extension = \File::extension($certificate_templates->background);

            //header('Content-type: image/jpeg');

            if($extension=='png') {
                $our_image = imagecreatefrompng(storage_path("app/uploads/images/".$certificate_templates->background));
            } else {
                $our_image = imagecreatefromjpeg(storage_path("app/uploads/images/".$certificate_templates->background));
            }
            $font_path = public_path("assets/front/certificate_settings/din-next-regular.ttf");
            $imagewidth = imagesx($our_image);
            //$size = 31;
            $angle = 0;

            foreach($template_texts as $template_text) {
                $size = floatval(str_replace('px', '', $template_text->font_size_css));
                $color_text=hexToRgb($template_text->font_color_css);
                $coordinates=json_decode($template_text->coordinates);
                if($template_text->type==CertificateTemplateTexts::STUDENT_NAME_LOCATION) {
                    $text= $data['user']->name;
                    $left = $coordinates->left;
                    $top = (str_replace('px', '', $coordinates->top)+70);
                }elseif($template_text->type==CertificateTemplateTexts::COURSE_NAME_LOCATION){
                    $text= $item->course->title;
                    $left = $coordinates->left;
                    $top = (str_replace('px', '', $coordinates->top)+90);
                }elseif($template_text->type==CertificateTemplateTexts::LECTURER_NAME_LOCATION){
                    $text= $lecturer->name;
                    $left = $coordinates->left;
                    $top = (str_replace('px', '', $coordinates->top)+60);
                } elseif($template_text->type==CertificateTemplateTexts::CERTIFICATE_DATE){
                    $text= date('Y-m-d');
                    $left = $coordinates->left;
                    $top = (str_replace('px', '', $coordinates->top)+130);
                } else {
                    $text=strip_tags($template_text->text);
                    $left = $coordinates->left;
                    $top = (str_replace('px', '', $coordinates->top)+45);
                }
                $color = imagecolorallocate($our_image, $color_text['r'], $color_text['g'], $color_text['b']);
                $text = $Arabic->utf8Glyphs($text);
                $box = @imageTTFBbox($size, $angle, $font_path, $text);
                $textwidth = abs($box[4] - $box[0]);
                if($template_text->type==CertificateTemplateTexts::STUDENT_NAME_LOCATION) {
                    if($left>($imagewidth/2)) {
                        $left = ($left + $textwidth);
                    } else {
                        $left = $imagewidth - ($left + $textwidth);
                    }
                }elseif($template_text->type==CertificateTemplateTexts::COURSE_NAME_LOCATION){
                    if($left>($imagewidth/2)) {
                        $left = ($left + $textwidth - 100);
                    } else {
                        $left = $imagewidth - ($left + $textwidth + 100);
                    }
                }elseif($template_text->type==CertificateTemplateTexts::CERTIFICATE_DATE){
                    if($left>($imagewidth/2)) {
                        $left = ($left + $textwidth);
                    } else {
                        $left = ($left + $textwidth-200);
                    }
                } else {
                    $left = ($left + $textwidth);
                }
                imagettftext($our_image, $size, $angle, $left, $top, $color, $font_path, $text);
            }

            $name = time() . ".jpeg";

            $path = storage_path("app/certificates/" . $item->user_id);
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }
            imagejpeg($our_image, $path . '/' . $name);

            return response()->download($path . '/' . $name);
        } catch (\Exception $e) {
            return back();
        }
    }

    public function myCourses($request, $is_web = true, $count_itmes = 9, $use_filters = true, $only_is_end = false)
    {
        $data['user'] = $this->getUser($is_web);

        $user_id = $data['user']->id;
        $course_type = $request->get('course_type');

        $data['courses'] = Courses::withTrashed()->active()->accepted()
            ->select('id', 'image', 'start_date', 'duration', 'type', 'category_id', 'is_active', 'is_delete','material_id')
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
        ->where(function($query)  use ($user_id, $only_is_end) {
            $query->where('id',studentSubscriptionCoursessIds());
            $query->orWhere('id',studentInstallmentsCoursessIds());

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
                    ->where('user_id', $user_id),

                'is_rating' => UserCourse::select('is_rating')
                    ->whereColumn('course_id', 'courses.id')
                    ->where('user_id', $user_id),
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
        ->select('id', 'image', 'start_date', 'duration', 'type', 'category_id', 'is_active', 'is_delete','material_id')
        ->with('translations:courses_id,title,locale,description')
        ->where('id', $course_id)
        ->addSelect([
            'is_end' => UserCourse::select('is_end')
                ->whereColumn('course_id', 'courses.id')
                ->where('user_id', auth()->id()),

            'is_rating' => UserCourse::select('is_rating')
                ->whereColumn('course_id', 'courses.id')
                ->where('user_id', auth()->id()),
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

        if ($data['course'] =='') abort(404);
        if (!$data['course']->isSubscriber()) abort(403);


        function getCurriculumQuery($courseId) {
            return CourseCurriculum::active()->where('course_id', $courseId)->select(['itemable_type', 'itemable_id', 'order'])->orderBy('id','asc');
        }

        function getSectionItemsQuery($courseId) {
            return CourseSectionItems::active()->where('course_id', $courseId)->select(['itemable_type', 'itemable_id', 'order'])->orderBy('id','asc');
        }

        $data['completed_lessons'] = getCurriculumQuery($data['course']->id)->completedItems(['lesson'])
            ->union( getSectionItemsQuery($data['course']->id)->completedItems(['lesson']) )
            ->get();

        $data['completed_quizzes'] = getCurriculumQuery($data['course']->id)->completedItems(['quiz'])
            ->union( getSectionItemsQuery($data['course']->id)->completedItems(['quiz']) )
            ->get();

        $data['completed_assignments'] = getCurriculumQuery($data['course']->id)->completedItems(['assignment'])
            ->union( getSectionItemsQuery($data['course']->id)->completedItems(['assignment']) )
            ->get();

       // $data['uncompleted_lessons'] = getCurriculumQuery($data['course']->id)->uncompletedItems(['lesson'])
        //     ->union( getSectionItemsQuery($data['course']->id)->uncompletedItems(['lesson']) )
        //     ->get();

        $data['uncompleted_lessons'] = getCurriculumQuery($data['course']->id)
        ->union( getSectionItemsQuery($data['course']->id) )
        ->get();

        // $data['uncompleted_quizzes'] = getCurriculumQuery($data['course']->id)->uncompletedItems(['quiz'])
        //     ->union( getSectionItemsQuery($data['course']->id)->uncompletedItems(['quiz']) )
        //     ->get();

        $data['uncompleted_quizzes'] = getCurriculumQuery($data['course']->id)
        ->union( getSectionItemsQuery($data['course']->id))
        ->get();

        // $data['uncompleted_assignments'] = getCurriculumQuery($data['course']->id)->uncompletedItems(['assignment'])
        //     ->union( getSectionItemsQuery($data['course']->id)->uncompletedItems(['assignment']) )
        //     ->get();

        $data['uncompleted_assignments'] = getCurriculumQuery($data['course']->id)
        ->union( getSectionItemsQuery($data['course']->id))
        ->get();

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

        return $session->joinLiveSession($request);
    }

}
