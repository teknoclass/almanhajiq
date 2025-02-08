<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Model;
use BigBlueButton\Parameters\GetRecordingsParameters;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use JoisarJignesh\Bigbluebutton\Facades\Bigbluebutton;

class CourseSession extends Model
{
    use HasFactory;
    use SoftDeletes;

    public static  $waiting = 'waiting';
    protected           $table = "course_sessions";

    protected $fillable = ['course_id', 'day', 'date', 'time',

    'title', 'group_id','public_password','status', 'price', 'meeting_id','meeting_status','private_password'];

    public function course()
    {
        return $this->belongsTo(Courses::class,'course_id');
    }

    function attachments(){
        return  $this->hasMany(CourseSessionAttachments::class,'session_id');
    }

    public function group()
    {
        return $this->belongsTo(CourseSessionsGroup::class);
    }

    public function canAccess($userId)
    {
        if($this->course->user_id == $userId)return true;

        $first = DB::table('course_session_subscriptions')
                 ->where(['course_session_id'=> $this->id,'student_id'=> $userId])
                 ->exists();

        $second = DB::table('student_session_installments')
                ->where('course_id',$this->course_id)
                ->where('student_id',$userId)
                ->where('access_until_session_id' , '>=' , $this->id)
                ->exists();

        if($first || $second)return true;
        else return false;
    }
    public function studentRequests()
    {
        return $this->hasMany(CourseSessionsRequest::class,'course_session_id')->where('user_type','student')
        ->where('user_id',auth('web')->user()->id);
    }
    public function teacherRequests()
    {
        return $this->hasMany(CourseSessionsRequest::class,'course_session_id')->where('user_type','teacher')
        ->where('user_id',auth('web')->user()->id);
    }

    public function requests()
    {
        return $this->hasMany(CourseSessionsRequest::class,'course_session_id');
    }
    public function createSessions($id, $sessionData)
    {
        try {
            $sessions =self::where('course_id', $id);
            foreach ($sessions->get() as $session){
                $session->requests()->delete();
            }
            $sessions->delete();
            $sessionIds = [];

            $sessions = [];

            foreach ($sessionData as $key => $value) {
                if (preg_match('/session_(day|date|time|title|id)_(\d+)/', $key, $matches)) {
                    $field = $matches[1];
                    $index = $matches[2];

                    $sessions[$index][$field] = $value;
                }
            }

            foreach ($sessions as $session) {
                $session['course_id'] = $id;

                $newSession = self::create($session);
                $sessionIds[] = $newSession->id;
            }
            return $sessionIds;
        }
        catch (\Exception $exception){
            Log::alert($exception->getMessage());
            return [];
        }
    }
    function generateSimplePassword($length = 8) {
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $charactersLength = strlen($characters);
        $randomPassword = '';

        // Generate the password
        for ($i = 0; $i < $length; $i++) {
            $randomPassword .= $characters[rand(0, $charactersLength - 1)];
        }

        return $randomPassword;
    }
    public function createLiveSession ($type = 'web'){
        if($this->meeting_status == "started"){
            return $this->joinLiveSessionV2($type);
        }else{

            $attendeePW = $this->generateSimplePassword(8);
            $moderatorPW = $this->generateSimplePassword(8);
            $meeting_id = "course_session_with_id_".$this->id.time();
            $this->meeting_id = $meeting_id;
            $this->meeting_status = "started";

            Bigbluebutton::create([
                'meetingID'      => $meeting_id,
                'meetingName'    => $this->title,
                'autoStartRecording' => true,
                'allowStartStopRecording' => false,
                'record'         => true,
                'attendeePW'     => $attendeePW,
                'moderatorPW'    => $moderatorPW,
                'endCallbackUrl' => route('user.meeting.finished' , $this->id),
                'logoutUrl'      => route('user.meeting.finished' , [$this->id , auth($type)->id()]),
            ]);
            $this->public_password = $attendeePW;
            $this->private_password = $moderatorPW;
            $url =  Bigbluebutton::join([
                'meetingID' => $this->meeting_id,
                'userName'  => auth($type)->user()->name,
                'role'      => 'MODERATOR',
                'password'  => $moderatorPW
            ]);
            $this->save();

            return $url;
        }
    }

    public function joinLiveSession($request) {
        try {

            $response = Bigbluebutton::join([
                'meetingID' => $this->meeting_id,
                'userName' => auth('web')->user()->name,
                'password' => trim($request->password),

            ]);
            Log::info('Join Live Session Response: ', ['response' => $response]);

            return $response;
        } catch (\Exception $e) {
            Log::error('Error joining live session: ', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Could not join session.'], 500);
        }
    }
    public function joinLiveSessionV2($type = 'web') {
        try {


            if(auth($type)->user()->role == 'student'){

                $response = Bigbluebutton::join([
                    'meetingID' => $this->meeting_id,
                    'userName' => auth($type)->user()->name,
                    'password' => $this->public_password,

                ]);
            }else{
                $response =  Bigbluebutton::join([
                    'meetingID' => $this->meeting_id,
                    'userName'  => auth($type)->user()->name,
                    'role'      => 'MODERATOR',
                    'password'  => $this->private_password
                ]);
            }
            Log::info('Join Live Session Response: ', ['response' => $response]);

            return $response;
        } catch (\Exception $e) {
            Log::error('Error joining live session: ', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Could not join session.'], 500);
        }
    }

    public function getRecording()
    {
        try{

            $link = "";

            $meetingId = $this->meeting_id;

            $getRecordingsParams = new GetRecordingsParameters();
            $getRecordingsParams->meetingId = $meetingId;
            $recordings = \Bigbluebutton::getRecordings($getRecordingsParams);
            $recording = null;

            if (!empty($recordings))
            {
                if ($meetingId)
                {
                    $recording = collect($recordings)->firstWhere('meetingID', $meetingId);
                }

                if ($recording && isset($recording['playback']['format'][0]['url']))
                {
                    $link = $recording['playback']['format'][0]['url'];
                }
            }

            return $link;
        }
        catch(\Exception $e)
        {

        }
    }

    function isNow(){
        $sessionDateTime = Carbon::parse($this->date . ' ' . $this->time);
        $now = now();
        return ($sessionDateTime->equalTo($now) || $sessionDateTime->diffInMinutes($now) <= 15);
    }

    function canPostpone(){
        $num = getSeting('can_postpone_hours_before');
        $datetime = Carbon::createFromFormat('Y-m-d H:i:s', $this->date . ' ' . $this->time);
        $datetimeWithNumHours = $datetime->subHour($num);
        $currentTime = Carbon::now();
        if ($currentTime->lessThan($datetimeWithNumHours)) {
            $exist = CourseSessionsRequest::where('course_session_id',$this->id)->first();
            if(!$exist)return true;
            else return false;
        } else {
            return false;
        }


    }

}
