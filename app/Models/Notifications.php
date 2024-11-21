<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notifications extends Model
{
    use HasFactory;
    protected $table = 'notifications';
    protected $fillable = ['title', 'text', 'title_en', 'text_en', 'sender_id', 'user_id', 'user_type', 'action_type', 'action_id', 'image','read_at'];


    public function getAction()
    {
        $action_type = $this->action_type;
        $action_id = $this->action_id;
        $url = 'javascript:void(0)';
        if ($this->user_type == 'admin') {
            switch ($action_type) {
                case 'contact_us':
                    $url = url('admin/inbox/view') . '/' . $action_id;
                    break;
                case 'join_as_teacher_request':
                    $url = url('admin/join-as-teacher-requests/edit' . '/' . $action_id) ;
                    break;
                case 'join_as_market_request':
                    $url = url('admin/marketers-joining-requests/all') ;
                    break;
                case 'add_course_requests':
                    $url = url('admin/add-course-requests/edit/' . $action_id ) ;
                    break;

            }
        } else {
            switch ($action_type) {
                case 'private_lesson_ratings':
                    if ($action_id) {
                        $url =
                        route('user.lecturer.private_lessons.index');
                    }
                    break;
                case 'private_lesson_registeration':
                    if ($action_id) {
                        $url =
                        route('user.lecturer.private_lessons.index');
                    }
                    break;
                case 'course_ratings':
                    if ($action_id) {
                        $url = route('user.lecturer.my_courses.viewRatings.index', ['course_id' => $action_id]);
                    }
                    break;
                case 'course_registeration':
                    if ($action_id) {
                        $url =
                        route('user.lecturer.students.index');
                    }
                    break;
                case 'comment_on_course_lesson':
                    if ($action_id) {
                        $url =
                        route('user.lecturer.my_courses.comments',$action_id);
                    }
                    break;
                case 'chat':
                    if ($action_id) {
                        $url =
                        route('user.chat.open.chat',$action_id);
                    }
                    break;
                case 'curriculum.item':
                    if ($action_id) {
                        $url =
                        route('user.courses.curriculum.item',$action_id);
                    }
                    break;

                case 'solve_quiz':
                if ($action_id) {
                    $url =
                    route('user.lecturer.my_courses.exams.students', $action_id);
                }
                break;

                case 'solve_assignment':
                if ($action_id) {
                    $url =
                    route('user.lecturer.my_courses.tasks.students', $action_id);
                }
                break;

                case 'withdrawal_requests_marketer':
                    $url = route('user.financialRecord.index', ['user_type'=>'marketer']);
                    break;
                case 'add_course_requests':
                    $url = url('user/lecturer/my-courses/edit/base-information/' . $action_id ) ;
                    break;
            }
        }


        return $url;
    }
}
