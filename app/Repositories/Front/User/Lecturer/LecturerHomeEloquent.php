<?php

namespace App\Repositories\Front\User\Lecturer;

use App\Models\Faqs;
use App\Models\User;
use App\Models\Courses;
use App\Models\Ratings;
use App\Models\Category;
use App\Models\CourseAssignments;
use App\Models\CourseFaqs;
use App\Models\UserCourse;
use Illuminate\Http\Request;
use App\Models\CourseQuizzes;
use App\Models\CourseSections;
use App\Models\PrivateLessons;
use App\Models\FaqsTranslation;
use App\Models\CourseLessons;
use App\Models\CoursePriceDetails;
use Illuminate\Support\Facades\DB;
use Kreait\Firebase\Http\Requests;
use Illuminate\Support\Facades\Auth;
use SebastianBergmann\Type\NullType;
use App\Repositories\Front\User\HelperEloquent;
use App\Models\CourseSectionItems;
use App\Models\CourseAssignmentQuestions;
use App\Models\CourseAssignmentQuestionsTranslation;
use App\Models\CourseCurriculum;
use App\Models\CourseLiveLesson;
use App\Models\CourseQuizzesQuestion;
use App\Models\CourseQuizzesQuestionsAnswer;
use App\Models\CourseQuizzesQuestionsAnswerTranslation;
use App\Models\CourseQuizzesQuestionTranslation;
use App\Models\LessonAttachment;
use Illuminate\Support\Facades\Storage;

class LecturerHomeEloquent extends HelperEloquent
{

    public function viewRatings($is_web=true)
    {
        $data['user'] = $this->getUser($is_web);

        $data['reviews']=Ratings::select(
            'id',
            'sourse_type',
            'sourse_id',
            'user_id',
            'rate',
            'comment_text',
            'is_active',
            'created_at'
        )->active()
        ->orderBy('id', 'desc')
        ->paginate(10);

        return $data;

    }

    public function viewStudents($is_web=true)
    {
        $data = $this->getStudentsStatistics();

        $data['user'] = $this->getUser($is_web);

        $data['students'] = $data['user']->RelatedStudents()
            ->select('id', 'name', 'image', 'email', 'mobile', 'created_at')
            ->paginate(10);

        return $data;

    }

    public function filterStudents($request, $is_web=true)
    {

        $data = $this->getStudentsStatistics();

        $data['user'] = $this->getUser($is_web);

        $data['search_query'] = $request->all();

        $data['students'] =  $data['user']->RelatedStudents()
            ->filterfromDate($request->date_from)
            ->filtertoDate($request->date_to)
            ->filterByName($request->name)
            ->filterEmail($request->email)
            ->paginate(10);

        return $data;

    }

    public function getStudentsStatistics($is_web=true)
    {
        $lecturer = $this->getUser($is_web);

        $data['total_student_no'] = $lecturer->RelatedStudents()->count();

        return $data;
    }

    public function studentCourses($id, $is_web=true)
    {
        $data['user'] = $this->getUser($is_web);

        $data['courses'] = UserCourse::where([
            ['lecturer_id',$data['user']->id],
            ])
            ->whereHas('user', function ($query) use ($id) {
                $query->where('id', $id) ->select('id');
            })
            ->with('course', function ($query) {
                $query->select('id', 'image', 'category_id', 'is_active', 'created_at' )
                    ->with('translations:courses_id,title,locale');
            })
            ->distinct('course_id')
            ->paginate(10);

        return $data;

    }

    public function studentLessons($id, $is_web=true)
    {
        $data['user'] = $this->getUser($is_web);

        $data['lessons'] = PrivateLessons::where('student_id', $id)
            ->where('teacher_id', $data['user']->id)
            ->paginate(10);

        return $data;

    }

    public function createCourse()
    {
        $data['languages']        = Category::query()->select('id', 'value', 'parent')
                                            ->with('translations:category_id,name,locale')
                                            ->where('parent', 'course_languages')
                                            ->orderByDesc('created_at')->get();

        $data['levels']          = Category::query()->select('id', 'value', 'parent')
                                            ->with('translations:category_id,name,locale')
                                            ->where('parent', 'course_levels')
                                            ->orderByDesc('created_at')->get();

        $data['categories']      = Category::query()->select('id', 'value', 'parent')
                                            ->with('translations:category_id,name,locale')
                                            ->where('parent', 'course_categories')
                                            ->orderByDesc('created_at')->get();

        $data['age_categories'] = Category::query()->select('id', 'value', 'parent')
                                          ->with('translations:category_id,name,locale')
                                          ->where('parent', 'age_categories')
                                         ->orderByDesc('created_at')->get();
        return $data;
    }

    public function addPrice($request, $is_web = true)
    {

        try {

            if ($request->id) $type = 'edit'; else $type = 'create';
            $data = $request->all();
            if(isset($data['free'])) {
                $data['price'] = NULL;
            }else {
                $data['price'] = $request->price;
            }

            if(isset($data['discount'])) {
                $data['discount_price'] = NULL;
            }else {
                $data['discount_price'] = $request->discount_price;
            }

            $item = CoursePriceDetails::updateOrCreate(['id' => $data['id']], $data);
            $message = __('message_done');
            $status = true;
            $response = [
                'message' => $message,
                'status' => $status,
            ];

        } catch (\Exception $e) {
            $message = __('message.unexpected_error');
            $status = false;
            $response = [
                'message' => $message,
                'status' => $status,
            ];
        }

        return $response;
    }


    public function addFaq($request)
    {

        DB::beginTransaction();
        try {
            if ($request->id) $type = 'edit'; else $type = 'create';
            for($i = 0 ; $i< count($request->questions) ; $i++){
                $questions   =  [
                    'type'   => 'course',
                ];
                $item   = Faqs::updateOrCreate(['id' => $request->id],  $questions);
                $item->order = $item->id ;
                $item->save();
                $faq_translation  = new FaqsTranslation() ;
                $faq_translation->faqs_id = $item->id;
                $faq_translation->locale  = 'ar';
                $faq_translation->title   = $request->questions[$i];
                $faq_translation->text    = !empty($request->{'answer_'.$i+1})  ? $request->{'answer_'.$i+1} : '';
                $faq_translation->save();
                $course_faq = new CourseFaqs();
                $course_faq->course_id  = $request->course_id;
                $course_faq->faq_id     = $item->id;
                $course_faq->save();
                $course_faq->order      = $course_faq->id;
                $course_faq->save();
            }


            $message = __('message.operation_accomplished_successfully');
            $status = true;
            $response = [
                'type'     => $type,
                'new_item' => $item,
                'message'  => $message,
                'status'   => $status,
            ];

            DB::commit();

        } catch (\Exception $e) {
            DB::rollback();
            dd($e);
            $message = __('message.unexpected_error');
            $status = false;
            $response = [
                'message' => $message,
                'status' => $status,
            ];
        }

        return $response;
    }

    public function addCourse($request , $is_web=true) {
        DB::beginTransaction();
        try {
            $data = $request->all();
            if ($request->get('start_date')) {
                $data['start_date'] = date('Y-m-d H:i:s', strtotime($request->start_date));
            }
            if ($request->get('end_date')) {
                $data['end_date'] = date('Y-m-d H:i:s', strtotime($request->end_date));
            }
            $user            = $this->getUser($is_web);
            $data['user_id'] = $user->id;
            $course = Courses::updateOrCreate(['id' => 0], $data)->createTranslation($request);

            if ($request->file('image')) {
                //path
                $image            = uploadImageBySendingFile($request->file('image'));
                $course->image     = str_replace('/', '-', $image);
            }

            if ($request->file('cover_image')) {
                //path
                $cover_image          = uploadImageBySendingFile($request->file('cover_image'));
                $course->cover_image  = str_replace('/', '-', $cover_image);
            }

            if ($request->file('video_image')) {
                //path
                $video_image         = uploadImageBySendingFile($request->file('video_image'));
                $course->video_image = str_replace('/', '-', $video_image);
            }
            $course->save();
            $message = __('message_done');
            $status = true;
            DB::commit();
        } catch (\Exception $e) {
            $message = __('message_error');
            $status = false;
            DB::rollback();
            dd($e);
        }
        $response = [
            'message' => $message,
            'status' => $status,
        ];

        return $response;
    }

}
