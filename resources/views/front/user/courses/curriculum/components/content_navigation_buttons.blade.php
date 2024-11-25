<div class="text-center d-flex justify-content-center align-items-center ">
    @if ($item_type == 'lesson' || ($item_type == 'live_lesson' && @$course_item->meeting == "finished"))
        @if (!$course_item->is_completed() && $course->is_delete == 0)
        <?php $item_type == 'lesson' ? $lesson_type = "normal" : $lesson_type = "live" ?>
        <a href={{ route('user.courses.curriculum.lesson.set.completed', ['course_id'=>@$course->id, 'id' => $course_item->id, 'type' => @$lesson_type ]) }} class="curriculum-navigation-btn mx-2 btn btn-primary font-medium">{{ __("lesson_completed") }}</a>
        @endif
    @endif
    <a href="{{ route('user.courses.curriculum.navigation', ['course_id'=>@$course->id, 'curclm_item_id'=>@$selected_curriculum_item_id, 'section_item_id'=>@$selected_curriculum_section_id, 'type'=>'back']) }}" class="curriculum-navigation-btn mx-2 btn btn-primary font-medium">{{ __("previous") }}</a>
    <a href="{{ route('user.courses.curriculum.navigation', ['course_id'=>@$course->id, 'curclm_item_id'=>@$selected_curriculum_item_id, 'section_item_id'=>@$selected_curriculum_section_id, 'type'=>'next']) }}" class="curriculum-navigation-btn mx-2 btn btn-primary font-medium">{{ __("next") }}</a>
</div>
