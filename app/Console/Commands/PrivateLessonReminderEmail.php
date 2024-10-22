<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Courses;
use App\Models\PrivateLessons;
use App\Models\UserCourse;
use Carbon\Carbon;

class PrivateLessonReminderEmail extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'private_lesson_reminder:email';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send a reminder email of the Private Lesson to student before 1 hr and in time';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
    */
    public function handle()
    {
        $time_now      = date('H:i:s');
        $time          = strtotime($time_now);

        $time_reminder1 = getSeting('private_lesson_reminder_1') ?? 0;
        $time_reminder1 = $time  + ($time_reminder1 * 60);
        $time_reminder1 = date("H:i:s", $time_reminder1);  // before 30 minutes

        $time_reminder2 = getSeting('private_lesson_reminder_2') ?? 0;
        $time_reminder2 = $time  + ($time_reminder2 * 60);
        $time_reminder2 = date("H:i:s", $time_reminder2); // on time

        if($time_reminder2 > $time_reminder1){
            $time_change    = $time_reminder1;
            $time_reminder1 = $time_reminder2;
            $time_reminder2 = $time_change;
        }

        $lessons = PrivateLessons::with(['student'])->
        where('status' , 'acceptable')
        ->where('meeting_date' , date('Y-m-d'))
        ->where('time_form' , 'between' , ["$time_reminder2" , "$time_reminder1"])
        ->get();
        foreach ($lessons as $lesson) {
            //send email to student
            $title_msg   = "تذكير بموعد درس خصوصي";
            $title       = $lesson->translations[0]->title;
            $start_date  = $lesson->meeting_date;
            $time_form   = $lesson->time_form;
            $text_msg    = "<p>تذكير ! موعد درس خصوصي $title <br> اليوم بتاريخ $start_date <br> الساعة $time_form <br ></p>";
            $text_msg   .= "<a href='$lesson->meeting_link'>رابط الدرس</a>";
            if(@$lesson->student?->email) {
                sendEmail($title_msg, $text_msg, $lesson->student?->email);
            }
            if(@$lesson->teacher?->email) {
                sendEmail($title_msg, $text_msg, $lesson->teacher?->email);
            }
        }
        return true;
    }

}
