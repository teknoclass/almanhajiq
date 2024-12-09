<?php

namespace App\Repositories\Front\User\Lecturer;

use App\Models\Category;
use App\Models\CategoryPrice;
use App\Models\Balances;
use App\Models\LecturerSetting;
use App\Models\PrivateLessons;
use App\Models\Ratings;
use App\Models\User;
use App\Models\UserCategory;
use App\Repositories\Front\User\HelperEloquent;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Kreait\Firebase\Http\Requests;
use App\Models\PrivateLessonMeeting;
use App\Models\PrivateLessonMeetingParticipants;
use Carbon\Carbon;
use JoisarJignesh\Bigbluebutton\Facades\Bigbluebutton;
use Jubaer\Zoom\Facades\Zoom;

class LecturerPrivateLessonsEloquent extends HelperEloquent
{

    public function index($type, $is_web = true)
    {

        $user = $this->getUser($is_web);

        $data = $this->getStatistics();

        $data['type'] = $type;

        $data['categories'] = $user->materials->map->category;

        $studentsWithLessons = PrivateLessons::distinct('student_id')->pluck('student_id');

        $data['students'] = $user->RelatedStudents()->select('id', 'name')->get();

        $data['lessons'] = PrivateLessons::query()->where('teacher_id', $user->id)
            ->with([
                'category' => function ($query) {
                    $query->select('id', 'title', 'value', 'parent')
                        ->with('translations:category_id,name,locale');
                }
           ,'requests'=>function ($query){
                $query->where('user_type','teacher');
                } ])->where('status','acceptable');

        $time_now = now()->toTimeString();
        $date_now = now()->toDateString();

        if ($type == 'upcoming') {
            $data['lessons']->where(function ($query) use ($time_now, $date_now) {
                $query->where('meeting_date', '>', $date_now)
                    ->orWhere(function ($query) use ($time_now, $date_now) {
                        $query->where('meeting_date', '=', $date_now)
                            ->where('time_to', '>=', $time_now);
                    });
            })
                ->where('status', '!=', 'unacceptable')
                ->orderBy('meeting_date', 'asc');
        } else {
            $data['lessons']->where(function ($query) use ($time_now, $date_now) {
                $query->where('meeting_date', '<', $date_now)
                    ->orWhere(function ($query) use ($time_now, $date_now) {
                        $query->where('meeting_date', '=', $date_now)
                            ->where('time_to', '<', $time_now);
                    })
                    ->orWhere('status', 'unacceptable');
            })
                ->orderBy('meeting_date', 'desc');
        }

        $data['lessons'] = $data['lessons']->paginate(10);

        // dd($data['lessons']);
        return $data;
    }

    public function filters($request, $is_web = true)
    {
        $user = $this->getUser($is_web);

        $data = $this->getStatistics();


        $data['categories'] = $user->materials->map->category;

        $studentsWithLessons = PrivateLessons::distinct('student_id')->pluck('student_id');

        $data['students'] = User::whereIn('id', $studentsWithLessons)->select('id', 'name')->get();

        $data['search_query'] = $request->all();

        $data['lessons'] = PrivateLessons::filterByDate($request->date_from, $request->date_to)
            ->filterByCategory($request->category_id)
            ->filterByStudent($request->student_id)
            ->filterByStatus($request->status)
            ->paginate(10);

        return $data;
    }

    public function settings($is_web = true)
    {

        $data['user'] = $this->getUser($is_web);

        // $data['categories']  = $user->materials->map->category;
        // dd(  $data['categories']);
        /* $data['lecturer'] = LecturerSetting::where('user_id', $user->id)
             ->select('id','accept_group', 'online_group_min_no', 'online_group_max_no', 'online_group_price',
                 'offline_group_min_no', 'offline_group_max_no', 'offline_group_price',)
             ->first();*/

        return $data;

    }

    public function getStatistics($is_web = true)
    {

        $data['totalPendingCourses'] = PrivateLessons::whereTeacherId('status', 'pending')->count();

        $data['totalLessons'] = PrivateLessons::whereTeacherId(auth()->id())->count();

        $data['totalStudents'] = PrivateLessons::whereTeacherId(auth()->id())->distinct('student_id')->count('student_id');

        //totalEarningsAllTime
        $user = $this->getUser($is_web);
        $totalEarningsAllTime = Balances::where('user_id', "=", $user->id)->where('transaction_type', "=", 'App\Models\PrivateLessons')->where('type', "=", 'deposit')->sum('amount');
        if ($user->country) {
            $data['totalEarningsAllTime'] = ceil($user->country->currency_exchange_rate * $totalEarningsAllTime) . " " . $user->country->currency_name;
        } else {
            $data['totalEarningsAllTime'] = $totalEarningsAllTime . ' $';
        }

        return $data;
    }

    public function create($is_web = true)
    {

        $user = $this->getUser($is_web);

        $data['categories'] = Category::getCategoriesByParent('course_categories')->get();

        return $data;
    }

    public function edit($id, $is_web = true)
    {

        $user = $this->getUser($is_web);

        //$data['categories'] = $user->materials->map->category;
        $data['categories'] = Category::getCategoriesByParent('course_categories')->get();

        $data['lesson'] = PrivateLessons::find($id);

        return $data;
    }


    public function set($request, $is_web = true)
    {
        DB::beginTransaction();

        $user = $this->getUser($is_web);

        try {

            $data = $request->all();

            $hour_price = $user->hour_price;

            if ($hour_price == null) {

                //$message = "الرجاء ادخال سعر المادة وعدد الطلاب من اعدادات الدروس الخصوصية قبل إنشاء الدرس!";
                $message = __('teacher_hourly_price_not_defined');
                $status = false;

                $response = [
                    'message' => $message,
                    'status' => $status,
                ];

                return $response;
            }

            // $category_prices = CategoryPrice::where('category_id', $request->category_id)->first();

            // if ($category_prices == null) {

            //     $category = Category::find($request->category_id);

            //     $message = "الرجاء ادخال أسعار مادة ال " . $category->name . " من اعدادات الدروس الخصوصية قبل إنشاء الدرس!";
            //     $status = false;

            //     $response = [
            //         'message' => $message,
            //         'status' => $status,
            //     ];

            //     return $response;
            // }
            for ($i = 0; $i < count($request->meeting_date); $i++) {
                if (strtotime($request->time_form[$i]) >= strtotime($request->time_to[$i])) {
                    $message = "وقت انتهاء الدرس يجب أن يكون أكبر من وقت البدء";
                    $response = [
                        'message' => $message,
                        'status' => false,
                    ];

                    return $response;
                }
                $data['meeting_date'] = $request->meeting_date[$i];
                $data['time_form'] = $request->time_form[$i];
                $data['time_to'] = $request->time_to[$i];
                //$item = PrivateLessons::create($data)->createTranslation($request);
                $item = PrivateLessons::updateOrCreate(['id' => $request->id], $data)->createTranslation($request);
            }

            $message = __('message.operation_accomplished_successfully');
            $status = true;

            DB::commit();
        } catch (\Exception $e) {
            dd($e);
            $message = __('message.unexpected_error');
            $status = false;
            DB::rollback();
        }
        $response = [
            'message' => $message,
            'status' => $status,
        ];

        return $response;
    }

    public function storeSettings($request, $is_web = true)
    {
        DB::beginTransaction();

        try {

            $user = $this->getUser($is_web);

            $data = $request->all();
            $data['user_id'] = $user->id;

            $item = User::updateOrCreate(['id' => $user->id], $data);

            $message = __('message.operation_accomplished_successfully');
            $status = true;

            DB::commit();
        } catch (\Exception $e) {
            $message = __('message.unexpected_error');
            $status = false;
            DB::rollback();
        }
        $response = [
            'message' => $message,
            'status' => $status,
        ];

        return $response;
    }

    public function storeCategoriesPrices($request, $is_web = true)
    {

        DB::beginTransaction();
        try {
            $user = $this->getUser($is_web);
            $data = $request->all();
            $data['user_id'] = $user->id;
            $item = CategoryPrice::updateOrCreate(['category_id' => $data['category_id']], $data);
            $message = __('message.operation_accomplished_successfully');
            $status = true;
            DB::commit();
        } catch (\Exception $e) {
            $message = __('message.unexpected_error');
            $status = false;
            DB::rollback();
        }
        $response = [
            'message' => $message,
            'status' => $status,
        ];

        return $response;
    }



    public function delete($request)
    {
        $item = PrivateLessons::find($request->id);
        if ($item) {

            $item->delete();
            $message = __('delete_done');
            $status = true;
            $response = [
                'message' => $message,
                'status' => $status,
            ];
            return $response;

        }
        $message = __('message_error');
        $status = false;

        $response = [
            'message' => $message,
            'status' => $status,
        ];

        return $response;
    }

    public function createMeeting($id, $is_web = true)
    {
        $data['user'] = $this->getUser($is_web);

        $lesson  = PrivateLessons::where('id', $id)->whereNotNull('student_id')->first();

        $meeting = PrivateLessonMeeting::where('private_lesson_id', $lesson->id)->first();

        if ($lesson == '') {
            abort(404);
        }

        if ($meeting) {
            //The meeting already exists, just redirect to join

            // $url_join_meeting = route('user.lecturer.private_lessons.meeting.join', ['id' => $lesson->id]);

            $data['url']    = $meeting->url;
            $data['status'] = true;

            return $data;

        }

        if ($lesson->canStartMeeting())
        {
            if(env('MeetingChannel') == 'AGORA')
            {
                $max_id_meeting = PrivateLessonMeeting::max('id');
                $name           = 'agora' . round(1111, 9999) . time() . $max_id_meeting;
                $project_agora  = $this->createProjectAgora($name);

                $meeting = PrivateLessonMeeting::create([
                    'private_lesson_id' => $lesson->id,
                    'app_id'            => $project_agora->project->vendor_key,
                    'app_certificate'   => $project_agora->project->sign_key,
                    'channel'           => $project_agora->project->name,
                    'uid'               => round(1111, 9999),
                ]);
                $token          = $this->createTokenAgora($meeting->app_id, $meeting->app_certificate, $meeting->channel);
                $meeting->token = $token;
                $meeting->url   = quickRandom() . $max_id_meeting;
                $meeting->update();

                $url_join_meeting = route('user.lecturer.private_lessons.meeting.join', ['id' => $lesson->id]);

                $data['url']      = $url_join_meeting;

            }elseif(env('MeetingChannel') == 'ZOOM'){

                $meeting = PrivateLessonMeeting::create([
                    'private_lesson_id' => $lesson->id,
                    'channel'           => 'ZOOM',
                    'uid'               => round(1111, 9999),
                ]);

                $meeting_name = getSeting('title_ar') . ' - ' . time() . $meeting->id . ' - ' . $lesson->title . '( '. $lesson->category->name . ' )';

                $z_meeting = Zoom::createMeeting([
                    "agenda" => getSeting('title_ar') . " ( درس خصوصي )",
                    "topic"  => $meeting_name,
                    "type" => 1, // 1 => instant, 2 => scheduled, 3 => recurring with no fixed time, 8 => recurring with fixed time
                    "duration" => $lesson->time_type == 'hour' ? 60 : 30, // in minutes
                    "timezone" => 'Europe/Istanbul', // set your timezone
                    // "password" => 'set your password',
                    "start_time" => Carbon::now()->toIso8601String(), // set your start time
                    // "template_id" => 'set your template id', // set your template id  Ex: "Dv4YdINdTk+Z5RToadh5ug==" from https://marketplace.zoom.us/docs/api-reference/zoom-api/meetings/meetingtemplates
                    "pre_schedule" => false,  // set true if you want to create a pre-scheduled meeting
                    "schedule_for" => $lesson->student?->email, // set your schedule for
                    "settings" => [
                        'join_before_host' => false, // if you want to join before host set true otherwise set false
                        'host_video' => false, // if you want to start video when host join set true otherwise set false
                        'participant_video' => false, // if you want to start video when participants join set true otherwise set false
                        'mute_upon_entry' => false, // if you want to mute participants when they join the meeting set true otherwise set false
                        'waiting_room' => false, // if you want to use waiting room for participants set true otherwise set false
                        'audio' => 'both', // values are 'both', 'telephony', 'voip'. default is both.
                        'auto_recording' => 'none', // values are 'none', 'local', 'cloud'. default is none.
                        'approval_type' => 0, // 0 => Automatically Approve, 1 => Manually Approve, 2 => No Registration Required
                    ],
                ]);
                $join_url         = @$z_meeting['data']['join_url'];

                $meeting->channel = 'ZOOM';
                $meeting->app_id  = @$z_meeting['data']['id'];
                $meeting->token   = @$z_meeting['data']['start_url'];
                $meeting->url     = $join_url;
                $meeting->update();

                $data['url']      = @$z_meeting['data']['start_url'];

                $lesson->meeting_link = $join_url;
                $lesson->update();

            }else{

                $meeting = PrivateLessonMeeting::create([
                    'private_lesson_id' => $lesson->id,
                    'channel'           => 'BBB',
                    'uid'               => round(1111, 9999),
                ]);

                $meeting_name = getSeting('title_ar') . ' - ' . time() . $meeting->id . ' - ' . $lesson->title . '( '. $lesson->category->name . ' )';
                $meeting_id   = 'BBB-' . time() . rand(1,100000) .  $meeting->id;


                $url          = $this->createTokenbBigBlue($meeting_id , $meeting_name);
                $meeting->url = $url;
                $meeting->app_id = $meeting_id;
                $meeting->token = $meeting_name;
                $meeting->update();

                $lesson->meeting_link = $url;
                $lesson->update();

                $data['url'] = $url;
            }

            $data['status'] = true;
            return $data;
        }

        $data['url'] = back()->withInput();
        $data['status'] = false;

        return $data;
    }


    public function joinMeeting($id, $is_web = true)
    {
        $data['user'] = $this->getUser($is_web);

        $session = PrivateLessons::where('id', $id)
            ->with('meeting')->first();

        if (!isset($session->meeting)) {
            abort(404);
        }

        if ($session->canStartMeeting())
        {
            if(env('MeetingChannel') == 'AGORA')
            {
                $item = PrivateLessonMeetingParticipants::where('user_id', $data['user']->id)
                    ->where('private_lesson_id', $id)->first();

                if (!$item)
                {
                    PrivateLessonMeetingParticipants::create([
                        'user_id'           => $data['user']->id,
                        'private_lesson_id' => $id,
                        'meeting_id'        => $session->meeting->id,
                    ]);
                }

                $data['meeting']        = $session->meeting;

                $data['private_lesson'] = $session;

                $data['status']         = true;

                return $data;
            }
            elseif(env('MeetingChannel') == 'ZOOM'){
                $data['url']    = $session->meeting_link;
                $data['status'] = true;

                return $data;
            }else
            {
                $meeting_id = $session->meeting?->app_id;

                $url=
                    Bigbluebutton::join([
                       'meetingID' => $meeting_id,
                       'userName'  => auth()->user()->name,
                       'role'      => 'MODERATOR',
                       'password'  => 'attendee'             //which user role want to join set password here
                    ]);


                $data['url']    = $url;
                $data['status'] = true;

                return $data;
            }
        }

        $data['status'] = false;

        return $data;

    }

    public function createProjectAgora($name)
    {
        $customerKey   = env('AGORA_CUSTOMER_KEY');
        $customerSecre = env('AGORA_CUSTOMER_SECRE');

        $credentoals = $customerKey . ":" . $customerSecre;

        $arr_header = "Authorization: Basic " . base64_encode($credentoals);

        $url = "https://api.agora.io/dev/v1/project";

        $data = [
            "name"            => $name,
            'enable_sign_key' => true
        ];
        $encodedData = json_encode($data);

        $headers = [
            $arr_header,
            'Content-Type: application/json',
        ];

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        // Disabling SSL Certificate support temporarly
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $encodedData);

        // Execute post
        $result = curl_exec($ch);

        // dd($result);

        if ($result === false) {
            die('Curl failed: ' . curl_error($ch));
        }

        // Close connection
        curl_close($ch);

        return json_decode($result);
    }

    public function createTokenAgora($app_id, $app_certificate, $channel_name)
    {

        include (app_path() . '\Libraries\AgoraToken\src\RtcTokenBuilder2.php');

        // Fill in your actual user ID
        $uid = 2882341273;
        // Token validity time in seconds
        $tokenExpirationInSeconds = 3600;
        // Validity time for permission to join a channel (seconds)
        $joinChannelPrivilegeExpireInSeconds = 3600;
        // Validity in seconds for the permission to publish audio streams in the channel
        $pubAudioPrivilegeExpireInSeconds = 3600;
        // Validity in seconds for the permission to publish video streams in the channel
        $pubVideoPrivilegeExpireInSeconds = 3600;
        // Validity in seconds for the permission to publish data streams in the channel
        $pubDataStreamPrivilegeExpireInSeconds = 3600;
        echo "App Id: " . $app_id . PHP_EOL;
        echo "App Certificate: " . $app_certificate . PHP_EOL;
        if ($app_id == "" || $app_certificate == "") {
            echo "Need to set environment variable AGORA_APP_ID and AGORA_APP_CERTIFICATE" . PHP_EOL;
            exit;
        }
        // Generate Token
        $token = \RtcTokenBuilder2::buildTokenWithUidAndPrivilege($app_id, $app_certificate, $channel_name, $uid, $tokenExpirationInSeconds, $joinChannelPrivilegeExpireInSeconds, $pubAudioPrivilegeExpireInSeconds, $pubVideoPrivilegeExpireInSeconds, $pubDataStreamPrivilegeExpireInSeconds);

        return $token;
    }

    // ----------------------
    function createTokenbBigBlue($meeting_id , $meeting_name)
    {
        Bigbluebutton::create([
            'meetingID'      => $meeting_id,
            'meetingName'    => $meeting_name,
            'record'         => true,
            'attendeePW'     => 'attendee',
            'moderatorPW'    => 'moderator',
            'endCallbackUrl' => route('user.meeting.finished' , $meeting_id),
            'logoutUrl'      => route('user.meeting.finished' , [$meeting_id , auth()->id()]),
        ]);

        $url =  Bigbluebutton::join([
            'meetingID' => $meeting_id,
            'userName'  => auth()->user()->name,
            'role'      => 'MODERATOR',
            'password'  => 'attendee'
        ]);

        return $url;
    }


}
