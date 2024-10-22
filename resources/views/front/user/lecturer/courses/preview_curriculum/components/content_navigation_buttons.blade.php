<div class="text-center d-flex justify-content-center align-items-center ">

    @php
        if (checkUser('lecturer')) {
            $back_url = route('user.lecturer.course.curriculum.preview_curriculum.navigation', ['course_id'=>@$course->id, 'curclm_item_id'=>@$selected_curriculum_item_id, 'section_item_id'=>@$selected_curriculum_section_id, 'type'=>'back']);
            $next_url = route('user.lecturer.course.curriculum.preview_curriculum.navigation', ['course_id'=>@$course->id, 'curclm_item_id'=>@$selected_curriculum_item_id, 'section_item_id'=>@$selected_curriculum_section_id, 'type'=>'next']);
        }
        else if (auth('admin')->user()){
            $back_url = route('panel.courses.preview_curriculum.navigation', ['course_id'=>@$course->id, 'curclm_item_id'=>@$selected_curriculum_item_id, 'section_item_id'=>@$selected_curriculum_section_id, 'type'=>'back']);
            $next_url = route('panel.courses.preview_curriculum.navigation', ['course_id'=>@$course->id, 'curclm_item_id'=>@$selected_curriculum_item_id, 'section_item_id'=>@$selected_curriculum_section_id, 'type'=>'next']);
        }
    @endphp

    <a href="{{ @$back_url }}" class="curriculum-navigation-btn mx-2 btn-primary">السابق</a>
    <a href="{{ @$next_url }}" class="curriculum-navigation-btn mx-2 btn-primary">التالي</a>
</div>
