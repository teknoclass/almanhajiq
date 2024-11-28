<?php

namespace App\Strategies;


use App\Models\CourseLessons;
use App\Models\CourseLessonsLearning;
use App\Models\CourseSections;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
class SectionStrategy implements ItemStrategy
{
    protected ?int $lessonId;

    public function __construct(?int  $lessonId)
    {
        $this->lessonId = $lessonId;
    }

    public function isCompleted(): bool
    {
        return 1;
    }
    public function renderModal(array $data): string
    {
        if ($data['type'] == 'add') {
            return View::make('front.user.lecturer.courses.my_courses.create.components.curriculum.modals.lessons.lesson', $data)->render();
        } else {
            $data['item'] = CourseLessons::where('id', $this->lessonId)
                                         ->with('translations:course_lessons_id,title,description,locale')
                                         ->first();
            $data['attachments'] = $data['item']->attachments;
            return View::make('front.user.lecturer.courses.my_courses.create.components.curriculum.modals.lessons.edit_lesson', $data)->render();
        }
    }
    public function getModelClass(): string
    {
        return CourseSections::class;
    }

    public function applyCompletedScope($query): void
    {
        $query->whereHas('lessonStatus', function ($query) {
            $query->where('user_id', auth()->id());
        });
    }
}
