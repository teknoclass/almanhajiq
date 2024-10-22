<?php

namespace App\Strategies;

use App\Models\CourseSectionItems;

class ItemStrategyFactory
{
    public static function create(?int $itemId,?string $itemType)
    {

        return match ($itemType) {
            'lesson' => new LessonStrategy($itemId),
            'quiz' => new QuizStrategy($itemId),
            'assignment' => new AssignmentStrategy($itemId),
            default => throw new \InvalidArgumentException("Invalid item type"),
        };
    }
}
