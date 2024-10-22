
@if (@$curriculum_items)
    <div class="col-lg-4">
        <div class="course-content border-light-primary rounded-10 bg-white">
            <div class="course-content-body p-4">
                @foreach ($curriculum_items as $item)
                    @php $the_selected_item = @$item->id == @$selected_curriculum_item_id @endphp

                    @if ($item->itemable_type == 'App\Models\CourseSections')
                        @php
                            $section = @$item->section;
                            $section_items = @$section->items;
                        @endphp

                        @if ($section_items->isNotEmpty())

                            <div id="curriculumAccordion" class="form-group col-12 mb-0">
                                <div data-bs-target="#curriculum-section-{{ @$section->id }}"
                                    class="curriculum-widget-section-title" data-bs-toggle="collapse">
                                    <div class="d-flex align-items-center">
                                        <div class="me-2 curriculum-head-widget-icon"><i
                                                class="fa-solid fa-bookmark"></i></div>
                                        <h4 class="font-medium">{{ @$section->title }}</h4>
                                    </div>
                                    <div class="me-2 ms-auto text-black curriculum-head-widget-icon"><i
                                            class="fa-solid fa-chevron-down"></i></div>
                                </div>

                            <div id="curriculum-section-{{ @$section->id }}" class="col-12 mx-2 collapse {{ (@$selected_curriculum_item_id == @$item->id) ? 'show' : '' }}">
                                @foreach ($section_items as $s_item)

                                    @php
                                        $lesson = @$s_item->itemable;

                                        $the_selected_section = @$s_item->id == @$selected_curriculum_section_id;
                                        $icon = getCurriculumWidgetIcon(config('constants.item_model_types.'.@$s_item->itemable_type), @$lesson->file_type);

                                        if (checkUser('lecturer')) {
                                            $item_url = route('user.lecturer.course.curriculum.preview_curriculum.item', ['course_id' => @$course->id, 'curclm_item_id' => @$item->id, 'section_item_id' => @$s_item->id]);
                                        }
                                        else if (auth('admin')->user()){
                                            $item_url = route('panel.courses.preview_curriculum.item', ['course_id' => @$course->id, 'curclm_item_id' => @$item->id, 'section_item_id' => @$s_item->id]);
                                        }
                                    @endphp

                                        <div
                                            class="curriculum-widget-item {{ @$the_selected_section && @$the_selected_item ? 'selected-color' : '' }}">
                                            <a href="{{ $item_url }}">
                                                <div class="d-flex align-items-center">
                                                    <div class="me-2 curriculum-widget-icon"><i
                                                            class="fa-solid {{ @$icon }}"></i></div>
                                                    <h4 class="">{{ @$lesson->title }}</h4>
                                                </div>
                                            </a>

                                            @if (@$lesson->status == 'inactive')
                                                <div class="me-2 bg-danger ms-auto text-white curriculum-widget-icon"><i
                                                        class="fa-solid fa-edit"></i></div>
                                                {{-- @elseif (@$lesson->status == 'active')
                                            <div class="me-2 bg-success ms-auto text-white curriculum-widget-icon"><i class="fa-solid fa-check"></i></div> --}}
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    @else

                        {{-- For Curriculum lessons, quizzes and assignments. --}}
                        @php
                            $icon = getCurriculumWidgetIcon(config('constants.item_model_types.'.@$item->itemable_type), @$item->itemable->file_type);

                            if (checkUser('lecturer')) {
                                $item_url = route('user.lecturer.course.curriculum.preview_curriculum.item', [
                                    'course_id' => @$course->id,
                                    'curclm_item_id' => @$item->id,
                                ]);
                            } elseif (auth('admin')->user()) {
                                $item_url = route('panel.courses.preview_curriculum.item', [
                                    'course_id' => @$course->id,
                                    'curclm_item_id' => @$item->id,
                                ]);
                            }
                        @endphp

                        <div
                            class="curriculum-widget-section-title {{ !@$selected_curriculum_section_id && @$the_selected_item ? 'selected-color' : '' }}">
                            <a href="{{ $item_url }}">
                                <div class="d-flex align-items-center">
                                    <div class="me-2 curriculum-head-widget-icon"><i
                                            class="fa-solid {{ @$icon }}"></i></div>
                                    <h4 class="font-medium">{{ $item->itemable->title  }}</h4>
                                </div>
                            </a>

                            @if (@$item->{@$item->itemable_type}->status == 'inactive')
                                <div class="me-2 bg-danger ms-auto text-white curriculum-widget-icon"><i
                                        class="fa-solid fa-edit"></i></div>
                                {{-- @elseif (@$item->{@$item->item_type}->status == 'active')
                            <div class="me-2 bg-success ms-auto text-white curriculum-widget-icon"><i class="fa-solid fa-check"></i></div> --}}
                            @endif
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
@endif
