<div class="text-center d-flex justify-content-center align-items-center ">
    {{-- @if ($item_type == 'lesson' || ($item_type == 'live_lesson' && @$course_item->meeting == "finished"))
         @if (($course_item->file_type!='video' && $course_item->file_type!='listen') && !$course_item->is_completed() && $course->is_delete == 0)
         <?php $item_type == 'lesson' ? $lesson_type = "normal" : $lesson_type = "live" ?>
         <a href={{ route('user.courses.curriculum.lesson.set.completed', ['course_id'=>@$course->id, 'id' => $course_item->id, 'type' => @$lesson_type ]) }} class="curriculum-navigation-btn mx-2 btn-primary">{{ __("lesson_completed") }}</a>
         @endif
     @endif--}}
     @php
         if ($item_type == 'lesson' || ($item_type == 'live_lesson' && @$course_item->meeting == "finished")) {
             if ((@$course_item->file_type=='audio' || @$course_item->file_type=='video') && !$course_item->is_completed() && $course->is_delete == 0) {
                 $disabled = "disabled";
             } else {
                 $disabled = '';
             }
         } elseif ($item_type == 'quiz' && ($course_item->studentQuizResults->isEmpty())) {
             $disabled = "disabled";
         } elseif ($item_type == 'assignment' && ($course_item->studentAssignmentResults->isEmpty())) {
             $disabled = "disabled";
         } else {
             $disabled = '';
         }
     @endphp
     @if(@$curriculum_items->sortBy('order')->first()?->id != $selected_curriculum_item_id)
     <a href="{{ route('user.courses.curriculum.navigation', ['course_id'=>@$course->id, 'curclm_item_id'=>@$selected_curriculum_item_id, 'section_item_id'=>@$selected_curriculum_section_id, 'type'=>'back']) }}" $action class="curriculum-navigation-btn mx-2 btn-primary">{{ __("previous") }}</a>
     @endif

     @if(@$curriculum_items->sortByDesc('order')->first()?->id != $selected_curriculum_item_id)
     <a href="{{ route('user.courses.curriculum.navigation', ['course_id'=>@$course->id, 'curclm_item_id'=>@$selected_curriculum_item_id, 'section_item_id'=>@$selected_curriculum_section_id, 'type'=>'next']) }}" id="next_btn" class="curriculum-navigation-btn mx-2 btn-primary {{$disabled}}">{{ __("next") }}</a>
     @elseif(@$is_course_finished)
         <span class="curriculum-navigation-btn mx-2 btn-success">{{ __('finished') }}</span>
     @endif
 </div>
