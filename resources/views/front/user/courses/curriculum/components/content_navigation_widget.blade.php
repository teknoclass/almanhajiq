@if (@$curriculum_items)
    <div class="col-lg-4">
        <div class="course-content border-light-primary rounded-10 bg-white">
            <div class="course-content-body p-4">
                @foreach ($curriculum_items as $key1 => $item)
                    @php $the_selected_item = @$item->id == @$selected_curriculum_item_id @endphp

                    @if ($item->itemable_type == 'App\Models\CourseSections')
                        @php
                            $section = @$item->section;
                            $section_items = @$section->items;
                        @endphp
                        @if ($section_items->isNotEmpty())
                            <div id="curriculumAccordion" class="form-group col-12 mb-0">
                                <div data-target="#curriculum-section-{{ @$section->id }}"
                                    class="curriculum-widget-section-title" data-toggle="collapse">
                                    <div class="d-flex align-items-center">
                                        <div class="me-2 curriculum-head-widget-icon"><i
                                                class="fa-solid fa-bookmark"></i></div>
                                        <h4 class="font-medium">{{ @$section->title }}</h4>
                                    </div>
                                    <div class="me-2 ms-auto text-black curriculum-head-widget-icon"><i
                                            class="fa-solid fa-chevron-down"></i></div>
                                </div>
                             {{--  <div id="curriculum-section-{{ @$section->id }}"
                                    class="col-12 mx-2 collapse {{ @$selected_curriculum_item_id == @$item->id ? 'show' : '' }}"> --}}
                                <div id="curriculum-section-{{ @$section->id }}"
                                    class="col-12 mx-2 collapse {{ !@$course->lessons_follow_up ? 'show' : '' }}">
                                    @foreach ($section_items as $key2 => $s_item)
                                        @php
                                            $lesson = @$s_item->itemable;
                                            $the_selected_section = @$s_itemable->id == @$selected_curriculum_section_id;
                                            $icon = getCurriculumWidgetIcon(config('constants.item_model_types.'.@$s_item->itemable_type), @$lesson->file_type);
                                        @endphp

                                        <div
                                            class="curriculum-widget-item {{ @$the_selected_section && @$the_selected_item ? 'selected-color' : '' }}">
                                            <a
                                                href="{{ route('user.courses.curriculum.item', ['course_id' => @$course->id, 'curclm_item_id' => @$item->id, 'section_item_id' => @$s_item->id]) }} ">
                                                <div class="d-flex align-items-center">
                                                    <div class="me-2 curriculum-widget-icon"><i
                                                            class="fa-solid {{ @$icon }}"></i></div>
                                                    <h4 class="">{{ @$lesson->title }}</h4>
                                                </div>
                                            </a>

                                            @if ($s_item->is_completed())
                                                <div class="me-2 bg-success ms-auto text-white curriculum-widget-icon">
                                                    <i class="fa-solid fa-check"></i></div>
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
                        @endphp

                        <div
                            class="curriculum-widget-section-title {{ !@$selected_curriculum_section_id && @$the_selected_item ? 'selected-color' : '' }}">
                            <a
                                href="@if ($item->is_completed() || (@$key1 == 0 && @$key2 == 0)) {{ route('user.courses.curriculum.item', ['course_id' => @$course->id, 'curclm_item_id' => @$itemable->id]) }} @else javascript:; @endif">
                                <div class="d-flex align-items-center">
                                    <div class="me-2 curriculum-head-widget-icon"><i
                                            class="fa-solid {{ @$icon }}"></i></div>
                                    <h4 class="font-medium">
                                        {{ @$item->itemable->title }}
                                    </h4>
                                </div>
                            </a>

                            @if ($item->is_completed())
                                <div class="me-2 bg-success ms-auto text-white curriculum-widget-icon"><i
                                        class="fa-solid fa-check"></i></div>
                            @endif
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
@endif
