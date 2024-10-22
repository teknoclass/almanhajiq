@if (isset($course_sections))

    @foreach ($course_sections->items as $item)
        @if ($item->itemable_type == \App\Models\CourseSections::class)
            @php

                if (checkUser('lecturer') && $user_type == "lecturer") {
                    $preview_url = route('user.lecturer.course.curriculum.preview_curriculum.openByItem', ['id' => @$item->itemable_id,'course_id' => @$item->course_id,'type' => @$item->itemable_type]);
                    $section_delete_url = route('user.lecturer.course.curriculum.section.delete_section');
                }
                else if (auth('admin')->user() && $user_type == "admin"){
                    $preview_url = route('panel.courses.preview_curriculum.openByItem', ['id' => @$item->itemable_id,'course_id' => @$item->course_id,'type' => @$item->itemable_type]);
                    $section_delete_url = route('panel.courses.edit.curriculum.section.delete_section');
                }
            @endphp

            <div class="accordion" id="accordionSection_{{ @$item->itemable_id }}">

                {{-- Section Details and actions --}}
                <div id="section_{{ @$item->itemable_id }}"
                     class="widget_item-section bg-light-green rounded-3 p-2 p-lg-3 mb-3">
                    <div class="bg-white rounded-3 p-2 widget_item-head d-lg-flex align-items-center collapsed pointer"
                         data-bs-toggle="collapse" data-bs-target="#collapse-section-{{ @$item->itemable_id }}">
                        <div class="d-flex align-items-center">
                            <div class="circle bg-dark ms-2"></div>
                            <h5>{{ __('section_name') }} / {{ isset($item)?@$item->section->translate(app()->getLocale())->title:''}}</h5>
                            <div class="widget_item-action d-flex align-items-center">
                                <div class="widget_item-icon edit-section"
                                     data-bs-toggle="modal"
                                     data-bs-target="#modalAddSection"
                                     data-id="{{ @$item->sections()->first()->id }}"
                                     data-title_ar="{{isset($item)?@$item->section->translate('ar')->title:''}}"
                                     data-title_en="{{isset($item)?@$item->section->translate('en')->title:''}}"
                                     data-is_active="{{ @$item->sections()->first()->is_active }}">
                                    <i class="fa-regular fa-pen-to-square"></i>
                                </div>
                                <button type="button" class="p-1 text-muted bg-transparent confirm-category"
                                        data-url="{{ @$section_delete_url }}"
                                        data-id="{{ @$item->itemable_id }}" data-is_relpad_page="true"
                                        data-row="accordionSection_{{ @$item->itemable_id }}">
                                    <div class="widget_item-icon"><i class="fa-solid fa-trash"></i></div>
                                </button>

                                <a href="{{ @$preview_url }}" target="__blank">
                                    <div class="widget_item-icon"><i class="fa-solid fa-eye"></i></div>
                                </a>
                                @php
                                    switch (@$item->section->is_active) {
                                        case '1':
                                            $class = "bg-success"; $icon = "fa-check";
                                            break;
                                        case '0':
                                            $class = "bg-danger"; $icon = "fa-times";
                                            break;
                                    }
                                @endphp

                                <div class="widget_item-icon {{ @$class }}"><i class="fa-solid {{ @$icon }}"></i></div>
                            </div>
                        </div>
                        <div class="d-flex align-items-center ms-lg-auto">
                            <div class="widget_item-chevron me-2"><i class="fa-regular fa-chevron-down"></i></div>
                        </div>
                    </div>

                    {{-- Section Content --}}
                    <div class="widget_item-body accordion-collapse collapse"
                         id="collapse-section-{{ @$item->itemable_id }}"
                         data-bs-parent="#accordionSection_{{ @$item->itemable_id }}">

                        {{-- Add Item to Section --}}
                        <div class="row my-3">
                            <?php $col_w = @$course->type == 'recorded' ? 4 : 3; ?>
                            <div class="col-lg-{{ @$col_w }}">
                                <button class="btn btn-primary-2 w-100 mb-2 mb-lg-0 outer_modal_lesson"
                                        data-course_id="{{ @$course->id }}" data-section_id="{{ @$item->itemable_id }}"
                                        data-course_type="{{ @$course->type}}"
                                        data-type="add">{{ __('add_lesson') }}</button>
                            </div>
                            <div class="col-lg-{{ @$col_w }}">
                                <button class="btn btn-primary-2 w-100 outer_modal_quiz"
                                        data-course_id="{{ @$course->id }}" data-section_id="{{ @$item->itemable_id }}"    data-course_type="{{ @$course->type}}"
                                        data-type="add">{{ __('add_quiz') }}</button>
                            </div>
                            <div class="col-lg-{{ @$col_w }}">
                                <button class="btn btn-primary-2 w-100 mb-2 mb-lg-0 outer_modal_assignment"
                                        data-course_id="{{ @$course->id }}" data-section_id="{{ @$item->itemable_id }}"    data-course_type="{{ @$course->type}}"
                                        data-type="add">{{ __('add_task') }}</button>
                            </div>
                        </div>

                        {{-- Section Items --}}
                        <div class="row">
                            @if (isset($item->section->items) && count(@$item->section->items) > 0)
                                @foreach ($item->section->items as $itemm)
                                    @php

                                        $preview_url = null;
                                        $delete_url = null;
                                               $type = $item_types[$itemm->itemable_type] ?? null;
  $type = $item_types[$itemm->itemable_type] ?? null;
                                        if (checkUser('lecturer') && $user_type == "lecturer") {
                                            $preview_url = route('user.lecturer.course.curriculum.preview_curriculum.openByItem', ['id' => @$itemm->itemable_id,'course_id' => @$itemm->course_id,'type' => @$itemm->itemable_type]);
                                            $delete_url = route('user.lecturer.course.curriculum.' . $type . '.delete_' .$type);
                                        } elseif (auth('admin')->check() && $user_type == "admin") {
                                            $preview_url = route('panel.courses.preview_curriculum.openByItem', ['id' => @$itemm->itemable_id,'course_id' => @$itemm->course_id,'type' => @$itemm->itemable_type]);
                                            $delete_url = route('panel.courses.edit.curriculum.' .  $type . '.delete_' .  $type);
                                        }

                                        $itemId = @$itemm->itemable->id;
                                        $status = @$itemm->itemable->status;
                                    @endphp

                                    @if ($type == 'lesson' || $type == 'quiz' || $type == 'assignment')
                                        <div class="col-12" id="lessonn_{{ $itemId }}">
                                            <div class="widget_item-lesson d-flex align-items-center rounded-3 mb-3"><i
                                                    class="fa-solid fa-minus"></i>
                                                <h6 class="mx-2">

                                                    @switch($type)
                                                        @case('lesson')
                                                        {{ __('lesson_name') }} : {{ @$itemm->itemable->title }}
                                                        @break
                                                        @case('quiz')
                                                        {{ __('quiz_name') }} : {{ @$itemm->itemable->title }}
                                                        @break
                                                        @case('assignment')
                                                        {{ __('task_title') }} : {{ @$itemm->itemable->title }}
                                                        @break
                                                    @endswitch
                                                </h6>
                                                @include('front.user.lecturer.courses.my_courses.create.components.curriculum.item_actions', ['type' => $type, 'itemId' => $itemId, 'course_id' => $course->id, 'status' => $status, 'deleteUrl' => $delete_url, 'previewUrl' => $preview_url])
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>

            </div>
            {{config("constants.item_types.$item->itemable_type")}}
        @else

            @php
                $preview_url = null;
                $delete_url = null;

                  $type = $item_types[$item->itemable_type] ?? null;

                if (checkUser('lecturer') && $user_type == "lecturer") {
                    $preview_url = route('user.lecturer.course.curriculum.preview_curriculum.openByItem', ['id' => @$item->itemable_id,'course_id' => @$item->course_id,'type' => @$item->itemable_type]);
  if ($type) {
            $delete_url = route('user.lecturer.course.curriculum.' . $type . '.delete_outer_' . $type);
        }                } elseif (auth('admin')->check() && $user_type == "admin") {

                    $preview_url = route('panel.courses.preview_curriculum.openByItem',['id' => @$item->itemable_id,'course_id' => @$item->course_id,'type' => @$item->itemable_type] );
                    $delete_url = route('panel.courses.edit.curriculum.' . $type . '.delete_outer_' .  $type);
                }

                $itemId = @$item->itemable->id;
                $status = @$item->itemable->status;
            @endphp

            @if ($type == 'lesson' ||  $type == 'quiz' || $type == 'assignment')
                <div class="col-12" id="lessonn_{{ $itemId }}">

                    <div class="widget_item-lesson d-flex align-items-center rounded-3 mb-3"><i
                            class="fa-solid fa-minus"></i>
                        <h6 class="mx-2">
                            @switch($type)
                                @case('lesson')
                                {{ __('lesson_name') }} : {{ @$item->itemable->title }}
                                @break
                                @case('quiz')
                                {{ __('quiz_name') }} : {{ @$item->itemable->title }}
                                @break
                                @case('assignment')
                                {{ __('task_title') }} : {{ @$item->itemable->title }}
                                @break
                            @endswitch
                        </h6>
                        @include('front.user.lecturer.courses.my_courses.create.components.curriculum.item_actions', ['type' => $type, 'itemId' => $itemId, 'course_id' => $course->id, 'status' => $status, 'deleteUrl' => $delete_url, 'previewUrl' => $preview_url])
                    </div>
                </div>
            @endif
        @endif
    @endforeach

@endif
