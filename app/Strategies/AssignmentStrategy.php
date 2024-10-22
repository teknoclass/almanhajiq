<?php

namespace App\Strategies;

use App\Models\CourseAssignmentResults;
use App\Models\CourseAssignments;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class AssignmentStrategy implements ItemStrategy
{
    protected ?int  $assignmentId;

    public function __construct(?int $assignmentId)
    {
        $this->assignmentId = $assignmentId;
    }

    public function isCompleted(): bool
    {
        return CourseAssignmentResults::where([
            'assignment_id' => $this->assignmentId,
            'student_id' => Auth::id(),
        ])->where('status', '!=', CourseAssignmentResults::$notSubmitted)->exists();
    }
    public function renderModal(array $data): string
    {
        if ($data['type'] == 'add') {
            return View::make('front.user.lecturer.courses.my_courses.create.components.curriculum.modals.tasks.task', $data)->render();
        } else {
            $data['item'] = CourseAssignments::where('id', $this->assignmentId)
                                             ->with(['assignmentQuestions', 'translations:course_assignments_id,title,description,locale'])
                                             ->first();
            return View::make('front.user.lecturer.courses.my_courses.create.components.curriculum.modals.tasks.edit_task', $data)->render();
        }
    }
    public function getModelClass(): string
    {
        return CourseAssignments::class;
    }

    public function applyCompletedScope($query)
    {
        $query->whereHas('assignmentResults', function ($query) {
            $query->where('student_id', Auth::id())
                  ->where('status', '!=', CourseAssignmentResults::$notSubmitted);
        });
    }
}
