<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use JoisarJignesh\Bigbluebutton\Facades\Bigbluebutton;

class CourseSession extends Model
{
    use HasFactory;

    public static  $waiting = 'waiting';
    protected           $table = "course_sessions";

    protected $fillable = ['course_id', 'day', 'date', 'time',

    'title', 'group_id','public_password','status', 'price'];

    public function course()
    {
        return $this->belongsTo(Courses::class,'course_id');
    }

    public function group()
    {
        return $this->belongsTo(CourseSessionsGroup::class);
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
    public function createLiveSession (){
        $attendeePW = $this->generateSimplePassword(8);
        $moderatorPW = $this->generateSimplePassword(8);
        Bigbluebutton::create([
            'meetingID'      => $this->id,
            'meetingName'    => $this->title,
            'record'         => true,
            'attendeePW'     => $attendeePW,
            'moderatorPW'    => $moderatorPW,
            'endCallbackUrl' => route('user.meeting.finished' , $this->id),
            'logoutUrl'      => route('user.meeting.finished' , [$this->id , auth()->id()]),
        ]);
        $this->public_password = $attendeePW;
        $this->save();
        $url =  Bigbluebutton::join([
            'meetingID' => $this->id,
            'userName'  => auth()->user()->name,
            'role'      => 'MODERATOR',
            'password'  => $moderatorPW
        ]);

        return $url;
    }

    public function joinLiveSession($request) {
        try {
            $response = Bigbluebutton::join([
                'meetingID' => $request->id,
                'userName' => $request->userName,
                'password' => $request->password,

            ]);

            Log::info('Join Live Session Response: ', ['response' => $response]);

            return $response;
        } catch (\Exception $e) {
            Log::error('Error joining live session: ', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Could not join session.'], 500);
        }
    }
}