<div class="list-add-section">

    @if (isset($course_sections) && count(@$course_sections) > 0)

        @foreach ($course_sections as $course_section)

            <div  id="section_{{ @$course_section->id }}"  class="widget_item-section bg-light-green rounded-3 p-2 p-lg-3 mb-3">
                <div class="bg-white rounded-3 p-2 widget_item-head d-lg-flex align-items-center">
                    <div class="d-flex align-items-center">
                        <div class="circle bg-dark ms-2"></div>
                        <h5>  {{ @$course_section->title }}   </h5>
                    </div>
                    <div class="d-flex align-items-center ms-lg-auto">
                        <div class="widget_item-action d-flex align-items-center">
                            <div class="widget_item-icon">
                                <div class="dropdown" id="dropdown">
                                   
                                    <div class="dropdown-menu dropdown-menu-end p-3 rounded">
                                        <p><a class="text-black action_btn" href="#" data-action="content"  data-section="{{ @$course_section->id }}"  >  {{ __('content') }} </a></p>
                                        <p><a class="text-black action_btn" href="#" data-action="lesson"  data-section="{{ @$course_section->id }}" > {{ __('new_lesson') }} </a></p>
                                        <p><a class="text-black action_btn" href="#"  data-action="exam"  data-section="{{ @$course_section->id }}"> {{ __('new_exam') }} </a></p>
                                        <p><a class="text-black action_btn" href="#" data-action="task"  data-section="{{ @$course_section->id }}"  >  {{ __('new_task') }} </a></p>
                                    </div>
                                </div>
                            </div>

                            <div class="widget_item-icon edit-section"
                                 data-bs-toggle="modal"
                                 data-bs-target="#modalAddSection"
                                 data-id="{{ @$course_section->id }}"
                                 data-title="{{ @$course_section->title }}"
                                 data-is_active="{{ @$course_section->is_active }}">
                                 <i class="fa-regular fa-pen-to-square"></i>
                            </div>

                            <div class="widget_item-icon confirm-category"
                                 data-url="{{route('user.lecturer.course.curriculum.section.delete_section')}}"
                                 data-id="{{ @$course_section->id }}" data-is_relpad_page="true"
                                 data-row="section_{{ @$course_section->id }}">
                                <i class="fa-solid fa-trash"></i>
                            </div>

                            <div class="widget_item-icon me-2 collapsed pointer"
                                    data-bs-toggle="collapse" data-bs-target="#collapse-section-no-content{{ @$course_section->id }}">
                                <i class="fa-regular fa-chevron-down"></i>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="widget_item-body accordion-collapse collapse" id="collapse-section-no-content{{ @$course_section->id }}"
                        data-bs-parent="#accordionSection">
                        <div class="row my-3">
                            <div class="py-3 px-2 px-lg-4" id="content_{{@$course_section->id}}">
                                @include('front.user.lecturer.courses.new_course.components.curriculum.modals.content')
                            </div>

                            <div class="py-3 px-2 px-lg-4" id="exam_{{@$course_section->id}}" style="display: none;">
                                @include('front.user.lecturer.courses.new_course.components.curriculum.modals.exam')
                            </div>

                            <div class="py-3 px-2 px-lg-4" id="lesson_{{@$course_section->id}}" style="display: none;">
                                @include('front.user.lecturer.courses.new_course.components.curriculum.modals.lesson')
                            </div>

                            <div class="py-3 px-2 px-lg-4" id="task_{{@$course_section->id}}" style="display: none;">
                                @include('front.user.lecturer.courses.new_course.components.curriculum.modals.task')
                            </div>

                        </div>
                </div>
            </div>

@endforeach

@endif

</div>



