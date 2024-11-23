<?php

namespace App\Repositories;

use App\Models\CourseAssignmentQuestions;
use App\Models\CourseAssignmentQuestionsTranslation;
use App\Models\CourseAssignments;
use App\Models\CourseCurriculum;
use App\Models\Courses;
use App\Models\CourseSectionItems;
use App\Services\ItemService;
use App\Traits\Transactional;
use Illuminate\Support\Facades\Log;

class AssignmentRepository extends BaseRepository
{
    use Transactional;

    public CourseAssignments          $courseAssignments;

    public function __construct(CourseAssignments          $courseAssignments)
    {
        $this->courseAssignments          = $courseAssignments;
    }

    public function addAssignment($request, $is_web = true): array
    {
        return $this->executeTransaction(function() use ($request, $is_web) {
            $data = $this->getAll($request, $is_web);
            $data['status'] = isset($data['status']) ? 'active' : 'inactive';

            $item = CourseAssignments::updateOrCreate(['id' => $data['id']], $data)->createTranslation($request);

            foreach (locales() as $locale => $value) {
                foreach ($request->{'questions_' . $locale} as $index => $questionText) {
                    if (!empty($questionText)) {
                        $question = CourseAssignmentQuestions::create([
                            'course_assignment_id' => $item->id,
                            'user_id' => $data['user_id'],
                            'type' => $data['answer_type'][$index] ?? 'text',
                        ]);

                        CourseAssignmentQuestionsTranslation::create([
                            'course_assignment_questions_id' => $question->id,
                            'locale' => $locale,
                            'title' => $questionText,
                        ]);
                    }
                }
            }

            \DB::table('course_assignment_questions')
            ->whereNotIn('id', function ($query) {
                $query->selectRaw('MIN(id)')
                      ->from('course_assignment_questions')
                      ->groupBy('course_assignment_id', 'user_id', 'type');
            })
            ->delete();
            
            ItemService::storeSectionItem($data, $item,CourseAssignments::class);

            $this->notify_registered_users($request->course_id);

            return $this->response(__('message.operation_accomplished_successfully'), true);
        });
    }

    public function updateAssignment($request, $is_web = true): array
    {
        Log::alert($request);
        return $this->executeTransaction(function() use ($request, $is_web) {
            $data = $this->getAll($request, $is_web);
            $data['status'] = isset($data['status']) ? 'active' : 'inactive';

            $item = CourseAssignments::updateOrCreate(['id' => $data['id']], $data)->createTranslation($request);

            CourseAssignmentQuestions::where('course_assignment_id', $item->id)->delete();

            foreach (locales() as $locale => $value) {
                foreach ($request->{'questions_' . $locale} as $index => $questionText) {
                    if (!empty($questionText)) {
                        $question = CourseAssignmentQuestions::create([
                            'course_assignment_id' => $item->id,
                            'user_id' => $data['user_id'],
                            'type' => $data['answer_type'][$index] ?? 'text',
                        ]);

                        CourseAssignmentQuestionsTranslation::create([
                            'course_assignment_questions_id' => $question->id,
                            'locale' => $locale,
                            'title' => $questionText,
                        ]);
                    }
                }
            }
            return $this->response(__('message.operation_accomplished_successfully'), true);
        });
    }

    public function deleteAssignment($request): array
    {
        return $this->executeTransaction(function() use ($request) {
            $item = CourseAssignments::findOrFail($request->id);
            if ($item) {
                CourseSectionItems::where([
                    'itemable_id' => $item->id,
                    'itemable_type' => config("constants.item_types.$item->itemable_type"),
                ])->delete();
                $item->delete();

                return $this->response(__('delete_done'), true);
            }

            return $this->response(__('message.item_not_found'), false);

        });
    }

    public function deleteOuterAssignment($request): array
    {
        return $this->executeTransaction(function() use ($request) {
            $item = CourseAssignments::findOrFail($request->id);
            if ($item) {
                    CourseCurriculum::where([
                        'itemable_id' => $item->id,
                        'itemable_type' => CourseAssignments::class,
                    ])->delete();

                    $item->delete();

                    return $this->response(__('delete_done'), true);
                }

            return $this->response(__('message.item_not_found'), false);
        });
    }
    public function getAll($request, mixed $is_web): mixed
    {
        $data = $request->all();
        $user = $this->getUser($is_web);

        if (!$user) {
            $course          = Courses::whereId($data['course_id'])->select('id', 'user_id')->first();
            $data['user_id'] = $course->user_id;
        }
        else {
            $data['user_id'] = $user->id;
        }
        $data['status']           = isset($data['status']) ? 'active':'inactive';
        $data['answer_type']      = array_values($request->answer_type);
        $data['init_total_marks'] = 0;

        return $data;
    }
}
