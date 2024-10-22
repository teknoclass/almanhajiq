<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Courses;
use App\Models\UserCourse;
use Carbon\Carbon;

class CourseReminderEmail extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'coursereminder:email';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send a reminder email of the registered course to student';

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
        $users = UserCourse::with(['user', 'course', 'course.translations:courses_id,title'])->whereIn('course_id', function($query) {
            $query->select('id')->from('courses');
            $query->where('type', Courses::LIVE);
            $query->whereBetween('start_date', [
                Carbon::now()->addHours(2)->toDateTimeString(),
                Carbon::now()->addHours(2)->addMinutes(2)->toDateTimeString()
            ]);
        })->get();
        foreach ($users as $user) {
            //send email to student
            $title_msg="تذكير بدورة";
            $title = $user->course->translations[0]->title;
            $start_date = $user->course->start_date;
            $text_msg="<p>تذكير ! موعد دورة $title اليوم بتاريخ $start_date</p>";
            $text_msg.="<a href='".route('courses.single', ['id'=>$user->course?->id, 'title' =>mergeString($title, '')])."'>رابط الدورة</a>";
            if($user->user!=null) {
                sendEmail($title_msg, $text_msg, $user->user?->email);
            }
        }
    }

}
