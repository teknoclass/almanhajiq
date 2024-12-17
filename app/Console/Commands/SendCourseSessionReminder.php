<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\CourseSession;
use App\Models\CourseSessionSubscription;
use App\Models\StudentSessionInstallment;
use App\Models\User;
use App\Models\UserCourse;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class SendCourseSessionReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'session_reminder:email';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send email reminders for CourseSessions starting in 4 hours';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $now = Carbon::now();
    
        $targetDateTime = $now->copy()->addHours(4);
    
        $sessions = CourseSession::whereDate('date', $targetDateTime->toDateString())
        ->whereTime('time', '>=', $targetDateTime->subMinutes(30)->toTimeString())
        ->whereTime('time', '<=', $targetDateTime->addMinutes(30)->toTimeString())
        ->get();

        foreach ($sessions as $session)
        {
            $course_id = $session->course_id;

            $studentCourses1 = UserCourse::where('course_id',$course_id)->pluck('user_id')->toArray();
            $studentCourses2 = CourseSessionSubscription::where('course_id',$course_id)->pluck('student_id')->where('course_session_id',$session->id)->toArray();
            $studentCourses3 = StudentSessionInstallment::where('course_id',$course_id)->where('access_until_session_id','<=',$session->id)->pluck('student_id')->toArray();
    
            $studentIds = array_unique(array_merge($studentCourses1, $studentCourses2, $studentCourses3));

            $participants = User::whereIn('id',$studentIds)->select('id','name','email')->get();

            foreach ($participants as $participant)
            {
                sendEmail(__('session_start_reminder_title'),__('session_start_reminder_msg'),$participant->email);
            }
        }

        return true;
    }
}
