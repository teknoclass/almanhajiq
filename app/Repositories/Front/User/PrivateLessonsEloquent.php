<?php

namespace App\Repositories\Front\User;

use App\Http\Resources\PrivateLessonCollection;
use App\Models\Balances;
use App\Models\LecturerTimeTable;
use App\Models\Notifications;
use App\Models\PrivateLessonMeetingParticipants;
use App\Models\PrivateLessons;
use App\Models\PrivateLessonsRequest;
use App\Models\Transactios;
use App\Models\User;
use Carbon\Carbon;
use GPBMetadata\Google\Api\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use JoisarJignesh\Bigbluebutton\Facades\Bigbluebutton;

class PrivateLessonsEloquent extends HelperEloquent
{

    public function index($type, $is_web = true, $package_id = null)
    {
        $data['type'] = $type;

        $data['user'] = $this->getUser($is_web);

        $privateLessons = PrivateLessons::query()->getStudentPrivateLessons($data['user']->id)
                                        ->where('status', 'acceptable')
                                        ->when($package_id, function($priv_lesson) use ($package_id) {
                                            $priv_lesson->whereHas('user_package', function($package) use ($package_id
                                            ) {
                                                $package->where('package_id', $package_id);
                                            });
                                        })
                                        ->with([
                                            'category' => function($query) {
                                                $query->select('id', 'title', 'value', 'parent')
                                                      ->with('translations:category_id,name,locale');
                                            }
                                        ])
                                        ->with([
                                            'teacher' => function($query) {
                                                $query->select('id', 'name');
                                            }
                                        ]);

        $time_now = now()->toTimeString();
        $date_now = now()->toDateString();

        if ($type == 'upcoming') {
            $privateLessons->where(function($query) use ($time_now, $date_now) {
                $query->where('meeting_date', '>', $date_now)
                      ->orWhere(function($query) use ($time_now, $date_now) {
                          $query->where('meeting_date', '=', $date_now)
                                ->where('time_to', '>=', $time_now);
                      });
            })
                           ->where('status', '!=', 'unacceptable')
                           ->orderBy('meeting_date', 'asc');
        }
        else {
            $privateLessons->where(function($query) use ($time_now, $date_now) {
                $query->where('meeting_date', '<', $date_now)
                      ->orWhere(function($query) use ($time_now, $date_now) {
                          $query->where('meeting_date', '=', $date_now)
                                ->where('time_to', '<', $time_now);
                      })
                      ->orWhere('status', 'unacceptable');
            })
                           ->orderBy('meeting_date', 'desc');
        }

        $data['privateLessons'] = $privateLessons->paginate(10);

        return $data;
    }

    public function indexApi($type, $is_web=true)
    {
        $data['type'] = $type;

        $data['user'] = $this->getUser($is_web);

        $privateLessons = PrivateLessons::query()->getStudentPrivateLessons($data['user']->id)
        ->with(['category' => function ($query) {
                $query->select('id', 'title', 'value', 'parent')
                    ->with('translations:category_id,name,locale');
            }
        ])
        ->with(['teacher' => function ($query) {
            $query->select('id', 'name','image');
        }
        ]);



        $time_now = now()->toTimeString();
        $date_now = now()->toDateString();


        if ($type == 'upcoming') {
            $privateLessons->where(function ($query) use ($time_now, $date_now) {
                $query->where('meeting_date', '>', $date_now)
                    ->orWhere(function ($query) use ($time_now, $date_now) {
                        $query->where('meeting_date', '=', $date_now)
                            ->where('time_form', '>=', $time_now);
                    });
                })
                ->where('status', '!=', 'unacceptable')
                ->orderBy('meeting_date', 'asc');
        }else if($type == 'now'){
            $privateLessons->where(function ($query) use ($time_now, $date_now) {
                $query->where('meeting_date', '=', $date_now)
                    ->where('time_form' , '<=' , $time_now)
                    ->where('time_to' , '>=', $time_now);
                })
                ->where('status', '!=', 'unacceptable')
                ->orderBy('meeting_date', 'asc');
        }else{
            $privateLessons->where(function ($query) use ($time_now, $date_now) {
                $query->where('meeting_date', '<', $date_now)
                ->orWhere(function ($query) use ($time_now, $date_now) {
                    $query->where('meeting_date', '=', $date_now)
                        ->where('time_to', '<', $time_now);
                })
                ->orWhere('status', 'unacceptable');
                })
                ->orderBy('meeting_date', 'desc');
        }

        $data['privateLessons'] = $privateLessons->paginate(10);

        if(!$is_web){

            $data['privateLessons'] = new PrivateLessonCollection($data['privateLessons']);
            unset($data['user']);

        }


        return $data;
    }


    public function book($request, $id, $is_web = true)
    {
        // dd($request->all());
        if (checkUser('lecturer')) {
            $message  = __("As_a_teacher_you_cant_register_in_the_Lessons");
            $status   = false;
            $response = [
                'message' => $message,
                'status' => $status,
            ];

            return $response;
        }
        try {
            DB::beginTransaction();
            $user         = $this->getUser($is_web);
            $data['user'] = $user;
            $teacher      = User::find($request->teacher_id);

            // $date         = Carbon::parse(strtotime($request->date))->addDays(1)->format('Y-m-d');
            // $from         = $request->from;
            // $to           = $request->to;


            $lesson       = new PrivateLessons();
            $time_type    = $request->time_type == "half_hour" ? 'half_hour' : 'hour';
            $lesson_hours = $request->time_type == "half_hour" ? 0.5 : 1;

            $user_package_id   = null;
            $use_old_hours     = $request->use_old_hours;
            $user_remain_hours = $use_old_hours ? $user->user_remain_hours : 0;


            // Validate times
            foreach ($request->lessons ?? [] as $request_lesson) {
                $date   = Carbon::parse(strtotime($request_lesson['date']))->addDays(1)->format('Y-m-d');
                $from   = $request_lesson['from'];
                $to     = $request_lesson['to'];
                $day_no = $request_lesson['day_no'] ?? null;

                $reserved_times = PrivateLessons::where('teacher_id', $teacher->id)
                                                ->where(function($query) use ($from, $to) {
                                                    $query->where('time_form', $from)->orWhere('time_to', $to);
                                                })
                                                ->where('meeting_date', $date)
                                                ->select(
                                                    DB::raw("Case When time_type = 'hour' then 1 else .5 end as times")
                                                )
                                                ->get('times')
                                                ->sum('times');
                if ($reserved_times + $lesson_hours > 1) {
                    $message = "هذا الميعاد تم حجزه من قبل! : $date [$from - $to]";
                    $status  = false;

                    $response = [
                        'message' => $message,
                        'status' => $status,
                    ];

                    return $response;
                }

                if ($use_old_hours && $user_remain_hours < $lesson_hours) {
                    $message = "للأسف لا يوجد لديكم في الباقة رصيد ساعات كافي!";
                    $status  = false;

                    $response = [
                        'message' => $message,
                        'status' => $status,
                    ];

                    return $response;
                }

                if ($date < now()->toDateString() || ($date == now()->toDateString() && $from < now()->toTimeString())) {
                    $lesson->status = "unacceptable";
                    $lesson->update();

                    $message = "هذا الدرس انتهى موعده! : $date [$from - $to]";
                    $status  = false;

                    $response = [
                        'message' => $message,
                        'status' => $status,
                    ];

                    return $response;
                }

                // check time in lecturer times
                $lecturer_times = LecturerTimeTable::where('user_id', $teacher->id)
                                                   ->where('day_no', $day_no)
                                                   ->where('from', $from)->where('to', $to)
                                                   ->exists();
                if ($lecturer_times || Carbon::parse($date)->dayOfWeek != $day_no) {
                    $lesson->status = "unacceptable";
                    $lesson->update();

                    $message = "هذا الدرس لم يعد متاح عند المدرس!";
                    $status  = false;

                    $response = [
                        'message' => $message,
                        'status' => $status,
                    ];

                    return $response;
                }


                $hour_price = $request->type == "half_hour" ? $teacher->hour_price / 2 : $teacher->hour_price;

                // if ($hour_price == null) {

                //     $message = "حدث خطأ في تسعير الدرس. الرجاء المحاولة لاحقاً أو التواصل مع المدرب المختص!";
                //     $status  = false;

                //     $response = [
                //         'message' => $message,
                //         'status' => $status,
                //     ];

                //     return $response;
                // }

                $lesson->price = $hour_price;

                if ($request->type == 'group') {

                    $student_no = $request->student_no;

                    if (!$student_no) {
                        $message  = "الرجاء إدخال عدد الطلاب";
                        $status   = false;
                        $response = [
                            'message' => $message,
                            'status' => $status,
                        ];

                        return $response;
                    }
                    else if ($student_no < $lesson->getMinStudentsNo($request->meeting_type)) {
                        $message  = "عدد الطلاب الذي أدخلته أقل من الحد الأدنى المطلوب";
                        $status   = false;
                        $response = [
                            'message' => $message,
                            'status' => $status,
                        ];

                        return $response;
                    }
                    else if ($student_no > $lesson->getMaxStudentsNo($request->meeting_type)) {
                        $message  = "عدد الطلاب الذي أدخلته أعلى من الحد الأقصى المطلوب";
                        $status   = false;
                        $response = [
                            'message' => $message,
                            'status' => $status,
                        ];

                        return $response;

                    }
                    else {
                        $lesson->student_no = $request->student_no;
                        $lesson->price      = $hour_price * $lesson->student_no;
                    }
                }
            }

            if ($use_old_hours) {
                $user_package_id = $user->user_packages()->paid()
                                        ->has('package_valid')
                                        ->first()?->id;
            }

            $total_money_to_pay   = 0;
            $transaction_id       = 0;
            $transactions_ingroup = [];
            // calculate
            foreach ($request->lessons ?? [] as $request_lesson) {
                $lesson            = new PrivateLessons();
                $lesson->time_type = $time_type;

                $date = Carbon::parse(strtotime($request_lesson['date']))->addDays(1)->format('Y-m-d');
                $from = $request_lesson['from'];
                $to   = $request_lesson['to'];

                if ($use_old_hours && $user_remain_hours < $lesson_hours) {
                    $use_old_hours = 0;
                }
                $user_remain_hours--;

                $hour_price    = $time_type == "half_hour" ? $teacher->hour_price / 2 : $teacher->hour_price;
                $lesson->price = $hour_price;

                if ($request->type == 'group') {
                    $student_no         = $request->student_no;
                    $lesson->student_no = $request->student_no;
                    $lesson->price      = $hour_price * $lesson->student_no;
                }

                $total_money_to_pay += $use_old_hours ? 0 : $lesson->price;

                $lesson->category_id     = 2;
                $lesson->title           = 'Lesson';
                $lesson->teacher_id      = $teacher->id;
                $lesson->description     = '';
                $lesson->time_form       = $from;
                $lesson->time_to         = $to;
                $lesson->meeting_date    = $date;
                $lesson->meeting_type    = $request->meeting_type;
                $lesson->student_id      = $user->id;
                $lesson->status          = $use_old_hours ? 'acceptable' : 'pending';//'acceptable';
                $lesson->user_package_id = $user_package_id;
                $lesson->save();

                // save Transactios
                $params_transactios = [
                    'description' => $lesson->title,
                    'user_id' => $lesson->student_id,
                    'user_type' => Transactios::LECTURER,
                    'payment_id' => null, //uniqid(),
                    'amount' => $lesson->price,
                    'amount_before_discount' => $lesson->price,
                    'type' => Transactios::DEPOSIT,
                    'transactionable_id' => $lesson->id,
                    'transactionable_type' => get_class($lesson),
                    'coupon' => '',
                    'is_paid' => $use_old_hours ? 1 : 0,
                ];

                if ($use_old_hours) {
                    $params_transactios['is_paid'] = 1;
                    $params_transactios['status']  = 'completed';
                }

                $transaction = $this->saveTransactios($params_transactios);

                $transaction_id = $transaction->id;

                if (!$use_old_hours) {
                    $transactions_ingroup[] = $transaction;
                }

                // add balance to lecturer
                $system_commission = getSystemCommission($lesson->teacher_id);

                if ($system_commission == "")
                    $system_commission = 0;

                //amount_before_commission
                $amount_after_commission = $lesson->price;
                if ($system_commission != 0) {
                    $amount_after_commission = $lesson->price - (($system_commission / 100) * $lesson->price);
                }

                $params_balance = [
                    'description' => $lesson->title,
                    'user_id' => $lesson->teacher_id,
                    'user_type' => Balances::LECTURER,
                    'transaction_id' => $lesson->id,
                    'transaction_type' => get_class($lesson),
                    'amount' => $amount_after_commission,
                    'system_commission' => $system_commission,
                    'amount_before_commission' => $lesson->price,
                    'becomes_retractable_at' => Carbon::now(),
                    'is_retractable' => 1,
                    'pay_transaction_id' => $transaction->id,
                    'is_paid' => $use_old_hours ? 1 : 0,
                ];
                session()->put('private-balance-'.auth('web')->user()->id,$params_balance);


            }

            // dd($total_money_to_pay , count($transactions_ingroup) ) ;

            if ($total_money_to_pay && count($transactions_ingroup) > 1) // more than 1 transaction
            {
                // create pay transaction
                $params_transactios = [
                    'description' => $lesson->title,
                    'user_id' => $lesson->student_id,
                    'user_type' => Transactios::LECTURER,
                    'payment_id' => null, //uniqid(),
                    'amount' => $total_money_to_pay,
                    'amount_before_discount' => $total_money_to_pay,
                    'type' => Transactios::DEPOSIT,
                    'transactionable_id' => null,
                    'transactionable_type' => get_class($lesson),
                    'coupon' => '',
                    'is_paid' => 0,
                ];

                $transaction = $this->saveTransactios($params_transactios);

                $transaction_id = $transaction->id;

                foreach ($transactions_ingroup as $key => $child_transaction) {
                    $child_transaction->pay_transaction_id = $transaction_id;
                    $child_transaction->save();
                }
            }


            // send notification after payment
            if (!$use_old_hours && !$total_money_to_pay) {
                $this->notify_lecturer_after_pay($transaction_id);
            }

            DB::commit();

            $message  = __('message_done');
            $status   = true;
            $response = [
                'message' => $message,
                'status' => $status,
                'transaction_id' => $transaction->id,
            ];
            if (!$use_old_hours) {
                  //if total_money_to_pay is free
                  if($total_money_to_pay == 0)
                  {
                    (new PrivateLessonsEloquent())->pay_realated($transaction_id);

                    $response['redirect_url'] =  url("/user/private-lessons");
                  }else{
                      $response['redirect_url'] = route('user.payment.checkout', $transaction->id);
                  }
            }

            return $response;
        } catch (\Exception $exception) {
            DB::rollBack();
            $status   = false;
            $response = [
                'message' => $exception->getMessage(),
                'status' => $status,
            ];

            return $response;
        }
    }

    //sendNotification

    public function saveTransactios(array $params)
    {
        return Transactios::create([
            'description' => $params['description'],
            'user_id' => $params['user_id'],
            'user_type' => $params['user_type'],
            'payment_id' => $params['payment_id'],
            'amount' => $params['amount'],
            'amount_before_discount' => $params['amount_before_discount'],
            'type' => $params['type'],
            'transactionable_id' => $params['transactionable_id'],
            'transactionable_type' => $params['transactionable_type'],
            'coupon' => isset($params['coupon']) ? $params['coupon'] : '',
            'pay_transaction_id' => @$params['pay_transaction_id'],
            'is_paid' => @$params['is_paid'] ?? 0,
            'status' => @$params['status'] ?? 'pinding',
        ]);
    }

    public function addBalance(array $params)
    {
        Balances::create([
            'description' => $params['description'],
            'user_id' => $params['user_id'],
            'user_type' => $params['user_type'],
            'type' => Balances::DEPOSIT,
            'transaction_id' => $params['transaction_id'],
            'transaction_type' => $params['transaction_type'],
            'amount' => $params['amount'],
            'system_commission' => $params['system_commission'],
            'amount_before_commission' => $params['amount_before_commission'],
            'becomes_retractable_at' => $params['becomes_retractable_at'],
            'is_retractable' => $params['is_retractable'],
            'pay_transaction_id' => @$params['pay_transaction_id'],
        ]);

        // Run Job to change its state to make it draggable

        return true;
    }

    function notify_lecturer_after_pay($transaction_id)
    {
        $transaction = Transactios::find($transaction_id);
        if (!$transaction) return false;

        $lesson = $transaction->transactionable;

        $user = $transaction->user;

        $title                       = 'حجز درس خصوصي ';
        $text                        = "قام " . $user->name . " بحجز درسك الخصوصي: " . $lesson->title;
        $notification['title']       = $title;
        $notification['text']        = $text;
        $notification['user_type']   = 'user';
        $notification['action_type'] = 'private_lesson_registeration';
        $notification['action_id']   = $lesson->id;
        $notification['created_at']  = \Carbon\Carbon::now();

        $teacher_id              = $lesson->teacher_id;
        $notification['user_id'] = $lesson->teacher_id;

        Notifications::insert($notification);
        sendWebNotification($teacher_id, 'user', $title, $text);


        $teacher = $lesson->teacher;
        $student = $lesson->student;
        // Send Mail To Lecturer
        $text_msg = "<p>أنا الطالب : <b>$student?->name</b>، </p>";
        $text_msg .= "<p>حجزت مع المدرس : <b>$teacher?->name</b> </p>";
        $text_msg .= "<p>موعد بتاريخ : <b>$lesson->meeting_date</b> </p>";
        $text_msg .= "<p>الساعة من <b>$lesson->time_form إلي $lesson->time_to </b> </p>";
        $text_msg .= "<p>وسعرها : <b>$transaction->amount</b> </p>";
        sendEmail($title, $text_msg, $student->email);
        // send teacher
        sendEmail($title, $text_msg, $teacher->email);

        return true;
    }

    function pay_realated($transaction_id)
    {
        $transaction = Transactios::find($transaction_id);
        if (!$transaction) return false;
        try {

            if (!$transaction->transactionable_id) {
                foreach ($transaction->related_transactions as $key => $related_transaction) {
                    if ($related_transaction->id != $transaction_id) {
                        $this->pay_realated($related_transaction->id);
                    }
                }
            }

            $transaction->update(['is_paid' => 1]);
            $transaction->related_transactions()->update(['is_paid' => 1]);
            $balanceDetails = session('private-balance-'.auth('web')->user()->id);
            $this->addBalance($balanceDetails);

            $lesson         = $transaction->transactionable;
            $lesson->status = 'acceptable';
            $lesson->save();

            $this->notify_lecturer_after_pay($transaction_id);

            return true;
        } catch (\Throwable $th) {
            \Log::error($th->getMessage());
            return false;
        }
    }

    public function joinMeeting($id, $is_web = true)
    {
        $data['user'] = $this->getUser($is_web);

        $session = PrivateLessons::where('id', $id)
                                 ->with('meeting')->first();

        if (!isset($session->meeting)) {
            abort(404);
        }

        if ($session->canStartMeeting()) {
            $item = PrivateLessonMeetingParticipants::where('user_id', $data['user']->id)
                                                    ->where('private_lesson_id', $id)->first();

            if (!$item) {
                PrivateLessonMeetingParticipants::create([
                    'private_lesson_id' => $id,
                    'meeting_id' => $session->meeting->id,
                    'user_id' => $data['user']->id,
                ]);
            }

            if (env('MeetingChannel') == 'AGORA') {
                $data['meeting']        = $session->meeting;
                $data['private_lesson'] = $session;
                $data['status']         = true;

                return $data;
            }
            else if (env('MeetingChannel') == 'ZOOM') {
                $data['url']    = $session->meeting->url;
                $data['status'] = true;

                return $data;
            }
            else {
                $meeting_id = $id;

                $url = Bigbluebutton::join([
                    'meetingID' => $session->meeting?->app_id,
                    'userName' => auth()->user()->name,
                    'role' => 'VIEWER',
                    'password' => 'attendee'             //which user role want to join set password here
                ]);

                $data['url']    = $url;
                $data['status'] = true;

                return $data;
            }
        }

        $data['status'] = false;

        return $data;

    }

    function postpone($request){

        $data = [
            'date' => $request->date,
            'from' => $request->from,
            'to' => $request->to
        ];
        $json = json_encode($data);
        $paths = array();
        foreach($request->files as $file){
            foreach($file as $f){
                $paths[] = uploadFile($f);
            }

        }

        $request = PrivateLessonsRequest::create([
            'private_lesson_id' => $request->lesson_id,
            'user_id' => auth('api')->id(),
            'user_type' => auth('api')->user()->role,
            'type' => 'postpone',
            'statuss' => 'pending',
            'suggested_dates' => $json,
            'optional_files' => $paths
        ]);




    }

    function getRequests(){
        $data = PrivateLessonsRequest::where('status','pending')->where('type','postpone')->where('user_type','teacher')
        ->whereHas('privateLesson',function($q){
            $q->where('student_id',auth('api')->id());
        })->paginate(10);

        return $data;
    }

    function respodeToRequest($request){

        $postRequest = PrivateLessonsRequest::find($request->request_id);

        $postRequest->status = $request->status;
        $postRequest->save();

        if($request->status == 'accepted'){
            $lesson = PrivateLessons::find($postRequest->private_lesson_id);
            $data = json_decode($postRequest->suggested_dates,1);

            $lesson->meeting_date = $data['date'];
            $lesson->time_form = $data['from'];
            $lesson->time_to = $data['to'];
            $lesson->save();
        }

    }


    function showRequest($id){
        $request = PrivateLessonsRequest::find($id);
        $data = json_decode($request->suggested_dates,1);
        $files = array();
        foreach($request->optional_files as $file){
            $files[] = fileUrl($file);
        }
        $data = [
            'id' => $id,
            'old_date' => $request->privateLesson->meeting_date,
            'old_from' => $request->privateLesson->time_form,
            'old_to' => $request->privateLesson->time_to,
            'date' => $data['date'],
            'from' => $data['from'],
            'to' => $data['to'],
            'files' => $files,
            'teacher_name' => $request->privateLesson->teacher->name,
            'teacher_photo' => imageUrl($request->privateLesson->teacher->image),
            'student_name' => $request->privateLesson->student->name,
            'student_photo' => imageUrl($request->privateLesson->student->image)
        ];

        return $data;
    }


}
